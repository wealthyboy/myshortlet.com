@extends('layouts.listing')
@section('content')

<div class="container-fluid">
    @if(null !== $locations)
    <div class="row">



        <div class=" mt-4 mb-4 ml-2">
            <h2 class="text-left bold-3 mb">Select Your Ideal Location</h2>
            <p class="lead text-left">Explore our diverse range of locations to find the perfect apartment that suits your lifestyle. Choose from a list of carefully curated areas, each offering a unique blend of comfort and convenience. Your dream home is just a click away!</p>
        </div>

        @foreach($locations as $cities)
        @if ($cities->children->count())

        @foreach($cities->children as $city)
        @if ($city->image === '' || null == $city->image) @continue @endif

        <div class="col-md-6 position-relative mb-3 p-0 p-1">
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


        <div class="col-md-12">
            <div class=" mt-4 mb-4 ml-2">
                <h2 class=" bold-3">Luxury Redefined: Explore Our Exquisite Collection of Apartments</h2>
                <p class="lead text-left">
                    Discover a world of unparalleled luxury with our exquisite collection of apartments. Each residence is meticulously crafted to redefine modern living, blending opulence with contemporary design. Immerse yourself in a lifestyle of sophistication, where every detail is curated to provide the utmost comfort and indulgence. Elevate your living experience with our prestigious collection of luxury apartments, where elegance meets excellence.
                </p>
            </div>
            <section class=" mb-1">
                <div class="row bg-grey position-relative  pb-5 pt-5">
                    <div class="col-md-5  re-order text-center d-flex justify-content-center align-items-center">
                        <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
                            <h2 class="mb-4 bold">Unrivaled Amenities: Elevate Your Living Experience</h2>
                            <p class="mt-4  text-left text-black light-bold">
                                Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. From rejuvenating spa retreats to state-of-the-art fitness centers, every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens, and host unforgettable gatherings in exclusive event spaces. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat. Welcome to a world where luxury knows no bounds.
                            <div class="buttons">

                            </div>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-7">


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





            <section class="">
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
                                    <img src="/uploads/4b2fVBQMd3OkPvATKDpuIxFK61PbgdcoEvJ3qI4j.jpg" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <img src="https://pendryresidencesweho.com/wp-content/uploads/2023/05/PRWH_11_705_Terrace_B_4006-min.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
                        <div class="about-panel  bg-panel-white  bg-panel p-sm-3 p-md-5">
                            <h2 class="mb-4">Seaside Serenity: Discover Tranquility in our Beachfront Apartments</h2>

                            <p class="mt-4  text-left text-black light-bold">
                                Nestled along the pristine coastline, our apartments offer a picturesque escape to a world of breathtaking beauty. Wake up to the soothing sounds of waves, as the sun paints the sky in hues of pink and gold during mesmerizing sunsets. Immerse yourself in the beauty of nature, with beachfront living that seamlessly blends the indoors with the vast expanse of the sea. Experience a harmonious blend of luxury and nature, where every moment becomes a postcard-worthy memory in our beautiful coastal haven. Welcome to a life of serenity by the sea.</p>

                            <div class=" buttons">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


    </div>



</div>
@endsection
@section('page-scripts')
@stop