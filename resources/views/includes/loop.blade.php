
@if ($obj->children->count())
@foreach($obj->children as $obj)
    @include('includes.loop',['obj'=>$obj])
@endforeach

@else
    <div class="togglebutton ml-3">
        <label>
            <input  
                {{ $helper->check(optional($model)->attributes , $obj->id) ? 'checked' : '' }} 
                name="attribute_id[]"  value="{{ $obj->id }}" type="checkbox" 
            >
        {{ $obj->name }}
        </label>
    </div>

@endif

