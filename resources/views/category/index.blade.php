@extends('layouts.listing')
@section('content')

<div class="bg-light mb-4">
    <div class="container-fluid">
        @if(null !== $locations)

        <div class="row p-4">
            <div id="intro-box" class=" opacity-0  mt-4 mb-4 ml-2">
                <h2 class="text-left bold-3 mb">Select Your Ideal Location</h2>
                <p class=" text-left">Explore our diverse range of locations to find the perfect apartment that suits your lifestyle. Choose from a list of carefully curated areas, each offering a unique blend of comfort and convenience. Your dream home is just a click away!</p>
            </div>

            @foreach($locations as $cities)
            @if ($cities->children->count())

            @foreach($cities->children as $city)
            @if ($city->image === '' || null == $city->image) @continue @endif

            <div id="category-box" class=" col-md-6 position-relative mb-3 p-0 p-1">
                <a class="d-block position-relative" href="/apartments/in/{{ $city->slug }}">
                    <img src="{{ $city->image }}" class="img-fluid rounded" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded bg-black opacity-50"></div>
                    <div class="position-absolute bottom-0 text-white text-left ml-3 mb-3">
                        <h2 class="bold-3  text-white fs-5 fs-md-4">
                            {{ $city->name }}
                        </h2>
                        <p class="bold-2 text-white">
                            {{ $city->description }}
                        </p>
                    </div>
                </a>
            </div>

            @endforeach

            @endif

            @endforeach
            @endif
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row p-1">






        <div class="col-md-12">


            <div id="intro-box2" class=" opacity-0 mt-4 mb-4 ml-2">
                <h2 class=" bold-3 text-left">Luxury Redefined</h2>
                <div class=" text-secondary  lead  text-left mt-2"> Explore Our Exquisite Collection of Apartments</div>

                <p class=" text-left mt-3">
                    Discover a world of unparalleled luxury with our exquisite collection of apartments. Each residence is meticulously crafted to redefine modern living, blending opulence with contemporary design.
                </p>
            </div>
            <section class=" mb-1">
                <div class="row bg-grey position-relative  pb-5 pt-5">
                    <div id="leftBox" style="z-index: 2;" class="col-md-5  opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                        <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                            <h2 class="mb-4 bold-2">Unrivaled Amenities</h2>
                            <div class="lead text-secondary">Elevate Your Living Experience</div>
                            <p class="mt-4  text-left text-black light-bold">
                                Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. From rejuvenating spa retreats to state-of-the-art fitness centers, every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens, and host unforgettable gatherings in exclusive event spaces. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat. Welcome to a world where luxury knows no bounds.
                            <div class="buttons">

                            </div>
                            </p>
                        </div>
                    </div>

                    <div id="rightBox" class="col-md-7 opacity-0">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/04/PRWH_08_ResidentsPool_B_3055-min.jpg" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </section>

            <section id="box3" class=" opacity-0 ">
                <div class="row   pb-5 pt-5 position-relative">
                    <div class="col-md-7 rounded  card-background-image">
                        <div id="c1" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#c1" data-slide-to="0" class="active"></li>
                                <li data-target="#c1" data-slide-to="1"></li>
                                <li data-target="#c1" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/04/Pendry-March-2023-HR-115.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/04/Pendry-March-2023-HR-115.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/04/Pendry-March-2023-HR-115.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-5  text-center d-flex justify-content-center align-items-center">
                        <div class="about-panel  bg-right-panel bg-panel-white  bg-panel p-sm-3 p-md-5">
                            <h2 class="mb-4">Seamless Indoor-Outdoor Harmony</h2>
                            <div class="lead text-secondary"> Discover Tranquility in our Beachfront Apartments</div>
                            <p class="mt-4  text-left text-black light-bold">
                                Step into a world where the boundaries between indoor and outdoor living dissolve. Expansive windows frame breathtaking vistas, while private balconies and terraces invite you to savor the beauty of nature. Our commitment to harmonious design ensures that every residence is a sanctuary in sync with the surrounding environment.
                            <div class=" buttons">

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- -------- START HEADER 5 w/ text and illustration ------- -->
            <header>
                <div class="page-header min-vh-80">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 my-auto">
                                <h1 class="mb-4">Desired Experiences</h1>
                                <p class=""></p>

                            </div>
                            <div class="col-lg-8 ps-5 pe-0">
                                <div class="row mt-3">
                                    <div class="col-lg-3 col-6">
                                        <img class="w-100 border-radius-lg shadow mt-0 mt-lg-7" src="https://cozystay.loftocean.com/apartment/wp-content/uploads/sites/6/2023/04/hayley-kim-design-sRSRuxkOuzI-unsplash.jpg" alt="flower-1" loading="lazy">
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <img class="w-100 border-radius-lg shadow" src="https://cozystay.loftocean.com/apartment/wp-content/uploads/sites/6/2023/04/sour-moha-_cUZkx0wTyM-unsplash.jpg" alt="flower-2" loading="lazy">
                                        <img class="w-100 border-radius-lg shadow mt-4" src="https://cozystay.loftocean.com/apartment/wp-content/uploads/sites/6/2023/04/nati-melnychuk-dFBhXJHKNeo-unsplash.jpg" alt="flower-3" loading="lazy">
                                    </div>
                                    <div class="col-lg-3 col-6 mb-3">
                                        <img class="w-100 border-radius-lg shadow mt-0 mt-lg-5" src="https://cozystay.loftocean.com/apartment/wp-content/uploads/sites/6/2023/03/img-39-2.jpg" alt="flower-4" loading="lazy">
                                        <img class="w-100 border-radius-lg shadow mt-4" src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" alt="flower-5" loading="lazy">
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <img class="w-100 border-radius-lg shadow mt-3" src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" alt="flower-6" loading="lazy">
                                        <img class="w-100 border-radius-lg shadow mt-4" src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" alt="flower-7" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- -------- END HEADER 5 w/ text and illustration ------- -->
        </div>


    </div>



