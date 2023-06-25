@extends('layouts.listing')
@section('content')
<div class="clearfix"></div>
<section id="content" style="background-color: #f8f5f4;">
   <div class="container ">
      <div class="row  no-gutters bg-white">
         <div class="col-lg-8 col-8">
            <div class="bg-white p-3 bold text-size-1-big">
               <div>{{ $property->name }}</div>
            </div>
         </div>
         <div class="col-md-4 col-4 d-flex   align-items-center  justify-content-end">
            <div>
               <saved :property="{{$property}}" />
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="{{ $property->images->count() >= 4 ? 'col-md-8' : 'col-md-12' }}  position-relative bg-white d-none d-lg-block  ">
            <a href="#" class=" img card-img galleries " style="background-image: url('{{ $property->image }}')"></a>
         </div>
         @if ($property->images->count() >= 4)
         <div class="col-md-4 d-none d-lg-block ">
            <div class="row no-gutters">
               <div class="col-6 pl-1  pb-1 pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ optional($property->images[0])->image }}')"></a>
               </div>
               <!-- <div class="col-6 ">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $property->images[1]->image }}')"></a>
                  <a href="#" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-1">
                        <svg  id="" class="mt-2">
                           <use xlink:href="#virtual-tour"></use>
                        </svg>
                     </p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">Virtual Tour</p>
                  </a>
               </div> -->
               <div class="col-6 pl-1  pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->images[2]->image }}')"></a>
               </div>
               <div class="col-6 pl-1  pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->images[2]->image }}')"></a>
               </div>
               <div class="col-6 pb-2 position-relative">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $property->images[3]->image }}')"></a>
                  <a href="#" id="full-image" class="full-image  bold card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-1">+{{ $property->images->count() }}</p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View Gallery</p>
                  </a>
               </div>
            </div>
         </div>
         @endif
         @include('properties.mobile_slides')

      </div>
      <div class="row">
         <div class="col-12 ">
            <nav class="nav text-capitalize bg-white">
               <a class="nav-link text-capitalize active text-gold text-size-1 pb-3" href="#Overview">Overview</a>
               <a class="nav-link text-capitalize pb-1 text-gold text-size-1" href="#Location">Location</a>
            </nav>
         </div>
      </div>
   </div>
   <div class="">
      <div class="container">
         <div class="row   align-items-start">
            <div class="col-md-8 rounded  mt-1">
               <div id="Overview" class="name scroll-to-div rounded bg-white">
                  <div class="card-body">
                     <h3 class="card-title">{{ $property->name }}</h3>
                     <p class="text-gold text-size-1">Size: {{ $property->size }} sqm</p>

                     <div class="d-flex pb-3 border-bottom mb-3 justify-content-between">
                        @if($property->discounted_price)

                        <div class="price">
                           <del>{{ $property->currency
                              }}{{ number_format($property->converted_price) }}</del>
                        </div>
                        <span>{{ $property->currency
                           }}{{ number_format($property->discounted_price) }}</span><span> per night</span>

                        <div>{{ number_format($property->percentage_off) }}% off</div>
                        @else
                        <div class="bold price">
                           {{ $property->currency }}{{ number_format($property->converted_price)  }}
                           <div class="text-size-2">
                              {{ $property->price_mode }}
                           </div>
                        </div>

                        @endif



                     </div>

                     <div class="text-gold text-size-2 ">
                        <i class="fal fa-phone"></i> Call us at {{ $system_settings->store_phone }} for more info.
                     </div>


                     <div class="row">
                        @if($property->type == 'single')
                        <div class="col-12 entire-apartment">
                           @include('_partials.entire_apartments',['obj' => $property->single_room])
                        </div>
                        @endif
                        <div class="col-md-6">
                           <h5>Facilities</h5>
                           <div class="row">
                              @if($property->facilities->count())
                              @foreach($property->facilities->take(3) as $facility)
                              <div class="col-6 d-flex mb-2 align-items-center">
                                 <span class="position-absolute svg-icon-section">
                                    <?php echo  html_entity_decode($facility->svg) ?>
                                 </span>
                                 <span class="svg-icon-text">{{ $facility->name }}</span>
                              </div>
                              @endforeach
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div style="height: 200px;" id="map2"></div>
                           @if ($areas->count())
                           <h3>Explore the area</h3>
                           <div class="">
                              <ul class="list-unstyled ">
                                 @foreach($areas as $key => $area)
                                 <li class="">{{ $area->name }}</li>
                                 @endforeach
                              </ul>
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>


               <div id="Location" class="name bg-white rounded">
                  <h3 class="card-title  pb-3 p-3 border-bottom">About this property</h3>
                  <div class="card-body">
                     <div>{{ $property->name }}</div>
                     <p><?php echo  html_entity_decode($property->description);  ?></p>
                  </div>
               </div>
               <div class="name bg-white rounded mb-5">
                  <h3 class="card-title  pb-3 p-3 border-bottom">About the area</h3>
                  <div class="card-body">
                     <div class="">
                        <div class="mb-3">
                           <h3> {{ $property->state }}</h3>
                           {{ $property->state_description }}
                        </div>
                        <div class="">
                           <div style="" id="map"></div>
                           <div class="row">
                              <div class="col-md-6 mt-3">
                                 @if ($areas->count())
                                 <h3>What's near by</h3>
                                 <ul class="list-unstyled">
                                    @foreach($areas as $key => $area)
                                    <li class="">{{ $area->name }}</li>
                                    @endforeach
                                 </ul>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="single-apartment rounded col-md-4  d-none d-lg-block ">
               <div class="name  rounded mt-1 bg-white">
                  <div class="card-body">
                     <form id="single-form" action="" method="GET">
                        <input type="hidden" id="qty" />
                        <div class="d-flex pb-3 border-bottom mb-3 justify-content-between">
                           @if($property->discounted_price)
                           <div>
                              <div>
                                 <div>
                                    <del>{{ $property->currency
                                    }}{{ number_format($property->converted_price) }}</del>
                                 </div>
                                 <span>{{ $property->currency
                                 }}{{ number_format($property->discounted_price) }}</span><span> per night</span>
                              </div>
                              <div>{{ number_format($property->percentage_off) }}% off</div>
                           </div>
                           <div>
                              @else
                              <div class="bold price">
                                 {{ $property->currency }}{{ number_format($property->converted_price)  }}
                                 <div class="text-size-2">
                                    {{ $property->price_mode }}
                                 </div>
                              </div>

                           </div>
                           <div class="text-gold text-size-1">
                              <i class="fal fa-phone"></i> Call us at {{ $system_settings->store_phone }} for more info.
                           </div>

                        </div>
                        @endif
                     </form>

                  </div>
               </div>
            </div>

         </div>

      </div>
   </div>
