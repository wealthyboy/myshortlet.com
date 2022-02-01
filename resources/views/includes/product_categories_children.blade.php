@foreach($obj->children->sortBy('name') as $obj)
    <div class="children" value="{{ $obj->id }}">
       <div class="checkbox">
            <label>
                <input 
                {{ isset($property) &&   $helper->check($property->locations , $obj->id) ? 'checked' : '' }} 
                type="checkbox" value="{{ trim($obj->id) }}" name="location_id[]" >
                {{ $obj->name }}  
            </label>
        </div>  
    @include('includes.product_categories_children',['obj'=>$obj])
    </div>
@endforeach