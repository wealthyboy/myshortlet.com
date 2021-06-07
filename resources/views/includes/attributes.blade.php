

    <div class="">
        @if (isset($radio))
            <div class="form-group">
                <label class="control-label"></label>
                <select name="attribute_ids[]"  class="form-control">
                    <option  value="" selected>Choose one</option>
                    @foreach($obj->children->sortBy('name') as $ob)
                       <option  value="{{ $ob->name }}">{{ $ob->name }}</option>
                    @endforeach
                </select>
            </div>
       @else
       @foreach($obj->children->sortBy('name') as $ob)
       <div class="{{ $space ? 'ml-3' : ''}}">
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
        @endforeach

        @endif 
    </div>

