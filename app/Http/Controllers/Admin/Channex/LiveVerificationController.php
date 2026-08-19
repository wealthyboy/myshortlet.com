<?php

namespace App\Http\Controllers\Admin\Channex;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\Channex\LiveSetupVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LiveVerificationController extends Controller
{
    public function index(Request $request, LiveSetupVerificationService $verification)
    {
        if (! $this->isAuthorized($request, true)) {
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

    public function reservationOptions(Request $request)
    {
        if (! $this->isAuthorized($request)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $properties = Property::query()
            ->whereNotNull('channex_property_id')
            ->with(['apartments' => function ($query) {
                $query->whereNotNull('channex_room_type_id')
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'name' => $property->name,
                    'channex_property_id' => $property->channex_property_id,
                    'apartments' => $property->apartments->map(function ($apartment) {
                        return [
                            'id' => $apartment->id,
                            'name' => $apartment->name,
                            'channex_room_type_id' => $apartment->channex_room_type_id,
                            'allow' => (bool) $apartment->allow,
                            'quantity' => max(1, (int) ($apartment->quantity ?: 1)),
                        ];
                    })->values(),
                ];
            })
            ->values();

        return response()->json([
            'environment' => app()->environment(),
            'cache' => config('cache.default'),
            'queue' => config('queue.default'),
            'scenario_column' => Schema::hasColumn('channex_ari_outbox_events', 'scenario'),
            'pending_jobs' => Schema::hasTable('jobs') ? DB::table('jobs')->count() : null,
            'failed_jobs' => Schema::hasTable('failed_jobs') ? DB::table('failed_jobs')->count() : null,
            'properties' => $properties,
        ])->header('Cache-Control', 'private, no-store');
    }

    public function reservation(Request $request)
    {
        if (! $this->isAuthorized($request)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'property' => ['required_without:reservation_id', 'nullable', 'string', 'max:255'],
            'apartment' => ['required_without:reservation_id', 'nullable', 'string', 'max:255'],
            'checkin' => ['required_without:reservation_id', 'nullable', 'date_format:Y-m-d'],
            'checkout' => ['required_without:reservation_id', 'nullable', 'date_format:Y-m-d', 'after:checkin'],
            'reservation_id' => ['nullable', 'integer', 'exists:user_reservations,id'],
            'execute' => ['required', 'accepted'],
            'process' => ['nullable', 'boolean'],
            'move_week' => ['nullable', 'boolean'],
            'email' => ['nullable', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        $arguments = [
            '--execute' => true,
            '--process' => (bool) ($validated['process'] ?? true),
            '--move-week' => (bool) ($validated['move_week'] ?? false),
        ];

        if (! empty($validated['reservation_id'])) {
            $arguments['--resume'] = (int) $validated['reservation_id'];
        } else {
            $arguments += [
                'property' => $validated['property'],
                'apartment' => $validated['apartment'],
                'checkin' => $validated['checkin'],
                'checkout' => $validated['checkout'],
            ];
        }

        if (! empty($validated['email'])) {
            $arguments['--email'] = $validated['email'];
        }
        if (! empty($validated['phone'])) {
            $arguments['--phone'] = $validated['phone'];
        }

        $exitCode = Artisan::call('channex:verify-reservation', $arguments);

        return response()->json([
            'success' => $exitCode === 0,
            'exit_code' => $exitCode,
            'output' => Artisan::output(),
        ], $exitCode === 0 ? 200 : 422)->header('Cache-Control', 'private, no-store');
    }

    protected function isAuthorized(Request $request, bool $allowQueryToken = false): bool
    {
        $expectedToken = trim((string) config('services.channex.verification_token', ''));
        $providedToken = (string) $request->bearerToken();

        if ($allowQueryToken && $providedToken === '') {
            $providedToken = (string) $request->query('token', '');
        }

        return $expectedToken !== '' && hash_equals($expectedToken, $providedToken);
    }
}
