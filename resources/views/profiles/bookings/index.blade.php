@extends('layouts.listing')

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
                    <div class="">
                        <div class=" justify-content-center">
                            <div class="">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>

                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Invoice</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Check-in</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Check-out</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Added</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                                    <th class="text-right  text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
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
                                                        <span><a href="" rel="tooltip" class="btn btn-success btn-simple" data-original-title="" title="View">
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