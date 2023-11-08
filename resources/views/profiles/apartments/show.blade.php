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
                <multiple-apartments :apartments="{{ $apartments }}" :amenities="{{ $amenities }}" :property="{{ $property }}" :days="{{ $days }}" :nights="{{ collect($nights) }}" type="multiple" />
            </div>
        </div>
    </div>
</div>
<!--End Contact Form & Info-->

@endsection