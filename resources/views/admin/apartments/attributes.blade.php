@foreach($attributes as $key => $attrs)
<h4 class="text-capitalize">{{ $str::replaceFirst('_', ' ', $key) }}</h4>
    @foreach($attrs as $child)
        <div class="mt-2 mb-2">
            <div class="togglebutton ggg">
                <label>
                    <input 
                        {{ $helper->check(optional($ob)->attributes , $child->id) ? 'checked' : '' }} 
                        name="attribute_id[]"  value="{{ $child->id }}" type="checkbox" 
                    >
                {{ $child->name }}
                </label>
                @include('includes.loop',['child'=>$child,'space'=>'&nbsp;&nbsp;','model' => $ob,'name' =>'attribute_id'])
            </div>
        </div>
    @endforeach
@endforeach