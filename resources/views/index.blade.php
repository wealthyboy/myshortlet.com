@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<div class="video-section">
   <div class="intro-image">
      <img src="/images/logo/avm_residences.png" alt="">
   </div>

   <div role="button" class="down-icon">
      <a href="#">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
            <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
         </svg>
      </a>

   </div>

   <video class=" vidoeo-intro" src="/video/avem.mp4" autoplay muted loop></video>

</div>




<div class="container-fluid ">
   <section id="intro-box" class="intro-box">
      <div class="text-center  mb-5">
         <p class="pt-3 mt-5 ">AvenueMontiagne Residences
         </p>

         <h1 class="large-heading bold">A Fresh Take <i class="bi bi-chevron-double-down text-white "></i>
            <br>
            on your <em>dream home</em>
         </h1>
      </div>
      <div class="row  pb-5 pt-3 position-relative">
         <div id="leftBox" style="background-image: url('/images/banners/avm_image_1.jpeg');" class="col-md-7 rounded  card-background-image"></div>
         <div id="rightBox" style="z-index: 2;" class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel bg-panel-white p-sm-3 p-md-5">
               <h2 class=" bold">Welcome to Avenue Montiagne</h2>
               <p class="mt-4  text-left text-black light-bold">
                  Our apartments offer amazing amenities, stylish design, and a perfect location for living the lagos dream. With your choice of spacious, meticulously-designed 1-, 2-, or 3-bedroom apartments, youll be sure to find the ideal fit for your needs and lifestyle. Get ready for apartment living on a whole new level, with two resort-style pools, a luxurious spa, and a state-of-the-art fitness center for your convenience and enjoyment. Get excited about everything that awaits you at Avm, Lagos!
               </p>
               <div class=" buttons">
                  <a href="/apartments" class="btn btn-outline-secondary rounded bold-2">
                     Explore the Residences
                  </a>

               </div>
            </div>
         </div>
      </div>
   </section>





   <section class=" mb-1">
      <div class="row bg-grey position-relative  pb-5 pt-5">
         <div class="col-md-5  re-order text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
               <h2 class="mb-4 bold">Relax and enjoy</h2>
               <p class="mt-4  text-left text-black light-bold">
                  Throughout your stay, you’ll enjoy a residents-only bar and lounge, a spectacular pool deck with panoramic views, a private screening room, a 24-hour Technogym® fitness center , and indoor parking. The open-air retail plaza features Fred S boutique, lifestyle brand KITH, Tesse restaurant, and Boutellier wine shop.
               <div class="buttons">
                  <a href="/apartments" class="btn btn-outline-secondary rounded bold-2">
                     Explore the Residences
                  </a>
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
               <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </button>
               <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </button>
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
               <button class="carousel-control-prev" type="button" data-target="#c1" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </button>
               <button class="carousel-control-next" type="button" data-target="#c1" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </button>
            </div>
         </div>
         <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <div class="about-panel  bg-panel-white  bg-panel p-sm-3 p-md-5">
               <h2 class="mb-4 bold">Luxury & Convenience</h2>

               <p class="mt-4  text-left text-black light-bold">
                  Our apartment is truly a cut above the rest, with spacious walk-in closets, private balcony or patio, central air conditioning, and high-speed internet. We are ideally located in Lagos, making any commute or relaxing day trip a breeze.
               </p>

               <div class=" buttons">
                  <a href="/apartments" class="btn btn-outline-secondary rounded bold-2">
                     Explore the Residences
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>


   <section class=" mb-1">
      <div class="row bg-grey position-relative  pb-5 pt-5">
         <div class="col-md-5  re-order text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5">
               <h2 class="mb-4 bold">Shop</h2>
               <p class="mt-4  text-left text-black light-bold">
                  Like to shop while you stay? Visit our online store to buy from the best brands prada, gucci e.t.c.
               <div class=" buttons">
                  <a href="https://theluxurysale.com" class="btn bold-2 btn-outline-secondary rounded">
                     Shop now
                  </a>
               </div>
               </p>
            </div>
         </div>
         <div style="background-image: url('https://cdn.shopify.com/s/files/1/0732/8464/9266/files/SALE_WEBSITE_3.png?v=1681599129&width=1780');" class="col-md-7  rounded  card-background-image"></div>
      </div>
   </section>





   <div class="clearfix"></div>
   @if ($posts->count())
   <div class="row">
      <div class="col-md-12">
         <h2>Get inspiration for your next trip</h2>
      </div>
      @foreach($posts as $post)
      <div class="col-md-4">
         <div class="card mb-4 shadow-sm">
            <img src="{{ $post->image }}" class="card-img" alt="...">
            <div class="card-body">
               <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
               <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                     <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                     <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                  </div>
                  <small class="text-muted">9 mins</small>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   @endif
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

                  <p class="mb-0 display-4 bold-1 text-white">Phone: +1 (123) 456-7890</p>
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




@stop