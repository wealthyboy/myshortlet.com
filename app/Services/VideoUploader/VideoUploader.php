<?php

namespace App\Services\VideoUploader;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Jobs\EncodeVideo;
use App\Models\Video;

class VideoUploader
{
    /**
     * Uploads and dispatches a video for encoding.
     *
     * @param UploadedFile $file
     * @param Video|null $model
     * @param string $disk
     * @param string $folder
     * @return Video
     */
    public static function uploadAndEncode(
        UploadedFile $file,
        ?Video $model = null,
        string $disk = 'spaces',
        string $folder = 'videos'
    ): Video {
        // Upload raw video to the disk
        $rawPath = Storage::disk($disk)->put($folder, $file);

        if (!$rawPath) {
            throw new \Exception('Failed to upload video to ' . $disk);
        }

        // Create or update video record
        if (!$model) {
            $model = new Video();
        }

        $model->fill([
            'filename' => $file->getClientOriginalName(),
            'path' => $rawPath,
            'encoded' => false,
            'disk' => $disk,
        ]);

        // Save model (polymorphic relations will automatically set videoable_id/type if used via relation)
        $model->save();

        // Dispatch encoding job
        EncodeVideo::dispatch($model);

        return $model;
    }
}
