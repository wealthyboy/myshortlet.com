@foreach($locations as $location)
    <div class="parent" value="{{ $location->id }}">
        <div class="checkbox">
            <label>
                <input type="checkbox" 
                {{ isset($property) && $helper->check($property->locations , $location->id) ? 'checked' : '' }} 
                value="{{ $location->id }}" name="location_id[]" >
                {{ $location->name }}  
            </label>
        </div>   
            @include('includes.product_categories_children',['obj'=>$location,'space'=>'&nbsp;&nbsp;','model' => 'location','url' => 'location'])
    </div>
@endforeach