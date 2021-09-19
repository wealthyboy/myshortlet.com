@foreach($obj->children->sortBy('name') as $obj)
    <div class="togglebutton ml-3">
        <label>
            <input  
                {{ $helper->check(optional($model)->attributes , $obj->id) ? 'checked' : '' }} 
                name="attribute_id[]"  value="{{ $obj->id }}" type="checkbox" 
            >
        {{ $obj->name }}
        </label>
    </div>
     
    @include('includes.loop',['obj'=>$obj])
@endforeach

