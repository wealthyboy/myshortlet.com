<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Channex\FacilitySyncService;

class SyncChannexFacilities extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'channex:sync-facilities';

    /**
     * The console command description.
     */
    protected $description = 'Sync property and room facilities from Channex into local database';

    /**
     * Execute the console command.
     */
    public function handle(FacilitySyncService $service): int
    {
        $this->info('Starting Channex facilities sync...');

        try {
            $count = $service->sync();

            $this->info("Facilities synced successfully ({$count} records).");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Facility sync failed.');
            $this->error($e->getMessage());

            logger()->error('Channex Facility Sync Failed', [
                'exception' => $e,
            ]);

            return Command::FAILURE;
        }
    }
}
