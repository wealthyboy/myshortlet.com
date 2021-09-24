<form id="collections" action="">
    <div class="text-left pl-3">
        <div class="text-capitalize pb-2 pt-3">Your Budget</div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">less than 200k</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">200k - 500k</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">500k - 1M</span> 
            </label>
            </div> 
        </div>
        <div class="mb-2">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">1M - 10M</span> 
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
                        <input for="box50" name="{{ $child->slug }}[]" value="{{ $child->id }}" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">{{  $child->name }}</span> 
                        </label>
                    </div> 
                </div>
            @endforeach
            @endforeach
        @endif
        @if ( $attributes->count() )
        <div class="text-capitalize ">Cities</div>
        <div class="m-0 ">
            <div class="checkbox">
            <label  id="box50" class="checkbox-label">
            <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text mt-1">less than 200k</span> 
            </label>
            </div> 
        </div>
        @endif


        
    </div>
</form>