

@extends('layouts.app')
@section('content')
<section>
<div class=" mt-5">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb pt-lg-0 pb-3">
         <li class="breadcrumb-item fs-12 letter-spacing-087">
            <a href="">Home</a>
         </li>
         <li class="breadcrumb-item fs-12 letter-spacing-087">
            <a href="listing-grid-with-left-filter.html">Listing</a>
         </li>
         <li class="breadcrumb-item fs-12 letter-spacing-087 active">Villa on Hollywood Boulevard</li>
      </ol>
   </nav>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col-lg-7">
         <div>
            <h1>{{ $apartment->name }}</h1>
            <p><i class="bi bi-geo-alt-fill"></i> {{ $apartment->address }}</p>
         </div>
      </div>
      <div class="col-lg-5">
         <div class="text-right">
            <span class="mr-3">
            <i class="bi bi-heart"></i>
            </span>
            <span>
            <i class="bi bi-share-fill"></i>             
            </span>
         </div>
      </div>
   </div>
   <div class="row galleries m-n1">
      <div class="col-lg-6 p-1">
         <div class="item item-size-4-3">
            <div class="card p-0 hover-zoom-in">
               <a href="{{ $apartment->image }}" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url({{ $apartment->image }})">
               <img src="{{ $apartment->image }}" alt="" class="img-fluid" srcset="">
               </a>
            </div>
         </div>
      </div>
      <div class="col-lg-6 p-1">
         <div class="row m-n1">
            <div class="col-md-6 p-1">
               <div class="item item-size-4-3">
                  <div class="card p-0 hover-zoom-in">
                     <a href="images/single-property-lg-2.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url('images/single-property-22.jpg')">
                     <img src="{{ $apartment->image }}" alt="" class="img-fluid" srcset="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-6 p-1">
               <div class="item item-size-4-3">
                  <div class="card p-0 hover-zoom-in">
                     <a href="images/single-property-lg-3.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url('images/single-property-3.jpg')">
                     <img src="{{ $apartment->image }}" alt="" class="img-fluid" srcset="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-6 p-1">
               <div class="item item-size-4-3">
                  <div class="card p-0 hover-zoom-in">
                     <a href="images/single-property-lg-4.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url('images/single-property-4.jpg')">
                     <img src="{{ $apartment->image }}" alt="" class="img-fluid" srcset="">
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-md-6 p-1">
               <div class="item item-size-4-3">
                  <div class="card p-0 hover-zoom-in">
                     <a href="images/single-property-lg-5.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="01" style="background-image:url('images/single-property-5.jpg')">
                     <img src="{{ $apartment->image }}" alt="" class="img-fluid" srcset="">
                     </a>
                     <a href="single-property-1.html#" class="card-img-overlay d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                        <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+12</p>
                        <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View
                           more
                        </p>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row no-gutters">
      <div class="col-lg-6">
         <div>
            <h1>Description</h1>
            <p><?php echo  html_entity_decode($apartment->description);  ?></p>
         </div>
         <hr>
         <h1>Popular Amenities</h1>
         <div class="col-lg-12">
         </div>
      </div>
      <div class="col-lg-6">
         <div class="">
            <h1>
            Availability 
            </h2>
            <div class="availability">
               <form action="/checkout/" method="POST" class="form-group">
                 @csrf
                  <div class="form-row mb-3">
                     <div class="col">
                        <input type="text" id="flatpickr-input" class="form-control " name="check_in_checkout" placeholder="Check in-Check out">
                     </div>
                     <div class="col">
                        <select class="form-select   form-control" aria-label="Default select example">
                           <option selected></option>
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                        </select>
                     </div>
                     <div class="">
                        <button type="submit" class="btn btn-primary">Search</button>
                     </div>
                  </div>
                  <div class="rooms">
                     @foreach($apartment->rooms as $room)
                     <div class="col-lg-12">
                        <div class="card mb-3" style="">
                           <div class="row no-gutters">
                              <div class="col-md-4">
                                 <img src="{{ $room->image }}" class="img-fluid" alt="...">
                                 
                              </div>
                              <div class="col-md-5">
                                 <div class="card-body">
                                    <h5 class="card-title">{{ $room->name }}</h5>
                                    <div class="card-text">
                                          <small href="">3 adults max , 2 Children Max, 3 bedroom</small>
                                    </div>
                                    <div class="facility">
                                    
                                    </div>
                                 </div>
                              </div>

                              <div class="col-md-1">
                                 <select class="form-select form-control" name="qty[{{ $room->id }}]" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                              </div>

                              <div class="col-md-2">
                                 <div class="text-right">
                                    <div class="">
                                       <div class="">
                                          
                                          <div class="">
                                             <div class="">
                                                <span class="">
                                                Price
                                                NGN&nbsp;26,337
                                                </span>
                                             </div>
                                          </div>
                                          <div class="">
                                             <div class="">
                                                Includes taxes and fees
                                             </div>
                                          </div>
                                       </div>
                                       <div>
                                          <div>
                                             <div colspan="4" class="roomFooter">
                                                <div class="">
                                                   
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     @endforeach
                     <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-block" type="submit">Book Now</button>
                     </div>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>
   <section>
      <h4 class="fs-22 text-heading lh-15 mb-5 pt-3">Rating & Reviews</h4>
      <div class="card border-0 mb-4">
         <div class="card-body p-0">
            <div class="row">
               <div class="col-sm-6 mb-6 mb-sm-0">
                  <div class="bg-gray-01 rounded-lg pt-2 px-6 pb-6">
                     <h5 class="fs-16 lh-2 text-heading mb-6">
                        Avarage User Rating
                     </h5>
                     <p class="fs-40 text-heading font-weight-bold mb-6 lh-1">4.6 <span class="fs-18 text-gray-light font-weight-normal">/5</span></p>
                     <ul class="list-inline">
                        <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item bg-warning text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item bg-gray-04 text-white w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-18 mb-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-sm-6 pt-3">
                  <h5 class="fs-16 lh-2 text-heading mb-5">
                     Rating Breakdown
                  </h5>
                  <div class="d-flex align-items-center mx-n1">
                     <ul class="list-inline d-flex px-1 mb-0">
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                     <div class="d-block w-100 px-1">
                        <div class="progress rating-progress">
                           <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                     <div class="text-muted px-1">60%</div>
                  </div>
                  <div class="d-flex align-items-center mx-n1">
                     <ul class="list-inline d-flex px-1 mb-0">
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                     <div class="d-block w-100 px-1">
                        <div class="progress rating-progress">
                           <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                     <div class="text-muted px-1">40%</div>
                  </div>
                  <div class="d-flex align-items-center mx-n1">
                     <ul class="list-inline d-flex px-1 mb-0">
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                     <div class="d-block w-100 px-1">
                        <div class="progress rating-progress">
                           <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                     <div class="text-muted px-1">0%</div>
                  </div>
                  <div class="d-flex align-items-center mx-n1">
                     <ul class="list-inline d-flex px-1 mb-0">
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                     <div class="d-block w-100 px-1">
                        <div class="progress rating-progress">
                           <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                     <div class="text-muted px-1">0%</div>
                  </div>
                  <div class="d-flex align-items-center mx-n1">
                     <ul class="list-inline d-flex px-1 mb-0">
                        <li class="list-inline-item text-warning mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                        <li class="list-inline-item text-border mr-1">
                           <i class="fas fa-star"></i>
                        </li>
                     </ul>
                     <div class="d-block w-100 px-1">
                        <div class="progress rating-progress">
                           <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                     <div class="text-muted px-1">0%</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="pt-5">
      <div class="card border-0 mb-4">
         <div class="card-body p-0">
            <h3 class="fs-16 lh-2 text-heading mb-0 d-inline-block pr-4 border-bottom border-primary">5
               Reviews
            </h3>
            <div class="media border-top pt-7 pb-6 d-sm-flex d-block text-sm-left text-center">
               <img src="images/review-07.jpg" alt="Danny Fox" class="mr-sm-8 mb-4 mb-sm-0">
               <div class="media-body">
                  <div class="row mb-1 align-items-center">
                     <div class="col-sm-6 mb-2 mb-sm-0">
                        <h4 class="mb-0 text-heading fs-14">Danny Fox</h4>
                     </div>
                     <div class="col-sm-6">
                        <ul class="list-inline d-flex justify-content-sm-end justify-content-center mb-0">
                           <li class="list-inline-item mr-1">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                           </li>
                           <li class="list-inline-item mr-1">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                           </li>
                           <li class="list-inline-item mr-1">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                           </li>
                           <li class="list-inline-item mr-1">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                           </li>
                           <li class="list-inline-item mr-1">
                              <span class="text-warning fs-12 lh-2"><i class="fas fa-star"></i></span>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <p class="mb-3 pr-xl-17">Very good and fast support during the week. Thanks for
                     always
                     keeping your WordPress themes up to date. Your level of support and dedication
                     is second to none.
                  </p>
                  <div class="d-flex justify-content-sm-start justify-content-center">
                     <p class="mb-0 text-muted fs-13 lh-1">02 Dec 2020 at 2:40pm</p>
                     <a href="single-property-1.html#" class="mb-0 text-heading border-left border-dark hover-primary lh-1 ml-2 pl-2">Reply</a>
                  </div>
               </div>
            </div>
            
            
           
         </div>
      </div>
   </section>
   <section>
</div>
</section>
@endsection
@section('page-scripts')
@stop

