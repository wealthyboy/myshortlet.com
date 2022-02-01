<div class="row no-gutters">
   <div class="col-md-3 position-relative">
      <div class="">
         <a href="/apartment/{{ $property->slug }}?check_in_checkout={{ request()->check_in_check_out }}">
         <img class="img  img-fluid" src="{{ $property->image_m }}">
         </a>
         <div class="fav-icon position-absolute">
            @include('_partials.saved',['obj'=> $property])
         </div>
      </div>
   </div>
   <div class="col-md-9 position-relative col-12 pl-3">
      <div class="d-flex  justify-content-between">
         <div class="">
            <a href="/apartment/{{ $property->slug }}?check_in_checkout={{ $date }}">{{ $property->name }}</a>
            <div class="d">
               <small class=""> 
               <a class="p-0" href="/apartment/{{ optional($property)->slug }}?check_in_checkout={{ $date }}">{{ $property->city }}</a>,  <a href="">{{ $property->state }}</a> </small>
            </div>
            <div class="mb-5">
               @if($property->facilities->count())
               <div class="">
                  @foreach($property->facilities->take(3) as $facility)
                  <span class="">{{ $facility->name }}. </span>
                  @endforeach
               </div>
               @endif
               @if( $property->type == 'single')
               <div class="guests-section">
                  <span class="">{{ $property->single_room->max_children + $property->single_room->no_of_rooms }} guests</span>
                  <span aria-hidden="true"> · </span>
                  <span class="">{{ $property->single_room->no_of_rooms }} bedroom</span>
                  <span aria-hidden="true"> · </span>
                  <span class="">{{ $property->single_room->toilets }} baths</span>
               </div>
               @endif
               @if( $property->is_refundable )
               <div class=""> Fully Refundable</div>
               @else
               <div class=""> Non - Refundable</div>
               @endif
               @if( $property->free_services->count() )
               <div class="d-inline-flex">
                  @foreach( $property->free_services as $free_service)
                  <div class="refundable">{{ $free_service->name }} included</div>
                  @endforeach
               </div>
               @endif
            </div>
         </div>
      </div>
      <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">
         <div class="reviews-section">
         </div>
         <div class=" text-right mr-2">
            @include('_partials.price')
            <a href="/apartment/{{ $property->slug }}?check_in_checkout={{ $date }}" class="btn btn-primary btn-round d-none d-lg-block d-xl-block">
            Check Availability  <i class="material-icons">arrow_forward_ios</i>
            </a>
         </div>
      </div>
   </div>
</div>