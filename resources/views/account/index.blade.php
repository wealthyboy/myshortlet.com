@extends('layouts.user')
@section('content')
<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
   <div class="d-flex flex-wrap flex-md-nowrap mb-6">
      <div class="mr-0 mr-md-auto">
         <h2 class="mb-0 text-heading fs-22 lh-15">Welcome back, Ronald Hunter!</h2>
         <p></p>
      </div>
      <div>
         <a href="/properties/create" class="btn btn-primary btn-lg">
            <span>Add New Property</span>
            <span class="d-inline-block ml-1 fs-20 lh-1">
               <svg class="icon icon-add-new">
                  <use xlink:href="#icon-add-new"></use>
               </svg>
            </span>
         </a>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-6 col-xxl-3 mb-6">
         <div class="card">
            <div class="card-body row align-items-center px-6 py-7">
               <div class="col-5">
                  <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-blue badge-circle">
                     <svg class="icon icon-1">
                        <use xlink:href="#icon-1"></use>
                     </svg>
                  </span>
               </div>
               <div class="col-7 text-center">
                  <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="29" data-decimals="0" data-duration="0" data-separator="">29</p>
                  <p>Properties </p>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xxl-3 mb-6">
         <div class="card">
            <div class="card-body row align-items-center px-6 py-7">
               <div class="col-5">
                  <span class="w-83px h-83 d-flex align-items-center justify-content-center fs-36 badge badge-green badge-circle">
                     <svg class="icon icon-2">
                        <use xlink:href="#icon-2"></use>
                     </svg>
                  </span>
               </div>
               <div class="col-7 text-center">
                  <p class="fs-42 lh-12 mb-0 counterup" data-start="0" data-end="1730" data-decimals="0" data-duration="0" data-separator="">1730</p>
                  <p>Total views</p>
               </div>
            </div>
         </div>
      </div>
      
      
   </div>
   
</div>
@endsection
@section('page-scripts')
@stop

