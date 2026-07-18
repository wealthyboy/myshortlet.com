<?php

namespace App\Http\Controllers\Admin\Channex;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function downloadApartmentsSnapshot()
    {
        $exitCode = Artisan::call('apartments:export-live-data');

        if ($exitCode !== 0) {
            return redirect()->back()->with(
                'error',
                'Failed to generate apartments export snapshot.'
            );
        }

        $latestPath = 'exports/latest_apartments_snapshot_path.txt';

        if (! Storage::disk('local')->exists($latestPath)) {
            return redirect()->back()->with(
                'error',
                'Snapshot path not found after export.'
            );
        }

        $snapshotFile = trim(Storage::disk('local')->get($latestPath));

        if (! Storage::disk('local')->exists($snapshotFile)) {
            return redirect()->back()->with(
                'error',
                'Snapshot file is missing: ' . $snapshotFile
            );
        }

        $downloadName = basename($snapshotFile);

        return Storage::disk('local')->download($snapshotFile, $downloadName, [
            'Content-Type' => 'application/json',
        ]);
    }
}
