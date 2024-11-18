@extends('layouts.checkout')
@section('content')


<section id="content" class="" style="">
   <div class="container ">
      <div class="row no-gutters bg-white ">
         <div class="col-lg-8 py-3 px-2">
            <div class="bg-white">
               <h3 class="bold-3">{{ $apartment->name }}</h3>
            </div>
         </div>

         <div class="clearfix"></div>
         <div class="col-md-8  d-none d-md-block d-lg-block  d-xxl-block  position-relative bg-white ">
            <a href="#" class="img card-img galleries" style="background-image: url('{{ $apartment->google_drive_image_links[0] }}')"></a>
         </div>
         <div class="col-md-4   d-none d-md-block d-lg-block  d-xxl-block ">
            <div class="row no-gutters">
               <div class="col-6 pl-1  pb-1 pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $apartment->google_drive_image_links[1] }}')"></a>
               </div>
               <div class="col-6 ">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $apartment->google_drive_image_links[2] }}')"></a>
                  <a href="#" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-1">
                        <svg id="" class="mt-2">
                           <use xlink:href="#virtual-tour"></use>
                        </svg>
                     </p>
                  </a>
               </div>
               <div class="col-6 pl-1  pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $apartment->google_drive_image_links[3] }}')"></a>
               </div>
               <div class="col-6 pb-2 position-relative">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $apartment->google_drive_image_links[4] }}')"></a>
                  <a href="#" id="full-image" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 bold-2  text-white lh-1 mb-1">+{{ count($apartment->google_drive_image_links) }}</p>
                     <p class="fs-16 bold-2 text-white lh-1625 text-uppercase">View Gallery</p>
                  </a>
               </div>
            </div>
         </div>

      </div>
      <div class="row">
         <div class="col-12 ">
            <div class="d-">
               <single-search  :peak_period="{{$peak_period}}" :apartment="{{$apartment}}" :property="{{$property}}" />
            </div>
         </div>
      </div>
   </div>
   <div class="">
      <div class="container">
         <div class="row  align-items-start">
            <div class=" rounded  mt-1">
               <div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="d-none gallery-images" style="
   position: fixed; 
   display: block;
   width: 100%; 
   height: 100vh; 
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   z-index: 2090; 
   background-color: rgba(0,0,0,.5);
   cursor: pointer;">
   <div class="">
      <div style="z-index: 3; 
      background-color: #fff !important;
    box-shadow: 0 2px .25rem 0 rgba(0, 11, 38, .2) !important;
    color: #342c27 !important;
    height: 2rem !important;
    min-height: 2rem !important;
    width: 2rem !important; 
    display: flex;
    justify-content: center;" class="border  close-icon fa-2x position-absolute "><i class="fal fa-times"></i></div>
      <div id="gallery-images" class="carousel slide carousel-fade" data-ride="carousel">
         <ol class="carousel-indicators">
            @foreach($apartment->google_drive_image_links as $key => $image)
            <li data-target="#gallery-images" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : ''}}"></li>
            @endforeach

         </ol>
         <div class="carousel-inner">
            @foreach($apartment->google_drive_image_links as $key => $image)
            <div class="carousel-item {{ $key == 0 ? 'active' : ''}}">
               <div class="full-background" style="background-image: url('{{ $image }}');">
                  <div class="container">
                     <div class="row">
                     </div>
                  </div>
               </div>
            </div>
            @endforeach

         </div>
         <a class="carousel-control-prev" href="#gallery-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#gallery-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
         </a>

      </div>
   </div>
</div>
@endsection
@section('inline-scripts')

document.addEventListener("DOMContentLoaded", function() {
var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

if ("IntersectionObserver" in window) {
let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
entries.forEach(function(entry) {
if (entry.isIntersecting) {
let lazyImage = entry.target;
lazyImage.src = lazyImage.dataset.src;
lazyImage.srcset = lazyImage.dataset.srcset;
lazyImage.classList.remove("lazy");
lazyImageObserver.unobserve(lazyImage);
}
});
});

lazyImages.forEach(function(lazyImage) {
lazyImageObserver.observe(lazyImage);
});
} else {
// Possibly fall back to event handlers here
}
});
jQuery(function() {
$("#full-image").on('click',function(e){
e.preventDefault()
$("#content").addClass('d-')
$('.gallery-images').removeClass('d-none')

})

$('.close-icon').on('click',function(){
$('.gallery-images').addClass('d-none')
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
function codeAddress(address = "{{ $apartment->city }}, {{ $apartment->state }}") {
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