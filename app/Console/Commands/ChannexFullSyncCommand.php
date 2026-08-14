<?php

namespace App\Console\Commands;

use App\Jobs\RunChannexFullSync;
use App\Models\Property;
use Illuminate\Console\Command;

class ChannexFullSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channex:full-sync {property_id?} {--days=500}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue a Channex full sync (availability + rates/restrictions) for one property or all synced properties';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $propertyId = $this->argument('property_id');

        $query = Property::query()->whereNotNull('channex_property_id');

        if ($propertyId) {
            $query->where('id', (int) $propertyId);
        }

        $properties = $query->get();

        if ($properties->isEmpty()) {
            $this->warn('No synced properties found for full sync.');
            return 0;
        }

        foreach ($properties as $property) {
            RunChannexFullSync::dispatch($property->id, $days);
            $this->info('Queued full sync for property ID ' . $property->id . ' (' . $property->name . ').');
        }

        return 0;
    }
}
