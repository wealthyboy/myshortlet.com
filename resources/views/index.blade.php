

@extends('layouts.app')
@section('content')
<div class="position-relative overflow-hidden  text-center bg-light">
   <div class="col-md-8 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">Find deals on Apartments.</h1>
      <p class="lead font-weight-normal"></p>
      <form>
         <div class="form-row">
            <div class="col">
               <input type="text" class="form-control" placeholder="location">
            </div>
            <div class="col">
               <input type="text" id="flatpickr-input" class="form-control " placeholder="Check in-Check out">
            </div>
            <div class="">
               <button type="submit" class="btn btn-primary">Search</button>
            </div>
         </div>
      </form>
   </div>
   <div class="product-device shadow-sm d-none d-md-block"></div>
   <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <h2> Top Apartments</h2>
         <p>See the top destinations people are traveling to</p>
      </div>
      @if ($featureds->count())
      @foreach($featureds as $featured)
      <div class="col-md-4">
         <a href="/apartment/{{ $featured->slug }}">
            <div class="col mb-4">
               <div class="card">
                  <img src="{{ $featured->image }}" class="card-img" alt="...">
                  <div class="card-body">
                     <h5 class="card-title">{{ $featured->name }}</h5>
                     <p class="card-text">{{ $featured->state }} {{  $featured->country }}</p>
                     <p class="card-text">Starting from  NGN{{ $featured->rooms->first()->price }}</p>
                     <p class="card-text"></p>
                  </div>
               </div>
            </div>
         </a>
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
         <a href="/apartments/{{ $state->slug }}">
            <div class="card bg-dark text-white">
               <img src="{{ $state->image }}" class="card-img" alt="...">
               <div class="card-img-overlay">
                  <h5 class="card-title">Card title</h5>
               </div>
               <h5 class="">Card title</h5>
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
<div class="position-relative overflow-hidden  text-center bg-light">
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
@endsection
@section('page-scripts')
@stop

