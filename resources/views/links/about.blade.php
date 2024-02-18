@extends('layouts.listing')
@section('content')

<header>

    <div class="page-header min-vh-75 h-28 position-relative" style="background-image: url(/images/banners/main_buiding.png)" loading="lazy">
        <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white text-center">
                    <h1 class="text-white bold-1">About Us </h1>
                    <div class="mb-3">
                        <p class="mb-0 display-4 bold-1 text-white">A stay infused with creativity and culture.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>



<div class="container mb-5">

    <div class="row">
        <div class="col-md-12 mt-5">
            <h3>
                A Luxury Haven in the Heart of Ikoyi, Lagos
            </h3>
            <p>

                Nestled in the heart of Ikoyi, Lagos, Avenue Montaigne stands as a beacon of opulence and sophistication, offering discerning guests an unparalleled experience in luxury living. With its exquisite blend of contemporary elegance and timeless charm, Avenue Montaigne sets the standard for refined serviced apartments in one of Nigeria's most prestigious neighborhoods
            </p>
            <h3>
                Luxurious Accommodations

            </h3>
            <p>
                At Avenue Montaigne, every detail has been meticulously crafted to ensure the utmost comfort and convenience for our esteemed guests. Our serviced apartments boast spacious layouts adorned with modern furnishings, sleek finishes, and cutting-edge amenities. Whether you're seeking a cozy studio or a sprawling penthouse suite, each residence at Avenue Montaigne exudes an air of refinement and indulgence, promising a truly unforgettable stay.
            </p>
            <h3>
                World-Class Amenities

            </h3>
            <p>
                Indulge in a wealth of world-class amenities designed to cater to your every need and desire. From our state-of-the-art fitness center and rejuvenating spa to our sparkling rooftop pool and elegant dining options, Avenue Montaigne offers an array of recreational and leisure facilities to elevate your stay to new heights. Immerse yourself in luxury living as our dedicated concierge team attends to your every whim, ensuring a seamless and memorable experience from start to finish.
            </p>
            <h3>
                Prime Location

            </h3>
            <p>
                Ideally situated in Ikoyi, one of Lagos' most exclusive neighborhoods, Avenue Montaigne places you in the heart of the city's vibrant cultural and commercial hub. Explore the nearby attractions, from upscale boutiques and gourmet restaurants to lush green spaces and cultural landmarks. With easy access to major transportation arteries, including the Third Mainland Bridge and Victoria Island, Avenue Montaigne provides the perfect base for both business and leisure travelers seeking to experience the best that Lagos has to offer.
            </p>

            <h3>
                Exceptional Service

            </h3>

            <p>
                At Avenue Montaigne, our commitment to excellence extends beyond our luxurious accommodations and amenities. Our dedicated team of hospitality professionals is on hand to anticipate your every need and ensure a flawless stay from check-in to check-out. Whether you require personalized concierge services, private transportation, or insider recommendations for exploring the city, we are here to exceed your expectations and create unforgettable memories that will last a lifetime.



            </p>
            <h3>
                Experience the Height of Luxury at Avenue Montaigne
            </h3>
            <p>
                Elevate your stay in Lagos to new heights of luxury and sophistication at Avenue Montaigne. Discover a sanctuary of style, comfort, and unparalleled service in the heart of Ikoyi, where every moment is crafted to perfection. Whether you're traveling for business or leisure, make Avenue Montaigne your home away from home and experience the epitome of refined living in Nigeria's bustling metropolis. Welcome to Avenue Montaigne, where luxury knows no bounds.
            </p>
        </div>
    </div>


</div>

<!-- -------- START HEADER 4 w/ search book a ticket form ------- -->
<header>

    <div class="page-header min-vh-75 half-hv position-relative" style="background-image: url(/images/banners/bed_room.jpg)" loading="lazy">
        <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white text-center">
                    <h1 class="text-white bold-1">Contact Us </h1>
                    <div class="mb-3">
                        <p class="mb-0 display-4 bold-1 text-white">Phone: +234 701 897 1322</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <p class="mb-0 display-4 bold-1 text-white">Email: info@avenuemontaigne.ng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
<!-- -------- END HEADER 4 w/ search book a ticket form ------- -->


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