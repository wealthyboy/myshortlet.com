@foreach($obj->children->sortBy('name') as $obj)
    <div class="children">
       <div class="checkbox">
            <label>
                <input 
                type="checkbox" value="{{ trim($obj->id) }}" name="location_id[]" >
                {{ $obj->name }}  
            </label>
        </div>  
    @include('includes.product_categories',['obj'=>$obj])
    </div>
@endforeach