<?php

namespace App\Http\Controllers\Admin\Channex;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\Channex\LiveSetupVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LiveVerificationController extends Controller
{
    public function index(Request $request, LiveSetupVerificationService $verification)
    {
        $expectedToken = trim((string) config('services.channex.verification_token', ''));
        $providedToken = (string) ($request->bearerToken() ?: $request->query('token', ''));

        if ($expectedToken === '' || ! hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $properties = Property::query()
            ->where(function ($query) {
                $query->whereNotNull('channex_property_id')
                    ->orWhere('name', 'like', 'Test Property%');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'channex_property_id']);

        $property = null;
        if ($request->filled('property_id')) {
            $property = $properties->firstWhere('id', (int) $request->query('property_id'));
        }

        $property = $property
            ?: $properties->filter(function ($item) {
                return stripos($item->name, 'Test Property') === 0;
            })->last()
            ?: $properties->last();

        if ($property) {
            $property = Property::findOrFail($property->id);
        }

        $report = $property
            ? Cache::remember(
                'channex:live-verification:' . $property->id,
                now()->addMinute(),
                function () use ($property, $verification) {
                    return $verification->verify($property, true);
                }
            )
            : null;

        return response()
            ->view('channex.live_verification', compact('properties', 'property', 'report'))
            ->header('Cache-Control', 'private, no-store')
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive');
    }
}
