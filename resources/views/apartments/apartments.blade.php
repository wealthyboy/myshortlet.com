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
            <div id="ap-loaders" class="bg-white mb-2 rounded ap-loaders">
                @for($i = 0; $i < 5; $i++) <div class="bg-white mb-2 rounded ap-loaders">
                    <div class=" position-relative">
                        <div class="row no-gutters"></div>
                    </div>
            </div>
            @endfor
        </div>
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