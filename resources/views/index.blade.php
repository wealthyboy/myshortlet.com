@extends('layouts.app')
@section('content')


<div class="video-section">
   <div title="Luxury apartments" class="intro-image">
      <img alt="Avenue Montaigne logo" itemscope itemtype="https://schema.org/LogoObject" src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000">
   </div>

   <div id="sm-main-banner" class="main-banner owl-carousel owl-theme d-block d-sm-none slider">
      @foreach($images['sliders'] as $key => $image)
      <div  data-bg-image="{{ $generator::generateThumbnailUrl($image) }}" class=" bg-image-class {{  $key > 0 ? 'd-none' : '' }} item page-header min-vh-75 half-hv position-relative rounded-top">
         <span class="position-absolute top-0 start-0 w-100 h-100 bg-black-2 opacity-50"></span>
      </div>
      @endforeach
   </div>


   <div id="main-banner" class="carousel slide carousel-fade d-none d-md-block" data-ride=" carousel">
      <ol class="carousel-indicators">
         @foreach($images['sliders'] as $key => $image)
         <li data-target="#main-banner" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : ''}}"></li>
         @endforeach
      </ol>
      <div class="carousel-inner header-filter">
         @foreach($images['sliders'] as $key => $image)
         <div class="carousel-item {{ $key === 0 ? 'active' : ''}} ">
            <img src="{{ $generator::generateThumbnailUrl($image) }}" class="d-block w-100" alt="...">
         </div>
         @endforeach
      </div>
      <button class="carousel-control-prev" data-target="#main-banner" data-slide="prev"><svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg><span class="sr-only">Previous</span>
      </button>

      <button class="carousel-control-next" data-target="#main-banner" data-slide="next"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg><span class="sr-only">Next</span></button>
   </div>

</div>



<div class="search-header d-block   p-3">
   <search-apartments :peak_period="{{$peak_period}}" />
</div>

<!-- 
<div class="container-fluid p-5">
   <section class="intro-box">

      <div style="background-image: url(/images/banners/avm_montaigne_intro_bckground.jpg); background-position: center;" class="row  pb-5 pt-3 position-relative">
         <div id="rbox1" style="z-index: 1;" class="col-md-12 text-center d-flex opacity-0  justify-content-center align-items-center">
            <div class="bg-panel bg-panel-white p-sm-3 p-md-5">
               <div class="primary-color ">STAY IN THE HEART OF LAGOS
               </div>
               

               <h2 class=" bold-2">Welcome to Avenue Montiagne</h2>
               <p class="mt-4  text-left text-black light-bold">
                  Our apartments offer amazing amenities, stylish design, and a perfect location for living the lagos dream. With your choice of spacious, meticulously-designed 1-, 2-, or 3-bedroom apartments, youll be sure to find the ideal fit for your needs and lifestyle. Get ready for apartment living on a whole new level, with two resort-style pools, a luxurious spa, and a state-of-the-art fitness center for your convenience and enjoyment. Get excited about everything that awaits you at Avm, Lagos!
               </p>
               <div class=" buttons">
                  <a href="/apartments" class="btn btn-primary rounded bold-2">
                     Explore the Residences
                  </a>

               </div>
            </div>
         </div>
      </div>
   </section>
</div> -->

