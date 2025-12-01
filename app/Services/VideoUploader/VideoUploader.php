<?php

namespace App\Services\VideoUploader;

use App\Jobs\EncodeVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoUploader
{
    public static function uploadAndEncode(
        UploadedFile $video,
        $model,
        string $disk = 'spaces',
        string $folder = 'videos'
    ) {
        // Upload raw source video
        $rawPath = Storage::disk($disk)->put($folder, $video);

        // Save video in DB (raw path)
        $model->update([
            'filename' => $video->getClientOriginalName(),
            'path' => $rawPath,
            'encoded' => false,
            'disk' => $disk,
        ]);

        // Dispatch HLS encoding job
        EncodeVideo::dispatch($model);

        return $model;
    }
}
