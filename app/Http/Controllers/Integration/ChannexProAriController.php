<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\ChannexPro\AriExportService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ChannexProAriController extends Controller
{
    public function index(Request $request, AriExportService $exporter): JsonResponse
    {
        $expectedToken = trim((string) config('services.live_export.token'));
        $providedToken = trim((string) ($request->bearerToken() ?: $request->query('token', '')));

        if ($expectedToken === '') {
            return response()->json([
                'message' => 'ChannexPro ARI export is not configured. Set LIVE_EXPORT_TOKEN first.',
            ], 503);
        }

        if ($providedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $propertyId = trim((string) $request->query('property_id', ''));
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));

        if ($propertyId === '' || $from === '' || $to === '') {
            return response()->json([
                'message' => 'property_id, from and to are required.',
            ], 422);
        }

        try {
            $dateFrom = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
            $dateTo = Carbon::createFromFormat('Y-m-d', $to)->startOfDay();
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'from and to must use YYYY-MM-DD format.',
            ], 422);
        }

        if ($dateTo->lt($dateFrom)) {
            return response()->json([
                'message' => 'to must be on or after from.',
            ], 422);
        }

        $days = $dateFrom->diffInDays($dateTo) + 1;
        if ($days > 730) {
            return response()->json([
                'message' => 'ARI requests are limited to 730 days per request.',
            ], 422);
        }

        $property = Property::query()
            ->whereKey($propertyId)
            ->where('allow', true)
            ->whereHas('apartments')
            ->first();

        if (! $property) {
            return response()->json([
                'message' => 'Property not found or not enabled for distribution.',
            ], 404);
        }

        try {
            $ari = $exporter->export($property, $dateFrom, $dateTo);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to build ARI feed: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'schema' => 'channexpro.ari.v1',
            'generated_at' => now()->toIso8601String(),
            'property_id' => (string) $property->id,
            'property_name' => (string) $property->name,
            'currency' => 'USD',
            'from' => $dateFrom->toDateString(),
            'to' => $dateTo->toDateString(),
            'days' => $days,
            'availability' => $ari['availability'],
            'restrictions' => $ari['restrictions'],
            'counts' => [
                'availability_ranges' => count($ari['availability']),
                'restriction_ranges' => count($ari['restrictions']),
            ],
        ])->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'X-Robots-Tag' => 'noindex, nofollow',
        ]);
    }
}
