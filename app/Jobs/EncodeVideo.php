<?php

namespace App\Jobs;

use FFMpeg;
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

    public $timeout = 3600; // 1 hour, adjust as needed


    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        // --- 1. Paths ---
        $inputFilename = $this->video->filename;
        $baseName = pathinfo($inputFilename, PATHINFO_FILENAME);

        // Temporary local folder
        $tempInput = storage_path('app/temp/' . $inputFilename);
        $tempOutput = storage_path('app/temp/hls/' . $baseName);

        if (!file_exists(dirname($tempOutput))) {
            mkdir(dirname($tempOutput), 0755, true);
        }

        // --- 2. Download video from Spaces ---
        Storage::disk('spaces')->get($this->video->path, $tempInput);

        // --- 3. FFMpeg instance with explicit binaries ---
        $ffmpeg = FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg', // update to your system
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // in seconds
            'ffmpeg.threads'   => 4,
        ]);

        $video = $ffmpeg->open($tempInput);

        // --- 4. Define resolutions ---
        $formats = [
            '1080' => (new \FFMpeg\Format\Video\X264)->setKiloBitrate(5000),
            '720'  => (new \FFMpeg\Format\Video\X264)->setKiloBitrate(2500),
            '480'  => (new \FFMpeg\Format\Video\X264)->setKiloBitrate(1000),
        ];

        $outputFolder = "videos/hls/{$baseName}";

        // --- 5. Encode each resolution ---
        foreach ($formats as $res => $format) {
            $resFolder = "{$tempOutput}/{$res}p";
            if (!file_exists($resFolder)) {
                mkdir($resFolder, 0755, true);
            }

            $video->exportForHLS()
                ->setSegmentLength(10)
                ->addFormat($format)
                ->toDisk('local')
                ->save("{$resFolder}/index.m3u8");

            // Upload segments to Spaces
            $files = glob("{$resFolder}/*.ts");
            foreach ($files as $file) {
                $filename = basename($file);
                Storage::disk('spaces')->put("{$outputFolder}/{$res}p/{$filename}", file_get_contents($file));
            }

            // Upload the m3u8 for this resolution
            Storage::disk('spaces')->put("{$outputFolder}/{$res}p/index.m3u8", file_get_contents("{$resFolder}/index.m3u8"));
        }

        // --- 6. Create master playlist ---
        $masterPath = "{$outputFolder}/master.m3u8";
        $master = "#EXTM3U\n#EXT-X-VERSION:3\n";

        foreach ($formats as $res => $format) {
            $bandwidth = $format->getKiloBitrate() * 1000;
            $height = $res;
            $width = intval($res * 16 / 9); // assuming 16:9 aspect
            $master .= "#EXT-X-STREAM-INF:BANDWIDTH={$bandwidth},RESOLUTION={$width}x{$height}\n";
            $master .= "{$res}p/index.m3u8\n";
        }

        Storage::disk('spaces')->put($masterPath, $master);

        // --- 7. Update database ---
        $this->video->update([
            'encoded' => true,
            'path'    => $masterPath,
        ]);

        // --- 8. Cleanup local temp files ---
        if (file_exists($tempInput)) unlink($tempInput);
        $this->deleteDirectory($tempOutput);
    }

    // Recursive delete folder helper
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) return;
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = "$dir/$file";
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
