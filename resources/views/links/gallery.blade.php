@extends('layouts.auth')
@section('content')
<div style="background-color: rgb(248, 245, 244);">
    <div class="container-fluid">

        <div id="full-bg" class="full-bg position-relative">
            <div class="signup--middle">
                <div class="loading">
                    <div class="loader"></div>
                </div>
            </div>
        </div>

        <div class="row  p-1">
            <div id="load-products" class="col-md-12">
                <apartments-index :filter="0" :gallery="0" :property="{{$property}}" :apartments="{{ $apartments }}" />
            </div>

            <div id="load-products" class="col-md-12">
                <apartments-index :filter="0" :gallery="1" :property="{{$property}}" :apartments="{{ $galleries }}" />
            </div>
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