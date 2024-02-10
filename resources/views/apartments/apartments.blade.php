@extends('layouts.listing')
@section('content')


<div class="container-fluid p-5">
    <div class="row  ">

        @if (!$apartments)
        <div id="load-products" class="col-md-10 pl-1">
            <div class="no-properties-found">
                <div class="text-center">
                    <i class="fas fa-home fa-5x"></i>
                    <p>We could not match any apartments to your search</p>
                </div>
            </div>
        </div>
        @else



        <div class="col-md-12  p-loader  mt-4">
            <div id="category-loader" class="mt-2 mb-3">
                <div class="apart-loading" style="width: 100%; height: 60px; background-color: rgb(204, 204, 204);"></div>
            </div>
        </div>





        @for($i = 0; $i < 5; $i++) <div class="col-12 col-md-3 border p-loader  mb-1 mt-1 pl-1 pb-1 px-0">
            <div class="col-md-12 aprts position-relative p-0">
                <div style=" height: 250px; background-color: rgb(204, 204, 204);" class="owl-carousel apart-loading owl-theme"></div>
            </div>
            <div class="col-md-12 bg-white  pt-3">
                <div class="card-title bold-2 text-size-1-big  mt-lg-0 mt-sm-3 ">
                    <div style=" height: 12px; background-color: rgb(204, 204, 204);" class="owl-carousel apart-loading owl-theme"></div>
                </div>
                <div class="text-size-2 text-gold">
                    <div style=" height: 5px; background-color: rgb(204, 204, 204);" class="owl-carousel apart-loading owl-theme"></div>
                </div>
                <div class="entire-apartments mt-1">

                    <div class="d-inline-flex flex-wrap">
                        <div class="position-relative">
                            <span class="position-absolute svg-icon-section"></span>
                            <div style=" height: 12px; background-color: rgb(204, 204, 204);" class="owl-carousel apart-loading owl-theme"></div>
                        </div>
                    </div>



                </div>






            </div>
    </div>
    @endfor


    <!-- <div class=" mb-2">
         <img src="/images/utilities/shopwhileyoustay-02.jpg" class="img-fluid" alt="">
      </div> -->
    <apartments-index :property="{{$property}}" :apartments="{{ $apartments }}" />
</div>
@endif


<!-- <div class="col-md-2 pl-2 d-none d-lg-block">
        <a href="https://theluxurysale.com" class="h">
            <img class="img-fluid" src="/images/banners/ads-07.jpg" alt="">
        </a>
    </div> -->
</div>
</div>

<div style="height: 50px;"></div>

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