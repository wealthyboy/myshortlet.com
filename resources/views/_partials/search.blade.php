<form id="collections" action="">
    <div class="text-left pl-3">
        <div class="text-capitalize pb-2 pt-3">Your Budget</div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-property" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">200,000</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000-500000" class="filter-property" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">200,000k - 500,000k</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="500000-1000000" class="filter-property" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">500,000k - 1,000,000</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="1000000-10000000" class="filter-property" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">1,000,000 - 10,000,000</span> 
            </label>
            </div> 
        </div>
        
        @if ( $attributes->count() )
            @foreach( $attributes as $key => $attribute )
            <div class="text-capitalize pb-2">{{ $str::replaceFirst('_', ' ', $key) }}</div>
            @foreach($attribute as $child)
                <div class="mb-2">
                    <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                           <input for="box50" name="{{ $child->slug }}[]" value="{{ $child->slug }}" class="filter-property" type="checkbox">
                           <span class="checkbox-custom rectangular"></span>
                           <span class="checkbox-label-text mt-1">{{  $child->name }}</span> 
                        </label>
                    </div> 
                </div>
            @endforeach
            @endforeach
        @endif
        @if ( $location->children->count() )

        <div class="text-capitalize pb-2">Cities</div>
        @foreach( $location->children as $city )
            <div class="mb-2">
                <div class="checkbox">
                <label  id="box50" class="checkbox-label">
                <input for="box50" name="cities[]" value="{{ $city->name }}" class="filter-property" type="checkbox">
                    <span class="checkbox-custom rectangular"></span>
                    <span class="checkbox-label-text mt-1">{{ $city->name }}</span> 
                </label>
                </div> 
            </div>
        @endforeach


        @endif


        
    </div>
</form>