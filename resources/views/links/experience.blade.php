@extends('layouts.auth')
@section('content')








<div class="container-fluid mb-3">
   <div class="row p-1">
      <div class="col-md-12">


         <section id="intro-box" class=" opacity-0 ">
            <div class="row  bg-grey pb-5 pt-5 position-relative">
               <div class="col-md-7 rounded  card-background-image">
                  <div id="c1" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#c1" data-slide-to="0" class="active"></li>
                        <li data-target="#c1" data-slide-to="1"></li>
                        <li data-target="#c1" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="/images/banners/5E8A0784.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                           <img src="/images/banners/ikoyi_city.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                           <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/04/Pendry-March-2023-HR-115.jpg" class="d-block w-100" alt="...">
                        </div>
                     </div>

                     <button class="carousel-control-prev" data-target="#c1" data-slide="prev"><svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Previous</span></button>

                     <button class="carousel-control-next" data-target="#c1" data-slide="next"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
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
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-primary rounded bold-2">
                           View All
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>









<div class="container-fluid">
   <div class="row p-1">
      <div class="col-md-12">
         <section class=" mb-1">
            <div class="row bg-grey position-relative  pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-md-5  opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                  <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                     <h2 class="mb-4 bold-2">Spa</h2>
                     <div class="lead text-secondary">Coming Soon</div>
                     <p class="mt-4  text-left text-black light-bold">
                        our spa will offer a sanctuary of serenity amidst the hustle and bustle of everyday life
                     </p>
                     <div class="buttons">
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
                           <img src="/images/banners/spa.jpeg" class="d-block w-100" alt="...">
                        </div>

                     </div>

                  </div>


               </div>

            </div>
         </section>
      </div>
   </div>
</div>



