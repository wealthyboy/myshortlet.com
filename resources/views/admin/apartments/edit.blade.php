@extends('admin.layouts.app')
@section('pagespecificstyles')
@stop
@section('content')
<div class="row">
   <div class="col-sm-12">
      <div class="text-right mb-3">
         <a href="{{ route('admin.apartments.sync', ['id' => $apartment->id]) }}" rel="tooltip" title="Sync Apartment" class="btn btn-primary btn-simple btn-xs" onclick="return confirm('Sync this apartment with Channex?')">
            <i class="material-icons">refresh</i>
            Sync Apartment
         </a>
      </div>
      @include('admin.errors.errors')
      <!--      Wizard container        -->
      <div class="wizard-container">
         <div class="card wizard-card" data-color="rose" id="wizardProfile">
            <form enctype="multipart/form-data" id="product-form" action="{{ route('admin.apartments.update',['apartment'=>$apartment->id,  'mode' => request()->mode ])  }}" method="post">
               @method('PATCH')
               @csrf

               @include('admin.apartments.edit_shortlet')

            </form>
         </div>
      </div>
      <!-- wizard container -->
   </div>
</div>
@endsection
@section('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('backend/js/products.js') }}"></script>
<script src="{{ asset('backend/js/uploader.js') }}?v={{ filemtime(public_path('backend/js/uploader.js')) }}"></script>

@stop


@section('inline-scripts')
$(document).ready(function() {



});

@stop
