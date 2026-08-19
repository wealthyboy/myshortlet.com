<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use App\Models\ChannexRatePlan;
use App\Models\Property;
use App\Services\Channex\ApartmentSyncService;
use App\Services\Channex\GroupPropertyService;
use App\Services\Channex\LiveSetupVerificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SetupChannexCertification extends Command
{
    protected $signature = 'channex:setup-certification
        {--execute : Create or repair the isolated certification setup}
        {--name=Test Property - Channex Final Certification : Exact certification property name}';

    protected $description = 'Create an isolated hidden Channex certification property with Twin and Double rooms';

    public function handle(): int
    {
        if (! $this->option('execute')) {
            $this->warn('No data was created. Add --execute to create the isolated certification setup.');
            return self::FAILURE;
        }

        $name = trim((string) $this->option('name'));
        if ($name === '' || stripos($name, 'Test Property') !== 0) {
            $this->error('The certification property name must begin with "Test Property".');
            return self::FAILURE;
        }

        try {
            $property = Property::withTrashed()->where('name', $name)->first() ?: new Property();
            if ($property->trashed()) {
                $property->restore();
            }

            $property->forceFill([
                'name' => $name,
                'address' => '37 Cooper Road, Ikoyi, Lagos',
                'description' => 'Hidden property used only for Channex PMS certification.',
                'type' => 'multiple',
                'mode' => 'shortlet',
                'slug' => Str::slug($name . '-' . ($property->token ?: mt_rand())),
                'token' => $property->token ?: mt_rand(),
                'allow' => false,
                'featured' => false,
                'is_shortlet' => true,
                'price' => 333,
            ])->save();

            app(GroupPropertyService::class)->sync($property);
            $property->refresh();

            $rooms = collect([
                ['name' => 'Twin Room', 'price' => 333],
                ['name' => 'Double Room', 'price' => 333],
            ])->map(function (array $room) use ($property) {
                $apartment = Apartment::withTrashed()
                    ->where('property_id', $property->id)
                    ->where('name', $room['name'])
                    ->first() ?: new Apartment();
                if ($apartment->trashed()) {
                    $apartment->restore();
                }

                $apartment->forceFill([
                    'property_id' => $property->id,
                    'name' => $room['name'],
                    'slug' => Str::slug($property->name . '-' . $room['name']),
                    'price' => $room['price'],
                    'max_adults' => 2,
                    'quantity' => 1,
                    'price_mode' => 'per night',
                    'type' => 'multiple',
                    'allow' => true,
                    'no_of_rooms' => 1,
                    'toilets' => 1,
                    'uuid' => (string) Str::uuid(),
                ])->save();

                $this->upsertRatePlan($apartment, 'Best Available Rate', 333, 'room_only', true);
                $this->upsertRatePlan($apartment, 'Bed & Breakfast Rate', 120, 'breakfast', false);

                app(ApartmentSyncService::class)->sync($apartment);
                return $apartment->fresh('channexRatePlans');
            });

            $report = app(LiveSetupVerificationService::class)->verify($property->fresh(), true);

            $this->table(['Entity', 'Local ID', 'Channex UUID'], collect([
                ['Property', $property->id, $property->channex_property_id],
            ])->merge($rooms->map(fn ($room) => [
                $room->name,
                $room->id,
                $room->channex_room_type_id,
            ]))->all());

            foreach ($rooms as $room) {
                foreach ($room->channexRatePlans as $plan) {
                    $this->line($room->name . ' / ' . $plan->name . ': ' . $plan->channex_rate_plan_id);
                }
            }

            $this->line('Live verification: ' . ($report['ready'] ? 'READY' : 'NOT READY'));
            $this->line('Failures: ' . $report['failures'] . ' | Warnings: ' . $report['warnings']);

            if (! $report['ready']) {
                foreach (collect($report['checks'])->where('status', 'fail') as $check) {
                    $this->error($check['message']);
                }
                return self::FAILURE;
            }

            return self::SUCCESS;
        } catch (\Throwable $exception) {
            $this->error(get_class($exception) . ': ' . $exception->getMessage());
            if ($exception instanceof \Illuminate\Http\Client\RequestException && $exception->response) {
                $this->line(json_encode($exception->response->json(), JSON_UNESCAPED_SLASHES));
            }
            logger()->error('Channex certification setup failed', ['exception' => $exception]);
            return self::FAILURE;
        }
    }

    protected function upsertRatePlan(
        Apartment $apartment,
        string $name,
        float $rate,
        string $mealType,
        bool $isDefault
    ): ChannexRatePlan {
        $plan = ChannexRatePlan::withTrashed()->firstOrNew([
            'apartment_id' => $apartment->id,
            'name' => $name,
        ]);
        if ($plan->trashed()) {
            $plan->restore();
        }

        $plan->forceFill([
            'default_rate' => $rate,
            'meal_type' => $mealType,
            'price_mode' => 'nightly',
            'is_default' => $isDefault,
            'is_active' => true,
        ])->save();

        return $plan;
    }
}