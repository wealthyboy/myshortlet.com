@foreach( $apartment_facilities as $apartment_facility )
    <div>{{ $apartment_facility->name }}</div>                       
    @foreach($apartment_facility->children->sortBy('name') as $child)
    <div class="mt-2 mb-2">
        <div class="togglebutton">
            <label>
                <input 
                    {{ $helper->check(optional($model)->attributes , $child->id) ? 'checked' : '' }} 

                    name="attribute_id[]"  value="{{ $child->id }}" type="checkbox" 
                >
                @if (isset($variation))
                <span class="toggle"></span>
                @endif

            {{ $child->name }}
            </label>
            @include('includes.loop',['obj'=>$child,'space'=>'&nbsp;&nbsp;','model' => $model])
        </div>
    </div>
    @endforeach
@endforeach