@extends('layouts.listing')
@section('content')
  <book-index :booking_details="{{ collect($booking_details) }}" :apartments="{{ $apartments->load('images','property') }}" />
@endsection
@section('page-scripts')
@stop

