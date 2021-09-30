@extends('layouts.listing')
@section('content')
<div class="d-flex  justify-content-center align-items-center" >
   <div class="container">
      <div class="row">
         <div class="col-md-12 ml-auto mr-auto">
            <div class="mt-5">
               @include('_partials.search_form')
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row no-gutters ">
      <div class="col-12 d-flex  mb-1 justify-content-between">
         <div>{{ $properties->total() }} properties found</div>
         <div>
            <div class="d-flex justify-content-md-end align-items-center">
               <div class="input-group border rounded  w-auto bg-white mr-3">
               <label class="input-group-text bg-transparent border-0   pr-1 pl-3" for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label>
               <select name="sort_by" id="sort_by" class="form-control border-0 bg-transparent  sortby" data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3" id="inputGroupSelect01">
               <option value="">Recommended</option>
               <option value="price,asc ">Price(low to high)</option>
               <option value="price,desc">Price(high to low)</option>
               </select>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>


      <div class="sidebar-toggle d-block d-sm-none ">  <i class="material-icons filter adjust">sort</i> filter</div>
      <div class="sidebar-overlay d-none"></div>
      
      <div class="col-md-3 pr-2 mobile-sidebar">
         <div class=" bg-white  sidebar-section">
            @include('_partials.search')
         </div>
         
      </div>

      <div  id="load-products" class="col-md-7 pl-1">
         <div class="d-none ap-loaders">
            @for($i =1; $i < 6; $i++)
            <div class="card position-relative"><div class="row no-gutters"><div class="col-md-3 position-relative"><div class="apart-loading" style="width: 100%; height: 232px; background-color: rgb(204, 204, 204);"><a href=""></a> <div class="fav-icon position-absolute"><a href="#" data-id="189" data-toggle="loggedIn" data-target="#auth" title="Wishlist" class="saved"></a></div></div></div> <div class="col-md-9 position-relative col-12 pl-3"><div class="d-flex  justify-content-between"><div class="apart-loading" style="width: 50%; height: 12px; background-color: rgb(204, 204, 204);"></div> <div class="apart-loading" style="width: 40%; height: 12px; background-color: rgb(204, 204, 204);"></div></div> <div><small><a class="p-0 d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></a>,  <a href="" class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></a></small></div> <div class="mb-5"><div><span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span> <span class="d-inline-block  apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span> <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span></div> <div><span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span> <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span> <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span></div></div> <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end"><div class="apart-loading mb-2" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></div> <div class="d-none d-lg-block d-xl-block text-right mr-2"><span class="apart-loading d-inline-block" style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"></span> <div class=" apart-loading btn btn-primary btn-round d-none d-lg-block d-xl-block" style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"></div></div></div></div></div></div>
            @endfor
         </div>
         
  
         @if ( $properties->count())
         @foreach( $properties as $property)
            <div class="bg-white mb-2 rounded position-relative loaded-apartments">
               @include('_partials.apartments')
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

      <div class="col-md-2 pl-2">
         <img class="img-fluid" src="https://avenuemontaigne.ng/uploads/Lfr25dG9jV42zCJ3iDQLymqDYOhzYYfCQi0ddaYn.gif" alt="">
      </div>
   </div>
</div>
   
@endsection
@section('page-scripts')
@stop

@section('inline-scripts')
    $(document).ready(function() {
        $("#load-products").loadProperties({
           'form':$('form#collections input'),
           'form_data':$("form#collections"),
           'form_sort_by':$("select#sort_by "),
           'target':'load-products',
           'loggedInStatus':8,
           'box':$('.filter-property'),

           'load_more':$(document).find('a.load_more'),
           'filter_url':'{{ request()->fullUrl() }}',
           'overlay': '.product-overlay'
        });
   
        //reset form
        $("#reset-search-form").on("click", function () {
           //  Reset all selections fields to default option.          
           $('input[type=checkbox]').each(function () {
               this.checked = false;
           }); 
        });   
   });
   
@stop