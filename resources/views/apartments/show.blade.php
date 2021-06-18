

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
            <section class="pb-7 border-bottom">
               <ul class="list-inline d-sm-flex align-items-sm-center mb-2">
                  <li class="list-inline-item badge badge-orange mr-2">Featured</li>
                  <li class="list-inline-item badge badge-primary mr-3">For Sale</li>
                  <li class="list-inline-item mr-2 mt-2 mt-sm-0"><i class="fal fa-clock mr-1"></i>2 months ago</li>
                  <li class="list-inline-item mt-2 mt-sm-0"><i class="fal fa-eye mr-1"></i>1039 views</li>
               </ul>
               <div class="d-sm-flex justify-content-sm-between">
                  <div>
                     <h2 class="fs-35 font-weight-600 lh-15 text-heading">Villa on Hollywood Boulevard</h2>
                     <p class="mb-0"><i class="fal fa-map-marker-alt mr-2"></i>398 Pete Pascale Pl, New York</p>
                  </div>
                  <div class="mt-2 text-lg-right">
                     <p class="fs-22 text-heading font-weight-bold mb-0">$1.250.000</p>
                     <p class="mb-0">$9350/SqFt</p>
                  </div>
               </div>
               <h4 class="fs-22 text-heading mt-6 mb-2">Description</h4>
               <p class="mb-0 lh-214">Massa tempor nec feugiat nisl pretium. Egestas fringilla phasellus faucibus
                  scelerisque eleifend donec.
                  Porta nibh venenatis cras sed felis eget velit aliquet. Neque volutpat ac tincidunt vitae semper
                  quis lectus. Turpis in eu mi bibendum neque
                  egestas congue quisque. Sed elementum tempus egestas sed sed risus pretium quam. Dignissim
                  sodales
                  ut eu sem. Nibh mauris cursus mattis molestie a
                  iaculis at erat pellentesque. Id interdum velit laoreet id donec ultrices tincidunt.
               </p>
            </section>
            <section class="pt-6 border-bottom">
               <h4 class="fs-22 text-heading mb-6">Facts and Features</h4>
               <div class="row">
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-family fs-32 text-primary">
                              <use xlink:href="#icon-family"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Type</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">Single Family</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-year fs-32 text-primary">
                              <use xlink:href="#icon-year"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">year built</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">2020</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-heating fs-32 text-primary">
                              <use xlink:href="#icon-heating"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">heating</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">Radiant</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-price fs-32 text-primary">
                              <use xlink:href="#icon-price"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">SQFT</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">979.0</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-bedroom fs-32 text-primary">
                              <use xlink:href="#icon-bedroom"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Bedrooms</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">3</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-sofa fs-32 text-primary">
                              <use xlink:href="#icon-sofa"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">bathrooms</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">2</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-Garage fs-32 text-primary">
                              <use xlink:href="#icon-Garage"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">GARAGE</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">1</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-4 mb-6">
                     <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                           <svg class="icon icon-status fs-32 text-primary">
                              <use xlink:href="#icon-status"></use>
                           </svg>
                        </div>
                        <div class="media-body">
                           <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Status</h5>
                           <p class="mb-0 fs-13 font-weight-bold text-heading">Active</p>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="pt-6 border-bottom pb-4">
               <h4 class="fs-22 text-heading mb-4">Additional Details</h4>
               <div class="row">
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Property ID</dt>
                     <dd>AD-2910</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Price</dt>
                     <dd>$890.000</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Property type</dt>
                     <dd>Apartment, bar, cafe, villa</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Property status</dt>
                     <dd>For Sale</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Rooms</dt>
                     <dd>4</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Bedrooms</dt>
                     <dd>3</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Size</dt>
                     <dd>900SqFt</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Bathrooms</dt>
                     <dd>2</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Garage</dt>
                     <dd>1</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Bathrooms</dt>
                     <dd>2000 SqFt</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Garage size</dt>
                     <dd>50 SqFt</dd>
                  </dl>
                  <dl class="col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Year build</dt>
                     <dd>2020</dd>
                  </dl>
                  <dl class="offset-sm-6 col-sm-6 mb-0 d-flex">
                     <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Label</dt>
                     <dd>Bestseller</dd>
                  </dl>
               </div>
            </section>
            <section class="pt-6 border-bottom pb-4">
               <h4 class="fs-22 text-heading mb-4">Offices Amenities</h4>
               <ul class="list-unstyled mb-0 row no-gutters">
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Balcony</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Fireplace</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Balcony</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Fireplace</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Basement</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Cooling</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Basement</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Cooling</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dining room</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dishwasher</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dining room</li>
                  <li class="col-sm-3 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dishwasher</li>
               </ul>
            </section>
            <section>
               <h4 class="fs-22 text-heading lh-15 mb-5 pt-3">Rating & Reviews</h4>
               <div class="card border-0 mb-4">
                  <div class="card-body p-0">
                     <div class="row">
                        <div class="col-sm-6 mb-6 mb-sm-0">
                           <div class="bg-gray-01 rounded-lg pt-2 px-6 pb-6">
                              <h5 class="fs-16 lh-2 text-heading mb-6">
                                 Avarage User Rating
                              </h5>
                              <p class="fs-40 text-heading font-weight-bold mb-6 lh-1">4.6 <span class="fs-18 text-gray-light font-weight-normal">/5</span></p>
                              <ul class="list-inline">
                                 <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item bg-gray-04 text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                           <h5 class="fs-16 lh-2 text-heading mb-5">
                              Rating Breakdown
                           </h5>
                           <div class="d-flex align-items-center mx-n1">
                              <ul class="list-inline d-flex px-1 mb-0">
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                              <div class="d-block w-100 px-1">
                                 <div class="progress rating-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                              <div class="text-muted px-1">60%</div>
                           </div>
                           <div class="d-flex align-items-center mx-n1">
                              <ul class="list-inline d-flex px-1 mb-0">
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                              <div class="d-block w-100 px-1">
                                 <div class="progress rating-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                              <div class="text-muted px-1">40%</div>
                           </div>
                           <div class="d-flex align-items-center mx-n1">
                              <ul class="list-inline d-flex px-1 mb-0">
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                              <div class="d-block w-100 px-1">
                                 <div class="progress rating-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                              <div class="text-muted px-1">0%</div>
                           </div>
                           <div class="d-flex align-items-center mx-n1">
                              <ul class="list-inline d-flex px-1 mb-0">
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                              <div class="d-block w-100 px-1">
                                 <div class="progress rating-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                              <div class="text-muted px-1">0%</div>
                           </div>
                           <div class="d-flex align-items-center mx-n1">
                              <ul class="list-inline d-flex px-1 mb-0">
                                 <li class="list-inline-item text-warning mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                                 <li class="list-inline-item text-border mr-1">
                                    <i class="fas fa-star"></i>
                                 </li>
                              </ul>
                              <div class="d-block w-100 px-1">
                                 <div class="progress rating-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                              <div class="text-muted px-1">0%</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="pt-5">
               <div class="card border-0 mb-4">
                  <div class="card-body p-0">
                     <h3 class="fs-16 lh-2 text-heading mb-0 d-inline-block pr-4 border-bottom border-primary">5
                        Reviews
                     </h3>
                     <div class="media border-top pt-7 pb-6 d-sm-flex d-block text-sm-left text-center">
                        <img src="images/review-07.jpg" alt="Danny Fox" class="mr-sm-8 mb-4 mb-sm-0">
                        <div class="media-body">
                           <div class="row mb-1 align-items-center">
                              <div class="col-sm-6 mb-2 mb-sm-0">
                                 <h4 class="mb-0 text-heading fs-14">Danny Fox</h4>
                              </div>
                              <div class="col-sm-6">
                                 <ul class="list-inline d-flex justify-content-sm-end justify-content-center mb-0">
                                    <li class="list-inline-item mr-1">
                                       <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                                    </li>
                                    <li class="list-inline-item mr-1">
                                       <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                                    </li>
                                    <li class="list-inline-item mr-1">
                                       <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                                    </li>
                                    <li class="list-inline-item mr-1">
                                       <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                                    </li>
                                    <li class="list-inline-item mr-1">
                                       <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <p class="mb-3 pr-xl-17">Very good and fast support during the week. Thanks for
                              always
                              keeping your WordPress themes up to date. Your level of support and dedication
                              is second to none.
                           </p>
                           <div class="d-flex justify-content-sm-start justify-content-center">
                              <p class="mb-0 text-muted fs-13 lh-1">02 Dec 2020 at 2:40pm</p>
                              <a href="single-property-1.html#" class="mb-0 text-heading border-left border-dark hover-primary lh-1 ml-2 pl-2">Reply</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section>
               <div class="card border-0">
                  <div class="card-body p-0">
                     <h3 class="fs-16 lh-2 text-heading mb-4">Write A Review</h3>
                     <form>
                        <div class="form-group mb-4 d-flex justify-content-start">
                           <div class="rate-input">
                              <input type="radio" id="star5" name="rate" value="5">
                              <label for="star5" title="text" class="mb-0 mr-1 lh-1">
                              <i class="fas fa-star"></i>
                              </label>
                              <input type="radio" id="star4" name="rate" value="4">
                              <label for="star4" title="text" class="mb-0 mr-1 lh-1">
                              <i class="fas fa-star"></i>
                              </label>
                              <input type="radio" id="star3" name="rate" value="3">
                              <label for="star3" title="text" class="mb-0 mr-1 lh-1">
                              <i class="fas fa-star"></i>
                              </label>
                              <input type="radio" id="star2" name="rate" value="2">
                              <label for="star2" title="text" class="mb-0 mr-1 lh-1">
                              <i class="fas fa-star"></i>
                              </label>
                              <input type="radio" id="star1" name="rate" value="1">
                              <label for="star1" title="text" class="mb-0 mr-1 lh-1">
                              <i class="fas fa-star"></i>
                              </label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="form-group mb-4">
                                 <input placeholder="Your Name" class="form-control form-control-lg border-0" type="text" name="name">
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group mb-4">
                                 <input type="email" placeholder="Email" name="email" class="form-control form-control-lg border-0">
                              </div>
                           </div>
                        </div>
                        <div class="form-group mb-6">
                           <textarea class="form-control form-control-lg border-0" placeholder="Your Review" name="message" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary px-10 mb-2">Submit</button>
                     </form>
                  </div>
               </div>
            </section>
            <section class="pt-6">
               <h4 class="fs-22 text-heading mb-5">What is Nearby?</h4>
               <div class="mt-4">
                  <h6 class="mb-0 mt-5"><a href="single-property-1.html#" class="fs-16 lh-2 text-heading border-bottom border-primary pb-1">Restaurants</a></h6>
                  <div class="border-top pt-2">
                     <div class="py-3 border-bottom d-sm-flex justify-content-sm-between">
                        <div class="media align-items-sm-center d-sm-flex d-block">
                           <a href="single-property-1.html#" class="hover-shine">
                           <img src="images/single-detail-property-02.jpg" class="mr-sm-4 rounded-lg w-sm-90" alt="Bacchanal Buffet-Temporarily Closed">
                           </a>
                           <div class="mt-sm-0 mt-2">
                              <h4 class="my-0"><a href="single-property-1.html#" class="lh-186 fs-15 text-heading hover-primary">Bacchanal Buffet-Temporarily Closed</a></h4>
                              <p class="lh-186 fs-15 font-weight-500 mb-0">3570 S Las Vegas BlvdLas Vegas, NV 89109</p>
                           </div>
                        </div>
                        <div class="text-lg-right mt-lg-0 mt-2">
                           <p class="mb-2 mb-0 lh-13">120 Reviews</p>
                           <i class="fas fa-star w-18px h-18 d-inline-flex justify-content-center align-items-center rate-bg-blue text-white fs-12 rounded-sm"></i>
                           <i class="fas fa-star w-18px h-18 d-inline-flex justify-content-center align-items-center rate-bg-blue text-white fs-12 rounded-sm"></i>
                           <i class="fas fa-star w-18px h-18 d-inline-flex justify-content-center align-items-center rate-bg-blue text-white fs-12 rounded-sm"></i>
                           <i class="fas fa-star w-18px h-18 d-inline-flex justify-content-center align-items-center rate-bg-blue text-white fs-12 rounded-sm"></i>
                           <i class="fas fa-star w-18px h-18 d-inline-flex justify-content-center align-items-center rate-bg-blue text-white fs-12 rounded-sm"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section class="py-6 border-bottom">
               <h4 class="fs-22 text-heading mb-6">Virtual Tour</h4>
               <iframe height="430" src="https://my.matterport.com/show/?m=wWcGxjuUuSb&utm_source=hit-content-embed" allowfullscreen="" class="w-100"></iframe>
            </section>
         </article>
         <aside class="col-lg-6 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
         <div class="availability">
               <form action="/checkout/" method="POST" class="form-group">
                 @csrf
                  <div class="form-row mb-3">
                     <div class="col">
                        <input type="text" id="flatpickr-input" class="form-control " name="check_in_checkout" placeholder="Check in-Check out">
                     </div>
                     <div class="col">
                        <select class="form-select   form-control" aria-label="Default select example">
                           <option selected></option>
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                        </select>
                     </div>
                     <div class="">
                        <button type="submit" class="btn btn-primary">Search</button>
                     </div>
                  </div>
                  <div class="rooms">
                     @foreach($apartment->rooms as $room)
                     <div class="col-lg-12">
                        <div class="card mb-3" style="">
                           <div class="row no-gutters">
                              <div class="col-md-3">
                                 <img src="{{ $room->image }}" class="img-fluid" alt="...">
                              </div>
                              <div class="col-md-5">
                                 <div class="card-body">
                                    <h5 class="card-title">{{ $room->name }}</h5>
                                    <div class="">
                                             <span class="">
                                             Price
                                             NGN&nbsp;26,337
                                             </span>
                                    </div>
                                    <div class="card-text">
                                          <small href="">3 adults max , 2 Children Max, 3 bedroom</small>
                                    </div>
                                    <div class="facility">
                                    
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-1">
                                 <select class="form-select form-control" name="qty[{{ $room->id }}]" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                              </div>

                              <div class="col-md-3">
                                 <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none mt-4">Reserve</button>
                              </div>

                              
                           </div>
                        </div>
                     </div>

                     @endforeach
                     <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-block" type="submit">Book Now</button>
                     </div>
                  </div>
               </form>

            </div>
         </aside>
      </div>
   </div>
