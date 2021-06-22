

@extends('layouts.app')
@section('content')
<section>
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb pt-lg-0 pb-3">
            <li class="breadcrumb-item fs-12 letter-spacing-087">
               <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item fs-12 letter-spacing-087">
               <a href="listing-grid-with-left-filter.html">Listing</a>
            </li>
            <li class="breadcrumb-item fs-12 letter-spacing-087 active">Villa on Hollywood Boulevard</li>
         </ol>
      </nav>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-9">
            <div>
               <h1>{{ $apartment->name }}</h1>
               <p><i class="bi bi-geo-alt-fill"></i> {{ $apartment->address }}</p>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="text-right">
               <span class="mr-3">
               <i class="bi bi-heart"></i>
               </span>
               <span>
               <i class="bi bi-share-fill"></i>             
               </span>
            </div>
         </div>
      </div>
      <div class="position-relative" >
         <div class="position-absolute pos-fixed-top-right z-index-3">
            <ul class="list-inline pt-4 pr-5">
               <li class="list-inline-item mr-2">
                  <a href="#" data-toggle="tooltip" title="Favourite" class="d-flex align-items-center justify-content-center w-40px h-40 bg-white text-heading bg-hover-primary hover-white rounded-circle">
                  <i class="far fa-heart"></i></a>
               </li>
               <li class="list-inline-item mr-2">
                  <button type="button" class="btn btn-white p-0 d-flex align-items-center justify-content-center w-40px h-40 text-heading bg-hover-primary hover-white rounded-circle border-0 shadow-none" data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-content=' <ul class="list-inline mb-0">
                     <li class="list-inline-item">
                     <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                     class="fab fa-twitter"></i></a>
                     </li>
                     <li class="list-inline-item ">
                     <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                     class="fab fa-facebook-f"></i></a>
                     </li>
                     <li class="list-inline-item">
                     <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                     class="fab fa-instagram"></i></a>
                     </li>
                     <li class="list-inline-item">
                     <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                     class="fab fa-youtube"></i></a>
                     </li>
                     </ul>
                     '>
                  <i class="far fa-share-alt"></i>
                  </button>
               </li>
               <li class="list-inline-item">
                  <a href="single-property-1.html#" data-toggle="tooltip" title="Print" class="d-flex align-items-center justify-content-center w-40px h-40 bg-white text-heading bg-hover-primary hover-white rounded-circle">
                  <i class="far fa-print"></i>
                  </a>
               </li>
            </ul>
         </div>
         <div class="row galleries m-n1">
            <div class="col-lg-6 p-1">
               <div class="item item-size-4-3">
                  <div class="card p-0 hover-zoom-in">
                     <a href="{{ $apartment->image }}" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url({{  $apartment->image }})">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 p-1">
               <div class="row m-n1">
                  @foreach($apartment->rooms as $room)

                  <div class="col-md-6 p-1">
                     <div class="item item-size-4-3">
                        <div class="card p-0 hover-zoom-in">
                           <a href="{{ $room->image }}" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url({{  $room->image }})">
                           </a>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  
                  
                  <div class="col-md-6 p-1">
                     <div class="item item-size-4-3">
                        <div class="card p-0 hover-zoom-in">
                           <a href="{{ $apartment->image }}" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url({{ $apartment->image }})">
                           </a>
                           <a href="single-property-1.html#" class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                              <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+12</p>
                              <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View
                                 more
                              </p>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="primary-content pt-8">
   <div class="container-fluid">
      <div class="row">
         <article class="col-lg-6 pr-xl-7">
            
         </article>
         <aside class="col-lg-6 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
            <room-available  :apartment="{{ $apartment }}" :rooms="{{ $apartment->rooms }}" />
         </aside>
      </div>
   </div>
</div>



@endsection
@section('page-scripts')
@stop