</section>

@include('properties.slider')


@endsection
@section('inline-scripts')
jQuery(function() {
$(".scroll-to-div").click(function() {

$('html,body').animate({
scrollTop: $(".second").offset().top},
'slow');
});

$(".full-image").on('click',function(e){
e.preventDefault()
$('.gallery-images').removeClass('d-none')
console.log(true)
})
$('.close-icon').on('click',function(){
$('.gallery-images').addClass('d-none')
})

$('.owl-carousel').owlCarousel({
loop:true,
margin:10,
nav:true,

responsive:{
0:{
items:1
},
600:{
items:1
},
1000:{
items:1
}

}
})

})
var geocoder;
var map, big_map;
function initialize() {
geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var mapOptions = {
zoom: 17,
center: latlng,
mapTypeControl: false,
streetViewControl: false
};
big_map = new google.maps.Map(document.getElementById("map"), mapOptions);
map = new google.maps.Map(document.getElementById("map2"), mapOptions);
}
function codeAddress(address = "{{ $property->city }}, {{ $property->state }}") {
geocoder.geocode({ address: address }, function(results, status) {
if (status == "OK") {
map.setCenter(results[0].geometry.location);
var marker = new google.maps.Marker({
map: map,
position: results[0].geometry.location,
});
big_map.setCenter(results[0].geometry.location);
var marker = new google.maps.Marker({
map: big_map,
position: results[0].geometry.location,
});
} else {
alert("Geocode was not successful for the following reason: " + status);
}
});
}
window.onload = function() {
initialize();
codeAddress();
};
@stop