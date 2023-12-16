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
                    <h2 class="page-title ">Apartments</h2>

                    <div class="">
                        <div class=" justify-content-center">
                            <div class="">
                                <div class="card shadow-none">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase bold-2">Name</th>
                                                    <th class="text-uppercase bold-2 ps-2"></th>
                                                    <th class="text-center text-uppercase bold-2"></th>
                                                    <th class="text-center text-uppercase bold-2">Date</th>
                                                    <th class=""></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($user->properties->count())
                                                @foreach($user->properties as $property)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">

                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-xs">{{ $property->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">{{ $property->agentsApartments->count() }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0"></p>
                                                        <p class="text-xs text-secondary mb-0"></p>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ $property->created_at }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="/profile/apartments/{{ $property->id }}" class=" text-secondary font-weight-bold text-xs">
                                                            <span class="badge badge-sm badge-success"> View Apartments</span>

                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else

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