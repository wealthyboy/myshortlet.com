@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)

    @foreach($locations as $cities)
    @if ($cities->children->count())

    <div class="row ">
        @foreach($cities->children as $city)

        <div class="col-md-6 my-4">
            <a href="/apartments/{{ $city->slug }}">
                <img src="{{ $city->image }}" class="img-fluid" alt="">
            </a>
        </div>
        @endforeach

    </div>
    @endif

    @endforeach
    @endif

</div>
@endsection
@section('page-scripts')
@stop