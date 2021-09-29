@extends('layouts.listing')
@section('content')
<div class="clearfix"></div>
<section  style="background-color: #f8f5f4;">
      


   <div class="container">
       
      <div class="row no-gutters bg-white">
      
         <div class="col-lg-8">
            <div class="bg-white">
               <div>{{ $property->name }}</div>
               <p><i class="material-icons">location_on</i> {{ $property->address }} {{ $property->type }}</p>
            </div>
         </div>

         <div class="col-md-4 d-flex  align-items-end  justify-content-between">
            <div class="bg-white">
               <a  href="#" class="">
                  <svg  id="" class="mt-2">
                     <use xlink:href="#virtual-tour"></use>
                  </svg>
                  Virtual Tour
               </a>
            </div>
            <div>@include('_partials.saved',['obj'=> $property])</div>
         </div>

         <div class="clearfix"></div>
         <div class="col-md-8  position-relative bg-white">
            <a href="#" class="img card-img galleries" style="background-image: url('{{ $property->image }}')">
               
            </a>
         </div>
         <div class="col-md-4">
            <div class="row no-gutters">
               <div class="col-6 pl-1  pb-1 pr-1">
                  <a  href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>
               <div class="col-6 ">
                  <a  href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>
               <div class="col-6 pl-1  pr-1">
                  <a href="#" class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
               </div>

               <div class="col-6 pb-2 position-relative">
                  <a class="img  card-img-tn img-fluid galleries" style="background-image: url('{{ $property->image }}')"></a>
                  <a href="" class="card-img-overlay  d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04">
                     <p class="fs-48 font-weight-600 text-white lh-1 mb-4">+12</p>
                     <p class="fs-16 font-weight-bold text-white lh-1625 text-uppercase">View more</p>
                  </a>
               </div>
            </div>
         </div>

         
      </div>

      <div class="row">
         <div class="col-12 ">
            <nav class="nav text-capitalize bg-white">
               <a class="nav-link text-capitalize active" href="#Overview">Overview</a>
               <a class="nav-link text-capitalize" href="#Amenities">Amenities</a>
               <a class="nav-link text-capitalize pb-1" href="#Location">Location</a>
               <a class="nav-link text-capitalize pb-1" href="#Reviews">Reviews  </a>
            </nav>
         </div>
      </div>
   </div>



   <div class="">
      <div class="container">
        
         <div  class="row   align-items-start">
            <div class=" {{ $property->type == 'single' ? 'col-md-7' : 'col-md-12' }} rounded  mt-1">
               <div id="Overview" class="name rounded bg-white">
                 <div class="card-body">
                     <h2 class="card-title">{{ $property->name }}</h2>

                     <div class="row">
                        @if($property->type == 'single')
                           <div class="col-12 entire-apartment">
                              @include('_partials.entire_apartments',['obj' => $property->single_room])
                           </div>
                        @endif


                        <div class="col-md-7">
                           <h3>Popular amenities</h3>
                           <div class="row">
                              
                              @if($property->facilities->count())
                                 @foreach($property->facilities->take(3) as $facility)
                                    <div class="col-6 d-flex align-items-center">
                                       <span class="mt-1">
                                          <?php echo  html_entity_decode($facility->svg) ?>
                                       </span>
                                       <span class="ml-2">{{ $facility->name }}</span>
                                    </div>
                                 @endforeach
                              @endif
                             
                              <div class="see-more col-12">
                                 <a href="#">See all >></a>
                              </div>
                              
                           </div>
                           <h3>Cleaning and safety practices</h3>
                           <div class="row">
                              <div class="col-6 d-flex align-items-center">
                                 <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                                 <span class="ml-2">Pool</span>
                              </div>
                              <div class="col-6 d-flex align-items-center">
                                 <span class="mt-1"><svg class="" aria-hidden="true" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z"></path><path fill-rule="evenodd" d="M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z" clip-rule="evenodd"></path><path d="M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg></span>
                                 <span class="ml-2">Pool</span>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <h3>Explore the area</h3>
                           Silverbird Galleria
                        </div>
                     </div>
                  </div>
               </div>

               @if ($property->type != 'single')
                 <form action="/book/{{ $property->slug }}" method="GET" class="">
                     <div >
                        <h3>Choose your unit</h3>
                        <div class="form-row">
                           <div class="form-group form-border search border pl-2 col-7">
                                 @include('_partials.date')
                           </div>
                        </div>
                     </div>
                     <div id="" class="name mt-1 rounded bg-white p-2">
                        @include('_partials.multiple')
                     </div>
                  </form>
               @endif

               <div class="name bg-white rounded">
                  <h3 class="card-title  pb-3 p-3 border-bottom">About this property</h3>
                  <div class="card-body">
                     <div>{{ $property->name }}</div>
                     <p><?php echo  html_entity_decode($property->description);  ?></p>
                  </div>  
               </div>
            </div>

            @if ($property->type == 'single')
            <div class="col-12 pl-1 single-apartment rounded col-md-5">
               @include('_partials.single_apartments',['obj' => $property->single_room])
            </div>
            @endif

            

            <div class="col-12  mt-1 col-md-12">
               <div id="Amenities" class="name mt-2 bg-white">
                  <h3 class="card-title  p-3 border-bottom">Amenities</h3>
                  <div class="card-body">
                  </div>  
               </div>
               <div class="name mt-1 bg-white">
                  <h3 class="card-title  p-3 border-bottom">House Rules</h3>
                  <div class="card-body">
                  </div>  
               </div>
               <div id="Reviews" class="name mt-1 bg-white mb-5">
                  <h3 class="card-title  p-3 border-bottom">Reviews</h3>
                  <div class="card-body">
                     <div>No reviews yet</div>

                  </div>  
               </div>
            </div>
               
         </div>
      </div>
   </div>
</section>

   
@endsection
