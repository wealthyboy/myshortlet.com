@extends('admin.layouts.app')



@section('content')

<div class="d-flex flex-wrap gap-3">
    <h6>
        <a href="/admin/abandoned-carts" class="px-4 py-2 border">Abandoned Checkout</a>
    </h6>
    <h6>
        <a href="/admin/apartments" class="px-4 py-2 border">Apartments</a>
    </h6>
    <h6>
        <a href="/admin/reservations?coming_from=checkin" class="px-4 py-2 border">Check-in</a>
    </h6>
    <h6>
        <a href="/admin/peak_periods" class="px-4 py-2 border">Peak Periods</a>
    </h6>
    <h6>
        <a href="/admin/visits" class="px-4 py-2 border">Reservations</a>
    </h6>
    <h6>
        <a href="/admin/invoices" class="px-4 py-2 border">Invoice</a>
    </h6>
    <h6>
        <a href="/admin/reservations?coming_from=payment" class="px-4 py-2 border">Visits</a>
    </h6>
    <h6>
        <a href="/admin/vouchers" class="px-4 py-2 border">Vouchers</a>
    </h6>

</div>





@endsection