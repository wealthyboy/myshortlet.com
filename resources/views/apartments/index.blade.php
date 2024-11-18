@extends('layouts.listing')
@section('content')
<div class="">
   <div class="container">
      <div class="row">
         <div class="col-md-12 category-search ml-auto mr-auto mt-4">
            <div id="category-loader" class="mt-2 mb-3">
               <div class="apart-loading" style="width: 100%; height: 60px; background-color: rgb(204, 204, 204);"></div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid">
   <div class="sidebar-toggle d-block d-sm-none "> <i class="material-icons filter adjust">sort</i> filter</div>
   <div class="sidebar-overlay d-none"></div>
   <div class="row no-gutters ">

      @if (!$properties)
      <div id="load-products" class="col-md-10 pl-1">
         <div class="no-properties-found">
            <div class="text-center">
               <i class="fas fa-home fa-5x"></i>
               <p>We could not match any apartments to your search</p>
            </div>
         </div>
      </div>
      @else
      <div class="col-md-2 pr-2 mobile-sidebar">
         <div class="bg-white sidebar-section"></div>
      </div>
      <div id="load-products" class="col-md-8 pl-1">
         <div id="ap-loaders" class="bg-white mb-2 rounded ap-loaders">
            @for($i = 0; $i < 5; $i++) <div class="bg-white mb-2 rounded ap-loaders">
               <div class=" position-relative">
                  <div class="row no-gutters">

                  </div>
               </div>
         </div>
         @endfor
      </div>
      <!-- <div class=" mb-2">
         <img src="/images/utilities/shopwhileyoustay-02.jpg" class="img-fluid" alt="">
      </div> -->
      <products-index  :next_page="{{ collect($next_page) }}" :propertys="{{ $apartments }}" />
   </div>
   @endif


   <div class="col-md-2 pl-2 d-none d-lg-block">
      <a href="https://theluxurysale.com" class="h">
         <img class="img-fluid" src="/images/banners/ads-07.jpg" alt="">
      </a>
   </div>
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