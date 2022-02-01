@extends('layouts.listing')
@section('content')

<div  style="">
   <div class="category-header banner-filter" style="">
      <div class="container">
         <div class="row">
            <div class="col-md-9 text-center ml-auto mr-auto">
                <h1 class="title text-white">{{ $link_name }}</h1>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid">

<section data-animated-id="2" class="wprt-section how-we-build pt-5 pb-5 mt-5 mb-5">
   <div class="row">
         
         <div class="col-md-4 col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary  d-flex justify-content-center align-items-center  text-center">
               <i class="fas fa-phone-alt fa-2x"></i>
               </div>
            </div>
            <div class="content-wrap">
               <h3 class="dd-title bold text-center">Make Reservations</h3>
               <p class=" text-center">

                   +234 904 238 2206
               </p>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-4 col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary   d-flex justify-content-center align-items-center  text-center">
                  <i class="far fa-envelope fa-2x"></i>
               </div>
               
            </div>
            <div class="content-wrap">
               <h3 class="bold text-center">Send Enquiry</h3>
               <p class=" text-center">
                  info@avenuemontaigne.ng
               </p>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-4  col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary  d-flex justify-content-center align-items-center  text-center">
                  <i class="fas fa-map-marker-alt fa-2x"></i>
               </div>
            </div>
            <div class="content-wrap">
               <h3 class="dd-title bold text-center text-center">Visit the Apartments</h3>
               <p class=" text-center">

               19A, Walter Carrington, Victoria Island, Lagos

               </p>
            </div>
         </div>

         

      </div>
      <!-- /.row -->
   </section>


   <div class="d-flex mb-5 justify-content-center align-content-center  text-center">
      <div class="icon mr-5">
         <a href="#">
            <i class="fab fa-facebook-f fa-2x"></i>
         </a>
      </div>
      <div class="icon">
         <a href="#">
            <i class="fab fa-instagram  fa-2x"></i>      
         </a>
      </div>
   </div>

   <div class="row">
         <div class="col-md-12">
              <div id="map"></div>
         </div>
      </div>
</div>


 
@endsection
@section('inline-scripts')

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
}
function codeAddress(address = "Victoria Island, Lagos") {
geocoder.geocode({ address: address }, function(results, status) {
if (status == "OK") {

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
