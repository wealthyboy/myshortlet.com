@extends('layouts.app')
@section('content')

<div class="video-section" itemscope itemtype="https://schema.org/WebPageElement">
   <div class="intro-image" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
      <img alt="Avenue Montaigne logo" src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" itemprop="url">
   </div>

   <div id="sm-main-banner" class="main-banner owl-carousel owl-theme d-block d-sm-none slider" itemprop="associatedMedia" itemscope itemtype="https://schema.org/MediaObject">
      @foreach($images['sliders'] as $key => $image)
      <div style="background-image: url({{ $generator::generateThumbnailUrl($image) }});" class="{{  $key > 0 ? 'd-none' : '' }} item page-header min-vh-75 half-hv position-relative rounded-top" itemprop="image">
         <span class="position-absolute top-0 start-0 w-100 h-100 bg-black-2 opacity-50"></span>
      </div>
      @endforeach
   </div>

   <div id="main-banner" class="carousel slide carousel-fade d-none d-md-block" data-ride="carousel" itemprop="associatedMedia" itemscope itemtype="https://schema.org/MediaObject">
      <ol class="carousel-indicators">
         @foreach($images['sliders'] as $key => $image)
         <li data-target="#main-banner" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : ''}}" itemprop="associatedMedia" itemscope itemtype="https://schema.org/MediaObject"></li>
         @endforeach
      </ol>
      <div class="carousel-inner header-filter">
         @foreach($images['sliders'] as $key => $image)
         <div class="carousel-item {{ $key === 0 ? 'active' : ''}}">
            <img src="{{ $generator::generateThumbnailUrl($image) }}" class="d-block w-100" alt="..." itemprop="image">
         </div>
         @endforeach
      </div>
      <button class="carousel-control-prev" data-target="#main-banner" data-slide="prev">
         <svg width="51" height="51" viewBox="0 0 21 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.9 40L1.3 20 19.9 0" class="carousel-control-prev-icon" aria-hidden="true" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg>
         <span class="sr-only">Previous</span>
      </button>
      <button class="carousel-control-next" data-target="#main-banner" data-slide="next">
         <svg width="19" height="40" viewBox="0 0 19 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M.1 0l18.6 20L.1 40" stroke="#FFF" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg>
         <span class="sr-only">Next</span>
      </button>
   </div>
</div>

<div class="search-header d-block p-3" itemscope itemtype="https://schema.org/SearchResultsPage">
   <search-apartments />
</div>

<div class="container-fluid mb-2">
   <div class="row">
      <div id="tree" class="opacity-0" style="background-image: url(https://drive.google.com/thumbnail?id=1aP9OVoify71pxLWDV-P33fYb5sopnI2g&sz=w2000);
    background-repeat: no-repeat;
    background-position: right -10px top 35px;
    height: 500px;
    position: absolute;
    width: -webkit-fill-available;"></div>
      <div class="col-md-12">
         <section id="rbox1" class=" " itemscope itemtype="https://schema.org/WebPageElement">
            <div class="row position-relative">
               <div class="col-lg-7 col-md-12 rounded card-background-image">
                  <div id="c1" class="carousel slide" data-ride="carousel" itemprop="associatedMedia" itemscope itemtype="https://schema.org/MediaObject">
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img src="https://drive.google.com/thumbnail?id=1ES6PROkjg09AnQdO2hn033mzg48dJT8S&sz=w2000" class="d-block w-100" alt="..." itemprop="image">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5 col-md-12 welcome text-center d-flex justify-content-center align-items-center">
                  <div class="about-panel bg-right-panel bg-panel-white bg-panel p-sm-3 p-md-5" itemscope itemtype="https://schema.org/AboutPage">
                     <div class="primary-color" itemprop="headline">STAY IN THE HEART OF LAGOS</div>
                     <h2 class="bold-2" itemprop="name">Welcome to Avenue Montaigne</h2>
                     <p class="mt-4 text-left text-black light-bold" itemprop="description">
                        Our apartments offer amazing amenities, stylish design, and a perfect location for living the Lagos dream. With your choice of spacious, meticulously-designed 3-bedroom apartments, you'll be sure to find the ideal fit for your needs and lifestyle.
                     </p>
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-primary rounded bold-2" itemprop="url">
                           View all Apartments
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</div>

