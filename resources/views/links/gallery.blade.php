@extends('layouts.auth')
@section('content')








<div class="container-fluid mb-3">
    <div class="row g-0 pr-1 pl-1">
        @foreach($images['galleries'] as $key => $image)
        <div class="col-md-4 mb-1 mt-1 pr-1 pl-1">
            <a href="{{ $generator::generateThumbnailUrl($image) }}" data-lightbox="gallery">
                <img src="{{ $generator::generateThumbnailUrl($image) }}" class="img-fluid" alt="{{ $generator::generateThumbnailUrl($image) }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
















@endsection
@section('inline-scripts')

jQuery(function () {
$(".owl-carousel").owlCarousel({
margin: 10,
nav: true,
dots: false,
responsive: {
0: {
items: 1,
},
600: {
items: 1,
},
1000: {
items: 1,
},
},
});
});
@stop