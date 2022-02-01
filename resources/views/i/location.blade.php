@if ($locations->children->count())
    @foreach($locations->children as $location)
    <option  value="{{ $location->id }}">{{ $location->name }}</option>
    @endforeach
@endif