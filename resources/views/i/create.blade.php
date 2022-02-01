@extends('layouts.auth')
@section('content')
<!--Content-->

<section class="sec-padding bg--gray mt-5">
   <div class="container">
      <div class="row justify-content-center">
         <div class="ml-1 col-md-10  bg--light mr-1">
            <property-create />
         </div>
      </div>
   </div>
</section>





<!--End Content-->
@endsection
@section('page-scripts')
   <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
   <script src="{{ asset('backend/js/uploader.js') }}"></script>
   <script src="{{ asset('backend/js/products.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function() {
   var d = $("#description")
    if (d.length){

   CKEDITOR.replace('description',{
      height: '300px',
            toolbar: [
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            '/',
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            '/',
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            { name: 'about', items: [ 'About' ] }
      ]
   }) 
}
    
   $('#location-state').on('change', function(e) {
      let self = $(this)
      if( self.val() == 0) return;
      let target = $("#location-city")
      getLocation(self.val(),target)
   })

   $('#location-city').on('change', function(e) {
      let self = $(this)
      let target = $("#location-town")
      if( self.val() == 0) return;
      getLocation(self.val(),target)
   })
   

 

   
   
});



function getLocation(val,target) {
   $.ajax({
      url: "/get/location/" +  val,
   }).done(function(res) {
      target.html('').html('<option value="0">Choose...</option>').append(res)
   });
}

@stop


