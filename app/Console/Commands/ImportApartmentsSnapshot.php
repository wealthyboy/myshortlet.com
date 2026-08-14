<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ImportApartmentsSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartments:import-live-data {--file=} {--url=} {--truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import apartments snapshot JSON into local apartments/images/attributes/facilities tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        [$decoded, $sourceLabel] = $this->loadSnapshotPayload();

        if (! is_array($decoded)) {
            return 1;
        }

        if (! is_array($decoded) || ! isset($decoded['apartments']) || ! is_array($decoded['apartments'])) {
            $this->error('Invalid snapshot format: apartments array missing.');
            return 1;
        }

        $apartmentRows = $decoded['apartments'];

        if (empty($apartmentRows)) {
            $this->warn('Snapshot is valid but contains zero apartments. Nothing to import.');
            return 0;
        }

        $apartmentColumns = Schema::getColumnListing('apartments');
        $imagesColumns = Schema::getColumnListing('images');
        $attributeColumns = Schema::getColumnListing('attributes');
        $facilityColumns = Schema::getColumnListing('facilities');

        $now = now();

        $apartmentUpserts = [];
        $imagesInserts = [];
        $attributeUpserts = [];
        $pivotAttributeInserts = [];
        $facilityUpserts = [];
        $pivotFacilityInserts = [];
        $apartmentIds = [];

        foreach ($apartmentRows as $row) {
            if (! isset($row['id'])) {
                continue;
            }

            $localPropertyId = $this->resolveLocalPropertyIdFromSnapshotRow($row);

            $apartmentIds[] = (int) $row['id'];

            $apartmentPayload = [
                'id' => (int) $row['id'],
                'name' => $row['name'] ?? null,
                'slug' => $row['slug'] ?? null,
                'property_id' => $localPropertyId,
                'price' => $row['price'] ?? null,
                'sale_price' => $row['sale_price'] ?? null,
                'allow' => $row['allow'] ?? null,
                'quantity' => $row['quantity'] ?? null,
                'max_adults' => $row['max_adults'] ?? null,
                'type' => $row['type'] ?? null,
                'teaser' => $row['teaser'] ?? null,
                'channex_room_type_id' => $row['channex_room_type_id'] ?? null,
                'channex_rate_plan_id' => $row['channex_rate_plan_id'] ?? null,
                'created_at' => $this->parseDateOrFallback($row['created_at'] ?? null, $now),
                'updated_at' => $this->parseDateOrFallback($row['updated_at'] ?? null, $now),
            ];

            $apartmentUpserts[] = $this->filterToColumns($apartmentPayload, $apartmentColumns);

            foreach (($row['images'] ?? []) as $imageRow) {
                $imagePayload = [
                    'image' => $imageRow['image'] ?? null,
                    'caption' => $imageRow['caption'] ?? null,
                    'imageable_type' => Apartment::class,
                    'imageable_id' => (int) $row['id'],
                    'created_at' => $this->parseDateOrFallback($imageRow['created_at'] ?? null, $now),
                    'updated_at' => $now,
                ];

                $imagesInserts[] = $this->filterToColumns($imagePayload, $imagesColumns);
            }

            foreach (($row['attributes'] ?? []) as $attributeRow) {
                if (! isset($attributeRow['id'])) {
                    continue;
                }

                $attributePayload = [
                    'id' => (int) $attributeRow['id'],
                    'name' => $attributeRow['name'] ?? null,
                    'type' => $attributeRow['type'] ?? null,
                    'slug' => $attributeRow['slug'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $attributeUpserts[] = $this->filterToColumns($attributePayload, $attributeColumns);

                $pivotAttributeInserts[] = [
                    'apartment_id' => (int) $row['id'],
                    'attribute_id' => (int) $attributeRow['id'],
                    'bed_count' => data_get($attributeRow, 'pivot.bed_count'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach (($row['facilities'] ?? []) as $facilityRow) {
                if (! isset($facilityRow['id'])) {
                    continue;
                }

                $facilityPayload = [
                    'id' => (int) $facilityRow['id'],
                    'name' => $facilityRow['name'] ?? null,
                    'scope' => $facilityRow['scope'] ?? null,
                    'channex_facility_id' => $facilityRow['channex_facility_id'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $facilityUpserts[] = $this->filterToColumns($facilityPayload, $facilityColumns);

                $pivotFacilityInserts[] = [
                    'apartment_id' => (int) $row['id'],
                    'facility_id' => (int) $facilityRow['id'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $apartmentIds = array_values(array_unique($apartmentIds));

        if (empty($apartmentIds)) {
            $this->warn('No valid apartment ids found in snapshot.');
            return 0;
        }

        DB::transaction(function () use (
            $apartmentIds,
            $apartmentUpserts,
            $imagesInserts,
            $attributeUpserts,
            $pivotAttributeInserts,
            $facilityUpserts,
            $pivotFacilityInserts
        ) {
            if ($this->option('truncate')) {
                DB::table('apartment_facility')->delete();
                DB::table('apartment_attribute')->delete();
                DB::table('images')->where('imageable_type', Apartment::class)->delete();
                DB::table('apartments')->delete();
            } else {
                DB::table('apartment_facility')->whereIn('apartment_id', $apartmentIds)->delete();
                DB::table('apartment_attribute')->whereIn('apartment_id', $apartmentIds)->delete();
                DB::table('images')
                    ->where('imageable_type', Apartment::class)
                    ->whereIn('imageable_id', $apartmentIds)
                    ->delete();
            }

            DB::table('apartments')->upsert(
                $apartmentUpserts,
                ['id'],
                array_values(array_diff(array_keys($apartmentUpserts[0]), ['id']))
            );

            if (! empty($attributeUpserts)) {
                DB::table('attributes')->upsert(
                    $this->uniqueRowsByKey($attributeUpserts, 'id'),
                    ['id'],
                    array_values(array_diff(array_keys($attributeUpserts[0]), ['id']))
                );
            }

            if (! empty($facilityUpserts)) {
                DB::table('facilities')->upsert(
                    $this->uniqueRowsByKey($facilityUpserts, 'id'),
                    ['id'],
                    array_values(array_diff(array_keys($facilityUpserts[0]), ['id']))
                );
            }

            if (! empty($imagesInserts)) {
                DB::table('images')->insert($imagesInserts);
            }

            if (! empty($pivotAttributeInserts)) {
                DB::table('apartment_attribute')->insert($pivotAttributeInserts);
            }

            if (! empty($pivotFacilityInserts)) {
                DB::table('apartment_facility')->insert($pivotFacilityInserts);
            }
        });

        $this->info('Import complete from: ' . $sourceLabel);
        $this->info('Apartments imported: ' . count($apartmentIds));

        return 0;
    }

    private function loadSnapshotPayload(): array
    {
        $urlOption = trim((string) $this->option('url'));

        if ($urlOption !== '') {
            $this->info('Downloading snapshot from URL...');
            return $this->downloadSnapshotFromUrl($urlOption);
        }

        $snapshotPath = $this->resolveSnapshotPath();

        if (! $snapshotPath || ! File::exists($snapshotPath)) {
            $this->error('Snapshot file not found. Use --url=https://... or --file=/path/to/snapshot.json');
            return [null, null];
        }

        $raw = File::get($snapshotPath);
        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            $this->error('Invalid JSON in snapshot file: ' . $snapshotPath);
            return [null, null];
        }

        return [$decoded, $snapshotPath];
    }

    private function downloadSnapshotFromUrl(string $url): array
    {
        try {
            $response = Http::timeout(180)->get($url);
        } catch (\Throwable $e) {
            $this->error('Failed to connect to URL: ' . $e->getMessage());
            return [null, null];
        }

        if (! $response->ok()) {
            $this->error('Download failed. HTTP ' . $response->status() . ' from ' . $url);
            return [null, null];
        }

        $body = trim((string) $response->body());

        $decoded = json_decode($body, true);
        if (is_array($decoded) && isset($decoded['apartments']) && is_array($decoded['apartments'])) {
            return [$decoded, $url];
        }

        // Support pointer files that contain a relative snapshot path.
        if ($body !== '' && str_ends_with($body, '.json')) {
            $resolvedUrl = $this->resolveRelativeUrl($url, $body);

            try {
                $jsonResponse = Http::timeout(180)->get($resolvedUrl);
            } catch (\Throwable $e) {
                $this->error('Failed to fetch snapshot JSON from pointer URL: ' . $e->getMessage());
                return [null, null];
            }

            if (! $jsonResponse->ok()) {
                $this->error('Snapshot JSON download failed. HTTP ' . $jsonResponse->status() . ' from ' . $resolvedUrl);
                return [null, null];
            }

            $jsonDecoded = json_decode((string) $jsonResponse->body(), true);
            if (! is_array($jsonDecoded)) {
                $this->error('Pointer resolved, but JSON payload is invalid: ' . $resolvedUrl);
                return [null, null];
            }

            return [$jsonDecoded, $resolvedUrl];
        }

        $this->error('URL did not return a valid snapshot JSON or pointer path.');
        return [null, null];
    }

    private function resolveRelativeUrl(string $baseUrl, string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $parts = parse_url($baseUrl);
        $scheme = $parts['scheme'] ?? 'https';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';

        return $scheme . '://' . $host . $port . '/' . ltrim($path, '/');
    }

    private function resolveSnapshotPath()
    {
        $fileOption = $this->option('file');

        if ($fileOption) {
            if (str_starts_with($fileOption, '/')) {
                return $fileOption;
            }

            return base_path($fileOption);
        }

        $candidatePointers = [
            public_path('exports/latest_apartments_snapshot_path.txt'),
            storage_path('app/exports/latest_apartments_snapshot_path.txt'),
        ];

        foreach ($candidatePointers as $pointerPath) {
            if (! File::exists($pointerPath)) {
                continue;
            }

            $snapshotRelativeOrAbsolute = trim((string) File::get($pointerPath));

            if ($snapshotRelativeOrAbsolute === '') {
                continue;
            }

            if (str_starts_with($snapshotRelativeOrAbsolute, '/')) {
                return $snapshotRelativeOrAbsolute;
            }

            $publicCandidate = public_path($snapshotRelativeOrAbsolute);
            if (File::exists($publicCandidate)) {
                return $publicCandidate;
            }

            $storageCandidate = storage_path('app/' . ltrim($snapshotRelativeOrAbsolute, '/'));
            if (File::exists($storageCandidate)) {
                return $storageCandidate;
            }

            $baseCandidate = base_path($snapshotRelativeOrAbsolute);
            if (File::exists($baseCandidate)) {
                return $baseCandidate;
            }
        }

        return null;
    }

    private function filterToColumns(array $payload, array $columns): array
    {
        return array_intersect_key($payload, array_flip($columns));
    }

    private function uniqueRowsByKey(array $rows, string $key): array
    {
        $unique = [];
        foreach ($rows as $row) {
            if (! isset($row[$key])) {
                continue;
            }
            $unique[(string) $row[$key]] = $row;
        }

        return array_values($unique);
    }

    private function parseDateOrFallback($value, $fallback)
    {
        if (! $value) {
            return $fallback;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return $fallback;
        }
    }

    private function resolveLocalPropertyIdFromSnapshotRow(array $row): ?int
    {
        $snapshotProperty = (array) ($row['property'] ?? []);

        $channexPropertyId = $snapshotProperty['channex_property_id'] ?? null;
        if (! empty($channexPropertyId)) {
            $property = Property::query()
                ->where('channex_property_id', $channexPropertyId)
                ->first();

            if ($property) {
                return (int) $property->id;
            }
        }

        $slug = $snapshotProperty['slug'] ?? null;
        if (! empty($slug)) {
            $property = Property::query()->where('slug', $slug)->first();

            if ($property) {
                return (int) $property->id;
            }
        }

        $name = $snapshotProperty['name'] ?? null;
        if (! empty($name)) {
            $property = Property::query()->where('name', $name)->first();

            if ($property) {
                return (int) $property->id;
            }
        }

        if (isset($row['property_id']) && $row['property_id'] !== null) {
            $existing = Property::query()->find($row['property_id']);
            if ($existing) {
                return (int) $existing->id;
            }
        }

        return null;
    }
}
