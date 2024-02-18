@extends('layouts.auth')
@section('content')








<div class="container-fluid mb-3">
    <div class="row ">


        @foreach ($files as $file)
        <div class="col-md-4 mb-3 mt-5">
            <a href="{{ asset('images/apartments/' . $file->getFilename()) }}" data-lightbox="gallery">
                <img src="{{ asset('images/apartments/' . $file->getFilename()) }}" class="img-fluid" alt="{{ $file->getFilename() }}">
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