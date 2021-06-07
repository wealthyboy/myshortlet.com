
@foreach($obj->children->sortBy('name') as $ob)
    <div class="">
        @if (isset($radio))
        <div class="form-group">
            <label class="control-label"></label>
            <select name="attribute_ids[]"  class="form-control">
                <option  value="" selected>Choose one</option>
                <option  value="{{ $ob->name }}" selected>{{ $ob->name }}</option>
            </select>
        </div>
        
       @else
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
        @endif 
    </div>
@endforeach