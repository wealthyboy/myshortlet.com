<?php

namespace App\Http\Controllers\Admin\Image;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Property;
use App\Models\User;
use App\Services\PhotoFinder\ApartmentPhotoFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class PhotoFinderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless($request->user() && $request->user()->users_permission && User::userHasPermission(2), 403);
            return $next($request);
        });
    }

    private function filters(Request $request): array
    {
        return $request->validate(['property_id' => ['nullable', 'integer', 'min:1'], 'apartment_id' => ['nullable', 'integer', 'min:1'],
            'room_tag' => ['nullable', Rule::in(array_merge(array_keys(ApartmentPhotoFinder::TAGS), ['untagged']))],
            'q' => ['nullable', 'string', 'max:100']]);
    }

    public function index(Request $request, ApartmentPhotoFinder $finder)
    {
        $filters = $this->filters($request);
        $properties = Property::whereHas('apartments')->orderBy('name')->get(['id', 'name']);
        $apartments = Apartment::whereHas('property')->orderBy('name')->get(['id', 'property_id', 'name']);
        return response()->view('admin.photo-finder.index', compact('properties', 'apartments', 'filters'))->header('Cache-Control', 'no-store, private');
    }

    public function photos(Request $request, ApartmentPhotoFinder $finder)
    {
        $filters = $this->filters($request);
        $request->validate(['page' => ['nullable', 'integer', 'min:1', 'max:10000']]);
        $page = $finder->query($filters)->with('imageable.property')->orderBy('id')->paginate(24);
        return response()->json(['photos' => $page->getCollection()->map(fn ($photo) => $finder->card($photo))->values(),
            'total' => $page->total(), 'page' => $page->currentPage(), 'last_page' => $page->lastPage()])->header('Cache-Control', 'no-store, private');
    }

    public function prepare(Request $request, ApartmentPhotoFinder $finder)
    {
        $filters = $this->filters($request);
        $data = $request->validate(['after_id' => ['required', 'integer', 'min:0']]);
        return response()->json($finder->prepare($filters, (int) $data['after_id']));
    }

    public function search(Request $request, ApartmentPhotoFinder $finder)
    {
        $filters = $this->filters($request);
        $request->validate(['photo' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192', 'dimensions:max_width=6000,max_height=6000']]);
        try {
            // PHP's temporary upload is read only. No gallery file is created,
            // no guest photo is retained, and no third-party AI receives it.
            return response()->json($finder->search(file_get_contents($request->file('photo')->getRealPath()), $filters))
                ->header('Cache-Control', 'no-store, private');
        } catch (Throwable $e) {
            $reference = (string) Str::uuid();
            Log::warning('apartment_photo_search_failed', ['reference' => $reference, 'exception_type' => get_class($e)]);
            return response()->json(['message' => 'We could not compare this photo. Try a smaller JPEG, PNG or WebP image (up to 12 megapixels).', 'reference' => $reference], 422);
        }
    }

    public function tag(Request $request, Image $photo, ApartmentPhotoFinder $finder)
    {
        abort_unless($finder->query()->whereKey($photo->id)->exists(), 404);
        $data = $request->validate(['room_tag' => ['present', 'nullable', Rule::in(array_keys(ApartmentPhotoFinder::TAGS))]]);
        $photo->room_tag = $data['room_tag'];
        $photo->save();
        return response()->json(['message' => 'Photo tag saved.', 'room_tag' => $photo->room_tag]);
    }
}
