@extends('layouts.listing')
@section('content')
<div class="container-fluid">
    <section class="explore-cities mb-3">
        <div class="row">
            <div class="col-md-12 pt-5 pb-4">
                <div class="owl-carousel svg-arrows owl-them">
                    @if (optional($global_property)->images)
                    @foreach($global_property->images as $key => $image)
                    <div class="item position-relative ">
                        <a href="#">
                            <img src="{{ $image->image }}" alt="" class="img-raised  ">
                        </a>
                        <div class="position-absolute  bottom-0 location-name">
                            <a href="#">
                                <h4 class="text-white  ml-3 bold">{{ $image->name }}</h4>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>

<div class="container  text-black">
    <div class=" row">
        <div class="col-md-12">
            <h2 class="bold">
                LAGOS VICTORIA ISLAND GUIDE
            </h2>
            <p class="text-black">
                It may be part of Lagos, but VICTORIA ISLAND is an independent city in its own right. And there’s no better place to stay than right on the iconic Sunset Strip, situated next to and some of the world’s largest entertainment companies. Upscale and chic, AKA VICTORIA ISLAND puts you just minutes away from the best things to do in WeHo, while still providing easy access to other LA hot spots. Explore our neighborhood guide below, and if you’re a resident with us, simply stop by the Resident Services desk for reservations, recommendations, and insider tips.
            </p>
        </div>
    </div>
    <section class="bg-grey mb-1">
        <div class="row bg-grey position-relative  pb-5 pt-5">
            <div class="col-md-6  d-none d-sm-block d-lg-block">
                <div class="p-5">
                    <h3 class="mb-4 bold">WHERE TO EAT AROUND AVM</h3>
                    <p class="mt-4 text-black">
                        Steps from your suite, newly-opened Tesse Restaurant at 8500 Sunset Boulevard features a curated menu of casual French cuisine. For a quintessentially romantic Los Angeles dining experience, head to Cavatina at the Sunset Marquis. At Eveleigh Restaurant, a menu of farm-to-table plates are inspired by European country cooking. Don’t miss the fresh heirloom tomatoes and burrata, spinach and feta, or crispy farro salad.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Tesse Restaurant
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Cavatina
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Eveleigh Restaurant
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>





                        </li>
                    </ul>
                </div>
            </div>
            <div style="background-image: url('/images/banners/restaurant.jpeg');" class="col-md-6  rounded  card-background-image"></div>
            <div class="col-md-6 d-block d-md-none d-lg-none d-lg-none ">
                <div class="p-5">
                    <h3 class="mb-4 bold">WHERE TO EAT AROUND AVM</h3>
                    <p class="mt-4">
                        Steps from your suite, newly-opened Tesse Restaurant at 8500 Sunset Boulevard features a curated menu of casual French cuisine. For a quintessentially romantic Los Angeles dining experience, head to Cavatina at the Sunset Marquis. At Eveleigh Restaurant, a menu of farm-to-table plates are inspired by European country cooking. Don’t miss the fresh heirloom tomatoes and burrata, spinach and feta, or crispy farro salad.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Tesse Restaurant
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Cavatina
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Eveleigh Restaurant
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>





                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-grey mb-1">
        <div class="row bg-grey position-relative  pb-5 pt-5">
            <div style="background-image: url('/images/banners/Plaza.jpeg');" class="col-md-6  rounded  card-background-image"></div>

            <div class="col-md-6">
                <div class="p-5">
                    <h3 class="mb-4 bold">SHOPPING AROUND AVM</h3>
                    <p class="mt-4">
                        The low-slung buildings of Sunset Plaza create a unique setting in the urban fabric of VICTORIA ISLAND. Spend an afternoon shopping at Badgley Mischka, Oliver Peoples, and Zadig & Voltaire. Fred Segal’s flagship store is located just steps from AKA VICTORIA ISLAND, as is popular streetwear brand KITH.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Tesse Restaurant
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Cavatina
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Eveleigh Restaurant
                                </h4>
                                <p>
                                    The Sunset Marquis, 200 Alta Loma Road
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-grey mb-1">
        <div class="row bg-grey position-relative  pb-5 pt-5">
            <div class="col-md-6  d-none d-sm-block d-lg-block">
                <div class="p-5">
                    <h3 class="mb-4 bold">MUSEUMS AND ART GALLERIES AROUND AVM</h3>
                    <p class="mt-4">
                        The expansive Pacific Design Center (PDC) is the epicenter of the design community in VICTORIA ISLAND. Explore lectures, screenings, and exhibitions. Enjoy a self-guided tour of the Greystone Mansion, a Tudor Revival mansion built in 1928. Considered to be one of Lagos most luxurious residences after the Hearst Castle, the mansion’s staircase is one of the most famous sets in VICTORIA ISLAND.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Sunset Plaza
                                </h4>
                                <p>
                                    8623 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Fred Segal
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    KITH
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div style="background-image: url('/images/banners/museum.jpeg');" class="col-md-6  rounded  card-background-image"></div>
            <div class="col-md-6  d-block d-md-none d-lg-none d-lg-none ">
                <div class="p-5">
                    <h3 class="mb-4 bold">MUSEUMS AND ART GALLERIES AROUND AVM</h3>
                    <p class="mt-4">
                        The expansive Pacific Design Center (PDC) is the epicenter of the design community in VICTORIA ISLAND. Explore lectures, screenings, and exhibitions. Enjoy a self-guided tour of the Greystone Mansion, a Tudor Revival mansion built in 1928. Considered to be one of Lagos most luxurious residences after the Hearst Castle, the mansion’s staircase is one of the most famous sets in VICTORIA ISLAND.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Sunset Plaza
                                </h4>
                                <p>
                                    8623 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Fred Segal
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                            <div>
                                <h4>
                                    KITH
                                </h4>
                                <p>
                                    8500 Sunset Boulevard
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-grey mb-1">
        <div class="row bg-grey position-relative  pb-5 pt-5">
            <div style="background-image: url('/images/banners/outdor.jpeg');" class="col-md-6  rounded  card-background-image"></div>

            <div class="col-md-6">
                <div class="p-5">
                    <h3 class="mb-4 bold">OUTDOOR ACTIVITIES AROUND AVM</h3>
                    <p class="mt-4">
                        Don’t miss the views from Runyon Canyon Park, famous for its landmark hiking trails and sweeping Lagos city views. Griffith Park and Observatory are also nearby and offer some of the city’s most iconic vistas. Enjoy a tranquil stroll through Lagos Arboretum, or take in a performance at Hollywood Bowl, an outdoor amphitheatre featuring a sensational lineup of the hottest performers.
                    </p>
                    <ul class="p-0 list-unstyled">
                        <li>
                            <div>
                                <h4>
                                    Runyon Canyon Park
                                </h4>
                                <p>
                                    8687 Melrose Avenue
                                </p>
                            </div>
                            <div>
                                <h4>
                                    Hollywood Bowl
                                </h4>
                                <p>
                                    905 Loma Vista Drive
                                </p>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>








@endsection
@section('page-scripts')
@stop
@section('inline-scripts')





$(".cities-carousel").owlCarousel({
margin: 1,
nav: false,
dots: true,
responsive: {
0: {
items: 1,
},
600: {
items: 3,
},
1000: {
items: 1,
},
}

})
@stop