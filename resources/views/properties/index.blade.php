@extends('layouts.user')
@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12 ml-auto mr-auto">
        <div class="text-right">
            <a href="{{ route('properties.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>
            <a href="{{ route('properties.create') }}"  title="Add New" class="btn btn-primary btn-simple btn-xs">
                    <i class="material-icons">add</i>
                    Add Property
            </a>
            

         </div>
         <h2 class="title"></h2>
         @include('includes.success')
         @if ( $properties->count())
         @foreach( $properties as $property)
         <div class="card card-plain border">
            <div class="row">
               <div class="col-md-2">
                  <div class="card-header card-header-image">
                     <img class="img img-raised" src="{{ $property->image_m }}">
                  </div>
               </div>
               <div class="col-md-7">
                  <h6 class="card-category text-info">{{ $property->status }}</h6>
                  <h3 class="card-title">
                     <a href="#">{{ $property->name }}</a>
                  </h3>
                  <div class="">
                  </div>
                  <div class="">
                     {{ $property->address }}                     
                  </div>
                  <p>
                     @if( $property->apartments->count() && $property->apartments->count() >  1  )
                     <span class="text-heading lh-15 font-weight-bold fs-17">{{ $property->currency }}{{ $property->apartments->single_room->price }}  - {{ $property->currency }}{{ $property->apartments[$property->apartments->count() - 1]->first()->price }} </span>
                     @else
                     <span class="text-heading lh-15 font-weight-bold fs-17">{{ $property->currency }}{{ optional(optional($property->apartments)->first())->price }}</span>
                     @endif
                     <span class="text-gray-light">/month</span>
                  </p>
               </div>
               <div class="col-md-3  d-flex justify-content-senter align-items-center">
                  <a href="" class="btn btn-primary  btn-link ">
                  <i class="material-icons">edit</i> Edit
                  </a>
                  <a href="" class="btn btn-primary  btn-link ">
                  <i class="material-icons">delete_forever</i> delete
                  </a>
               </div>
            </div>
         </div>
         @endforeach
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
   </div>
</div>
@endsection
@section('page-scripts')
@stop