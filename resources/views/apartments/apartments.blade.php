@extends('layouts.listing')
@section('content')


<header>
    <div class="page-header min-vh-75 h-28 position-relative" style="background-image: url(https://drive.google.com/thumbnail?id=1DTtgCelVMLA0F2HRS1mJw_U_b5gaksbg&sz=w2000); background-position: top;" loading="lazy">
        <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white text-center">
                    <h1 class="text-white bold-1">Book your stay </h1>
                    <div class="mb-3">
                        <p class="mb-0 display-4 bold-1 text-white">A stay infused with creativity and culture.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



<div class="container">


    <div id="full-bg" class="full-bg position-relative">
        <div class="signup--middle">
            <div class="loading">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <div class="row  ">
        @if (!$apartments)
        <div id="load-products" class="col-md-10 ">
            <div class="no-properties-found">
                <div class="text-center">
                    <i class="fas fa-home fa-5x"></i>
                    <p>We could not match any apartments to your search</p>
                </div>
            </div>
        </div>
        @else

        <div id="load-products-2" class="col-md-12"> 
            <apartments-index :peak_period="{{$peak_period}}" :isGallery="[]" :filter="1" :showResult="{{$apr}}"  :apr="{{$apr}}"  :property="{{$property}}" :apartments="{{ $apartments }}" />
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