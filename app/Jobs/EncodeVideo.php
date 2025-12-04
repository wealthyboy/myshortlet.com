<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Throwable;

class EncodeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Video $video;
    public int $timeout = 3600;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        $video = $this->video;

        if (!$video) {
            Log::error('EncodeVideo: missing video model.');
            return;
        }

        $disk = $video->disk ?? 'spaces';
        $remotePath = $video->path;

        if (!$remotePath) {
            Log::error('EncodeVideo: video->path is empty', [
                'video_id' => $video->id
            ]);
            return;
        }

        if (!Storage::disk($disk)->exists($remotePath)) {
            Log::error('EncodeVideo: source file not found', [
                'video_id'   => $video->id,
                'disk'       => $disk,
                'remotePath' => $remotePath,
            ]);
            return;
        }

        $baseName = pathinfo($remotePath, PATHINFO_FILENAME);
        $outputFolder = "videos/hls/{$baseName}";
        $masterPlaylist = "{$outputFolder}/master.m3u8";

        $segmentPattern = 'segment_%05d.ts';

        try {
            /**
             * Create HLS export builder
             */
            $hls = FFMpeg::fromDisk($disk)
                ->open($remotePath)
                ->exportForHLS()
                ->setSegmentLength(10);

            /**
             * LOW MEMORY MULTI-BITRATE (only 2 streams)
             * Using veryfast preset to reduce RAM + CPU
             */

            $bitrates = [2000, 800];

            foreach ($bitrates as $kbps) {
                $format = (new X264)
                    ->setKiloBitrate($kbps)
                    ->setAudioCodec('aac')
                    ->setAdditionalParameters(['-preset', 'veryfast']);

                $hls->addFormat(
                    $format,
                    null,
                    $segmentPattern
                );
            }

            $hls->toDisk($disk)->save($masterPlaylist);

            $video->update([
                'encoded'      => true,
                'encoded_path' => $masterPlaylist,
            ]);

            Log::info('EncodeVideo: encoding complete', [
                'video_id' => $video->id,
                'master'   => $masterPlaylist,
            ]);
        } catch (Throwable $e) {

            Log::error('EncodeVideo: exception during encoding', [
                'video_id'  => $video->id,
                'exception' => $e->getMessage(),
            ]);

            $video->update([
                'encoded' => false,
            ]);

            throw $e;
        }
    }
}
