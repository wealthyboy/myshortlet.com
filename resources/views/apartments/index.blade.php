

@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
<div class="container-fluid">


   <div class="row">
      <div class="col-lg-9 main-content">
         <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
               <div class="col-md-4">
                  <img src="..." alt="...">
               </div>
               <div class="col-md-8">
                  <div class="card-body">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                     <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="sidebar-overlay"></div>
      <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
      <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
         <div class="pin-wrapper" style="">
            <div class="sidebar-wrapper" style="">
            </div>
         </div>
      </aside>
      <!-- End .col-lg-3 -->
   </div>
</div>
@endsection
@section('page-scripts')
@stop

