@extends('admin.layouts.app')
@section('pagespecificstyles')
@stop
@section('content')
<div class="row">
   <div class="col-sm-12">
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('backend/js/products.js') }}"></script>
<script src="{{ asset('backend/js/uploader.js') }}"></script>
@stop


@section('inline-scripts')
$(document).ready(function() {
CKEDITOR.replace('description',{
height: '400px'
})


});
@stop