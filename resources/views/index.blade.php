@extends('layouts.app')
@section('content')


<div class="video-section">
   <div class="intro-image">
      <img alt="Avenue Montaigne logo" src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" alt="">
   </div>



   <div class="main-banner owl-carousel owl-theme d-block d-sm-none slider">
      @foreach($images['sliders'] as $key => $image)
      <div style="background-image: url({{ $generator::generateThumbnailUrl($image) }}); " class="item page-header min-vh-75 half-hv position-relative rounded-top">
         <span class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50"></span>
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


<div class="bg-dark">
   <div class="search-header d-block bg-dark  p-3">
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

   <div class="container-fluid mb-2 bg-dark">

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
                  <div class="col-lg-7 col-md-12  rounded  card-background-image">
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
                  <div class="col-lg-5 col-md-12   bg-dark  welcome text-center d-flex justify-content-center align-items-center">
                     <div class="about-panel  bg-right-panel bg-panel-white   bg-dark  bg-panel p-sm-3 p-md-5">
                        <div class="primary-color sub-heading-color">STAY IN THE HEART OF LAGOS</div>
                        <h2 class=" bold-2 text-white ">Welcome to Avenue Montiagne</h2>
                        <p class="mt-4  text-left text-black light-bold room-service-color">
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


   <div style="background-color: rgb(248, 245, 244);" class="ap mb-3 bg-dark">
      <div class="container-fluid ">
         <div id="intro-box2" class=" opacity-0 mt-4 mb-4">
            <h2 class="bold-3 text-left text-white">Luxury Redefined</h2>
            <div class=" text-secondary   text-left mt-2 sub-heading-color"> Explore Our Exquisite Collection of Apartments.</div>
         </div>

         <div class="title">
            <div class="d-flex justify-content-between">
               <h3 class="large-heading bold-2 text-white">Apartments
               </h3>

               <a href="/apartments" class="btn btn-round  btn-primary   py-2  bold-2   align-self-end font-weight-bold-2">
                  View All
               </a>
            </div>

         </div>
         <div class="row  p-1">
            <div id="load-products" class="col-md-12">
               <apartments-index :isGallery="0" :filter="0" :property="{{$property}}" :apartments="{{ $apartments }}" />
            </div>
         </div>
      </div>
   </div>

   <div class="room-essencials bg-dark py-5">
      <div class=" container-fluid apartment-essencials">
         <div class="row p-1">
            <div class="col-md-6 mb-5">

               <div class="">

                  <div class="cs-title-wrap">
                     <div class="text-white"><span class="room-service-color ">The Essential In-Room Amenities</span></div>
                     <h2 class="mb-4 text-white">Our spaces have all the essentials you need for your stay.</h2>

                  </div>
               </div>
            </div>
            <div class="col-md-6  mb-5 room-service-color ">
               Our spaces are thoughtfully designed to provide you with everything you need for a comfortable and enjoyable stay. From essential amenities like air conditioning and high-speed WiFi to convenient onsite parking and daily housekeeping services, we ensure that your needs are met with care and attention to detail.
            </div>

            <div class="col-md-3 col-12 mb-5">
               <div class="d-flex flex-column">
                  <svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path d="M22 11h-4.17l3.24-3.24-1.41-1.42L15 11h-2V9l4.66-4.66-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93 6.34 4.34 11 9v2H9L4.34 6.34 2.93 7.76 6.17 11H2v2h4.17l-3.24 3.24 1.41 1.42L9 13h2v2l-4.66 4.66 1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24 1.42-1.41L13 15v-2h2l4.66 4.66 1.41-1.42L17.83 13H22v-2z"></path>
                  </svg><span class="text-white">Air conditioning</span>
               </div>
               <div class="room-service-color ">
                  Enjoy comfortable indoor temperatures regardless of the weather with our efficient air conditioning systems.
               </div>
            </div>

            <div class="col-md-3 col-12  mb-5">
               <div class="d-flex  flex-column "><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path fill-rule="evenodd" d="m1 9 2 2a12.73 12.73 0 0 1 18 0l2-2A15.57 15.57 0 0 0 1 9zm8 8 3 3 3-3a4.24 4.24 0 0 0-6 0zm-2-2-2-2a9.91 9.91 0 0 1 14 0l-2 2a7.07 7.07 0 0 0-10 0z" clip-rule="evenodd"></path>
                  </svg><span class="text-white">Free WiFi</span></div>

               <div style="color: #9E9E9E;" class="room-service-color ">
                  Stay connected and productive with complimentary high-speed WiFi available throughout the property.
               </div>
            </div>

            <div class="col-md-3 col-12  mb-5">

               <div class="d-flex  flex-column ">
                  <svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-small uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path fill-rule="evenodd" d="M20.15 10.15c-1.59 1.59-3.74 2.09-5.27 1.38L13.41 13l6.88 6.88-1.41 1.41L12 14.41l-6.89 6.87-1.41-1.41 9.76-9.76c-.71-1.53-.21-3.68 1.38-5.27 1.92-1.91 4.66-2.27 6.12-.81 1.47 1.47 1.1 4.21-.81 6.12zm-9.22.36L8.1 13.34 3.91 9.16a4 4 0 0 1 0-5.66l7.02 7.01z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-white">Restaurant</span>
               </div>
               <div class="room-service-color ">
                  Indulge in culinary delights at our onsite restaurants, offering a variety of dishes to satisfy every palate. </div>
            </div>

            <div class="col-md-3 col-12  mb-5">

               <div class="d-flex  flex-column ">
                  <svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-small uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                  </svg>
                  <span class="text-white ">Housekeeping</span>
               </div>
               <div class="room-service-color ">
                  Relax and unwind knowing that our dedicated housekeeping team is taking care of your accommodations.
               </div>
            </div>


            <div class="col-md-3 col-12  mb-5">
               <div class="d-flex flex-column ">
                  <svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-small uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path d="M9.82 11.64h.01a4.15 4.15 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path>
                     <path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 0 0-2.29 0 4.13 4.13 0 0 1-4.36 0h-.01a2.08 2.08 0 0 0-2.29 0 4.13 4.13 0 0 1-4.36 0h-.01a2.08 2.08 0 0 0-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 0 1 4.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path>
                     <path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 0 1-1.15-.36 4.13 4.13 0 0 0-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 0 0-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 0 0-4.36 0h-.01A1.8 1.8 0 0 1 2 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 0 1 2.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 0 1 2.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 0 1 2.29 0h.01zM19 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                  </svg>
                  <span class="text-white">Pool</span>
               </div>
               <div class="room-service-color ">
                  Enjoy swimming laps for exercise or simply lounge by the poolside, soaking up the sun and enjoying the serene ambiance. </div>
            </div>

            <div class="col-md-3 col-12  mb-5">
               <div class="d-flex  flex-column">
                  <svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-small uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path fill-rule="evenodd" d="M14 7c0 .28-.06.55-.16.79A9.01 9.01 0 0 1 21 16H3a9.01 9.01 0 0 1 7.16-8.21A2 2 0 0 1 12 5a2 2 0 0 1 2 2zm8 12v-2H2v2h20z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-white">Room service</span>
               </div>
               <div class="room-service-color ">
                  Indulge in the convenience of room service, bringing delicious meals right to your door for a delightful dining experience without leaving the comfort of your apartment. </div>
            </div>

            <div class="col-md-3 col-12  mb-5">

               <div class="d-flex  flex-column ">
                  <svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-small uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path fill-rule="evenodd" d="M6 3h7a6 6 0 0 1 0 12h-3v6H6V3zm4 8h3.2a2 2 0 0 0 2-2 2 2 0 0 0-2-2H10v4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-white">Parking included</span>
               </div>

               <div class="room-service-color ">
                  Convenient parking facilities are available onsite, providing secure and hassle-free parking for guests' vehicles.
               </div>
            </div>

            <div class="col-md-3 col-12  mb-5">

               <div class="d-flex  flex-column ">
                  <svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                     <path fill-rule="evenodd" d="M19 7V4H5v3H2v13h8v-4h4v4h8V7h-3zM9 10v1h2v1H8V9h2V8H8V7h3v3H9zm6 2h1V7h-1v2h-1V7h-1v3h2v2z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-white">24/7 front desk</span>
               </div>
               <div class="room-service-color ">
                  Experience peace of mind with our 24/7 front desk, available around the clock to assist you with any inquiries you may need. </div>

            </div>
         </div>

      </div>
   </div>