<div class="container-fluid mb-2">
   <div class="row">
      <div id="tree"  class="opacity-0" data-image="https://drive.google.com/thumbnail?id=1aP9OVoify71pxLWDV-P33fYb5sopnI2g&sz=w2000" style="background-image: url(https://drive.google.com/thumbnail?id=1aP9OVoify71pxLWDV-P33fYb5sopnI2g&sz=w2000);
    background-repeat: no-repeat;
    background-position: right -10px top 35px;
    height: 500px;
    position: absolute;
    width: -webkit-fill-available;"></div>
      <div class="col-md-12">
         <section id="rbox1">
            <div class="row position-relative" itemscope itemtype="https://schema.org/Thing">
               <div class="col-lg-7 col-md-12 rounded card-background-image" itemprop="image">
                  <div id="c1" class="carousel slide" data-ride="carousel">
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img title="STAY IN THE HEART OF LAGOS Avenue montaigne" data-image="https://drive.google.com/thumbnail?id=1ES6PROkjg09AnQdO2hn033mzg48dJT8S&sz=w2000" itemprop="image" class="d-block w-100  image-class" alt="STAY IN THE HEART OF LAGOS avenue montaigne">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5 col-md-12 welcome text-center d-flex justify-content-center align-items-center" itemprop="description">
                  <div class="about-panel bg-right-panel bg-panel-white bg-panel p-sm-3 p-md-5">
                     <div class="primary-color">STAY IN THE HEART OF LAGOS</div>
                     <h2 class="bold-2">Welcome to Avenue Montaigne</h2>
                     <p class="mt-4 text-left text-black light-bold">
                        Our apartments offer amazing amenities, stylish design, and a perfect location for living the Lagos dream. With your choice of spacious, meticulously-designed 3-bedroom apartments, you'll be sure to find the ideal fit for your needs and lifestyle.
                     </p>
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-primary rounded bold-2">
                           View all Apartments
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>


<div style="background-color: rgb(248, 245, 244);" class="ap mb-3">
   <div class="container-fluid">
      <div id="intro-box2" class="opacity-0 mt-4 mb-4">
         <h2 class="bold-3 text-left" itemprop="name">Luxury Redefined</h2>
         <div class="text-secondary text-left mt-2" itemprop="description">Explore Our Exquisite Collection of Apartments.</div>
      </div>

      <div class="title">
         <div class="d-flex justify-content-between">
            <h3 class="large-heading bold" itemprop="name">Apartments</h3>
            <a href="/apartments" class="btn btn-round btn-primary py-2 bold-2 align-self-end font-weight-bold-2" itemprop="url">
               View all Apartments
            </a>
         </div>
      </div>
      <div class="row p-1">
         <div id="load-products" class="col-md-12" itemscope itemtype="https://schema.org/ItemList">
         <apartments-index  :peak_period="{{$peak_period}}" :isGallery="0" :filter="0" :property="{{$property}}" :apartments="{{ $apartments }}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" />
         </div>
      </div>
   </div>
</div>





<div class="container-fluid mb-3">
   <div class="row p-1">
      <div class="col-md-12">
         <section class="mb-1">
            <div class="row bg-grey position-relative pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-lg-5 col-md-12 order-sm-2 order-lg-1 opacity-0 re-order text-center d-flex justify-content-center align-items-center" itemscope itemtype="https://schema.org/WebPageElement">
                  <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                     <h2 class="mb-4 bold-2" itemprop="name">Unrivaled Amenities</h2>
                     <div class="lead text-secondary" itemprop="description">Elevate Your Living Experience</div>
                     <p class="mt-4 text-left text-black light-bold">
                        Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. Every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat.
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-primary rounded bold-2">
                           View all Apartments
                        </a>
                     </div>
                     </p>
                  </div>
               </div>

               <div id="rightBox" class="col-lg-7 col-md-12 order-sm-1 opacity-0" itemscope itemtype="https://schema.org/ImageObject">
                  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img title="View all Apartments Avenue montaigne" data-image="https://drive.google.com/thumbnail?id=1GlZ6VnD1-5X-v2F3t6aOURj6_NglHntq&sz=w2000" class="d-block w-100 image-class" alt="View amenities" itemprop="url">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>



