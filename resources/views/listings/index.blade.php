

@extends('layouts.listing')
@section('content')
<main role="main">
<div class="jumbotron">
   <div class="container">
      <div class="row featurette">
         <div class="col-md-7">
            <h2 class="featurette-heading"> List Your  <span class="text-muted">Apartment</span></h2>
            <p class="lead"> Registration can take as little as 15 minutes to complete – get started today </p>
         </div>
         <div class="col-md-5">
            <div class="">
               <h2> Create new listing </h2>
               <p class="lead"> It's free to create a listing</p>
               <p class="lead"> 24/7 support by phone or email </p>
               <p class="lead"> Set your own house rules for guests </p>
               <div class="call-to-action">
               @if ( !auth()->check() )
                  <a href="/register" class="btn btn-primary btn-lg btn-block" type="submit">Get Started</a>
               @else
                  <a href="/properties/create" class="btn btn-primary btn-lg btn-block" type="submit">Get Started</a>
               @endif
               </div>
            </div>
            <p> By continuing, you agree to let Booking.com email you regarding your property registration. </p>
         </div>
      </div>
   </div>
</div>
<!-- Marketing messaging and featurettes
   ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container marketing">
   <!-- START THE FEATURETTES -->
   <hr class="featurette-divider">
   <div class="row featurette">
      <div class="col-md-7">
         <h2 class="featurette-heading"> Your peace of mind is our top priority.</h2>
         <p class="lead"> Here’s how we’re helping you feel confident welcoming guests: </p>
         <p class="lead"> Set house rules guest must agree to before they stay </p>
         <p class="lead"> Request damage deposits for extra security </p>
         <p class="lead"> Report guest misconduct if something goes wrong </p>
      </div>
      <div class="col-md-5">
         <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#eee"/>
            <text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>
         </svg>
      </div>
   </div>
   <hr class="featurette-divider">
   <div class="row featurette">
      <div class="col-12">
         <h2 class="featurette-heading"> frequently asked questions </h2>
         <div class="accordion" id="accordionExample">
            <div class="card">
               <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                     <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     Collapsible Group Item #1
                     </button>
                  </h2>
               </div>
               <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                     Some placeholder content for the first accordion panel. This panel is shown by default, thanks to the <code>.show</code> class.
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="headingTwo">
                  <h2 class="mb-0">
                     <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                     Collapsible Group Item #2
                     </button>
                  </h2>
               </div>
               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                  <div class="card-body">
                     Some placeholder content for the second accordion panel. This panel is hidden by default.
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="headingThree">
                  <h2 class="mb-0">
                     <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     Collapsible Group Item #3
                     </button>
                  </h2>
               </div>
               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                  <div class="card-body">
                     And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /END THE FEATURETTES -->
</div>
<!-- /.container -->
@endsection
@section('page-scripts')
@stop

