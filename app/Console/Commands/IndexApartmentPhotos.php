<?php

namespace App\Console\Commands;

use App\Services\PhotoFinder\ApartmentPhotoFinder;
use Illuminate\Console\Command;
use Throwable;

class IndexApartmentPhotos extends Command
{
    protected $signature = 'photos:index-apartments {--property= : Limit to one AVM property ID} {--force : Recompute existing fingerprints}';
    protected $description = 'Prepare local visual fingerprints for the admin apartment photo finder (does not change photos).';

    public function handle(ApartmentPhotoFinder $finder)
    {
        if ($this->option('property') && (!ctype_digit((string) $this->option('property')) || (int) $this->option('property') < 1)) {
            $this->error('Use a positive AVM property ID.'); return 1;
        }
        $indexed = 0; $failed = 0; $skipped = 0;
        $finder->query(['property_id' => $this->option('property')])->chunkById(100, function ($photos) use ($finder, &$indexed, &$failed, &$skipped) {
            foreach ($photos as $photo) {
                try { $finder->index($photo, (bool) $this->option('force')) ? $indexed++ : $skipped++; }
                catch (Throwable $e) { $failed++; $this->warn('Could not read photo #'.$photo->id.'. Originals are unchanged.'); }
            }
        });
        $this->info("Prepared: {$indexed}. Already current: {$skipped}. Unavailable: {$failed}.");
        return $failed ? 1 : 0;
    }
}
