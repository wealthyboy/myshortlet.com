@foreach($obj->children->sortBy('name') as $ob)
    <div class="" value="{{ $ob->id }}">
        @if (isset($radio))
        <div class="">
            <label>
                <input type="radio" value="{{ $ob->id }}"   name="{{ $obj->name }}[]" >
                {{ $space }}{{ $ob->name }}
            </label>
            @include('includes.attributes',['obj'=>$ob,'radio'=>1, 'space'=>'&nbsp;&nbsp;&nbsp;','model' => 'attributes','url' => 'attribute'])

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
                {{ $space }} {{ $ob->name }}
            </label>
        </div> 
        @endif 
    </div>
@endforeach