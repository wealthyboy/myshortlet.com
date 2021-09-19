@extends('layouts.listing')
@section('content')
<div class="">
   <nav aria-label="breadcrumb" class="mt-5" role="navigation">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="#">Home</a></li>
         <li class="breadcrumb-item"><a href="#">Library</a></li>
         <li class="breadcrumb-item active" aria-current="page">Data</li>
      </ol>
   </nav>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div>
               <div>{{ $property->name }}</div>
               <p><i class="material-icons">location_on</i> {{ $property->address }}</p>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="">
   <div class="container">
      <div class="row no-gutters">
         <div class="col-md-8">
            <div class="">
               <div class="">
                  <img src="https://avenuemontaigne.ng/uploads/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg" alt="" class="img-fluid" >   
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="row no-gutters">
               <div class="col-md-6 col-3">
                  <img src="https://avenuemontaigne.ng/uploads/m/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg" alt="" class="img-fluid" >   
               </div>
               <div class="col-md-6 col-3">
                  <img src="https://avenuemontaigne.ng/uploads/m/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg" alt="" class="img-fluid" >   
               </div>
               <div class="col-md-6 col-3">
                  <img src="https://avenuemontaigne.ng/uploads/m/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg" alt="" class="img-fluid" >   
               </div>
               <div class="col-md-6 col-3">
                  <div>
                     <img src="https://avenuemontaigne.ng/uploads/m/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg" alt="" class="img-fluid" >   
                     <a href="#" class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                        <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+12</p>
                        <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View more</p>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-12">
            <nav class="nav">
               <a class="nav-link active" href="#0">Apartments</a>
               <a class="nav-link" href="#0">About </a>
               <a class="nav-link" href="#0">Amenities</a>
               <a class="nav-link" href="#0">Reviews</a>
            </nav>
         </div>
         <div class="clearfix"></div>

         
         
      </div>

      <div class="row">
         <div class="col-md-6">
            <div>
               <div>{{ $property->name }}</div>
               <p><i class="material-icons">location_on</i> {{ $property->address }}</p>
            </div>
            <div class="pt-6 border-bottom">
               <h4>Description</h4>
               <p>
               Conveniently situated at a prime location in Abu Dhabi, Al Diar Sawa Hotel Apartments is the destination for those who want an exclusive lifestyle that combines luxury, comfort and dedicated service.

Each apartment unit has a flat-screen TV, highly comfortable beds, and special amenities. Apartments have a seating area, fully equipped kitchen and a private bathroom. Underground parking is conveniently available for guests and residents.

Guests can relax and enjoy at the outdoor swimming pool, Jacuzzi and kids swimming pool at the roof top. Separate men’s and women’s sauna and steam cabins are also available to complement the recreation offers.

In addition to the services and facilities, a meeting space up to 6 persons, secretarial services at the Reception desk and wireless internet connection are available upon request.

Al Diar Sawa Hotel Apartments is located at Al Nahyan Camp area. It is just a 26-minute drive from Abu Dhabi International Airport, Yas Marina Circuit and Ferrari World, 17-minutes drive from Abu Dhabi National Exhibitions Centre 
               </p>
            </div>

            <div class="pt-6 border-bottom">
              <h4>What this place offers</h4>
            </div>

            <div class="pt-6 border-bottom">
              <h4>Reviews</h4>
            </div>

            <div class="pt-6 border-bottom">
              <h4>What is Nearby?</h4>
            </div>
         
         </div>
         <div class="col-6">
            <div class="card position-relative">
               <div class="row no-gutters">
                  <div class="col-md-3 position-relative">
                     <div class="">
                        <img class="img img-raised img-fluid" src="http://myshortlet.test/images/apartments/m/4PeVUoGLRAjZrxvoYOY520jU6NvdcVMLQJQN68ic.jpg">
                     </div>
                  </div>
                  <div class="col-md-6 pl-3">
                     <div class="card-title">
                        <a href="/apartment/lovely-studio-apartment-at-lekki-agungi-wwifi-1447616684">Lovely Studio Apartment at Lekki, Agungi w/WIFI</a>
                     </div>
                     
                     <div>
                        <span class="">Kitchen</span>
                        <span aria-hidden="true"> · </span>
                        <span class="">Air conditioning</span>
                     </div>
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
                  <div class="col-md-3  d-flex justify-content-start align-items-end pl-3">
                     <div>
                        <p>
                           <span class="text-heading lh-15 font-weight-bold fs-17">₦5000</span>
                           <span class="text-gray-light">/ night</span>
                        </p>
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('page-scripts')
@stop