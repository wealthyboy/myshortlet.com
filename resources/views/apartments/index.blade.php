@extends('layouts.listing')
@section('content')
<div class="clearfix"></div>
<div class="d-flex mt-5 justify-content-center align-items-center" >
   <div class="container">
      <div class="row">
      <div class="col-md-12 ml-auto mr-auto">
         <div class="">
            <div class="mt-5">
               @include('_partials.search_form')
            </div>
         </div>
      </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col-12 d-flex justify-content-between">
         <div>{{ $properties->count() }} properties in Lagos</div>
         <div>
            <div class="d-flex justify-content-md-end align-items-center">
               <div class="input-group border rounded  w-auto bg-white mr-3">
               <label class="input-group-text bg-transparent border-0   pr-1 pl-3" for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label>
               <select class="form-control border-0 bg-transparent  sortby" data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3" id="inputGroupSelect01" name="sortby">
               <option selected>Top Selling</option>
               <option value="1">Most Viewed</option>
               <option value="2">Price(low to high)</option>
               <option value="3">Price(high to low)</option>
               </select>
               </div>
            </div>
            

         </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-3 ">
         <div class="card">
            <div class="text-left pl-3">
               <div class="text-capitalize pb-2 pt-3">Your Budget</div>
               <div class="mb-2">
                  <div class="checkbox">
                     <label  id="box50" class="checkbox-label">
                     <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">less than 200k</span> 
                     </label>
                  </div> 
               </div>
               <div class="mb-2">
                  <div class="checkbox">
                     <label  id="box50" class="checkbox-label">
                     <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">200k - 500k</span> 
                     </label>
                  </div> 
               </div>
               <div class="mb-2">
                  <div class="checkbox">
                     <label  id="box50" class="checkbox-label">
                     <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">500k - 1M</span> 
                     </label>
                  </div> 
               </div>
               <div class="mb-2">
                  <div class="checkbox">
                     <label  id="box50" class="checkbox-label">
                     <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">1M - 10M</span> 
                     </label>
                  </div> 
               </div>
               
               @if ( $attributes->count() )
                  @foreach( $attributes as $key => $attribute )
                     <div class="text-capitalize pb-2">{{ $str::replaceFirst('_', ' ', $key) }}</div>
                     @foreach($attribute->sortBy('name') as $child)
                        <div class="mb-2">
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                                 <span class="checkbox-custom rectangular"></span>
                                 <span class="checkbox-label-text mt-1">{{$child->name }}</span> 
                              </label>
                           </div> 
                        </div>
                     @endforeach
                  @endforeach
               @endif
               @if ( $attributes->count() )

               <div class="text-capitalize ">Cities</div>

               <div class="m-0 ">
                  <div class="checkbox">
                     <label  id="box50" class="checkbox-label">
                     <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                        <span class="checkbox-custom rectangular"></span>
                        <span class="checkbox-label-text mt-1">less than 200k</span> 
                     </label>
                  </div> 
               </div>


               @endif


               
            </div>
         </div>
         
      </div>
      <div class="col-md-9">
            
         @if ( $properties->count())
         @foreach( $properties as $property)
            <div class="card position-relative">
               <div class="row no-gutters">
                  <div class="col-md-3 position-relative">
                     <div class="">
                        <a href="/apartment/{{ $property->slug }}">
                           <img class="img img-raised img-fluid" src="{{ $property->image_m }}">
                        </a>
                        <div class="fav-icon position-absolute">
                            @include('_partials.saved',['obj'=> $property])
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 pl-3">
                     <h3 class="card-title">
                        <a href="/apartment/{{ $property->slug }}">{{ $property->name }}</a>
                     </h3>
                     <div class="">
                        <samll class=""> <a class="p-0" href="/apartment/{{ optional($property)->slug }}"> <i class="material-icons">location_on</i> {{ $property->city }}</a>,  <a href="">{{ $property->state }}</a> </small>
                     </div>
                     <div class="d-flex">

                     @foreach($property->facilities->take(3) as $facility)
                     <div class="">
                        <span class="">  <span class="c"><?php echo  html_entity_decode($facility->svg) ?></span> {{ $facility->name }}</span>
                     </div>
                     @endforeach
                     </div>


                     @if( $property->type == 'single')
                     <div>
                        <span class="">{{  $property->single_room->max_children + $property->single_room->no_of_rooms }} guests</span>
                        <span aria-hidden="true"> · </span>
                        <span class="">{{ $property->single_room->no_of_rooms }} bedroom</span>
                        <span aria-hidden="true"> · </span>
                        <span aria-hidden="true"> · </span>
                        <span class="">{{ $property->single_room->toilets }}baths</span>
                     </div>
                     @endif

                     <div class="position-absolute">
                        3 reviews
                     </div>
                  </div>
                  <div class="col-md-3  d-flex justify-content-start align-items-end pl-3">
                     <div>
                        <p>
                           @if( $property->apartments->count() && $property->apartments->count() >  1  )
                           <span class="text-heading lh-15 font-weight-bold fs-17">From {{ $property->currency }}{{ optional($property->single_room)->price }} </span>
                           @else
                           <span class="text-heading lh-15 font-weight-bold fs-17">{{ $property->currency }}{{ optional(optional($property->apartments)->first())->price }}</span>
                           @endif
                           <span class="text-gray-light">/ night</span>
                        </p>
                        @if ($property->allow_cancellation)
                        <div class=""><span class="">FREE CANCELLATION</span></div>
                        @endif
                        <a href="/apartment/{{ $property->slug }}" class="btn btn-primary btn-round">
                           Check Availability  <i class="material-icons">arrow_forward_ios</i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
         <div id="pagination" class=" text-center mb-20 md-offset-1">
               @if(!empty($properties->hasMorePages()))
                  <a href="{{ $properties->nextPageUrl() }}" id="load_more" class="btn btn-primary loadmore btn-loadmore load_more mt-4 mb-2">
                     <span class="spinner-grow spinner-grow-md d-none"></span>
                     Load More  <i class="material-icons">arrow_forward_ios</i>
                  </a>
               @endif
         </div>
         @else
            <div class="no-apartments">
               <div class=" d-flex justify-content-center fa-2x"  >
                  <div class="text-center pb-3">
                     <i class="material-icons display-1">apartment</i>
                     <p class="bold">You have not added any property.</p>
                  </div>
               </div>
            </div>
         @endif
      </div>
   </div>
</div>

@include('_partials.svg')

   
@endsection
@section('page-scripts')
@stop