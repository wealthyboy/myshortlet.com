@extends('layouts.listing')
@section('content')
<div class="d-flex  justify-content-center align-items-center" >
   <div class="container">
      <div class="row">
         <div class="col-md-12 ml-auto mr-auto">
            <category-search 
               :reload="0"
            />
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="sidebar-toggle d-block d-sm-none ">  <i class="material-icons filter adjust">sort</i> filter</div>
   <div class="sidebar-overlay d-none"></div>
   <div class="row no-gutters ">
      <div class="col-12">
         <properties-count    />
      </div>

      @if (!$properties)
      <div  id="load-products" class="col-md-10 pl-1">
         <div
            class="no-properties-found"
         >
            <div class="text-center">
               <i class="fas fa-home fa-5x"></i>
               <p>We could not match any apartments to your search</p>
            </div>
         </div>
      </div>
      @else
         <div class="col-md-2 pr-2 mobile-sidebar">
            <div class=" bg-white  sidebar-section">
               <filter-search :attrs="{{ $attributes }}" />
            </div>
         </div>
         <div  id="load-products" class="col-md-8 pl-1">
            <products-index :next_page="{{ collect($next_page) }}" :propertys="{{ $properties->load('facilities','free_services') }}" />
         </div>
      @endif

      <div class="col-md-2 pl-2">
         <a href="" class="h">
            <img class="img-fluid" src="https://avenuemontaigne.ng/uploads/Lfr25dG9jV42zCJ3iDQLymqDYOhzYYfCQi0ddaYn.gif" alt="">
         </a>
      </div>
   </div>
</div>
   
@endsection
@section('page-scripts')
@stop