<div style="background-color: rgb(248, 245, 244);" class="ap mb-3" itemscope itemtype="https://schema.org/WebPageSection">
   <div class="container-fluid">
      <div id="intro-box2" class="opacity-0 mt-4 mb-4">
         <h2 class="bold-3 text-left" itemprop="name">Luxury Redefined</h2>
         <div class="text-secondary text-left mt-2" itemprop="description">Explore Our Exquisite Collection of Apartments.</div>
      </div>

      <div class="title">
         <div class="d-flex justify-content-between">
            <h3 class="large-heading bold" itemprop="name">Apartments</h3>
            <a href="/apartments" class="btn btn-round btn-primary py-2 bold-2 align-self-end font-weight-bold-2" itemprop="url">
               View all Apartments
            </a>
         </div>
      </div>
      <div class="row p-1">
         <div id="load-products" class="col-md-12" itemscope itemtype="https://schema.org/ItemList">
            <apartments-index :isGallery="0" :filter="0" :property="{{$property}}" :apartments="{{ $apartments }}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" />
         </div>
      </div>
   </div>
</div>

<div class="container-fluid mb-3">
   <div class="row p-1">
      <div class="col-md-12">
         <section class="mb-1" itemscope itemtype="https://schema.org/WebPageSection">
            <div class="row bg-grey position-relative pb-5 pt-5">
               <div id="leftBox" style="z-index: 2;" class="col-lg-5 col-md-12 order-sm-2 order-lg-1 opacity-0 re-order text-center d-flex justify-content-center align-items-center">
                  <div class="bg-panel-white bg-left-panel p-sm-3 p-md-5" itemscope itemtype="https://schema.org/AboutPage">
                     <h2 class="mb-4 bold-2" itemprop="headline">Unrivaled Amenities</h2>
                     <div class="lead text-secondary" itemprop="description">Elevate Your Living Experience</div>
                     <p class="mt-4 text-left text-black light-bold" itemprop="text">
                        Indulge in a lifestyle of unparalleled luxury with our meticulously designed apartments, complemented by a suite of unmatched amenities. Every detail has been thoughtfully curated to elevate your living experience. Enjoy the convenience of concierge services, savor moments of tranquility in lush landscaped gardens. Our commitment to providing exceptional amenities ensures that every day in your new home is a lavish retreat.
                     </p>
                     <div class="buttons">
                        <a href="/apartments" class="btn btn-primary rounded bold-2" itemprop="url">
                           View all Apartments
                        </a>
                     </div>
                  </div>
               </div>
               <div id="rightBox" class="col-lg-7 col-md-12 order-sm-1 order-lg-2 opacity-0 rounded card-background-image" itemscope itemtype="https://schema.org/ImageObject">
                  <img src="https://drive.google.com/thumbnail?id=1YWK1ofG4jLO-LGcsU53xO2KmxHkZShHb&sz=w2000" class="d-block w-100" alt="..." itemprop="url">
               </div>
            </div>
         </section>
      </div>
   </div>
</div>

<div class="container-fluid mt-3 mb-5" itemscope itemtype="https://schema.org/WebPageSection">
   <div class="row p-1">
      <div class="col-md-12">
         <section class="d-none d-sm-block" itemscope itemtype="https://schema.org/WebPageElement">
            <div id="intro-box3" class="opacity-0 text-center">
               <h2 class="bold-3 text-center mb-4" itemprop="name">Available Units</h2>
               <div class="lead text-secondary text-center" itemprop="description">Discover Your Perfect Home</div>
            </div>
         </section>
         <section class="d-block d-sm-none" itemscope itemtype="https://schema.org/WebPageElement">
            <div id="intro-box3" class="opacity-0 text-left">
               <h2 class="bold-3 text-left mb-4" itemprop="name">Available Units</h2>
               <div class="lead text-secondary text-left" itemprop="description">Discover Your Perfect Home</div>
            </div>
         </section>

         <div class="title">
            <div class="d-flex justify-content-between">
               <h3 class="large-heading bold" itemprop="name">Find your apartment</h3>
               <a href="/apartments" class="btn btn-round btn-primary py-2 bold-2 align-self-end font-weight-bold-2" itemprop="url">
                  View all Apartments
               </a>
            </div>
         </div>
         <div class="row p-1">
            <div id="load-products" class="col-md-12" itemscope itemtype="https://schema.org/ItemList">
               <apartments-index :isGallery="0" :filter="0" :property="{{$property}}" :apartments="{{ $apartments }}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" />
            </div>
         </div>
      </div>
   </div>
</div>

@endsection