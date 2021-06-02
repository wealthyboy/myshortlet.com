

@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="row mt-5">
      <div class="col-lg-3">
         @include('includes.account_nav')
      </div>
      @if ($properties->count())
      @foreach($properties as $propertie)
      <div class="col-lg-9">
         <div class="card mb-3" style="">
            <div class="row no-gutters">
               <div class="col-md-4">
                  <img src="{{ $propertie->image }}" class="img-fluid" alt="...">
               </div>
               <div class="col-md-5">
                  <div class="card-body">
                     <h5 class="card-title">{{ $propertie->name }}</h5>
                     <div class="card-text"><a href="">{{ $propertie->city }}</a>,  <a href="">{{ $propertie->state }}</a></div>
                     <p class="card-text"><small class="text-muted"><?php echo  str_limit(html_entity_decode($propertie->description), $limit = 200, $end = '...') ?> </small></p>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="text-right">
                     <div class="d-flex justify-content-end">
                        <div class="review-score__content">
                           <div class="review-score__title"> Very Good</div>
                           <div class="review-score__text"> 2,977 reviews </div>
                        </div>
                        <div class="review-score__badge" aria-label="Scored 8.3 "> 8.3 </div>
                     </div>
                     <div class="">
                        <div class="">
                           <div class="">
                              <div class="">1 night, 2 adults</div>
                           </div>
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
                                    <a class="" href="">
                                       <span class="button__text js-sr-cta-text">
                                       See availability
                                       </span>
                                       <span class="">
                                          <svg class="bk-icon -streamline-arrow_nav_right" height="16" width="16" viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false">
                                             <path d="M9.45 6c.2 0 .39.078.53.22l5 5c.208.206.323.487.32.78a1.1 1.1 0 0 1-.32.78l-5 5a.75.75 0 0 1-1.06 0 .74.74 0 0 1 0-1.06L13.64 12 8.92 7.28a.74.74 0 0 1 0-1.06.73.73 0 0 1 .53-.22zm4.47 5.72zm0 .57z"></path>
                                          </svg>
                                       </span>
                                    </a>
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
      @else
      <div class="col-lg-9 main-content">No Apartments</div>
      @endif
   </div>
</div>
@endsection
@section('page-scripts')
@stop

