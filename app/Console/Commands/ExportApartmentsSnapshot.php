<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportApartmentsSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:export-live-data {--output=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all apartments with images and attributes to a JSON snapshot file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->option('output');

        if (! $filename) {
            $filename = 'exports/apartments_snapshot_' . now()->format('Ymd_His') . '.json';
        }

        if (str_starts_with($filename, '/')) {
            $this->error('Use a relative storage path, e.g. exports/my_file.json');
            return 1;
        }

        $apartments = Apartment::with([
            'property',
            'images',
            'attributes',
            'apartmentfacilities',
        ])->orderBy('id')->get();

        $payload = [
            'generated_at' => now()->toIso8601String(),
            'app_env' => config('app.env'),
            'app_url' => config('app.url'),
            'apartments_count' => $apartments->count(),
            'apartments' => $apartments->map(function (Apartment $apartment) {
                return [
                    'id' => $apartment->id,
                    'name' => $apartment->name,
                    'slug' => $apartment->slug,
                    'property_id' => $apartment->property_id,
                    'price' => $apartment->price,
                    'sale_price' => $apartment->sale_price,
                    'allow' => (bool) $apartment->allow,
                    'quantity' => $apartment->quantity,
                    'max_adults' => $apartment->max_adults,
                    'type' => $apartment->type,
                    'teaser' => $apartment->teaser,
                    'channex_room_type_id' => $apartment->channex_room_type_id,
                    'channex_rate_plan_id' => $apartment->channex_rate_plan_id,
                    'property' => $apartment->property ? [
                        'id' => $apartment->property->id,
                        'name' => $apartment->property->name,
                        'slug' => $apartment->property->slug,
                        'channex_group_id' => $apartment->property->channex_group_id,
                        'channex_property_id' => $apartment->property->channex_property_id,
                    ] : null,
                    'images' => $apartment->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image' => $image->image,
                            'caption' => $image->caption,
                            'created_at' => optional($image->created_at)->toDateTimeString(),
                        ];
                    })->values()->all(),
                    'attributes' => $apartment->attributes->map(function ($attribute) {
                        return [
                            'id' => $attribute->id,
                            'name' => $attribute->name,
                            'type' => $attribute->type,
                            'slug' => $attribute->slug,
                            'pivot' => [
                                'bed_count' => optional($attribute->pivot)->bed_count,
                            ],
                        ];
                    })->values()->all(),
                    'facilities' => $apartment->apartmentfacilities->map(function ($facility) {
                        return [
                            'id' => $facility->id,
                            'name' => $facility->name,
                            'scope' => $facility->scope,
                            'channex_facility_id' => $facility->channex_facility_id,
                        ];
                    })->values()->all(),
                    'created_at' => optional($apartment->created_at)->toDateTimeString(),
                    'updated_at' => optional($apartment->updated_at)->toDateTimeString(),
                ];
            })->values()->all(),
        ];

        Storage::disk('local')->put(
            $filename,
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        Storage::disk('local')->put(
            'exports/latest_apartments_snapshot_path.txt',
            $filename
        );

        $this->info('Export complete: ' . storage_path('app/' . $filename));

        return 0;
    }
}
