@extends('admin.layouts.app')
@section('pagespecificstyles')
<link href="{{ asset('backend/css/photo-finder.css') }}?v=20261025" rel="stylesheet">
@endsection
@section('content')
<div id="photo-finder" data-gallery-url="{{ route('admin.photo-finder.photos') }}" data-search-url="{{ route('admin.photo-finder.search') }}" data-prepare-url="{{ route('admin.photo-finder.prepare') }}">
    <header class="pf-heading"><div><span class="pf-eyebrow">AVM · APARTMENT LIBRARY</span><h1>Find the apartment behind the photo.</h1><p>Compare a reference photo with your gallery, or browse by room type. Every result belongs to a named apartment.</p></div><a class="pf-back" href="{{ route('admin.apartments.index') }}">← Apartments</a></header>
    <div id="pf-message" class="pf-message" role="status" aria-live="polite" hidden></div>
    <div class="pf-workspace">
        <aside class="pf-tools">
            <section class="pf-panel"><span class="pf-step">01 · YOUR REFERENCE</span><h2>Search with a photo</h2><p>Upload an Expedia photo or screenshot. Crop out the page around it for a better comparison.</p>
                <label class="pf-upload" for="pf-photo"><span class="material-icons" aria-hidden="true">image_search</span><strong>Choose a reference photo</strong><span>JPEG, PNG or WebP · up to 8 MB / 12 MP</span><input type="file" id="pf-photo" accept="image/jpeg,image/png,image/webp"></label>
                <div id="pf-preview-wrap" hidden><img id="pf-preview" alt="Your reference photo"><p id="pf-filename"></p></div>
                <button class="pf-primary" type="button" id="pf-search">Find similar photos</button><button class="pf-secondary" type="button" id="pf-browse">Browse all photos instead</button>
                <small>Your reference is used only for this search. It is not added to the gallery or sent to an AI service.</small>
            </section>
            <section class="pf-panel"><span class="pf-step">02 · NARROW IT DOWN</span><h2>Filter your gallery</h2>
                <label for="pf-property">Property</label><select id="pf-property"><option value="">All properties</option>@foreach($properties as $property)<option value="{{ $property->id }}" {{ (string)($filters['property_id'] ?? '') === (string)$property->id ? 'selected' : '' }}>{{ $property->name }}</option>@endforeach</select>
                <label for="pf-apartment">Apartment</label><select id="pf-apartment"><option value="">All apartments</option>@foreach($apartments as $apartment)<option value="{{ $apartment->id }}" data-property="{{ $apartment->property_id }}" {{ (string)($filters['apartment_id'] ?? '') === (string)$apartment->id ? 'selected' : '' }}>{{ $apartment->name }}</option>@endforeach</select>
                <label for="pf-tag">Room tag</label><select id="pf-tag"><option value="">All room types</option>@foreach(\App\Services\PhotoFinder\ApartmentPhotoFinder::TAGS as $key => $label)<option value="{{ $key }}" {{ ($filters['room_tag'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>@endforeach<option value="untagged" {{ ($filters['room_tag'] ?? '') === 'untagged' ? 'selected' : '' }}>Not tagged yet</option></select>
                <label for="pf-name">Apartment name</label><input type="search" id="pf-name" value="{{ $filters['q'] ?? '' }}" placeholder="e.g. Cannes or Mayfair">
                <button class="pf-secondary" type="button" id="pf-filter">Apply filters</button><button class="pf-link" type="button" id="pf-clear">Clear filters</button>
            </section>
            <section class="pf-panel pf-index"><h2>First time here?</h2><p>Prepare a searchable fingerprint of existing photos. Original photos and apartment assignments are never changed. New uploads can be prepared here too.</p><button class="pf-secondary" type="button" id="pf-prepare">Prepare photo search</button><button class="pf-link" type="button" id="pf-stop" hidden>Stop after this batch</button><p id="pf-progress" role="status"></p></section>
        </aside>
        <main class="pf-results" aria-labelledby="pf-results-heading"><div class="pf-results-heading"><div><span class="pf-eyebrow">YOUR APARTMENT PHOTOS</span><h2 id="pf-results-heading">Photo library</h2><p id="pf-summary">Loading your apartment photos…</p></div><span class="pf-library-note">Tag photos as you browse</span></div>
            <div class="pf-caution">Visual results are suggestions, not confirmed identities. Compare the furniture, layout and finishes before mapping an OTA room. A different angle or a heavily cropped photo may not match.</div>
            <div id="pf-grid" class="pf-grid" aria-busy="true"></div><p id="pf-empty" class="pf-empty" hidden>No photos match these filters. Try all room types, or prepare photo search first.</p>
            <nav class="pf-pagination" aria-label="Photo pages"><button type="button" class="pf-secondary" id="pf-prev" disabled>← Previous</button><span id="pf-page"></span><button type="button" class="pf-secondary" id="pf-next" disabled>Next →</button></nav>
        </main>
    </div>
</div>
@endsection
@section('page-scripts')
<script src="{{ asset('backend/js/photo-finder.js') }}?v=20261025" defer></script>
@endsection
