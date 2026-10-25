<?php

namespace App\Services\PhotoFinder;

use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class ApartmentPhotoFinder
{
    public const TAGS = ['bedroom' => 'Bedroom', 'living_room' => 'Living room', 'bathroom' => 'Bathroom',
        'kitchen' => 'Kitchen', 'dining' => 'Dining room', 'balcony' => 'Balcony / terrace', 'exterior' => 'Exterior', 'other' => 'Other'];

    private $visual;

    public function __construct(VisualSignature $visual) { $this->visual = $visual; }

    public function query(array $filters = [])
    {
        // Only photos belonging to real, non-deleted apartments. Property-wide
        // and unrelated polymorphic galleries must never be mislabelled rooms.
        $apartments = Apartment::query()->select('id')->whereHas('property');
        if (!empty($filters['property_id'])) { $apartments->where('property_id', $filters['property_id']); }
        if (!empty($filters['apartment_id'])) { $apartments->whereKey($filters['apartment_id']); }
        if (!empty($filters['q'])) { $apartments->where('name', 'like', '%'.$filters['q'].'%'); }
        $query = Image::query()->where('imageable_type', (new Apartment)->getMorphClass())->whereIn('imageable_id', $apartments)
            ->whereNotNull('image')->where('image', '<>', '');
        if (($filters['room_tag'] ?? '') === 'untagged') { $query->whereNull('room_tag'); }
        elseif (!empty($filters['room_tag'])) { $query->where('room_tag', $filters['room_tag']); }
        return $query;
    }

    public function source(Image $photo): string { return hash('sha256', (string) $photo->image); }

    public function indexed(Image $photo): bool
    {
        return $photo->photo_signature_source === $this->source($photo)
            && ($photo->photo_signature['version'] ?? null) === VisualSignature::VERSION;
    }

    public function key(Image $photo): string
    {
        $path = parse_url((string) $photo->image, PHP_URL_PATH);
        $file = rawurldecode(basename(is_string($path) ? $path : ''));
        if ($file === '' || strpbrk($file, "/\\\0") !== false || !preg_match('/\.(?:jpe?g|png|webp)$/i', $file) || strpos($file, '..') !== false) {
            throw new RuntimeException('Unsupported stored photo.');
        }
        // Never fetch a URL supplied by a user or stored in an image record.
        // Resolve only within AVM's apartment directory / configured upload disk.
        return 'images/apartments/'.$file;
    }

    public function url(Image $photo, bool $thumbnail = false): string
    {
        try { $key = $this->key($photo); }
        catch (RuntimeException $e) { return asset('backend/img/default_img.png'); }
        if ($thumbnail) { $key = 'images/apartments/m/'.basename($key); }
        return is_file(public_path($key)) ? asset($key) : Storage::disk(config('uploads.disk', 'spaces'))->url($key);
    }

    public function index(Image $photo, bool $force = false): bool
    {
        if (!$force && $this->indexed($photo)) { return false; }
        $source = $this->source($photo);
        $key = $this->key($photo);
        try { $signature = $this->visual->make($this->bytes($key)); }
        catch (Throwable $e) {
            // Older camera originals can exceed the safe decode budget. AVM
            // already has small gallery derivatives; do not decode 24MP files
            // inside an admin web request just to compute a tiny fingerprint.
            $signature = $this->visual->make($this->bytes('images/apartments/m/'.basename($key)));
        }
        // A concurrent upload must not receive the previous file's fingerprint.
        Image::whereKey($photo->id)->where('image', $photo->image)->update([
            'photo_signature' => json_encode($signature), 'photo_signature_source' => $source, 'photo_indexed_at' => now(),
        ]);
        return true;
    }

    private function bytes(string $key): string
    {
        $local = public_path($key);
        $root = realpath(public_path('images/apartments'));
        $real = realpath($local);
        if ($real && (!$root || strpos($real, $root.DIRECTORY_SEPARATOR) !== 0)) {
            throw new RuntimeException('Photo path is outside the apartment gallery.');
        }
        $stream = $real && $root && strpos($real, $root.DIRECTORY_SEPARATOR) === 0
            ? fopen($real, 'rb') : Storage::disk(config('uploads.disk', 'spaces'))->readStream($key);
        if (!is_resource($stream)) { throw new RuntimeException('Stored photo unavailable.'); }
        try { $bytes = stream_get_contents($stream, VisualSignature::MAX_BYTES + 1); }
        finally { fclose($stream); }
        return $bytes;
    }

    public function prepare(array $filters, int $after): array
    {
        $photos = $this->query($filters)->where('id', '>', $after)->orderBy('id')->limit(2)->get();
        $failed = 0; $indexed = 0; $reference = null;
        foreach ($photos as $photo) {
            try { $indexed += $this->index($photo) ? 1 : 0; }
            catch (Throwable $e) {
                $failed++; $reference = (string) Str::uuid();
                Log::warning('apartment_photo_index_failed', ['reference' => $reference, 'image_id' => $photo->id, 'exception_type' => get_class($e)]);
            }
        }
        $last = $photos->isEmpty() ? $after : (int) $photos->last()->id;
        return ['after_id' => $last, 'processed' => $photos->count(), 'indexed' => $indexed, 'failed' => $failed, 'reference' => $reference,
            'done' => !$this->query($filters)->where('id', '>', $last)->exists()];
    }

    public function card(Image $photo, ?int $score = null): array
    {
        $apartment = $photo->imageable;
        return ['id' => $photo->id, 'url' => $this->url($photo), 'thumbnail_url' => $this->url($photo, true), 'caption' => $photo->caption,
            'apartment_id' => $apartment->id, 'apartment_name' => $apartment->name,
            'property_name' => optional($apartment->property)->name, 'room_tag' => $photo->room_tag,
            'edit_url' => route('admin.apartments.edit', ['apartment' => $apartment->id, 'mode' => 'shortlet']),
            'tag_url' => route('admin.photo-finder.tag', $photo->id), 'score' => $score];
    }

    public function search(string $bytes, array $filters): array
    {
        $signature = $this->visual->make($bytes);
        $results = []; $total = 0; $indexed = 0;
        foreach ($this->query($filters)->orderBy('id')->cursor() as $photo) {
            $total++;
            if (!$this->indexed($photo)) { continue; }
            $indexed++;
            $results[] = ['id' => $photo->id, 'score' => $this->visual->score($signature, $photo->photo_signature)];
            // Bounded memory even with large apartment galleries.
            usort($results, fn ($a, $b) => ($b['score'] <=> $a['score']) ?: ($a['id'] <=> $b['id']));
            $results = array_slice($results, 0, 24);
        }
        $photos = $this->query($filters)->whereIn('id', array_column($results, 'id'))->with('imageable.property')->get()->keyBy('id');
        $cards = [];
        foreach ($results as $result) {
            if (isset($photos[$result['id']])) { $cards[] = $this->card($photos[$result['id']], $result['score']); }
        }
        return ['photos' => $cards, 'total' => $total, 'indexed' => $indexed,
            'close_match' => !empty($results) && $results[0]['score'] >= 86];
    }
}
