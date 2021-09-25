@extends('layouts.listing')
@section('content')
<div class="clearfix"></div>
<section  style="background-color: #f8f5f4;">
   <div class="property-name-section">
      <div class="container-fluid">
         <div class="row mt-5">
            <div class="col-lg-8">
               <div >
                  <div>{{ $property->name }}</div>
                  <p><i class="material-icons">location_on</i> {{ $property->address }}</p>
               </div>
            </div>

            <div class="col-md-4">
               <div>                Virtual Tour</div>
               <div></div>
            </div>
         </div>
      </div>
   </div>


   <div class="container-fluid">
      <div class="row no-gutters">
         <div class="col-md-8">
            <a href="#" class="img card-img galleries" style="background-image: url('{{ $property->image }}')"></a>
         </div>
         <div class="col-md-4">
            <div class="row no-gutters">

               <div class="col-6">
                  <a  href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>
               <div class="col-6">
                  <a  href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>
               <div class="col-6">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>

               <div class="col-6 position-relative">
                  <a class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
                  <a href="" class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+12</p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View more</p>
                  </a>
               </div>
            </div>
         </div>

         
      </div>
   </div>



   <div class="">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-7">
               <div class="name mt-2 bg-white p-3">
                  <h2>{{ $property->name }}</h2>
                  <div class="row">
                     <div class="col-md-7">
                        <h3>Popular amenities</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>

                           <div class="see-more col-12">
                              <a href="#">See all >></a>
                           </div>
                           
                        </div>
                        <h3>Cleaning and safety practices</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <h3>Explore the area</h3>
                         Silverbird Galleria
                     </div>
                  </div>
               </div>

               <div class="name mt-2 bg-white p-3">
                 <h3 clas="m-0">About this property</h3>

                  <div class="row">
                     
                     <div class="col-12">
                        <h4>{{ $property->name }}</h4>
                        <p><?php echo  html_entity_decode($property->description);  ?></p>
                     </div>
                  </div>
               </div>

               <div class="name mt-2 bg-white p-3">
                  <h2 clas="m-0">Amenities</h2>
                  <div class="row">
                     <div class="col-md-7">
                        <h3>Popular amenities</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>

                           <div class="see-more col-12">
                              <a href="#">See all >></a>
                           </div>
                           
                        </div>
                        <h3>Cleaning and safety practices</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <h3>Explore the area</h3>
                         Silverbird Galleria
                     </div>
                  </div>
               </div>

               <div class="name mt-2 bg-white p-3 mb-3">
                  <h3 clas="m-0">Rules & Policies</h3>
                  <div class="row">
                     <div class="col-md-7">
                        <h3>Popular amenities</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>

                           <div class="see-more col-12">
                              <a href="#">See all >></a>
                           </div>
                           
                        </div>
                        <h3>Cleaning and safety practices</h3>
                        <div class="row">
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                           <div class="col-6 d-flex align-items-center">
                              <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                              <span class="ml-2">Pool</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-5">
                        <h3>Explore the area</h3>
                         Silverbird Galleria
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-12 col-md-5">
               <h3>Check Availability</h3>
               <div class="card position-relative">
                  <form action="/book/{{ $property->slug }}" method="GET" class="">
                     @csrf
                     <input type="hidden" name="property_id" value="{{ $property->id }}" />
                     <div class="form-row">
                        <div class="form-group  search border pl-2 col-7">
                           <label  class="pl-2" for="flatpickr-input-f">Check-in - Check-out</label>
                           <input type="text" class="form-control" name="date" id="flatpickr-input-f" placeholder="Add Dates">
                        </div>
                        <div class="col-2">
                           <button type="submit" class="btn btn-primary">Check Availability</button>
                        </div>
                     </div>

                     @if ($property->apartments->count())
                        @foreach($property->apartments as $apartment)
                        <div class="row no-gutters border-bottom mb-1 mt-1 pl-1 pb-1">
                           <div class="col-md-3 position-relative">
                              <div class="">
                                 <img class="img  img-fluid" src="{{ $apartment->images[0]->image_m }}">
                              </div>
                           </div>
                           <div class="col-md-7 pl-2">
                              <div class="card-title">
                                 <a href="">Lovely Studio Apartment at Lekki, Agungi w/WIFI</a>
                              </div>
                              <div>
                                 <span class="">Kitchen</span>
                                 <span aria-hidden="true"> · </span>
                                 <span class="">Air conditioning</span>
                                 <div>
                                    <span class="">4 guests</span>
                                    <span aria-hidden="true"> · </span>
                                    <span class="">1 bedroom</span>
                                    <span aria-hidden="true"> · </span>
                                    <span class="">1 bed</span>
                                    <span aria-hidden="true"> · </span>
                                    <span class="">1.5 baths</span>
                                 </div>
                              </div>
                             
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="qty">Qty</label>
                                 <select class="form-control" name="apartment_quantity[{{ $apartment->uuid }}]" id="qty">
                                    @for($i = 1; $i <= $apartment->quantity; $i++ )
                                    <option>{{ $i }}</option>
                                    @endfor
                                 </select>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     @endif
                  
                  <div>
                     <ul class="list-unstyled mb-0 p-2">
                        <li class="d-flex justify-content-between lh-22">
                        <p class="text-gray-light mb-0">2nights</p>
                        <p class="font-weight-500 text-heading mb-0">s</p>
                        </li>
                        <li class="d-flex justify-content-between lh-22">
                        <p class="text-gray-light mb-0">Apartment</p>
                        <p class="font-weight-500 text-heading mb-0">2</p>
                        </li>
                     </ul>
                  </div>
                        
                  <div class="card-footer p-2  bg-transparent d-flex justify-content-between p-0 align-items-center">
                     <p class="text-heading mb-0">Total Price:</p>
                     <span class="fs-32 font-weight-bold text-heading total-price">0</span>
                  </div>
                  <button type="submit"   class="ml-1 btn btn-primary btn-round  mr-1 btn-block">
                        <div class="auth-spinner d-none">
                           @include('_partials.spinner',['bgcolor' => '#ffffff'])
                        </div> 
                     <span class="lt">Book now</span> 
                  </button>
                  </form>

               </div>
               
            </div>

         </div>
      </div>
   </div>
</section>

   
@endsection
@section('page-scripts')
@stop