<div class="container-fluid">
   <div class="row p-1">
      <div class="col-md-12">
         <!-- <section class=" mb-1">
            <div  class="row bg-grey position-relative  pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-md-5  opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                  <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                     <h2 class="mb-4 bold-2">Unrivaled Amenities</h2>
                     <div class="lead text-secondary">Elevate Your Living Experience</div>
                     <p class="mt-4  text-left text-black light-bold">
                     <div class="row" role="list">
                        <div class="col-md-4 p-0 pl-1">

                           <div class=" d-flex p-3"><svg class="e" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M20 3H4v10a4 4 0 0 0 4 4h6a4 4 0 0 0 4-4v-3h2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 5h-2V5h2v3zm0 11H4v2h16v-2z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">In Room Service</span></div>
                           <div class=" d-flex p-3"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M9.82 11.64h.01a4.15 4.15 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path>
                                 <path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 0 0-2.29 0 4.13 4.13 0 0 1-4.36 0h-.01a2.08 2.08 0 0 0-2.29 0 4.13 4.13 0 0 1-4.36 0h-.01a2.08 2.08 0 0 0-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 0 1 4.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 0 1 4.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path>
                                 <path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 0 1-1.15-.36 4.13 4.13 0 0 0-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 0 0-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 0 0-4.36 0h-.01A1.8 1.8 0 0 1 2 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 0 1 2.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 0 1 2.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 0 1 2.29 0h.01zM19 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Pool</span></div>
                           <div class=" d-flex p-3"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M20.15 10.15c-1.59 1.59-3.74 2.09-5.27 1.38L13.41 13l6.88 6.88-1.41 1.41L12 14.41l-6.89 6.87-1.41-1.41 9.76-9.76c-.71-1.53-.21-3.68 1.38-5.27 1.92-1.91 4.66-2.27 6.12-.81 1.47 1.47 1.1 4.21-.81 6.12zm-9.22.36L8.1 13.34 3.91 9.16a4 4 0 0 1 0-5.66l7.02 7.01z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Restaurant</span></div>
                           <div class=" d-flex p-3"><svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M21 3v2l-8 9v5h5v2H6v-2h5v-5L3 5V3h18zM5.66 5l1.77 2h9.14l1.78-2H5.66z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Bar</span></div>
                           <div class=" d-flex p-3"><svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M14 7c0 .28-.06.55-.16.79A9.01 9.01 0 0 1 21 16H3a9.01 9.01 0 0 1 7.16-8.21A2 2 0 0 1 12 5a2 2 0 0 1 2 2zm8 12v-2H2v2h20z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Room service</span></div>

                           <div class=" d-flex p-3"><svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M12.06 2a11.8 11.8 0 0 1 3.43 7.63A14.36 14.36 0 0 0 12 12.26a13.87 13.87 0 0 0-3.49-2.63A12.19 12.19 0 0 1 12.06 2zM2 10a12.17 12.17 0 0 0 10 12 12.17 12.17 0 0 0 10-12c-4.18 0-7.85 2.17-10 5.45A11.95 11.95 0 0 0 2 10z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Spa</span></div>

                        </div>
                        <div class="col-md-4 p-0 pr-1">
                           <div class=" d-flex p-3"><svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="m1 9 2 2a12.73 12.73 0 0 1 18 0l2-2A15.57 15.57 0 0 0 1 9zm8 8 3 3 3-3a4.24 4.24 0 0 0-6 0zm-2-2-2-2a9.91 9.91 0 0 1 14 0l-2 2a7.07 7.07 0 0 0-10 0z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Free WiFi</span></div>
                           <div class=" d-flex p-3"><svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M6 3h7a6 6 0 0 1 0 12h-3v6H6V3zm4 8h3.2a2 2 0 0 0 2-2 2 2 0 0 0-2-2H10v4z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Parking included</span></div>
                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M22 11h-4.17l3.24-3.24-1.41-1.42L15 11h-2V9l4.66-4.66-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93 6.34 4.34 11 9v2H9L4.34 6.34 2.93 7.76 6.17 11H2v2h4.17l-3.24 3.24 1.41 1.42L9 13h2v2l-4.66 4.66 1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24 1.42-1.41L13 15v-2h2l4.66 4.66 1.41-1.42L17.83 13H22v-2z"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Air conditioning</span>
                           </div>

                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Housekeeping</span>
                           </div>
                           <div class=" d-flex p-3">

                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M18 2.01 6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4c0-1.11-.89-1.99-2-1.99zM11 5a1 1 0 0 0-1-1 1 1 0 0 0-1 1 1 1 0 0 0 1 1 1 1 0 0 0 1-1zM9.17 16.83a4 4 0 0 0 5.66-5.66l-5.66 5.66zM7 4a1 1 0 0 1 1 1 1 1 0 0 1-1 1 1 1 0 0 1-1-1 1 1 0 0 1 1-1zM6 14a6 6 0 1 0 12.01-.01A6 6 0 0 0 6 14z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Laundry</span>
                           </div>

                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M19 7V4H5v3H2v13h8v-4h4v4h8V7h-3zM9 10v1h2v1H8V9h2V8H8V7h3v3H9zm6 2h1V7h-1v2h-1V7h-1v3h2v2z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">24/7 front desk</span>
                           </div>

                        </div>

                        <div class="col-md-4 p-0 pr-1">
                           <div class=" d-flex p-3"><svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="m1 9 2 2a12.73 12.73 0 0 1 18 0l2-2A15.57 15.57 0 0 0 1 9zm8 8 3 3 3-3a4.24 4.24 0 0 0-6 0zm-2-2-2-2a9.91 9.91 0 0 1 14 0l-2 2a7.07 7.07 0 0 0-10 0z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Free WiFi</span></div>
                           <div class=" d-flex p-3"><svg class="uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-default-theme" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M6 3h7a6 6 0 0 1 0 12h-3v6H6V3zm4 8h3.2a2 2 0 0 0 2-2 2 2 0 0 0-2-2H10v4z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Parking included</span></div>
                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M22 11h-4.17l3.24-3.24-1.41-1.42L15 11h-2V9l4.66-4.66-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93 6.34 4.34 11 9v2H9L4.34 6.34 2.93 7.76 6.17 11H2v2h4.17l-3.24 3.24 1.41 1.42L9 13h2v2l-4.66 4.66 1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24 1.42-1.41L13 15v-2h2l4.66 4.66 1.41-1.42L17.83 13H22v-2z"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Air conditioning</span>
                           </div>

                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Housekeeping</span>
                           </div>
                           <div class=" d-flex p-3">

                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M18 2.01 6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4c0-1.11-.89-1.99-2-1.99zM11 5a1 1 0 0 0-1-1 1 1 0 0 0-1 1 1 1 0 0 0 1 1 1 1 0 0 0 1-1zM9.17 16.83a4 4 0 0 0 5.66-5.66l-5.66 5.66zM7 4a1 1 0 0 1 1 1 1 1 0 0 1-1 1 1 1 0 0 1-1-1 1 1 0 0 1 1-1zM6 14a6 6 0 1 0 12.01-.01A6 6 0 0 0 6 14z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">Laundry</span>
                           </div>

                           <div class=" d-flex p-3">
                              <svg aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path fill-rule="evenodd" d="M19 7V4H5v3H2v13h8v-4h4v4h8V7h-3zM9 10v1h2v1H8V9h2V8H8V7h3v3H9zm6 2h1V7h-1v2h-1V7h-1v3h2v2z" clip-rule="evenodd"></path>
                              </svg><span class="uitk-text uitk-type-300 uitk-text-default-theme">24/7 front desk</span>
                           </div>

                        </div>
                     </div>
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-outline-secondary rounded bold-2">
                           Explore the Residences
                        </a>
                     </div>
                    
                     </p>
                  </div>
               </div>

               <div id="rightBox" class="col-md-7 opacity-0">

               </div>
            </div>
         </section> -->

         <section id="box3" class=" opacity-0 ">
            <div class="row   pb-5 pt-5 position-relative">
               <div class="col-md-7 rounded  card-background-image">
                  <div id="c1" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#r1" data-slide-to="0" class="active"></li>
                        <li data-target="#r1" data-slide-to="1"></li>
                        <li data-target="#r1" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="/images/banners/r.jpeg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                           <img src="/images/banners/r.jpeg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                           <img src="/images/banners/r.jpeg" class="d-block w-100" alt="...">
                        </div>
                     </div>

                     <button class="carousel-control-prev" data-target="#r1" data-slide="prev"><svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Previous</span></button>

                     <button class="carousel-control-next" data-target="#r1" data-slide="next"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
                           <path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg><span class="sr-only">Next</span></button>

                  </div>
               </div>
               <div class="col-md-5  text-center d-flex justify-content-center align-items-center">
                  <div class="about-panel  bg-right-panel bg-panel-white  bg-panel p-sm-3 p-md-5">
                     <h2 class="mb-">The Restaurant</h2>
                     <div class="lead text-secondary"> Experience exquisite cuisine from all over the world</div>
                     <p class="mt-4  text-left text-black light-bold">
                        The experienced chefs creates international specialties with unique flavors. Relax with gourmet cuisine and signature cocktails or homemade tonics, all enhanced by beautiful music and gorgeous views over the city. From seasonal menus to dining experiences to satisfy any craving, see what our chefs are preparing for you. </p>
                     <ul class="text-left">
                        <li> <span class="">
                           </span> <span class="list-content">Location: Ground Floor</span> </li>
                        <li> <span class="">
                           </span> <span class="list-content">
                              Serves: Breakfast, Brunch, Lunch, Dinner, Dessert</span> </li>
                        <li> <span class="">
                           </span> <span class="list-content">Phone: +234 810 688 7920</span> <a class="list-link" href="tel:+234 810 688 7920"></a> </li>
                        <li> <span class="">
                           </span> <span class="list-content">Hours: 8:00 am -10:00 pm</span> </li>
                     </ul>
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