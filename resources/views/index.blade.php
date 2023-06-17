@extends('layouts.app')
@section('content')

<div class="video-section">
   <div class="intro-image">
      <img src="/images/logo/avm_residences.png" alt="">
   </div>
   <video  class=" vidoeo-intro"   src="/video/avem.mp4" autoplay muted loop></video>
</div>



<div class="container-fluid ">
   <section class="">
      <div class="text-center  mb-5">
         <p class="pt-3 mt-5">AvenueMontiagne  Residences
         </p>

         <h3 class="bold pt-3">A Fresh Take on the California Dream</h3>
      </div>
      <div class="row  pb-5 pt-3 position-relative">
         <div id="operator" style="background-image: url('/uploads/GUSAX89nsYHONae8aQOD4HkhhdUqrrS2NIolUNsz.jpg');" class="col-md-7 rounded  card-background-image"></div>
         <div style="z-index: 2;" class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel bg-panel-white p-5">
               <h3 class=" bold">Welcome to Avenue Montiagne</h3>
               <p class="mt-4 text-left">
                  Our apartments in Lagos offer amazing amenities, stylish design, and a perfect location for living the lagos dream. With your choice of spacious, meticulously-designed 1-, 2-, or 3-bedroom apartments, youll be sure to find the ideal fit for your needs and lifestyle. Get ready for apartment living on a whole new level, with two resort-style pools, a luxurious spa, and a state-of-the-art fitness center for your convenience and enjoyment. Get excited about everything that awaits you at Avm, Lagos!
               </p>
               <div class="buttons">
                  <a href="/property/{{ optional($global_property)->slug }}" class="btn bold rounded btn-primary btn-lg">
                     Check Availability
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>


 


   <section class=" mb-1">
      <div class="row bg-grey position-relative  pb-5 pt-5">
         <div class="col-md-5  re-order text-center d-flex justify-content-center align-items-center">
            <div class="bg-panel-white bg-left-panel p-5">
               <h3 class="mb-4 bold">Relax and enjoy</h3>
               <p class="mt-4">
                  Throughout your stay, you’ll enjoy a residents-only bar and lounge, a spectacular pool deck with panoramic views, a private screening room, a 24-hour Technogym® fitness center , and indoor parking. The open-air retail plaza features Fred S boutique, lifestyle brand KITH, Tesse restaurant, and Boutellier wine shop.
               <div class="buttons">
                  <a href="/property/{{ optional($global_property)->slug }}" class="btn rounded bold btn-primary btn-lg">
                     Check Availability
                  </a>
               </div>
               </p>
            </div>
         </div>
         <div style="background-image: url('/uploads/M0oTm4VwHit8yGVeA6gRTL2gVwu47ioaMU6V1YyM.jpg');" class="col-md-7  rounded  card-background-image"></div>
      </div>
   </section>


   <section class="">
      <div class="row   pb-5 pt-5 position-relative">
         <div style="background-image: url('/uploads/4b2fVBQMd3OkPvATKDpuIxFK61PbgdcoEvJ3qI4j.jpg');" class="col-md-7 rounded  card-background-image">
         </div>
         <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <div class="about-panel  bg-panel-white  bg-panel p-5">
               <h3 class="mb-4 bold">Luxury & Convenience</h3>
               <p class="mt-4">
                  Our apartment is truly a cut above the rest, with spacious walk-in closets, private balcony or patio, central air conditioning, and high-speed internet. We are ideally located in Lagos, making any commute or relaxing day trip a breeze.
               </p>

               <div class="buttons">
                  <a href="/property/{{ optional($global_property)->slug }}" class="btn rounded bold btn-primary btn-lg">
                     Check Availability
                  </a>
               </div>
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





@stop