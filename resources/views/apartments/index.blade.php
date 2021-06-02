@extends('layouts.app')
@section('content')
<nav class="mt-5" aria-label="breadcrumb">
   <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Library</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data</li>
   </ol>
</nav>
<div class="container-fluid ">
   <div class="row justify-content-end mb-5">
      <div class="col-lg-3 ">
         <form id="collections" action="">
            <div class="widget">
               <h3 class="widget-title ">
                  <a data-toggle="collapse" href="#widget-prices" role="button" class="bold" aria-expanded="true" aria-controls="widget-body-2">Prices</a>
               </h3>
               <div class="collapsed bold" id="widget-prices">
                  <div class="widget-body">
                     <ul class="cat-list">
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="200000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  200,000</span> 
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="400000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  400,000</span> 
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="600000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  600,000</span> 
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="800000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  800,000</span> 
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="1000000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  1,000,000</span> 
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox">
                              <label  id="box50" class="checkbox-label">
                              <input for="box50" name="prices[]" value="10000000" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text">Less Than  10,000,000</span> 
                              </label>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <!-- End .widget-body -->
               </div>
               <!-- End .collapse -->
            </div>
            <!-- End .widget -->
            @foreach($attributes as $attribute)
            <div  class="widget">
               <h3 class="widget-title">
                  <a class="collapsed bold"   data-toggle="collapse" href="#widget-body-4{{ $attribute->id }}" role="button" aria-expanded="true" aria-controls="widget-body-4{{ $attribute->id}}">{{ $attribute->name }}</a>
               </h3>
               <div class="collapse"  id="widget-body-4{{ $attribute->id }}">
                  <div class="widget-body">
                     <ul class="cat-list  {{ $attribute->children->count() > 6  ?  'widget-scroll' : '' }}">
                        @foreach($attribute->children as $attribute)
                        <li class="">
                           <div class="checkbox">
                              <label  id="box{{ $attribute->slug }}" class="checkbox-label">
                              <input for="box{{ $attribute->slug }}" name="{{ $attribute->slug }}[]" value="{{ $attribute->slug }}" class="filter-product" type="checkbox">
                              <span class="checkbox-custom rectangular"></span>
                              <span class="checkbox-label-text color--primary">{{ optional($attribute)->name }}   </span> 
                              </label>
                           </div>
                        </li>
                        @endforeach
                     </ul>
                  </div>
                  <!-- End .widget-body -->
               </div>
               <!-- End .collapse -->
            </div>
            <!-- End .widget -->
            @endforeach
            <!-- Content -->
         </form>
      </div>
      <div class="col-lg-9">
         <div class="filters">
            
            <div class="row align-items-sm-center mb-4">
               <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">We found <span class="text-primary">{{ $apartments->count() }}</span> properties
                     available for
                     you in  {{ $location->name }}
                  </h2>
               </div>
               <div class="col-md-6 mt-4 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center">
                     <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                        <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3" for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label>
                        <div class="dropdown bootstrap-select form-control border-0 bg-transparent shadow-none p-0 sortby">
                           <select class="form-control border-0 bg-transparent shadow-none p-0  sortby"  id="inputGroupSelect01" name="sortby" tabindex="null">
                              <option selected="">Top Selling</option>
                              <option value="1">Most Viewed</option>
                              <option value="2">Price(low to high)</option>
                              <option value="3">Price(high to low)</option>
                           </select>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
         @if ($apartments->count())
         @foreach($apartments as $apartment)
         <div class="col-lg-12">
            <div class="card mb-3" style="">
               <div class="row no-gutters">
                  <div class="col-md-4">
                     <a href="/apartment/{{ $apartment->slug }}">
                     <img src="{{ $apartment->image }}" class="img-fluid" alt="...">
                     </a>
                  </div>
                  <div class="col-md-5">
                     <a href="/apartment/{{ $apartment->slug }}">
                        <div class="card-body">
                           <h5 class="card-title">{{ $apartment->name }}</h5>
                           <div class="card-text">
                     <a href="">{{ $apartment->city }}</a>,  <a href="">{{ $apartment->state }}</a></div>
                     <p class="card-text"><small class="text-muted"><?php echo  str_limit(html_entity_decode($apartment->description), $limit = 200, $end = '...') ?> </small></p>
                     </div>
                     </a>
                  </div>
                  <div class="col-md-3">
                     <div class="text-right">
                        <div class="d-flex justify-content-end">
                           <div class="review-score__content">
                              <a href="/apartment/{{ $apartment->slug }}">
                                 <div class="review-score__title"> Very Good</div>
                                 <div class="review-score__text"> 2,977 reviews </div>
                              </a>
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
                                       <a href="/apartment/{{ $apartment->slug }}">
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
</div>
@endsection
@section('page-scripts')
@stop

