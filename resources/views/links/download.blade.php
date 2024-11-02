@extends('layouts.auth')
@section('content')
<div style="background-color: rgb(248, 245, 244);">
    <div class="container-fluid">

        <div id="full-bg" class="full-bg position-relative">
            <div class="signup--middle">
                <div class="loading">
                    <div class="loader"></div>
                </div>
            </div>
        </div>

        <div class="row  p-1">
            <div id="load-products" class="col-md-12">
            <div class="col-12 col-md-4 border-bottom  mb-1 mt-1 pl-1 pb-1 px-0">
            <div  id="" class="name mt-1 rounded p-2">
                <div class="position-relative">
                    <input type="hidden" name="property_id" value="217" />
                        <div class="row">
                <div class="col-md-12 aprts position-relative p-0">
                <div class="owl-carousel owl-theme">
                    <div class="item rounded-top" :key="image.id" v-for="image in $room->images">
                    <img src="{{ $image->image }}" class="img   img-fluid" />
                    <div class="images-count">
                        <button type="button"
                        class="uitk-button uitk-button-medium uitk-button-has-text uitk-button-overlay uitk-gallery-button">
                           <span aria-hidden="true"></span>
                           Images
                        </button>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12 bg-white  pt-3">
                <div clsass="card-title bold-2 text-size-1-big  mt-lg-0 mt-sm-3 ">
                    <a href="`/apartment/${$room->slug}`">{{ $room->name }}</a>
                </div>
               
                <!-- https://avenuemontaigne.ng/apartments?rooms=2&check_in_checkout=2024-12-03+to+2025-01-01&children=1&adults=1&apartment_id=28 -->

                <!-- https://avenuemontaigne.ng/apartments?rooms=2&check_in_checkout=2024-12-03%20to%202025-01-01&checkin=2024-12-03&checkout=2025-01-01&children=1&persons=1&expiry=1730573910227?t=0.5217366932299483 -->

              
                </div>

              

                
                </div>
            </div>

        
        </div>
    </div>
</div>

<div style="height: 200px; background-color: rgb(248, 245, 244);"></div>
@endsection
@section('inline-scripts')

jQuery(function () {
$(".owl-carousel").owlCarousel({
margin: 10,
nav: true,
dots: false,
responsive: {
0: {
items: 1,
},
600: {
items: 1,
},
1000: {
items: 1,
},
},
});
});
@stop