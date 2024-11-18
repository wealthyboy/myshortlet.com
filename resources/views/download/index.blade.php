@extends('layouts.auth')
@section('content')
<div style="background-color: rgb(248, 245, 244);">
<div class="container py-5">
    <h2 class="mb-4">Image Gallery</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($apartments as $apartment)
        <div class="col mb-2">
            <div class="card h-100">
                <img src="{{ $apartment->google_drive_image_link[0]}}" class="card-img-top" alt="Image 1">
                <div class="card-body">
                    <h5 class="card-title">{{ $apartment->name}}</h5>
                    <a href="/download-images/{{ $apartment->id }}"  class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
        @endforeach
        <!-- End of Image Card -->

       
    </div>
</div>
</div>

<div style="height: 200px; background-color: rgb(248, 245, 244);"></div>
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