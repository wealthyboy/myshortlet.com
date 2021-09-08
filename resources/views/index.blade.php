@extends('layouts.app')
@section('content')
<div class="text-center bg-light">
   <div class="col-md-11 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">Find deals on Apartments.</h1>
      <form  action="/search" method="GET">
         <div class="form-row">
            <div class="col-md-4">
               <div class="form-group mb-4">
                  <div class="input-group input-group-lg">
                     <div class="input-group-prepend ">
                        <span
                           class="input-group-text  border-0 text-muted fs-18"
                           id="inputGroup-sizing-lg"
                           >
                        <i class="fas fa-location"></i>
                        </span>
                     </div>
                     <input
                        type="text"
                        class="form-control  shadow-none fs-13"
                        id="location"
                        name="location"
                        required="true"
                        placeholder="Where are you going"
                        autocomplete="off"
                     />
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group mb-4">
                  <div class="input-group input-group-lg">
                     <div class="input-group-prepend">
                        <span
                           class="input-group-text  border-0 text-muted fs-18"
                           id="inputGroup-sizing-lg"
                           >
                        <i class="fal fa-calendar-week"></i>
                        </span>
                     </div>
                     <input
                        type="text"
                        class="form-control  shadow-none fs-13"
                        id="flatpickr-input-f"
                        name="check_in_check_out"
                        placeholder="Check in-Check out"
                        />
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <persons />
            </div>
            <div class="col-md-2">
               <button type="submit" class="btn btn-block btn-primary">Search</button>
            </div>
         </div>
      </form>
   </div>