</div>



<div class="container-fluid   bg-dark ">
   <div class="row p-1">
      <div class="col-md-12">
         <section class=" mb-1">
            <div class="row bg-dark position-relative  pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-lg-5  col-md-12  order-sm-2 order-lg-1 opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                  <div class="bg-panel-white bg-left-panel  bg-dark   p-sm-3 p-md-5">
                     <h2 class="mb-4 bold-2 text-white">Unrivaled Amenities</h2>
                     <div class="lead text-secondary sub-heading-color ">Elevate Your Living Experience</div>
                     <p class="mt-4  text-left text-black light-bold room-service-color">
                        Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. Every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat.
                     <div class="buttons">
                        <a href="/experience" class="btn btn-primary rounded bold-2">
                           View More
                        </a>
                     </div>
                     </p>
                  </div>
               </div>

               <div id="rightBox" class="col-lg-7  col-md-12  order-sm-1 opacity-0">
                  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                     <!-- <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                     </ol> -->
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="https://drive.google.com/thumbnail?id=1GlZ6VnD1-5X-v2F3t6aOURj6_NglHntq&sz=w2000" class="d-block w-100" alt="...">
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
    background-size: contain;" class="row  bg-dark  position-relative  pb-5 pt-5">

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
                  <div class="about-panel  bg-right-panel bg-panel-white bg-dark  bg-panel p-sm-3 p-md-5">
                     <h2 class="mb-4 text-white">Seamless Indoor-Outdoor Harmony</h2>
                     <div class="lead text-secondary  sub-heading-color "> Discover Tranquility in our Apartments</div>
                     <p class="mt-4  text-left text-black light-bold  room-service-color">
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
</div>


@endsection
@section('inline-scripts')









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