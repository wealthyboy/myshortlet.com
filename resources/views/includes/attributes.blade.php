@foreach($obj->children->sortBy('name') as $ob)
    <div class="" value="{{ $ob->id }}">
        @if (isset($radio))
        <div class="">
            <label>
                <input type="radio" value="{{ $ob->id }}"   name="{{$obj->rules}}[]" >
                {{ $ob->name }}
            </label>
        </div>

       @else
       <div class="">
            <label>
                <input 
                    type="checkbox" 
                    value="{{ $ob->id }}"   
                    name="attribute_ids[]" 
                    {{ isset($room) && isset($helper)  && $helper->check($room->attributes , $ob->id) ? 'checked' : '' }} 
                >
                {{ $ob->name }}
            </label>
        </div> 
        @endif 
    </div>
@endforeach