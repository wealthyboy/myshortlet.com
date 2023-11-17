@extends('layouts.listing')
@section('content')
<div class="">
   <div class="container">
      <div class="row">

         <div class="col-md-12 category-search ml-auto mr-auto mt-4">
            <div id="category-loader" class="mt-2 mb-3">
               <div class="apart-loading" style="width: 100%; height: 60px; background-color: rgb(204, 204, 204);"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="sidebar-toggle d-block d-sm-none "> <i class="material-icons filter adjust">sort</i> filter</div>
   <div class="sidebar-overlay d-none"></div>
   <div class="row no-gutters ">


      @if (!$properties)
      <div id="load-products" class="col-md-10 pl-1">
         <div class="no-properties-found">
            <div class="text-center">
               <i class="fas fa-home fa-5x"></i>
               <p>We could not match any apartments to your search</p>
            </div>
         </div>
      </div>
      @else
      <div class="col-md-2 pr-2 mobile-sidebar">
         <div class=" bg-white  sidebar-section">
         </div>
      </div>
      <div id="load-products" class="col-md-8 pl-1">
         <div id="ap-loaders" class="bg-white mb-2 rounded ap-loaders">
            @for($i = 0; $i < 5; $i++) <div class="bg-white mb-2 rounded ap-loaders">
               <div class=" position-relative">
                  <div class="row no-gutters">
                     <div class="col-md-3 position-relative">
                        <div class="apart-loading" style="width: 100%; height: 232px; background-color: rgb(204, 204, 204);">
                           <a href=""></a>
                           <div class="fav-icon position-absolute">
                              <a href="#" data-id="189" data-toggle="loggedIn" data-target="#auth" title="Wishlist" class="saved"></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-9 position-relative col-12 pl-3">
                        <div class="d-flex  mt-2 justify-content-between">
                           <div class="apart-loading" style="width: 50%; height: 12px; background-color: rgb(204, 204, 204);"></div>
                           <div class="apart-loading" style="width: 40%; height: 12px; background-color: rgb(204, 204, 204);"></div>
                        </div>
                        <div>
                           <small><a class="p-0 d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></a>,
                              <a href="" class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></a></small>
                        </div>
                        <div class="mb-5">
                           <div>
                              <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                              <span class="d-inline-block  apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                              <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                           </div>
                           <div>
                              <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                              <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                              <span class="d-inline-block apart-loading" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                           </div>
                        </div>
                        <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">
                           <div class="apart-loading mb-2" style="width: 10%; height: 12px; background-color: rgb(204, 204, 204);"></div>
                           <div class="d-none d-lg-block d-xl-block text-right mr-2">
                              <span class="apart-loading d-inline-block" style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"></span>
                              <div class=" apart-loading btn btn-primary btn-round d-none d-lg-block d-xl-block" style="width: 100%; height: 12px; background-color: rgb(204, 204, 204);"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         @endfor
      </div>
      <products-index :next_page="{{ collect($next_page) }}" :propertys="{{ $properties->load('facilities','free_services') }}" />
   </div>
   @endif

   <div class="col-md-2 pl-2">
      <a href="https://theluxurysale.com" class="h">
         <img class="img-fluid" src="/images/banners/ads-07.jpg" alt="">
      </a>
   </div>
</div>
</div>

<div style="height: 200px;"></div>

@endsection
@section('page-scripts')
@stop