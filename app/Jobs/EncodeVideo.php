<?php

namespace App\Jobs;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class EncodeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public $timeout = 3600; // 1 hour


    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        /** -----------------------------------
         * 1. Build temp paths
         * -----------------------------------*/
        $inputFilename = $this->video->filename;
        $baseName = pathinfo($inputFilename, PATHINFO_FILENAME);

        $tempFolder = storage_path("app/temp/hls/{$baseName}");
        $tempInput  = storage_path("app/temp/{$inputFilename}");

        if (!file_exists(dirname($tempInput))) {
            mkdir(dirname($tempInput), 0755, true);
        }

        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }

        /** -----------------------------------
         * 2. Download original video from Spaces
         * -----------------------------------*/
        file_put_contents(
            $tempInput,
            Storage::disk('spaces')->get($this->video->path)
        );

        /** -----------------------------------
         * 3. Create FFMpeg instance
         * -----------------------------------*/
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 4,
        ]);

        $video = $ffmpeg->open($tempInput);

        /** -----------------------------------
         * 4. Resolutions (16:9 safe)
         * -----------------------------------*/
        $formats = [
            '1080' => (new X264)->setKiloBitrate(5000),
            '720'  => (new X264)->setKiloBitrate(2500),
            '480'  => (new X264)->setKiloBitrate(1000),
        ];

        $spacesOutputFolder = "videos/hls/{$baseName}";

        /** -----------------------------------
         * 5. Encode multiple resolutions
         * -----------------------------------*/
        foreach ($formats as $res => $format) {

            $resFolder = "{$tempFolder}/{$res}p";
            mkdir($resFolder, 0755, true);

            $video
                ->exportForHLS()
                ->setSegmentLength(10)
                ->addFormat($format)
                ->save("{$resFolder}/index.m3u8");

            // upload .ts segments
            foreach (glob("{$resFolder}/*.ts") as $file) {
                Storage::disk('spaces')->put(
                    "{$spacesOutputFolder}/{$res}p/" . basename($file),
                    file_get_contents($file)
                );
            }

            // upload m3u8
            Storage::disk('spaces')->put(
                "{$spacesOutputFolder}/{$res}p/index.m3u8",
                file_get_contents("{$resFolder}/index.m3u8")
            );
        }

        /** -----------------------------------
         * 6. Create master playlist
         * -----------------------------------*/
        $master = "#EXTM3U\n#EXT-X-VERSION:3\n";

        foreach ($formats as $res => $format) {
            $bandwidth = $format->getKiloBitrate() * 1000;
            $height = $res;
            $width = intval($res * 16 / 9);

            $master .= "#EXT-X-STREAM-INF:BANDWIDTH={$bandwidth},RESOLUTION={$width}x{$height}\n";
            $master .= "{$res}p/index.m3u8\n";
        }

        Storage::disk('spaces')->put("{$spacesOutputFolder}/master.m3u8", $master);

        /** -----------------------------------
         * 7. Update database
         * -----------------------------------*/
        $this->video->update([
            'encoded' => true,
            'path' => "{$spacesOutputFolder}/master.m3u8",
        ]);

        /** -----------------------------------
         * 8. Cleanup temp
         * -----------------------------------*/
        @unlink($tempInput);
        $this->deleteDirectory($tempFolder);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) return;

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;

            $path = "$dir/$item";
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }

        rmdir($dir);
    }
}
