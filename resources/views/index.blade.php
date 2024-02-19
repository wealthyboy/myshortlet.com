@extends('layouts.app')
@section('content')


<div class="video-section">
   <div class="intro-image">
      <img src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" alt="">
   </div>
   <!-- 
   <div role="button" class="intro-image play">
      <a class=" play-video" href="#">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
            <path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z" />
         </svg>
      </a>
   </div> -->

   <!-- <video class=" vidoeo-intro" src="/video/avem.mp4" autoplay muted loop></video> -->

   <div id="main-banner" class="carousel slide carousel-fade" data-ride=" carousel">
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
   <search-apartments />
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

   <div class="row p-1 ">
      <div id="tree" class="opacity-0" style="background-image: url(https://drive.google.com/thumbnail?id=1aP9OVoify71pxLWDV-P33fYb5sopnI2g&sz=w2000);
    background-repeat: no-repeat;
    background-position: right -10px top 35px;
    height: 500px;
    position: absolute;
    width: -webkit-fill-available;"></div>
      <div class="col-md-12">


         <section id="rbox1" class=" ">
            <div class="row   position-relative">
               <div class="col-md-7 rounded  card-background-image">
                  <div id="c1" class="carousel slide" data-ride="carousel">
                     <!-- <ol class="carousel-indicators">
                        <li data-target="#c1" data-slide-to="0" class="active"></li>
                        <li data-target="#c1" data-slide-to="1"></li>
                        <li data-target="#c1" data-slide-to="2"></li>
                     </ol> -->
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="https://drive.google.com/thumbnail?id=1ES6PROkjg09AnQdO2hn033mzg48dJT8S&sz=w2000" class="d-block w-100" alt="...">
                        </div>

                     </div>


                     <!-- <button class="carousel-control-prev" data-target="#c1" data-slide="prev"><svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Previous</span></button>

                     <button class="carousel-control-next" data-target="#c1" data-slide="next"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Next</span></button> -->

                  </div>
               </div>
               <div class="col-md-5  text-center d-flex justify-content-center align-items-center">
                  <div class="about-panel  bg-right-panel bg-panel-white  bg-panel p-sm-3 p-md-5">
                     <div class="primary-color ">STAY IN THE HEART OF LAGOS</div>
                     <h2 class=" bold-2">Welcome to Avenue Montiagne</h2>
                     <p class="mt-4  text-left text-black light-bold">
                        Our apartments offer amazing amenities, stylish design, and a perfect location for living the lagos dream. With your choice of spacious, meticulously-designed 3-bedroom apartments, youll be sure to find the ideal fit for your needs and lifestyle.
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
      </div>
   </div>
</div>


