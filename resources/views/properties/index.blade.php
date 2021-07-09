@extends('layouts.user')
@section('content')



<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
   <div class="d-flex flex-wrap flex-md-nowrap mb-6">
      <div class="mr-0 mr-md-auto">
         <h2 class="mb-0 text-heading fs-22 lh-15">My Properties<span class="badge badge-white badge-pill text-primary fs-18 font-weight-bold ml-2">29</span></h2>
      </div>
      <div class="form-inline justify-content-md-end mx-n2">
         <a href="/properties/create" class="btn btn-primary btn-lg">
            <span>Add New Property</span>
            <span class="d-inline-block ml-1 fs-20 lh-1">
               <svg class="icon icon-add-new">
                  <use xlink:href="#icon-add-new"></use>
               </svg>
            </span>
         </a>
         
      </div>
   </div>
   @include('includes.success')
   @if ( $apartments->count())
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
            @foreach( $apartments as $apartment)
               <tr class="shadow-hover-xs-2 bg-hover-white">
                  <td class="align-middle pt-6 pb-4 px-6">
                     <div class="media">
                        <div class="w-120px mr-4 position-relative">
                           <a href="">
                           <img src="{{ $apartment->image_m }}" alt="Home in Metric Way">
                           </a>
                           <span class="badge badge-indigo position-absolute pos-fixed-top"></span>
                        </div>
                        <div class="media-body">
                           <a href="single-property-1.html" class="text-dark hover-primary">
                              <h5 class="fs-16 mb-0 lh-18">{{ $apartment->name }}</h5>
                           </a>
                           <p class="mb-1 font-weight-500">{{ $apartment->address }}</p>
                           @if( $apartment->rooms->count() >  1 )
                              <span class="text-heading lh-15 font-weight-bold fs-17">{{ $apartment->rooms->first()->price - $apartment->rooms->latest()->first() }}</span>
                           @else
                              <span class="text-heading lh-15 font-weight-bold fs-17">{{ optional(optional($apartment->rooms)->first())->price }}</span>
                           @endif
                           <span class="text-gray-light">/month</span>
                        </div>
                     </div>
                  </td>
                  <td class="align-middle">{{ $apartment->created_at->format('d/m/y')}}</td>
                  <td class="align-middle">
                     <span class="badge text-capitalize font-weight-normal fs-12 badge-yellow">{{ $apartment->status }}</span>
                  </td>
                  <td class="align-middle">0</td>
                  <td class="align-middle">
                     <a href="{{ route('properties.edit',['property'=>$apartment->id]) }}" data-toggle="tooltip" title="Edit" class="d-inline-block fs-18 text-muted hover-primary mr-5"><i class="fal fa-pencil-alt"></i></a>
                     <a href="#" data-toggle="tooltip" title="Delete" class="d-inline-block fs-18 text-muted hover-primary"  
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i class="fal fa-trash-alt"></i></a>
                     <form id="logout-form" action="{{ route('properties.destroy',['property'=>$apartment->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')

                     </form>
                  </td>
               </tr>
            
            @endforeach
         </tbody>
      </table>
   </div>
   @else
   <div class="no-apartments"></div>
   @endif
   <nav class="mt-6">
      {{ $apartments->links() }}
      
   </nav>
</div>



@endsection
@section('page-scripts')
@stop

