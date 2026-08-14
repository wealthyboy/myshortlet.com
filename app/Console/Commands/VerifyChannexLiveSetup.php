<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class VerifyChannexLiveSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channex:verify-live
        {property? : Local property ID, exact property name, or Channex property UUID}
        {--room=Twin Room : Exact local apartment name to verify}
        {--remote : Read the mapped entities from Channex as well}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read-only verification of a hidden Channex test property and room on the live server';

    /** @var int */
    protected $failures = 0;

    /** @var int */
    protected $warnings = 0;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Channex live setup verification (read-only)');
        $this->line('Environment: ' . app()->environment() . ' | URL: ' . config('app.url'));
        $this->newLine();

        $this->verifyApplicationConfiguration();

        $property = $this->findProperty($this->argument('property'));

        if (! $property) {
            $this->fail('Test property was not found. Pass its local ID, exact name, or Channex UUID.');
            $this->printSummary();

            return 1;
        }

        $this->newLine();
        $this->line('Property: #' . $property->id . ' ' . $property->name);
        $this->verifyProperty($property);

        $room = $property->apartments()
            ->where('name', $this->option('room'))
            ->first();

        if (! $room) {
            $this->fail('Room "' . $this->option('room') . '" was not found under this property.');
        } else {
            $this->newLine();
            $this->line('Room: #' . $room->id . ' ' . $room->name);
            $this->verifyRoom($room);
        }

        $this->verifyQueueState();

        if ($this->option('remote') && $room) {
            $this->newLine();
            $this->line('Remote Channex checks');
            $this->verifyRemoteMappings($property, $room);
        }

        $this->printSummary();

        return $this->failures === 0 ? 0 : 1;
    }

    protected function verifyApplicationConfiguration(): void
    {
        $this->check(
            app()->environment('production'),
            'APP_ENV is production.',
            'APP_ENV is not production (' . app()->environment() . ').',
            true
        );

        $this->check(
            ! config('app.debug'),
            'APP_DEBUG is disabled.',
            'APP_DEBUG is enabled; disable it on the live server.'
        );

        $this->check(
            filled(config('services.channex.base_url')),
            'CHANNEX_BASE_URL is configured.',
            'CHANNEX_BASE_URL is missing.'
        );

        $this->check(
            filled(config('services.channex.key')),
            'CHANNEX_API_KEY is configured (value hidden).',
            'CHANNEX_API_KEY is missing.'
        );

        $this->check(
            filled(config('services.channex.webhook_secret')),
            'CHANNEX_WEBHOOK_SECRET is configured (value hidden).',
            'CHANNEX_WEBHOOK_SECRET is missing.'
        );

        $this->check(
            config('services.channex.webhook_secret_header') === 'X-Channex-Webhook-Secret',
            'The Channex webhook secret header is correct.',
            'CHANNEX_WEBHOOK_SECRET_HEADER must be X-Channex-Webhook-Secret.'
        );

        $badMigration = database_path('migrations/2026_01_28_111755_create_room_type.phps_table.php');
        $this->check(
            ! file_exists($badMigration),
            'The duplicate CreateRoomType migration is absent.',
            'The invalid duplicate CreateRoomType migration still exists.'
        );
    }

    protected function findProperty($identifier): ?Property
    {
        $query = Property::query();

        if ($identifier !== null && $identifier !== '') {
            if (ctype_digit((string) $identifier)) {
                return $query->find((int) $identifier);
            }

            return $query
                ->where('name', $identifier)
                ->orWhere('channex_property_id', $identifier)
                ->first();
        }

        $matches = $query
            ->where('name', 'like', 'Test Property%')
            ->orderByDesc('id')
            ->get();

        if ($matches->count() > 1) {
            $this->warnCheck(
                'More than one local test property exists. Verifying the newest one; pass an ID to select explicitly.'
            );
        }

        return $matches->first();
    }

    protected function verifyProperty(Property $property): void
    {
        $this->check(
            ! (bool) $property->allow,
            'Property is hidden from the public website (Allow OFF).',
            'Property Allow is ON; the certification property can appear publicly.'
        );

        if (Schema::hasColumn('properties', 'featured')) {
            $this->check(
                ! (bool) $property->featured,
                'Property is not featured.',
                'Property Featured is ON; turn it off.'
            );
        }

        $this->check(
            $this->isUuid($property->channex_property_id),
            'Channex property UUID: ' . $property->channex_property_id,
            'The Channex property UUID is missing or invalid.'
        );

        $this->check(
            $this->isUuid($property->channex_group_id),
            'Channex group UUID: ' . $property->channex_group_id,
            'The Channex group UUID is missing or invalid.'
        );

        $this->check(
            (bool) $property->channex_synced,
            'Property is marked as Channex synced.',
            'Property is not marked as Channex synced.'
        );
    }

    protected function verifyRoom(Apartment $room): void
    {
        $this->check(
            (bool) $room->allow,
            'Room Allow is ON, so Channex can receive sellable availability.',
            'Room Allow is OFF; full sync will send zero availability and stop sell.'
        );

        $this->check(
            (int) $room->max_adults === 2,
            'Room maximum adult occupancy is 2.',
            'Room maximum adult occupancy is ' . (int) $room->max_adults . '; expected 2.'
        );

        $this->check(
            $this->isUuid($room->channex_room_type_id),
            'Channex room-type UUID: ' . $room->channex_room_type_id,
            'The Channex room-type UUID is missing or invalid.'
        );

        $this->check(
            (bool) $room->channex_synced,
            'Room is marked as Channex synced.',
            'Room is not marked as Channex synced.'
        );

        $plans = $room->channexRatePlans()->where('is_active', true)->get();

        $this->check(
            $plans->isNotEmpty(),
            $plans->count() . ' active rate plan(s) found.',
            'No active rate plans were found.'
        );

        foreach ($plans as $plan) {
            $label = $plan->name . ' (' . number_format((float) $plan->default_rate, 2) . ' USD)';
            $this->check(
                $this->isUuid($plan->channex_rate_plan_id),
                $label . ' is mapped to ' . $plan->channex_rate_plan_id . '.',
                $label . ' has no valid Channex rate-plan UUID.'
            );
        }

        $bar = $plans->first(function ($plan) {
            return stripos($plan->name, 'Best Available Rate') !== false;
        });
        $breakfast = $plans->first(function ($plan) {
            return stripos($plan->name, 'Breakfast') !== false;
        });

        $this->check(
            $bar !== null,
            'Best Available Rate plan exists.',
            'Best Available Rate plan is missing.'
        );

        $this->check(
            $breakfast !== null,
            'Bed & Breakfast rate plan exists.',
            'Bed & Breakfast rate plan is missing.'
        );

        if ($bar) {
            $this->check(
                (float) $bar->default_rate === 100.0,
                'Best Available Rate default is 100.00 USD.',
                'Best Available Rate default is ' . number_format((float) $bar->default_rate, 2) . ' USD; expected 100.00.'
            );
        }

        if ($breakfast) {
            $this->check(
                (float) $breakfast->default_rate === 120.0,
                'Bed & Breakfast default is 120.00 USD.',
                'Bed & Breakfast default is ' . number_format((float) $breakfast->default_rate, 2) . ' USD; expected 120.00.'
            );
        }
    }

    protected function verifyQueueState(): void
    {
        $this->newLine();
        $this->line('Queue checks');

        $connection = config('queue.default');
        $this->check(
            $connection !== 'sync',
            'Queue connection is ' . $connection . '.',
            'QUEUE_CONNECTION is sync; use a persistent queue on the live server.'
        );

        if ($connection === 'database' && Schema::hasTable('jobs')) {
            $pending = DB::table('jobs')->count();
            $pending === 0
                ? $this->pass('No database queue jobs are waiting.')
                : $this->warnCheck($pending . ' database queue job(s) are waiting; confirm the Forge worker is running.');
        }

        if (Schema::hasTable('failed_jobs')) {
            $failed = DB::table('failed_jobs')->count();
            $failed === 0
                ? $this->pass('No failed queue jobs exist.')
                : $this->warnCheck($failed . ' failed queue job(s) exist; inspect php artisan queue:failed.');
        }
    }

    protected function verifyRemoteMappings(Property $property, Apartment $room): void
    {
        if (! filled(config('services.channex.base_url')) || ! filled(config('services.channex.key'))) {
            $this->fail('Remote checks cannot run without CHANNEX_BASE_URL and CHANNEX_API_KEY.');
            return;
        }

        $this->remoteEntityExists('property', '/properties/' . $property->channex_property_id);
        $this->remoteEntityExists('room type', '/room_types/' . $room->channex_room_type_id);

        foreach ($room->channexRatePlans()->where('is_active', true)->get() as $plan) {
            if ($this->isUuid($plan->channex_rate_plan_id)) {
                $this->remoteEntityExists(
                    'rate plan ' . $plan->name,
                    '/rate_plans/' . $plan->channex_rate_plan_id
                );
            }
        }
    }

    protected function remoteEntityExists(string $label, string $uri): void
    {
        try {
            $response = Http::withHeaders([
                'user-api-key' => config('services.channex.key'),
                'Accept' => 'application/json',
            ])->timeout(20)->get(rtrim(config('services.channex.base_url'), '/') . $uri);

            $this->check(
                $response->successful() && filled(data_get($response->json(), 'data.id')),
                'Remote ' . $label . ' exists in Channex.',
                'Remote ' . $label . ' check returned HTTP ' . $response->status() . '.'
            );
        } catch (\Throwable $exception) {
            $this->fail('Remote ' . $label . ' check failed: ' . $exception->getMessage());
        }
    }

    protected function check(bool $condition, string $success, string $failure, bool $warning = false): void
    {
        if ($condition) {
            $this->pass($success);
            return;
        }

        $warning ? $this->warnCheck($failure) : $this->fail($failure);
    }

    protected function pass(string $message): void
    {
        $this->line('<fg=green>PASS</>  ' . $message);
    }

    protected function warnCheck(string $message): void
    {
        $this->warnings++;
        $this->line('<fg=yellow>WARN</>  ' . $message);
    }

    protected function fail(string $message): void
    {
        $this->failures++;
        $this->line('<fg=red>FAIL</>  ' . $message);
    }

    protected function printSummary(): void
    {
        $this->newLine();
        $this->line('Result: ' . ($this->failures === 0 ? '<fg=green>READY</>' : '<fg=red>NOT READY</>'));
        $this->line('Failures: ' . $this->failures . ' | Warnings: ' . $this->warnings);

        if ($this->failures === 0) {
            $this->info('The local setup passed all required checks. This command did not change or sync any data.');
        } else {
            $this->error('Fix the failed checks before running a live sync or recording the test.');
        }
    }

    protected function isUuid($value): bool
    {
        return is_string($value)
            && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value) === 1;
    }
}
