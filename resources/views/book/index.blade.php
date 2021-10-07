@inject('helper', 'App\Http\Helper')
@extends('layouts.checkout')
@section('content')
<div class="container vh-100">
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