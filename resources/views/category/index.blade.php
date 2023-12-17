@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)
    <div class="row">

        <div class=" mt-4 mb-4 ml-2">
            <h2 class="text-left bold-3 mb">Select Your Ideal Location</h2>
            <p class="lead text-left">Explore our diverse range of locations to find the perfect apartment that suits your lifestyle. Choose from a list of carefully curated areas, each offering a unique blend of comfort and convenience. Your dream home is just a click away!</p>
        </div>

        @foreach($locations as $cities)
        @if ($cities->children->count())

        @foreach($cities->children as $city)
        @if ($city->image === '' || null == $city->image) @continue @endif

        <div class="col-md-6 position-relative mb-3 p-0 p-1">
            <a class="d-block position-relative" href="/apartments/in/{{ $city->slug }}">
                <img src="{{ $city->image }}" class="img-fluid rounded" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 rounded bg-black opacity-50"></div>
                <div class="position-absolute bottom-0 text-white text-left ml-3 mb-3">
                    <h2 class="bold-3  text-white fs-5 fs-md-4">
                        {{ $city->name }}
                    </h2>
                    <p class="bold-2 text-white">
                        {{ $city->description }}
                    </p>
                </div>
            </a>
        </div>

        @endforeach

        @endif

        @endforeach
        @endif

    </div>



</div>
@endsection
@section('page-scripts')
@stop