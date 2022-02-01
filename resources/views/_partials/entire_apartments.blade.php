<div class="bold mb-2"> Entire apartment </div>
<div class="d-flex justify-content-between flex-wrap">
    <div class="position-relative">
        <span class="position-absolute svg-icon-section">
            <svg  class="">
                <use xlink:href="#bedrooms-icon"></use>
            </svg>
        </span> 
        <span class="svg-icon-text">{{ $obj->no_of_rooms }}  Bedrooms</span>
    </div>
    <div class="position-relative">
        <span class="position-absolute svg-icon-section">
            <svg  class="">
                <use xlink:href="#bathroom-icon"></use>
            </svg>
        </span> 
        <span class="svg-icon-text">{{ $obj->toilets }}  bathrooms</span>
    </div>

    <div class="position-relative">
       <span class="position-absolute svg-icon-section">
            <svg  class="">
                <use xlink:href="#bathroom-icon"></use>
            </svg>
        </span> 
        <span class="svg-icon-text">{{ $obj->max_adults + $obj->max_children }} Guests</span>
    </div>

</div>
