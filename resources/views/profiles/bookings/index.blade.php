@extends('layouts.auth')

@section('content')

<div class=" mt border">
    <div class="container">
        <div class="d-block d-sm-none ">
            @include('_partials.mobile_nav')
        </div>
    </div>
    <div class="container ">
        <div class="row">
            @include('_partials.nav')
            <div class="col-md-9 mt-3">
                <section class=" ">
                    <h2 class="page-title ">Bookings</h2>

                    <div class="">
                        <div class=" justify-content-center">
                            <div class="">
                                <div class="card shadow-none">
                                    <div class="table-responsive border">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>

                                                    <th class="text-uppercase text-xxs bold-2">Invoice</th>
                                                    <th class="text-uppercase text-xxs bold-2">Customer</th>
                                                    <th class="text-uppercase text-xxs bold-2">Check-in</th>
                                                    <th class="text-uppercase text-xxs bold-2">Check-out</th>
                                                    <th class="text-uppercase text-xxs bold-2">Date Added</th>
                                                    <th class="text-uppercase text-xxs bold-2">Total</th>
                                                    <th class="text-right text-uppercase text-xxs  bold-2">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($reservations->count())
                                                @foreach ($reservations as $reservation )
                                                <tr>

                                                    <td class="text-left">{{ $reservation->invoice }}</td>
                                                    <td>{{ $reservation->user->fullname() }}</td>
                                                    <td>{{ $reservation->checkin->isoFormat('dddd, MMMM Do YYYY') }}</td>
                                                    <td>{{ $reservation->checkout->isoFormat('dddd, MMMM Do YYYY') }}</td>
                                                    <td>{{ $reservation->created_at }}</td>
                                                    <td class="text-left">{{ $reservation->currency  ?? '₦'}}{{ $reservation->total }}</td>
                                                    <td class="td-actions text-center">
                                                        <span><a href="" rel="tooltip" class="">
                                                                <i class="fa fa-eye"></i>
                                                            </a></span>

                                                    </td>
                                                </tr>

                                                @endforeach
                                                @else
                                                <tr>
                                                    <td>
                                                        No Bookings yet

                                                    </td>
                                                </tr>
                                                </tr>
                                                @endif


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!--End Contact Form & Info-->

@endsection