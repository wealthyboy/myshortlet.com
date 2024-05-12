@foreach($extras as $child)
    <div class="mt-2 mb-2">
        <div class="togglebutton d-flex">
            <label>
            <input 
                {{ $helper->check(optional($obj)->attributes , $child->id) ? 'checked' : '' }} 
                name="{{ $attribute_name }}[]"  value="{{ $child->id }}" type="checkbox" 
            >
            @if (isset($variation))
               <span class="toggle"></span>
            @endif
            {{ $child->name }}
            </label>
            @include('includes.loop',['child'=>$child,'space'=>'&nbsp;&nbsp;','model' => 'Attribute','name' => 'attribute_id'])
        </div>
        <div class="extras-se  form-group">
            <input name="{{ $name }}[{{ $child->id }}]"  value="{{ $helper->check(optional($obj)->extra_services, $child->id,'price')   }}" placeholder="Leave blank if you want it free" class="form-control" type="number">
        </div>
    </div>
@endforeach
