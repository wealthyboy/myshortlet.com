@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)
    <div class="row ">

        @foreach($locations as $cities)
        @if ($cities->children->count())

        @foreach($cities->children as $city)

        <div class="col-md-6 my-4">
            <a href="/apartments/in/{{ $city->slug }}">
                <img src="{{ $city->image }}" class="img-fluid" alt="">
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