<div class="container-fluid ">
   <div style="background-image: url('/images/banners/flowers.png');
        background-position: center right;
    background-repeat: no-repeat;
    background-size: contain;" class="row bg-grey position-relative  pb-5 pt-5">

      <div class="col-md-12">



         <section id="box3" class=" opacity-0 ">

            <div class="row  position-relative">
               <div class="col-lg-7 col-md-12 rounded  card-background-image">
                  <div id="gallery-banner" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        @foreach($images['gallery'] as $key => $image)
                        <li data-target="#gallery-banner" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : ''}}"></li>
                        @endforeach
                     </ol>
                     <div class="carousel-inner">

                        @foreach($images['gallery'] as $key => $image)
                        <div class="carousel-item {{ $key === 0 ? 'active' : ''}} ">
                           <img src="{{ $generator::generateThumbnailUrl($image) }}" class="d-block w-100" alt="...">
                        </div>
                        @endforeach
                        <!-- <div class="carousel-item">
                           <img src="/images/banners/main_buiding.png" class="d-block w-100" alt="...">
                        </div> -->
                     </div>

                     <button class="carousel-control-prev" data-target="#gallery-banner" data-slide="prev"><svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Previous</span></button>

                     <button class="carousel-control-next" data-target="#gallery-banner" data-slide="next"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Next</span></button>

                  </div>
               </div>
               <div class="col-lg-5 col-md-12  text-center d-flex justify-content-center align-items-center">
                  <div class="about-panel  bg-right-panel bg-panel-white  bg-panel p-sm-3 p-md-5">
                     <h2 class="mb-4">Seamless Indoor-Outdoor Harmony</h2>
                     <div class="lead text-secondary"> Discover Tranquility in our Apartments</div>
                     <p class="mt-4  text-left text-black light-bold">
                        Step into a world where the boundaries between indoor and outdoor living dissolve. Expansive windows frame breathtaking vistas, while private balconies and terraces invite you to savor the beauty of nature. Our commitment to harmonious design ensures that every residence is a sanctuary in sync with the surrounding environment.
                     <div class=" buttons">
                        <a href="/gallery" class="btn btn-primary rounded bold-2">
                           View Gallery
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>


<!-- -------- START HEADER 4 w/ search book a ticket form ------- -->
<header>

   <div class="page-header min-vh-75 half-hv position-relative" style="background-image: url(/images/banners/bed_room.jpg)" loading="lazy">
      <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>

      <div class="container">
         <div class="row">
            <div class="col-lg-8 mx-auto text-white text-center">
               <h1 class="text-white bold-1">Contact Us </h1>
               <div class="mb-3">
                  <p class="mb-0 display-4 bold-1 text-white">Phone: +234 701 897 1322</p>
               </div>

               <!-- Email -->
               <div class="mb-3">
                  <p class="mb-0 display-4 bold-1 text-white">Email: info@avenuemontaigne.ng</p>
               </div>
            </div>
         </div>
      </div>
   </div>

</header>
<!-- -------- END HEADER 4 w/ search book a ticket form ------- -->
@endsection
@section('inline-scripts')

document.addEventListener("DOMContentLoaded", function() {
var bgImages = document.querySelectorAll('.bg-image-class');
bgImages.forEach(function(element) {
var dataBgImage = element.getAttribute('data-bg-image');
if (dataBgImage) {
element.style.backgroundImage = 'url(' + dataBgImage + ')';
}
});
});

document.addEventListener("DOMContentLoaded", function() {
var images = document.querySelectorAll('.image-class');
images.forEach(function(image) {
var dataImage = image.getAttribute('data-image');
if (dataImage) {
image.setAttribute('src', dataImage);
}
});
});






jQuery(function () {



// Add touch event listeners to centered images
$(".intro-image").on("touchstart", function(event){
// Record the initial touch position
var startX = event.touches[0].clientX;

// Add touch move event listener
$(this).on("touchmove", function(event){
// Calculate the distance moved
var moveX = event.touches[0].clientX - startX;

// If the distance moved is greater than a threshold, trigger carousel swipe
if(Math.abs(moveX) > 50){ // Adjust threshold as needed
if(moveX > 0){
// Swipe right
$(".owl-carousel").trigger("prev.owl.carousel");
} else {
// Swipe left
$(".owl-carousel").trigger("next.owl.carousel");
}

// Remove touchmove event listener to prevent multiple triggers
$(this).off("touchmove");
}
});

// Add touchend event listener to clean up
$(this).on("touchend", function(){
// Remove touchmove event listener
$(this).off("touchmove");
});
});
console.log(true)
});
@stop