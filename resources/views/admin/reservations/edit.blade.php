@extends('admin.layouts.app')

@section('content')
<style>
   .reservation-edit-card .form-group label {
      color: #20242d;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 8px;
   }

   .reservation-edit-card .booking-summary {
      background: #f7f8fb;
      border: 1px solid #e5e8ef;
      border-radius: 10px;
      margin-bottom: 26px;
      padding: 18px 20px;
   }

   .reservation-edit-card .booking-summary small {
      color: #747b88;
      display: block;
      font-weight: 600;
      margin-bottom: 4px;
      text-transform: uppercase;
   }

   .reservation-edit-card .booking-summary strong {
      color: #20242d;
      font-size: 16px;
   }

   .reservation-edit-card .form-control {
      background: #fff;
      border: 1px solid #d9dde6;
      border-radius: 8px;
      box-shadow: none;
      height: 46px;
      padding: 10px 12px;
   }

   .reservation-edit-card .form-control:focus {
      border-color: #9c27b0;
      box-shadow: 0 0 0 3px rgba(156, 39, 176, .1);
   }
</style>

<div class="row">
   <div class="col-md-10 col-md-offset-1">
      @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($errors->any())
      <div class="alert alert-danger">
         <strong>Please correct the booking dates.</strong>
         <ul style="margin: 8px 0 0 18px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif

      <div class="card reservation-edit-card">
         <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">edit_calendar</i>
         </div>
         <div class="card-content">
            <h4 class="card-title">Edit Booking</h4>
            <p class="text-muted">Move this reservation to new dates. Only the old and new occupied dates will be synchronized with Channex.</p>

            <div class="booking-summary row">
               <div class="col-sm-4">
                  <small>Guest</small>
                  <strong>{{ optional($userReservation->guest_user)->fullname() ?: 'Guest booking' }}</strong>
               </div>
               <div class="col-sm-4">
                  <small>Property</small>
                  <strong>{{ optional(optional($reservation->apartment)->property)->name ?: 'Property #' . $userReservation->property_id }}</strong>
               </div>
               <div class="col-sm-4">
                  <small>Apartment</small>
                  <strong>{{ optional($reservation->apartment)->name ?: 'Apartment #' . $reservation->apartment_id }}</strong>
               </div>
            </div>

            <form action="{{ route('admin.reservations.update', ['reservation' => $userReservation->id]) }}" method="POST" novalidate>
               @csrf
               @method('PUT')

               <div class="row">
                  <div class="form-group col-md-6">
                     <label for="checkin">Check-in date</label>
                     <input
                        type="date"
                        class="form-control"
                        id="checkin"
                        name="checkin"
                        value="{{ old('checkin', optional($reservation->checkin)->format('Y-m-d')) }}"
                        required>
                  </div>

                  <div class="form-group col-md-6">
                     <label for="checkout">Check-out date</label>
                     <input
                        type="date"
                        class="form-control"
                        id="checkout"
                        name="checkout"
                        value="{{ old('checkout', optional($reservation->checkout)->format('Y-m-d')) }}"
                        required>
                  </div>
               </div>

               <div class="clearfix" style="margin-top: 18px;">
                  <a href="{{ route('admin.reservations.show', ['reservation' => $userReservation->id]) }}" class="btn btn-default">
                     Cancel
                  </a>
                  <button type="submit" class="btn btn-rose pull-right">
                     <i class="material-icons">save</i> Save booking dates
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
