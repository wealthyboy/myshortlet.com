@extends('layouts.user')
@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12 ml-auto mr-auto">
         <h2 class="title"></h2>
         @if ($reservations->count())
         @foreach($reservations as $reservation)
         <div class="card  border">
            <div class="row">
               <div class="col-md-3 col-12">
                  <div class="card-header card-header-image">
                     <img class="img img-raised" src="{{ optional($reservation->property)->image }}">
                  </div>
               </div>
               <div class="col-md-7">
                  <h6 class="card-category text-info">{{ $reservation->created_at->format('d/m/y') }}</h6>
                  <h3 class="card-title">
                     <a href="#">{{ optional($reservation->apartment)->name ?? optional(optional($reservation->apartment)->property)->name }}</a>
                  </h3>
                  <div class="">
                     <small href=""
                        >{{ optional($reservation->apartment)->max_adults + optional($reservation->apartment)->max_children }}
                     Guests,
                     {{ optional($reservation->apartment)->no_of_rooms }} bedroom
                     </small>
                  </div>
                  <div class="d-flex justify-content-between">
                     <div>
                        <div>Check-in</div>
                        {{ $reservation->checkin->isoFormat('dddd, MMMM, Do YYYY') }}
                     </div>
                     <div>
                        <div>Check-out</div>
                        {{ $reservation->checkout->isoFormat('dddd, MMMM, Do YYYY') }}
                     </div>
                  </div>
                  <p>
                     <strong>Total: </strong> <span>{{  $reservation->currency }}{{  $reservation->total  }}</span>
                  </p>
               </div>
               <div class="col-md-2  d-flex justify-content-center align-items-center">
                  <a href="{{ route('reservations.show',['reservation'=>$reservation->id]) }}" class="btn btn-primary  btn-link ">
                  <i class="material-icons">details</i> View
                  </a>
               </div>
            </div>
         </div>
         @endforeach
         @else
         <div class="no-apartments">
            <div class=" d-flex justify-content-center fa-2x"  >
               <div class="text-center pb-3">
                  <i class="material-icons display-1">holiday_village</i>
                  <p class="bold">You have no bookings.</p>
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</div>
@endsection
@section('page-scripts')
@stop