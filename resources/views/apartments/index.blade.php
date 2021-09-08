@extends('layouts.app')
@section('content')
<section class="pb-8 page-title shadow">
   <div class="container-fluid ">
   <div class="text-center bg-light">
   <div class="col-md-11 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">Find deals on Apartments.</h1>
      <form  action="/search" method="GET">
         <div class="form-row">
            <div class="col-md-4">
               <div class="form-group mb-4">
                  <div class="input-group input-group-lg">
                     <div class="input-group-prepend ">
                        <span
                           class="input-group-text  border-0 text-muted fs-18"
                           id="inputGroup-sizing-lg"
                           >
                        <i class="fas fa-location"></i>
                        </span>
                     </div>
                     <input
                        type="text"
                        class="form-control  shadow-none fs-13"
                        id="location"
                        name="location"
                        required="true"
                        placeholder="Where are you going"
                        autocomplete="off"
                     />
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group mb-4">
                  <div class="input-group input-group-lg">
                     <div class="input-group-prepend">
                        <span
                           class="input-group-text  border-0 text-muted fs-18"
                           id="inputGroup-sizing-lg"
                           >
                        <i class="fal fa-calendar-week"></i>
                        </span>
                     </div>
                     <input
                        type="text"
                        class="form-control  shadow-none fs-13"
                        id="flatpickr-input-f"
                        name="check_in_check_out"
                        placeholder="Check in-Check out"
                        />
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <persons />
            </div>
            <div class="col-md-2">
               <button type="submit" class="btn btn-block btn-primary">Search</button>
            </div>
         </div>
      </form>
   </div>
</div>
      <div class="row justify-content-end mb-5">
         <div class="col-lg-3 ">
            <div class="primary-sidebar-inner">
               
               <section class="">
                  <h4 class="fs-22 text-heading mb-6"></h4>
                  @if ( $attributes->count() )
                  @foreach( $attributes as $attribute )
                  <h3 class="card-title mb-0 text-heading fs-22 lh-15">{{ $attribute->name }}</h3>
                  @foreach($attribute->children->sortBy('name') as $child)
                  <div class="">
                     <ul class="list-group list-group-no-border">
                        <li class="list-group-item px-0 pt-0 pb-2">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" name="features[]" id="{{ $child->id }}">
                              <label class="custom-control-label" for="{{ $child->id }}">{{ $child->name }}</label>
                           </div>
                        </li>
                     </ul>
                  </div>
                  @endforeach
                  @endforeach
                  @endif
               </section>
            </div>
         </div>
         <div class="col-lg-9 mb-8 mb-lg-0 order-1 order-lg-2">
            <div class="row align-items-sm-center mb-4">
               <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">We found <span class="text-primary">45</span> properties
                     available for
                     you
                  </h2>
               </div>
               <div class="col-md-6 mt-4 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center">
                     <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                        <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3" for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label>
                        <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby" data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3" id="inputGroupSelect01" name="sortby">
                           <option selected>Top Selling</option>
                           <option value="1">Most Viewed</option>
                           <option value="2">Price(low to high)</option>
                           <option value="3">Price(high to low)</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            @if ($properties->count())
               @foreach($properties as $property)
                  <div class="" data-animate="fadeInUp">
                     <div class="row mb-5">
                        <div class="col-sm-3">
                           <a class="" href="/property/{{ $property->slug }}">
                              <img src="{{ $property->image_m }}" class="card-img" alt="{{ $property->name }}">
                           </a>
                        </div>
                        <div class="col-sm-9">
                           <div>
                              <div class="" style="">{{ $property->type }}</div>
                              <a href="/property/{{ $property->slug }}" class="fs-16 lh-2 text-dark hover-primary d-block">
                                 <h2 class="my-0">{{ $property->name }}</h2>
                              </a>
                              <button aria-label="Add listing to a list" type="button" class="_1mm2a5z"><span class="_e296pg"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: transparent; height: 24px; width: 24px; stroke: rgb(34, 34, 34); stroke-width: 2; overflow: visible;"><path d="m16 28c7-4.733 14-10 14-17 0-1.792-.683-3.583-2.05-4.95-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05l-2.051 2.051-2.05-2.051c-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05-1.367 1.367-2.051 3.158-2.051 4.95 0 7 7 12.267 14 17z"></path></svg></span></button>
                           </div>
                           
                           @if( $property->type == 'single')
                           <div>
                              <span class=""> guests</span>
                              <span aria-hidden="true"> · </span>
                              <span class="">1 bedroom</span>
                              <span aria-hidden="true"> · </span>
                              <span class="">1 bed</span>
                              <span aria-hidden="true"> · </span>
                              <span class="">1.5 baths</span>
                           </div>
                           @endif

                           <div>
                              <span class="">Kitchen</span>
                              <span aria-hidden="true"> · </span>
                              <span class="">Air conditioning</span>
                           </div>

                           <div>
                              <span class="">Free conditioning</span>
                           </div>

                           <div class="">
                              <div>4.72 (29 reviews)</div>

                              <div>$20 - $20 per night</div>
                           </div>
                     
                        </div>
                  </div>
               @endforeach
            @else
            <div class="col-lg-9 main-content">No Apartments</div>
            @endif
            <nav class="pt-6">
            </nav>
         </div>
      </div>
   </div>
</section>
@endsection
@section('page-scripts')
@stop