</div>

<!-- -------- START HEADER 4 w/ search book a ticket form ------- -->
<header>

    <div class="page-header min-vh-75 half-hv position-relative" style="background-image: url(https://avenuemontaigne.ng/images/locations/kA0lndRkg4kYoEcmaq62HPQSoW77AmGiQDHLDmU0.jpg)" loading="lazy">
        <span class="position-absolute top-0 start-0 w-100 h-100  bg-black opacity-50"></span>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white text-center">
                    <h1 class="text-white bold-1">Contact Us </h1>
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                            <path d="M12.488 11.67c-2.187-2.187-2.82-2.82-3.54-3.53-.762-.762-1.487-1.92-2.293-3.568a1.008 1.008 0 0 0-1.422-.422C3.413 4.663 2.65 5.431 2.262 6.85c-.087.293-.223.808-.422 1.422-.258 1.04-.594 2.13-1.323 3.378a14.994 14.994 0 0 1-.849 1.318c-.539.65-1.027 1.156-1.431 1.5a1.5 1.5 0 0 0-.251 1.44l1.194 2.988a1.5 1.5 0 0 0 1.437.997h1.446c.303 0 .626-.12.877-.365.477-.456 1.47-1.577 2.88-2.888 1.309-1.309 2.43-2.403 2.887-2.88.244-.25.365-.574.365-.876V3.5a1.5 1.5 0 0 0-1.5-1.5h-2.996c-.302 0-.626.12-.877.365a28.872 28.872 0 0 0-1.436 1.436 19.347 19.347 0 0 0-1.317 1.318c-.539.65-1.027 1.157-1.43 1.5a1.5 1.5 0 0 0-.251 1.44l1.194 2.988a1.5 1.5 0 0 0 1.437.997h1.443a.5.5 0 0 0 .5-.5v-1.993a.5.5 0 0 0-.146-.354z" />
                        </svg>
                        <p class="mb-0 display-4 bold-1 text-white">Phone: +1 (123) 456-7890</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 3.91V13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V3.91l-8 4.57-8-4.57zm1-.66L8 8.35 15 3.25V4a1 1 0 0 0 1 1 1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1 1 1 0 0 0 1 1v1a1 1 0 0 0 1 1z" />
                        </svg>
                        <p class="mb-0 display-4 bold-2 text-white">Email: info@thecentralavenue.ng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
<!-- -------- END HEADER 4 w/ search book a ticket form ------- -->
@endsection
@section('page-scripts')
@stop