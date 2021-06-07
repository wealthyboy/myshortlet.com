
@foreach($obj->children->sortBy('name') as $ob)
    <div class="">
        @if (isset($radio))
        <div class="{{ $space ? 'ml-3' : ''}}">
            <label>
                <input type="radio" value="{{ $ob->id }}"   name="{{ $obj->name }}[]" >
                {{ $ob->name }}
            </label>
            @include('includes.attributes',['obj'=>$ob,'radio'=>1, 'space'=>1,'model' => 'attributes','url' => 'attribute'])
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