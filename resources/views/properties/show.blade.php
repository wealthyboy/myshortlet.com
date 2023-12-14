@extends('layouts.listing')
@section('content')
<div class=""></div>
@include('properties.shortlet')

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
      <button style="z-index: 1; right: 3px;" class="close-icon cursor-pointer fa-2x position-absolute"><i class="fal fa-times"></i></button>
      <div id="gallery-images" class="carousel slide carousel-fade" data-ride="carousel">
         <ol class="carousel-indicators">
            @foreach($property->images as $key => $image)
            <li data-target="#gallery-images" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : ''}}"></li>
            @endforeach

         </ol>
         <div class="carousel-inner">
            @foreach($property->images as $key => $image)
            <div class="carousel-item {{ $key == 0 ? 'active' : ''}}">
               <div class="full-background" style="background-image: url('{{ $image->image }}');">
                  <div class="container">
                     <div class="row ">
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
jQuery(function() {
$("#full-image").on('click',function(e){
e.preventDefault()
$("#content").addClass('d-')
$('.gallery-images').removeClass('d-none')
})

$('.close-icon').on('click',function(){
$('.gallery-images').addClass('d-none')
})

  $('.sm-flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });

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


document.addEventListener("DOMContentLoaded", function() {
var lazyImages = [].slice.call(document.querySelectorAll(".lazy"));


if ("IntersectionObserver" in window) {
console.log(lazyImages)

let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
entries.forEach(function(entry) {
if (entry.isIntersecting) {
let lazyImage = entry.target;
lazyImage.style.backgroundImage = `url(${lazyImage.dataset.src})`;
lazyImage.classList.remove("lazy");
console.log(lazyImage)
lazyImageObserver.unobserve(lazyImage);
}
});
});

lazyImages.forEach(function(lazyImage) {
lazyImageObserver.observe(lazyImage);
});
} else {
// Possibly fall back to event handlers here
console.log("error")
}
});


$(document).ready(function() {
// Use on('click') to handle the click event
$('.scrollLink').on('click', function(e) {
e.preventDefault(); // Prevent the default behavior of the link
// Remove 'active' class from all links
$('.scrollLink').removeClass('bold-3');

// Add 'active' class to the clicked link
$(this).addClass('bold-3');
var targetId = $(this).attr('href'); // Get the target ID from the link's href
var targetElement = $(targetId);

if (targetElement.length) {
// Scroll to the target element with a smooth animation
$('html, body').animate({
scrollTop: targetElement.offset().top
}, 1000); // Adjust the duration as needed
}
});


var nav = $('#stickyNav');
var navOffset = nav.offset().top;

// Use scroll event to add or remove the 'sticky' class based on scroll position
$(window).on('scroll', function() {
if ($(window).scrollTop() > navOffset) {
nav.addClass('sticky');
} else {
nav.removeClass('sticky');
}
});
});

@stop