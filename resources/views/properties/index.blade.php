@extends('layouts.user')
@section('content')



<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
   <div class="d-flex flex-wrap flex-md-nowrap mb-6">
      <div class="mr-0 mr-md-auto">
         <h2 class="mb-0 text-heading fs-22 lh-15">My Properties<span class="badge badge-white badge-pill text-primary fs-18 font-weight-bold ml-2">29</span></h2>
         <p></p>
      </div>
      <div class="form-inline justify-content-md-end mx-n2">
         <div class="p-2">
            <div class="input-group input-group-lg bg-white border">
               <div class="input-group-prepend">
                  <button class="btn pr-0 shadow-none" type="button"><i class="far fa-search"></i></button>
               </div>
               <input type="text" class="form-control bg-transparent border-0 shadow-none text-body" placeholder="Search listing" name="search">
            </div>
         </div>
         <div class="p-2">
            <div class="input-group input-group-lg bg-white border">
               <div class="input-group-prepend">
                  <span class="input-group-text bg-transparent letter-spacing-093 border-0 pr-0"><i class="far fa-align-left mr-2"></i>Sort by:</span>
               </div>
               <select class="form-control bg-transparent pl-0 selectpicker d-flex align-items-center sortby" name="sort-by" data-style="bg-transparent px-1 py-0 lh-1 font-weight-600 text-body" id="status">
                  <option>Alphabet</option>
                  <option>Price - Low to High</option>
                  <option>Price - High to Low</option>
                  <option>Date - Old to New</option>
                  <option>Date - New to Old</option>
               </select>
            </div>
         </div>
      </div>
   </div>
   <div class="table-responsive">
      <table class="table table-hover bg-white border rounded-lg">
         <thead class="thead-sm thead-black">
            <tr>
               <th scope="col" class="border-top-0 px-6 pt-5 pb-4">Listing title</th>
               <th scope="col" class="border-top-0 pt-5 pb-4">Date Published</th>
               <th scope="col" class="border-top-0 pt-5 pb-4">Status</th>
               <th scope="col" class="border-top-0 pt-5 pb-4">View</th>
               <th scope="col" class="border-top-0 pt-5 pb-4">Action</th>
            </tr>
         </thead>
         <tbody>
            <tr class="shadow-hover-xs-2 bg-hover-white">
               <td class="align-middle pt-6 pb-4 px-6">
                  <div class="media">
                     <div class="w-120px mr-4 position-relative">
                        <a href="single-property-1.html">
                        <img src="images/my-properties-01.jpg" alt="Home in Metric Way">
                        </a>
                        <span class="badge badge-indigo position-absolute pos-fixed-top">for rent</span>
                     </div>
                     <div class="media-body">
                        <a href="single-property-1.html" class="text-dark hover-primary">
                           <h5 class="fs-16 mb-0 lh-18">Home in Metric Way</h5>
                        </a>
                        <p class="mb-1 font-weight-500">1421 San Pedro St, Los Angeles</p>
                        <span class="text-heading lh-15 font-weight-bold fs-17">$2500</span>
                        <span class="text-gray-light">/month</span>
                     </div>
                  </div>
               </td>
               <td class="align-middle">30 December, 2019</td>
               <td class="align-middle">
                  <span class="badge text-capitalize font-weight-normal fs-12 badge-yellow">pending</span>
               </td>
               <td class="align-middle">2049</td>
               <td class="align-middle">
                  <a href="#" data-toggle="tooltip" title="Edit" class="d-inline-block fs-18 text-muted hover-primary mr-5"><i class="fal fa-pencil-alt"></i></a>
                  <a href="#" data-toggle="tooltip" title="Delete" class="d-inline-block fs-18 text-muted hover-primary"><i class="fal fa-trash-alt"></i></a>
               </td>
            </tr>
            
            
         </tbody>
      </table>
   </div>
   <nav class="mt-6">
      <ul class="pagination rounded-active justify-content-center">
         <li class="page-item"><a class="page-link" href="#"><i class="far fa-angle-double-left"></i></a></li>
         <li class="page-item"><a class="page-link" href="#">1</a></li>
         <li class="page-item"><a class="page-link" href="#"><i class="far fa-angle-double-right"></i></a></li>
      </ul>
   </nav>
</div>



@endsection
@section('page-scripts')
@stop

