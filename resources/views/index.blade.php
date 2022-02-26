@extends('layouts.app')
@section('content')
@if ($sliders->count())
<div  class="carousel">
   
   <div class="owl-carousel main-slider svg-arrows owl-them">
      @foreach($sliders as $key =>  $slider)
      <div class="item">
         <div class="page-header banner-filter" style="background-image: url('{{ $slider->image }}');">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 text-center ">
                     <h1 class="title">Avenue Montaigne</h1>
                     <p>Luxury Apartments</p>
                     <div class="mt-2 mb-2">
                        <a href="#" class="play-video">
                           <i class="fas fa-play"></i>
                        </a>
                     </div>
                     <br>
                     <div class="buttons">
                        <a href="{{ $slider->link }}" class="btn rounded btn-primary btn-lg">
                           Check Availability 
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   
</div>
@endif


<div class="container-fluid ">
   <section class="bg-grey">
      <div class="text-center ">               
         <h3 class="bold pt-3">Welcome to Avenue Montiagne</h3>
      </div>
      <div  class="row bg-grey pb-5 pt-3 position-relative">
         <div id="operator"  style="background-image: url('/uploads/GUSAX89nsYHONae8aQOD4HkhhdUqrrS2NIolUNsz.jpg');" class="col-md-8 rounded  card-background-image"></div>
         <div   style="z-index: 2;" class="col-md-4 text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel bg-panel-white p-5">
               <h3 class=" bold">Welcome to Avenue Montiagne</h3>
               <p class="mt-4 text-left">
                  Our apartments in Lagos offer amazing amenities, stylish design, and a perfect location for living the lagos dream. With your choice of spacious, meticulously-designed 1-, 2-, or 3-bedroom apartments, youll be sure to find the ideal fit for your needs and lifestyle. Get ready for apartment living on a whole new level, with two resort-style pools, a luxurious spa, and a state-of-the-art fitness center for your convenience and enjoyment. Get excited about everything that awaits you at Avm, Lagos!
               </p>
               <div class="buttons">
                  <a href="http://myshortlet.test/property/lovely-studio-apartment-at-lekki-agungi-wwifi-716059713" class="btn bold rounded btn-primary btn-lg">
                     Check Availability 
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   

   <section data-animated-id="2" class="wprt-section how-we-build pt-5 pb-5 mt-5 mb-5">
      <div class="row">
         <div class="col-md-4 mb-sm-5 col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary  d-flex justify-content-center align-items-center  text-center">
                  <svg
                     id=""
                  >
                     <use xlink:href="#check-icon"></use>
                  </svg>
               </div>
            </div>
            <div class="content-wrap">
               <h3 class="dd-title bold text-center">Wired & Ready</h3>
               
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-4  mb-sm-5 col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary   d-flex justify-content-center align-items-center  text-center">
                  <svg
                     id=""
                  >
                     <use xlink:href="#question-icon"></use>
                  </svg>
               </div>
               
            </div>
            <div class="content-wrap">
               <h3 class="bold text-center">Just Bring Yourself</h3>
            </div>
         </div>
         <!-- /.col-md-4 -->
         <div class="col-md-4 mb-sm-5  col-12">
            <div class="wprt-icon-box">
               <div class="icon-wrap bg-primary  d-flex justify-content-center align-items-center  text-center">
               <svg
                  id=""
               >
                  <use xlink:href="#check-icon"></use>
               </svg>
               </div>
               
            </div>
            <div class="content-wrap">
               <h3 class="dd-title bold text-center text-center">Stylish Comfort</h3>
            </div>
         </div>

      </div>
      <!-- /.row -->
   </section>


   <section class="bg-grey mb-1">
     <div class="row bg-grey position-relative  pb-5 pt-5">
         <div class="col-md-5  re-order text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel-white bg-left-panel p-5">
               <h3 class="mb-4 bold">Relax and enjoy</h3>
               <p class="mt-4">
               Throughout your stay, you’ll enjoy a residents-only bar and lounge, a spectacular pool deck with panoramic views, a private screening room, a 24-hour Technogym® fitness center , and indoor parking. The open-air retail plaza features Fred S boutique, lifestyle brand KITH, Tesse restaurant, and Boutellier wine shop.


                  <div class="buttons">
                     <a href="#" class="btn rounded bold btn-primary btn-lg">
                        Check Availability 
                     </a>
                  </div>
               </p>
            </div>
         </div>
         <div style="background-image: url('/uploads/M0oTm4VwHit8yGVeA6gRTL2gVwu47ioaMU6V1YyM.jpg');" class="col-md-7  rounded  card-background-image"></div>
      </div>
   </section>


   <section class="bg-grey">
      <div   class="row bg-grey  pb-5 pt-5 position-relative">
         <div style="background-image: url('/uploads/4b2fVBQMd3OkPvATKDpuIxFK61PbgdcoEvJ3qI4j.jpg');" class="col-md-7 rounded  card-background-image">
         </div>
         <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <div class="about-panel  bg-panel-white  bg-panel p-5">
               <h3 class="mb-4 bold">Luxury & Convenience</h3>
               <p class="mt-4">
                  Our apartment is truly a cut above the rest, with spacious walk-in closets, private balcony or patio, central air conditioning, and high-speed internet. We are ideally located in Lagos,  making any commute or relaxing day trip a breeze. 
               </p>

               <div class="buttons">
                  <a href="#" class="btn rounded bold btn-primary btn-lg">
                     Check Availability 
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section  class="explore-cities mb-3">
      <div class="row">

         <div class="col-12 text-center mt-3">
            <h1 class="bold">Photo Gallery</h1>
            <p>Live Your Lifestyle In Comfort</p>
         </div>
         
         <div class="col-md-12 pt-5 pb-4">
            <div class="owl-carousel svg-arrows owl-them">
               @foreach($global_property->images  as $key => $image)
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
            </div>
         </div>
      </div>
   </section>
   <section class="bg-single-image-02  mt-3 bg-accent pb-5" data-animated-id="3">
      <div class="row bg-gray">
        <div class="col-md-12 mb-3">
            <h2 class="text-center  bold text-uppercase">Avenue Montaigne</h2>
            <p class="subtitle text-center text-size-1-big bold">  
              Victoria Island, Lagos.
            </p>
         </div>
         
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
@endsection
@section('inline-scripts')

$('.owl-carousel').owlCarousel({
   loop:true,
   margin:10,
   nav:true,
   dots: true,
   center: true,
   navText: [
      '<div class="nav-btn prev-slide"><svg width="31" height="50" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg"><path d="M19.9 40L1.3 20 19.9 0" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
      '<div class="nav-btn next-slide"><svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg"><path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>',
   ],
   responsive:{
      0:{
         items:1
      },
      600:{
         items:1
      },
      1000:{
        items:1
      }
   }
})


$(".cities-carousel").owlCarousel({
   margin: 1,
   nav:  false,
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