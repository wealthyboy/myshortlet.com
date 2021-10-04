@extends('layouts.app')
@section('content')

<!-- Carousel Card -->
<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
   <div class="carousel-inner">
      <div class="carousel-item active">
         <div class="page-header header-filter" style="background-image: url('https://avenuemontaigne.ng/uploads/CYTb8rEICf4n8z5kJLcPoBH9mxOkYZDIB9NqIzmI.jpg');">
            <div class="container">
               <div class="row">
               </div>
            </div>
         </div>
      </div>
      <div class="carousel-item">
         <div class="page-header header-filter" style="background-image: url('https://avenuemontaigne.ng/uploads/MfsU4nIKSo0WVog3rBC5tXwPCFtHHczs9l4roB00.jpg');">
            <div class="container">
               <div class="row">
               </div>
            </div>
         </div>
      </div>
      <div class="carousel-item">
         <div class="page-header header-filter" style="background-image: url('https://avenuemontaigne.ng/uploads/xeoziKXfykSDUyJVFXzTSkiZ0f5v5vGFnO2fzwP4.jpg');">
            <div class="container">
               <div class="row">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Carousel Card -->
<div class="search-box">
   <div class="container">
      <div class="row">
         <div class="col-md-12 ml-auto mr-auto">
            <div class="card card-raised card-form-horizontal">
               <div class="col-md-8 text-left">
                  <div class="card-title">Find deals on Apartment homes...</div>
                  <div>From cosy country homes to funky city flats</div>
               </div>
               <div class="card-body ">
                 <category-search  :reload="1" />
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid mt-3 position-relative">
   <section class="pt-9 pt-xl-7 pb-6">
      <div class="">
         <div class="row">
            <div class="col-md-6">
               <h2 class="text-heading">Cool Plus stays</h2>
               <span class="heading-divider"></span>
               <p class="mb-6">Where Avm  members are staying and saving</p>
            </div>
            <div class="col-md-6 text-md-right">
               <a href="" class="btn btn-lg text-secondary btn-accent rounded-lg mb-6">See all properties
               <i class="far fa-long-arrow-right ml-1"></i>
               </a>
            </div>
         </div>
         <div class="row no-gutters">
            @foreach( $featureds as $featured)
            <div class="col-lg-3 col-xl-3 custom-col-5-xl-to-xxl mb-6 pr-1 pl-1" >
               <div class="card card-profile card-plain mb-3 position-relative">
                  <a href="/apartment/{{ $featured->slug }}">
                  <img class="card-img-top" src="{{ optional($featured)->image_m }}" rel="nofollow" alt="Card image cap">
                  </a>
                  <div class="fav-icon position-absolute">
                     @include('_partials.saved',['obj'=> $featured])
                  </div>
                  <div class="card-body p-1">
                     <a href="/property/{{ $featured->slug }}">
                        <h4 class="card-title">{{ optional($featured)->name }}</h4>
                        <p class="card-text"></p>
                     </a>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>

   
   <div class="row no-gutters">
      <div class="col-md-12">
         <h2>Explore nearby</h2>
         <p>See the top destinations people are traveling to</p>
      </div>
      @if ($cities->count())
      @foreach($cities as $city)
      <div class="col-lg-3  pr-1 pl-1" >
         <div class="card card-profile card-plain position-relative">
            <a href="/apartments/{{ $city->slug }}">
            <img class="card-img-top" src="{{ optional($city)->image }}" rel="nofollow" alt="Card image cap">
            </a>
            <div class="card-body p-1">
               <a href="/apartments/{{ $city->slug }}">
                  <h4 class="card-title">{{ optional($city)->name }}</h4>
                  <p class="card-text"></p>
               </a>
            </div>
         </div>
      </div>
      @endforeach
      @endif
   </div>
   <div class="row">
      <div class="col-md-12">
         <h2> Top destinations</h2>
         <p>See the top destinations people are traveling to</p>
      </div>
      @if ($states->count())
      @foreach($states as $state)
      <div class="col-md-4">
         <div class="card bg-dark text-white">
            <a href="/apartments/{{ $state->slug }}">
               <img class="card-img" src="{{ $state->image }}" rel="nofollow" alt="Card image">
               <div class="card-img-overlay">
                  <h4 class="card-title">{{ $state->name }} properties</h4>
               </div>
            </a>
         </div>
      </div>
      @endforeach
      @endif
   </div>
   <div class="clearfix"></div>
   @if ($posts->count()) 
   <div class="row">
      <div class="col-md-12">
         <h2>Get inspiration for your next trip</h2>
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
@include('_partials.svg')




@endsection
@section('page-scripts')
@stop