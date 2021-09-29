<h3> Entire apartment </h3>
<div class="d-flex justify-content-between">
    <div class="">
        <span class="">
        <svg  class="">
            <use xlink:href="#bedrooms-icon"></use>
        </svg>
        </span> 
        {{ $obj->no_of_rooms }} Bedrooms
    </div>
    <div class=""> 
        <span class="">
        <svg  class="">
            <use xlink:href="#bathroom-icon"></use>
        </svg>
        </span> 
        {{ $obj->toilets }}  bathrooms
    </div>
    <div class="">
        <span class="">
        <svg  class="">
            <use xlink:href="#sleeps-icon"></use>
        </svg>
        </span>
        {{ $obj->no_of_rooms }} Sleeps
    </div>
</div>
