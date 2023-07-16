@extends('layouts.listing')
@section('content')
<div class="clearfix"></div>
<section id="content" style="background-color: #f8f5f4;">
   <div class="container">
      <div class="row no-gutters bg-white">
         <div class="col-lg-10 col-10">
            <div class="bg-white p-3 bold text-size-1-big">
               <div>{{ $property->name }}</div>
            </div>
         </div>
         <div class="col-md-2 col-2 d-flex  align-items-center  justify-content-end">
            <div>
               <saved :property="{{$property}}" />
            </div>
         </div>
         <div class="clearfix"></div>
         <div class=" {{ $property_type->images->count() >= 4 ? 'col-md-8' : 'col-md-12' }} position-relative bg-white  d-none d-lg-block ">
            <a href="#" class="img card-img galleries" style="background-image: url('{{ $property->image }}')"></a>
         </div>
         @if ($property_type->images->count() >= 4)

         <div class="col-md-4 d-none d-lg-block ">
            <div class="row no-gutters">
               <div class="col-6 pl-1  pb-1 pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ optional($property_type->images[0])->image }}')"></a>
               </div>
               <div class="col-6 pl-1  pb-1 pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ optional($property_type->images[0])->image }}')"></a>
               </div>
               <!-- <div class="col-6 ">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $property_type->images[1]->image }}')"></a>
                  <a href="#" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-1">
                        <svg  id="" class="mt-2">
                           <use xlink:href="#virtual-tour"></use>
                        </svg>
                     </p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase bold">Virtual Tour</p>
                  </a>
               </div> -->
               <div class="col-6 pl-1  pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property_type->images[2]->image }}')"></a>
               </div>
               <div class="col-6 pb-2 position-relative">
                  <a class="img  card-img-tn header-filter img-fluid galleries" style="background-image: url('{{ $property_type->images[3]->image }}')"></a>
                  <a href="#" id="full-image" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image ">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-1 bold">+{{ $property->images->count() }}</p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase bold">View Gallery</p>
                  </a>
               </div>
            </div>
         </div>
         @endif

         @include('properties.mobile_slides')
      </div>
      <div class="row">
         <div class="col-12 ">
            <div class="d-flex justify-content-between bg-white">
               <nav class="nav text-capitalize bg-white">
                  <a class="nav-link text-capitalize active" href="#Overview">Overview</a>
                  <a class="nav-link text-capitalize" href="#Amenities">Amenities</a>
                  <a class="nav-link text-capitalize pb-1" href="#Location">Location</a>
               </nav>
               <a target="_blank" href="/property/avenu-montaigne-42210936" class="btn btn-round  btn-blue     d-lg-block d-xl-block align-self-end">
                  Make Reservation
               </a>
            </div>
         </div>
      </div>
   </div>
   <div class="">
      <div class="container">
         <div class="row   align-items-start">
            <div class=" {{ $property->type == 'single' ? 'col-md-7' : 'col-md-12' }} rounded  mt-1">
               <div id="Overview" class="name rounded bg-white">
                  <div class="card-body">
                     <h3 class="card-title bold">{{ $property->name }}</h3>
                     <div class="row">
                        @if($property->type == 'single')
                        <div class="col-12 entire-apartment mb-3">
                           @include('_partials.entire_apartments',['obj' => $property->single_room])
                        </div>
                        @endif
                        <div class="col-md-6">
                           <h5 class="bold">Popular amenities</h5>
                           <div class="row">
                              @if($property->facilities->count())
                              @foreach($property->facilities->take(3) as $facility)
                              <div class="col-6 d-flex mb-2 align-items-center">
                                 <span class="position-absolute svg-icon-section">
                                    <?php echo  html_entity_decode($facility->svg) ?>
                                 </span>
                                 <span class="svg-icon-text">{{ $facility->name }}</span>
                              </div>
                              @endforeach
                              @endif
                              <div class="see-more col-12">
                                 <a class="text-size-2 text-gold" href="#">See all >></a>
                              </div>
                           </div>
                           <h5 class="bold">Safety practices</h5>
                           <div class="">
                              <ul class="list-unstyled ">
                                 @foreach($safety_practices as $key => $safety_practice)
                                 <li class="">{{ $safety_practice->name }}</li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div style="height: 200px;" id="map2"></div>
                           <div>{{ $property_type->address }}</div>
                           @if ($areas->count())
                           <h5 class="bold">Explore the area</h5>
                           <div class="">
                              <ul class="list-unstyled ">
                                 @foreach($areas as $key => $area)
                                 <li class="">{{ $area->name }}</li>
                                 @endforeach
                              </ul>
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               <div>
                  @if ($property->type != 'single')
                  <multiple-apartments :apartments="{{ $apartments }}" :property="{{ $property }}" :days="{{ $days }}" :nights="{{ collect($nights) }}" type="multiple" />
                  @endif
               </div>
               <div class="name bg-white rounded">
                  <h3 class="card-title  pb-3 p-3 border-bottom bold">About this property</h3>
                  <div class="card-body">
                     <div>{{ $property->name }}</div>
                     <p><?php echo  html_entity_decode($property->description);  ?></p>
                  </div>
               </div>
               <div class="name bg-white rounded">
                  <h3 class="card-title  pb-3 p-3 border-bottom bold">About the area</h3>
                  <div class="card-body">
                     <div class="row   align-items-start">
                        <div class="col-md-4">
                           <h3 class="card-title bold"> {{ $property->state }}</h3>
                           {{ $property->state_description }}
                        </div>
                        <div class="col-md-7">
                           <div id="map"></div>
                           <div class="row">
                              @if ($areas->count())

                              <div class="col-md-6">
                                 <h5 class="card-title bold">What's near by</h5>
                                 <ul class="list-unstyled">
                                    @foreach($areas as $key => $area)
                                    <li class="">{{ $area->name }}</li>
                                    @endforeach
                                 </ul>
                              </div>
                              @endif
                              <div class="col-md-6">
                                 <h5 class="card-title bold">Restuarants</h5>
                                 <ul class="list-unstyled ">
                                    @foreach($restaurants as $key => $restaurant)
                                    <li class=""><span class="position-absolute svg-icon-section">
                                          <?php echo  html_entity_decode($facility->svg) ?>
                                       </span>{{ $restaurant->name }}
                                    </li>
                                    @endforeach
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @if ($property->type == 'single')
            <div class="col-12 pl-1 single-apartment rounded col-md-5">
               <single-apartment :apartment="{{ $apartments[0]->load('property') }}" :property="{{ $property }}" :days="{{ $days }}" :nights="{{ collect($nights) }}" type="multiple" />
            </div>
            @endif
            <div class="col-12  mt-1 col-md-12">
               <div id="Amenities" class="name mt-2 bg-white">
                  <h3 class="card-title  p-3 border-bottom bold">Amenities</h3>
                  <div class="card-body">
                     <div class="row">
                        @foreach($amenities as $key => $apartment_facilities)
                        <div class="col-md-3">
                           <h5 class="card-title">{{ $key }}</h5>
                           <ul class="list-unstyled">
                              @foreach($apartment_facilities as $key => $apartment_facility)
                              <li>
                                 {{ $apartment_facility->name }}
                              </li>
                              @endforeach
                           </ul>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>

               <div class="name house-rules mt-1 bg-white mb-3">
                  <h3 class="card-title  p-3 border-bottom bold">House Rules</h3>
                  <div class="card-body">
                     <ul class="list-unstyled">
                        <li>
                           Check in - {{ $property->check_in_time }}
                        </li>
                        <li>
                           Check out - {{ $property->check_out_time }}
                        </li>
                        @foreach($property->rules as $rule)
                        <li>
                           {{ $rule->name }}
                        </li>
                        @endforeach
                        <li>
                           <div>{{ $property->cancellation_message }}</div>
                        </li>
                     </ul>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</section>

@include('properties.slider')


@endsection