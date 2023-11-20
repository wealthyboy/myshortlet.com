@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)
    <div class="row ">

        @foreach($locations as $cities)
        @if ($cities->children->count())

        @foreach($cities->children as $city)
        @if ($city->image === '' || null == $city->image) @continue @endif
        <div class="col-md-6 my-4">
            <a href="/apartments/in/{{ $city->slug }}">
                <img src="{{ $city->image }}" class="img-fluid" alt="">

                <p>
                    {{ $city->name }}
                </p>

                <p>
                    {{ $city->description }}
                </p>
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