</div>
<div class="container-fluid mt-5">
   <section class="pt-9 pt-xl-7 pb-6">
      <div class="">
         <div class="row">
            <div class="col-md-6">
               <h2 class="text-heading">Best Properties For Sale</h2>
               <span class="heading-divider"></span>
               <p class="mb-6"></p>
            </div>
            <div class="col-md-6 text-md-right">
               <a href="" class="btn btn-lg text-secondary btn-accent rounded-lg mb-6">See all properties
               <i class="far fa-long-arrow-right ml-1"></i>
               </a>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-4 col-xl-6 custom-col-5-xl-to-xxl mb-6" >
               <div style="background-image: url({{ optional($featured)->image }})" class="card border-sm-0 mb-6 mb-xl-0 bg-properties-creative h-100">
                  <div class="card-body p-2 d-flex flex-column">
                     <div class="mb-auto">
                        <span class="badge badge-orange mr-2">Featured</span>
                     </div>
                     <div class="bg-white mx-sm-2 mb-sm-2 mt-lg-0 mt-11 d-md-flex p-4 rounded-md pt-4 flex-column flex-md-row flex-lg-column flex-xl-row ">
                        <div class="mr-auto">
                           <p class="mb-0 font-weight-500 text-gray-light"><i class="far fa-map-marker-alt"></i> <a href="/apartment/{{ optional($featured)->slug }}">{{ optional($featured)->city }}</a>,  <a href="">{{ optional($featured)->state }}</a> </p>
                           <h2 class="my-0"><a href="single-property-1.html" class="fs-20 lh-16 text-dark hover-primary d-block">{{ optional($featured)->name }}</a></h2>
                        </div>
                        <div class="mt-2 mt-lg-0">
                           <p class="fs-20 font-weight-bold text-heading mb-0"></p>
                           <ul class="list-inline d-flex mb-0 flex-wrap mr-n3">
                              <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-3" data-toggle="tooltip" title="3 Bedroom">
                                 <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-bedroom"></use>
                                 </svg>
                                 3 Br
                              </li>
                              <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-3" data-toggle="tooltip" title="3 Bedroom">
                                 <svg class="icon icon-shower fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-shower"></use>
                                 </svg>
                                 3 Ba
                              </li>
                              <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-3" data-toggle="tooltip" title="Size">
                                 <svg class="icon icon-square fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-square"></use>
                                 </svg>
                                 2300 Sq.Ft
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-8 col-xl-6 custom-col-7-xl-to-xxl" >
               @foreach( $featureds as $featured)
               <div class="media flex-column flex-md-row mb-6">
                  <div class="w-md-200 mr-md-4 card border-0 hover-change-image bg-hover-overlay">
                     <img src="{{ optional($featured)->image_m }}" class="card-img" alt="Home in Metric Way dddddd">
                     <div class="card-img-overlay p-2">
                        <span class="badge badge-orange position-absolute">Featured</span>
                        <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image">
                           <li class="list-inline-item">
                              <a href="#" class="w-40px h-40 rounded-circle d-inline-flex align-items-center justify-content-center text-heading bg-white bg-hover-primary hover-white" data-toggle="tooltip" title="Wishlist">
                                 <i class="far fa-heart"></i>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="media-body border-md-0 border p-4 p-md-0 w-100">
                     <h2 class="mt-0 mb-1"><a href="" class="fs-16 lh-2 text-dark hover-primary d-block">{{ optional($featured)->name }} (multiple apartments)</a></h2>
                     <p class="mb-1 font-weight-500 text-gray-light"> <i class="far fa-map-marker-alt"></i> <a href="/apartment/{{ $featured->slug }}">{{ optional($featured)->city }}</a>,  <a href="">{{ optional($featured)->state }}</a> </p>
                     <div>ggg</div>
                     <div>ggg</div>
                     <div>ggg</div>


                     <div class="d-sm-flex justify-content-sm-between">
                        <ul class="list-inline d-flex mb-0 mt-3 mt-sm-0 flex-wrap">
                           <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center  mr-3 mr-sm-0" data-toggle="tooltip" title="3 Bedroom">
                              <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                 <use xlink:href="#icon-bedroom"></use>
                              </svg>
                              3 Bedrooms
                           </li>
                           <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center ml-sm-3 mr-3 mr-sm-0" data-toggle="tooltip" title="3 Bathrooms">
                              <svg class="icon icon-shower fs-18 text-primary mr-1">
                                 <use xlink:href="#icon-shower"></use>
                              </svg>
                              3 Bathrooms
                           </li>
                           <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center ml-sm-3 mr-3 mr-sm-0" data-toggle="tooltip" title="Size">
                              <svg class="icon icon-square fs-18 text-primary mr-1">
                                 <use xlink:href="#icon-square"></use>
                              </svg>
                              2300 Sq.Ft
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </section>
   <div class="row">
      <div class="col-md-12">
         <h2> Top destinations</h2>
         <p>See the top destinations people are traveling to</p>
      </div>
      @if ($states->count())
      @foreach($states as $state)
      <div class="col-md-4">
         <a href="/properties/{{ $state->slug }}">
            <div class="card bg-dark text-white">
               <img src="{{ $state->image }}" class="card-img" alt="...">
               <div class="card-img-overlay">
                  <h5 class="card-title">{{ $state->name }}</h5>
                  <div class="c">
                     {{ $state->properties->count() }} properties
                  </div>
               </div>
               <div class="card-footer position-absolute">
                  <h5 class="">Average Price</h5>
               </div>
            </div>
         </a>
      </div>
      @endforeach
      @endif
   </div>
   <div class="clearfix"></div>
   @if ($posts->count()) 
   <div class="row">
      <div class="col-md-12">
         <h2>  Get inspiration for your next trip </h2>
      </div>
      @foreach($posts as $post)
      <div class="col-md-4">
         <div class="card mb-4 shadow-sm">
            <img src="{{ $post->image }}" class="card-img" alt="...">
            <div class="card-body">
               <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
               <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                     <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                     <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                  </div>
                  <small class="text-muted">9 mins</small>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   @endif
</div>
<div class="position-relative overflow-hidden   mt-5 text-center bg-light">
   <div class="col-md-7 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">Sign Up for .</h1>
      <p class="lead font-weight-normal"></p>
      <form>
         <div class="form-row">
            <div class="col">
               <input type="text" class="form-control" placeholder="email">
            </div>
            <div class="">
               <button type="submit" class="btn btn-primary">Signe Up</button>
            </div>
         </div>
      </form>
   </div>
   <div class="product-device shadow-sm d-none d-md-block"></div>
   <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>
<section class="pt-12 pb-11 bg-overlay-secondary bg-img-cover-center" style="background-image: url('images/BG3.jpg');">
   <div class="container position-relative z-index-2 text-center text-white">
      <p class="fs-18 font-weight-bold text-uppercase lh-143 letter-spacing-5 mb-3 mt-1">Rent your apartment</p>
      <h2 class="fs-30 fs-lg-48 lh-13 font-weight-normal mb-7 text-white">Add a listing</h2>
      <a href="/listing" class="btn btn-lg btn-primary px-9 mb-1">Learn more</a>
   </div>
</section>
@endsection
@section('page-scripts')
@stop