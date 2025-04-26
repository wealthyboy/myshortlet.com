@extends('admin.layouts.app')



@section('content')

<div class="d-flex flex-wrap gap-3">
    <a href="/admin/abandoned-carts" class="btn btn-outline-primary rounded-pill px-4 py-2">Abandoned Checkout</a>
    <a href="/admin/apartments" class="btn btn-outline-primary rounded-pill px-4 py-2">Apartments</a>
    <a href="/admin/reservations?coming_from=checkin" class="btn btn-outline-primary rounded-pill px-4 py-2">Check-in</a>
    <a href="/admin/peak_periods" class="btn btn-outline-primary rounded-pill px-4 py-2">Peak Periods</a>
    <a href="/admin/reservations?coming_from=payment" class="btn btn-outline-primary rounded-pill px-4 py-2">Reservations</a>
    <a href="/admin/visits" class="btn btn-outline-primary rounded-pill px-4 py-2">Visits</a>
    <a href="/admin/vouchers" class="btn btn-outline-primary rounded-pill px-4 py-2">Vouchers</a>
</div>





@endsection