@if ($bedrooms->count())

@foreach($bedrooms as $key => $parent)
@if ($apartment->no_of_rooms > $key )
<div class="bedroom-{{ $key + 1 }} mt-3">
    <h6> {{ $parent->name }} </h6>
    @foreach($parent->children as $bedroom)
    <label for="bedroom-{{ $bedroom->id }}-{{ $apartment->id }}" class="radio-inline">
        <input class="radio-button" {{  $apartment->bedrooms->contains($bedroom) ? 'checked' : ''}} value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $apartment->id }}" name="{{ $parent->slug }}_{{ $apartment->id }}" type="radio">{{ $bedroom->name }}
        <div class="bed-count">
            <input name="bed_count[{{ $apartment->id }}][{{ $bedroom->id }}]" placeholder="Number of beds" class="form-control bed-qty" value="{{ $helper->check(optional($apartment)->bedrooms, $bedroom->id,'bed_count')   }}" type="number">
        </div>
    </label>
    @endforeach
</div>
@else
<div class="bedroom-{{ $key + 1 }} d-none  {{ $key }}">
    <div>{{ $parent->name }} </div>
    @foreach($parent->children as $bedroom)
    <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
        <input class="radio-button" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $apartment->id }}" type="radio">{{ $bedroom->name }}
        <div class="bed-count">
            <input name="bed_count[{{ $apartment->id }}][{{ $bedroom->id }}]" placeholder="Number of beds" class="form-control  bed-qty" value="{{ $helper->check(optional($apartment)->bedrooms, $bedroom->id,'bed_count')   }}" type="number">
        </div>
    </label>
    @endforeach
</div>
@endif
@endforeach

@endif