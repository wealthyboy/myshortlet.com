@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)

    @foreach($locations as $cities)
    <div class="row ">
        @if ($cities->children->count())
        @foreach($cities->children as $city)

        <div class="col-md-6 my-4">
            <a href="/apartments/{{ $city->slug }}">
                <img src="{{ $city->image }}" class="img-fluid" alt="">
            </a>
        </div>
        @endforeach
        @endif

    </div>
    @endforeach
    @endif

</div>
@endsection
@section('page-scripts')
@stop