</div>
<section class="pt-6 pb-8">
   <div class="container">
      <h4 class="fs-22 text-heading mb-6">Similar Homes You May Like</h4>
      <div class="slick-slider" data-slick-options='{"slidesToShow": 3, "dots":false,"arrows":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
         <div class="box">
            <div class="card shadow-hover-2">
               <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                  <img src="images/properties-grid-38.jpg" alt="Home in Metric Way">
                  <div class="card-img-overlay p-2 d-flex flex-column">
                     <div>
                        <span class="badge mr-2 badge-primary">for Sale</span>
                     </div>
                     <ul class="list-inline mb-0 mt-auto hover-image">
                        <li class="list-inline-item mr-2" data-toggle="tooltip" title="9 Images">
                           <a href="single-property-1.html#" class="text-white hover-primary">
                           <i class="far fa-images"></i><span class="pl-1">9</span>
                           </a>
                        </li>
                        <li class="list-inline-item" data-toggle="tooltip" title="2 Video">
                           <a href="single-property-1.html#" class="text-white hover-primary">
                           <i class="far fa-play-circle"></i><span class="pl-1">2</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="card-body pt-3">
                  <h2 class="card-title fs-16 lh-2 mb-0"><a href="single-property-1.html" class="text-dark hover-primary">Home in Metric Way</a></h2>
                  <p class="card-text font-weight-500 text-gray-light mb-2">1421 San Pedro St, Los Angeles</p>
                  <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                     <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                        <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                           <use xlink:href="#icon-bedroom"></use>
                        </svg>
                        3 Br
                     </li>
                     <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bathrooms">
                        <svg class="icon icon-shower fs-18 text-primary mr-1">
                           <use xlink:href="#icon-shower"></use>
                        </svg>
                        3 Ba
                     </li>
                     <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Size">
                        <svg class="icon icon-square fs-18 text-primary mr-1">
                           <use xlink:href="#icon-square"></use>
                        </svg>
                        2300 Sq.Ft
                     </li>
                     <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="1 Garage">
                        <svg class="icon icon-Garage fs-18 text-primary mr-1">
                           <use xlink:href="#icon-Garage"></use>
                        </svg>
                        1 Gr
                     </li>
                  </ul>
               </div>
               <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                  <p class="fs-17 font-weight-bold text-heading mb-0">$1.250.000</p>
                  <ul class="list-inline mb-0">
                     <li class="list-inline-item">
                        <a href="single-property-1.html#" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-secondary bg-accent border-accent" data-toggle="tooltip" title="Wishlist"><i class="fas fa-heart"></i></a>
                     </li>
                     <li class="list-inline-item">
                        <a href="single-property-1.html#" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent" data-toggle="tooltip" title="Compare"><i class="fas fa-exchange-alt"></i></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         
      </div>
   </div>
</section>


@endsection
@section('page-scripts')
@stop

