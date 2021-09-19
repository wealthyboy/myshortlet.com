@extends('layouts.user')
@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="card card-stats">
            <div class="stats p-2 text-center">
               <a href="javascript:;">
               <i class="material-icons">holiday_village</i>
                  Bookings
               </a>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="card card-stats">
            <div class="stats p-2 text-center">
               <a href="javascript:;">
                  <i class="material-icons">apartment</i>

                  Listings
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="card card-stats">
            <div class="stats p-2 text-center">
               <a href="javascript:;">
               <i class="material-icons">person_outline</i>
                  Profile
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="card card-stats">
            <div class="stats p-2 text-center">
               <a href="javascript:;">
                  <i class="material-icons">receipt</i>
                  Rents
               </a>
            </div>
         </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
         <div class="card card-stats">
            <div class="stats p-2 text-center">
               <a href="javascript:;">
                  <i class="material-icons">favorite</i>
                  Saved
               </a>
            </div>
         </div>
      </div>
   </div>
   
</div>
@endsection
@section('page-scripts')
@stop

