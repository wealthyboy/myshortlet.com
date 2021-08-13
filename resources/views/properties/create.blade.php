@extends('layouts.auth')
@section('content')
<!--Content-->

<section class="sec-padding bg--gray mt-5">
   <div class="container">
      <div class="row justify-content-center">
         <div class="ml-1 col-md-10  bg--light mr-1">
            <div class="form-section mt-4 mb-4">
               <div class="target"></div>
               @if (!$step && !session('status'))
               <section class="bg-single-image-03 pt-9 step-one" data-animated-id="5">
                  <div class="container">
                     <h2 class="text-dark text-center mxw-751 px-md-8 lh-163">
                        We have the most listings and constant updates. So you’ll never miss
                        out.
                     </h2>
                     <span class="heading-divider mx-auto"></span>
                     <div class="row mt-7 mb-6 mb-lg-11">
                        <div class="col-lg-6 mb-6 mb-lg-0">
                           <div
                              class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100 fadeInUp animated"
                              data-animate="fadeInUp"
                              >
                              <img
                                 src="/img/group-16.png"
                                 alt="Buy a new home"
                                 class="mb-6 mb-sm-0 mr-sm-6"
                                 />
                              <div class="media-body">
                                 <a
                                    href="{{ route('properties.create',['type' => 'single', 'step' => 'one', 'token' => request()->token ]) }}"
                                       class="text-decoration-none d-flex align-items-center"
                                    >
                                    <h4 class="fs-20 lh-1625 text-secondary mb-1">
                                       Single Apartment
                                    </h4>
                                    <div class="position-relative d-flex align-items-center ml-2">
                                       <span
                                          class="image text-primary position-absolute pos-fixed-left-center fs-16"
                                          ><i class="fal fa-long-arrow-right"></i
                                          ></span>
                                       <span
                                          class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"
                                          >
                                          <svg class="icon icon-long-arrow">
                                             <use xlink:href="#icon-long-arrow"></use>
                                          </svg>
                                       </span>
                                    </div>
                                 </a>
                                 <p class="mb-0">
                                    Click here if you
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0">
                           <div
                              class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100 fadeInUp animated"
                              data-animate="fadeInUp"
                              >
                              <img
                                 src="/img/group-17.png"
                                 alt="Sell a home"
                                 class="mb-6 mb-sm-0 mr-sm-6"
                                 />
                              <div class="media-body">
                                 <a
                                    href="{{ route('properties.create',['type' => 'multiple', 'step' => 'one', 'token' => request()->token ]) }}"
                                    class="text-decoration-none d-flex align-items-center"
                                    >
                                    <h4 class="fs-20 lh-1625 text-secondary mb-1">
                                       Multiple Apartments
                                    </h4>
                                    <div class="position-relative d-flex align-items-center ml-2">
                                       <span
                                          class="image text-primary position-absolute pos-fixed-left-center fs-16"
                                          ><i class="fal fa-long-arrow-right"></i
                                          ></span>
                                       <span
                                          class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"
                                          >
                                          <svg class="icon icon-long-arrow">
                                             <use xlink:href="#icon-long-arrow"></use>
                                          </svg>
                                       </span>
                                    </div>
                                 </a>
                                 <p class="mb-0"></p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 text-right mt-5">
                           <a href="/apartment/create?=" class="btn btn-lg text-secondary btn-accent"
                              >Next
                           <i class="far fa-long-arrow-right ml-1"></i>
                           </a>
                        </div>
                     </div>
                  </div>
               </section>
               @else
               @if (session('status'))
                  <div class="text-dark text-center text-info mxw-751 px-md-8 lh-163">
                     We have received your upload allow us 2-3 working days to review your apartment.
                  </div>
               @endif

               @if (session('error'))
                  <div class="text-dark text-center text-info mxw-751 px-md-8 lh-163">
                      We could not complete your upload ..
                  </div>
               @endif


               @endif

               @if ($step)
                  @include('properties.step_'.$step)
               @endif
            </div>
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


