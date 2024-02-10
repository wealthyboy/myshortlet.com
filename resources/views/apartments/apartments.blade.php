@extends('layouts.listing')
@section('content')


<div class="container-fluid">
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

        <div id="load-products" class="col-md-12 pl-1">
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