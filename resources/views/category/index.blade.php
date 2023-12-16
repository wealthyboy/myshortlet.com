@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)
    <div class="row g-1 mt-3">

        @foreach($locations as $cities)
        @if ($cities->children->count())

        @foreach($cities->children as $city)
        @if ($city->image === '' || null == $city->image) @continue @endif

        <div class="col-md-6 position-relative m">
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