<?php

namespace App\Http\Controllers\Admin\Channex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function publicApartmentsSnapshot(Request $request)
    {
        $expectedToken = (string) config('services.live_export.token');
        $providedToken = (string) ($request->bearerToken() ?: $request->query('token', ''));

        if ($expectedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $exitCode = Artisan::call('apartments:export-live-data');

        if ($exitCode !== 0) {
            return response()->json([
                'message' => 'Failed to generate apartments export snapshot.',
            ], 500);
        }

        $latestPath = 'exports/latest_apartments_snapshot_path.txt';

        if (! Storage::disk('local')->exists($latestPath)) {
            return response()->json([
                'message' => 'Snapshot path not found after export.',
            ], 500);
        }

        $snapshotFile = trim(Storage::disk('local')->get($latestPath));

        if (! Storage::disk('local')->exists($snapshotFile)) {
            return response()->json([
                'message' => 'Snapshot file is missing: ' . $snapshotFile,
            ], 500);
        }

        return response(
            Storage::disk('local')->get($snapshotFile),
            200,
            [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]
        );
    }
}
