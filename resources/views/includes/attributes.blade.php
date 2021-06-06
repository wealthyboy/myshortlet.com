@foreach($obj->children->sortBy('name') as $obj)
    <div class="" value="{{ $obj->id }}">
        @if (isset($radio))
        <div class="">
            <label>
                <input type="radio" value="{{ $obj->id }}"   name="attribute_ids[]" >
                {{ $obj->name }}
            </label>
        </div>

       @else
       <div class="">
            <label>
                <input 
                    type="checkbox" 
                    value="{{ $obj->id }}"   
                    name="attribute_ids[]" 
                    {{ isset($room) && isset($helper)  && $helper->check($room->attributes , $obj->id) ? 'checked' : '' }} 
                >
                {{ $obj->name }}
            </label>
        </div> 
        @endif 
    </div>
@endforeach