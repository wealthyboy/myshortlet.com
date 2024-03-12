@inject('helper', 'App\Http\Helper')
@extends('layouts.checkout')
@section('content')
<div class="container vh-100">

  

   <div id="full-bg" class="full-bg position-relative">
      <div class="signup--middle">
         <div class="loading">
            <div class="loader"></div>
         </div>
      </div>
   </div>

   <book-index :booking_details="{{ collect($booking_details) }}" :property="{{ $property }}" :apartments="{{ $bookings }}" :phone_codes="{{ collect($phone_codes) }}" />
</div>


@endsection
@section('page-scripts')
@stop