@inject('helper', 'App\Http\Helper')
@extends('layouts.checkout')
@section('content')
<div class="container vh-100">

   <div class="row">
       <div class="col-12"> <a href="{{ $referer }}?check_in_checkout={{ $qs['check_in_checkout'] }}&property_id={{ isset( $qs['property_id'] ) ? $qs['property_id'] : null }}"> <i class=""></i> Back to selection</a> </div>
   </div>

   <div id="full-bg"  class="full-bg position-relative">
      <div class="signup--middle">
         <div class="loading">
               <div class="loader"></div>
         </div>
         <img src="{{ $system_settings->logo_path() }}" height="80" width="80" alt="myshotlet sale Logo">
      </div>  
   </div>
    
    <book-index 
      :booking_details="{{ collect($booking_details) }}" 
      :property="{{ $property }}"  
      :apartments="{{ $bookings }}"
      :phone_codes="{{ collect($phone_codes) }}"
   />
</div>


@endsection
@section('page-scripts')
@stop