<div style="background-color: rgb(248, 245, 244);" class="ap mb-3">
   <div class="container-fluid p-5">
      <div id="intro-box2" class=" opacity-0 mt-4 mb-4 ml-2">
         <h2 class=" bold-3 text-left">Luxury Redefined</h2>
         <div class=" text-secondary  lead  text-left mt-2"> Explore Our Exquisite Collection of Apartments</div>
      </div>

      <div class="title">
         <div class="d-flex justify-content-between">
            <h3 class="large-heading bold">Apartments
            </h3>

            <a href="/apartments" class="btn btn-round  btn-primary   py-2  bold-2   align-self-end font-weight-bold-2">
               View All
            </a>
         </div>

      </div>
      <div class="row">

         @foreach($apartments as $key => $apartment)
         <div id="product-{{$key}}" class="col-12 col-md-3   mb-1 mt-1 pl-1 pb-1 px-0 opacity-0">
            <div class="col-md-12 aprts position-relative p-0">
               <div class="owl-carousel owl-theme">
                  @foreach($apartment->images as $image)
                  <div class="item rounded-top">
                     <img src="{{$image->image}}" class="img img-fluid" />
                     <div class="images-count">
                        <button type="button" class="uitk-button uitk-button-medium uitk-button-has-text uitk-button-overlay uitk-gallery-button">
                           <svg class="uitk-icon uitk-icon-leading uitk-icon-medium" aria-label="Show all 7 images for Classic Twin Room" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <title id="photo_library-property-offers-media-carousel-1-title">Show all {{ $apartment->images->count() }} images</title>
                              <path fill-rule="evenodd" d="M22 16V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2zm-11-4 2.03 2.71L16 11l4 5H8l3-4zm-9 8V6h2v14h14v2H4a2 2 0 0 1-2-2z" clip-rule="evenodd"></path>
                           </svg>
                           <span aria-hidden="true">{{ $apartment->images->count() }}</span>
                        </button>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="col-md-12 bg-white  pt-3">
               <div class="card-title bold-2 text-size-1-big  mt-lg-0 mt-sm-3 ">
                  <a href="/apartments">{{ $apartment->name }}</a>
               </div>
               <div class="text-size-2 text-gold">
                  <i class="fas fa-info-circle mr-2 "></i>Instant Confirmation
               </div>
               <div class="entire-apartments">
                  <div class="bold-2 mb-2">Entire apartment</div>
                  <div class="d-flex justify-content-between flex-wrap flex-column">
                     <div class="position-relative mb-1">
                        <span class="position-absolute svg-icon-section">
                           <svg>
                              <use xlink:href="#bedrooms-icon"></use>
                           </svg>
                        </span>
                        <span class="svg-icon-text">{{ $apartment->no_of_rooms }} Bedrooms</span>
                     </div>
                     <div class="position-relative mb-1">
                        <span class="position-absolute svg-icon-section">
                           <svg>
                              <use xlink:href="#bathroom-icon"></use>
                           </svg>
                        </span>
                        <span class="svg-icon-text">{{ $apartment->toilets }} bathrooms</span>
                     </div>
                     <div class="position-relative mb-1">
                        <span class="position-absolute svg-icon-section">
                           <svg>
                              <use xlink:href="#sleeps-icon"></use>
                           </svg>
                        </span>
                        <span class="svg-icon-text">{{ $apartment->guests }} Guests</span>
                     </div>
                  </div>

                  @if($apartment->free_services->count())
                  <div class="d-inline-flex flex-wrap">
                     @foreach($apartment->free_services as $free_service)
                     <div class="position-relative">
                        <span class="position-absolute svg-icon-section"></span>
                        <span class="svg-icon-text text-gray">{{ $free_service->name }}</span>
                     </div>
                     @endforeach
                  </div>
                  @endif

                  @if($apartment->bedrooms->count())
                  @foreach($apartment->bedrooms as $bed)

                  <div class="position-relative mb-1">
                     <span class="position-absolute svg-icon-section">
                        <svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                           <path fill-rule="evenodd" d="M11 7h8a4 4 0 014 4v9h-2v-3H3v3H1V5h2v9h8V7zm-1 3a3 3 0 11-6 0 3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                     </span>
                     <span class="svg-icon-text">{{ $bed->parent->name }}</span>
                     <span class="svg-icon-text">
                        {{ $bed->pivot->bed_count }} {{ $bed->name }}
                     </span>
                  </div>
                  @endforeach

                  @endif

                  <div class="position-relative mb-1">
                     <a class="d-flex active-link text-highlight font-weight-bold-2" href="#">
                        <span aria-hidden="true">More details</span>
                        <svg class="" aria-hidden="true" class="align-self-center" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                           <path d="M10 6 8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"></path>
                        </svg>
                     </a>
                  </div>
               </div>

               <div>
                  <div class="d-flex d-flex justify-content-between">
                     <div class="price-box ">
                        <div class="d-inline-flex  mt-sm-3">
                           @if($apartment->discounted_price)
                           <div class="sale-price mr-3">
                              {{ $apartment->currency }}{{ $apartment->converted_price }}
                           </div>
                           <div class="price bold-3">
                              {{ $apartment->currency }}{{ $apartment->discounted_price }}
                           </div>
                           @else
                           <div class="price bold-3 mt-2">
                              {{ $apartment->currency }}{{ $apartment->converted_price }}
                           </div>
                           @endif

                        </div>
                        <div class="text-size-2">{{ $apartment->price_mode }}</div>
                     </div>
                     <div class="align-self-end">
                        @if($apartment->is_refundable)
                        <div class="font-weight-bold-2 text-success">
                           Fully Refundable
                        </div>
                        @endif

                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>



<div class="container-fluid mb-3">
   <div class="row p-1">
      <div class="col-md-12">
         <section class=" mb-1">
            <div class="row bg-grey position-relative  pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-md-5  opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                  <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                     <h2 class="mb-4 bold-2">Unrivaled Amenities</h2>
                     <div class="lead text-secondary">Elevate Your Living Experience</div>
                     <p class="mt-4  text-left text-black light-bold">
                        Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. Every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat.
                     <div class="buttons">
                        <a href="/experience" class="btn btn-primary rounded bold-2">
                           View More
                        </a>
                     </div>
                     </p>
                  </div>
               </div>

               <div id="rightBox" class="col-md-7 opacity-0">
                  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                     <!-- <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                     </ol> -->
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="https://drive.google.com/thumbnail?id=1objnfLxXO6ui1XncszCPhF9skQMbnM8t&sz=w2000" class="d-block w-100" alt="...">
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
   <div class="row p-1">
      <div class="col-md-12">


         <section id="box3" class=" opacity-0 ">
            <div class="row   pb-5 pt-5 position-relative">
               <div class="col-md-7 rounded  card-background-image">
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
               <div class="col-md-5  text-center d-flex justify-content-center align-items-center">
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