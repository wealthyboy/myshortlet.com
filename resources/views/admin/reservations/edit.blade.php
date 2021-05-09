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
            <form enctype="multipart/form-data" id="product-form" action="{{ route('admin.reservations.update',['reservation'=>$reservation->id])  }}" method="post">
               @method('PATCH')
               @csrf
               @csrf
               <!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
               <div class="wizard-header">
                  <h3 class="wizard-title">
                     Upload Product
                  </h3>
               </div>
               <div class="wizard-navigation">
                  <ul>
                     <li><a href="wizard.html#ProductData" data-toggle="tab">Reservation Data</a></li>
                     <li><a href="wizard.html#ProductVariations" data-toggle="tab">Rooms</a></li>
                  </ul>
               </div>
               <div class="tab-content">
                  <div class="tab-pane" id="ProductData">
                     @include('admin.reservations.product_data')
                  

                  <div class="tab-pane" id="ProductVariations">
                     <h4 class="info-text">Apartment Type</h4>
                     <div class="clearfix"></div>
                     <div class="row new-room">
                        <label class="col-md-12  col-xs-12 col-xs-12">
                           <div class="pull-right">
                              <button type="button"  id="add-room" class="btn btn-round  btn-primary">
                                 Add Room
                                 <span class="btn-label btn-label-right">
                                    <i class="fa fa-plus"></i>
                                 </span>
                              </button>
                           </div>
                        </label>
                     </div>
                     @include('admin.reservations.edit_variation')
                  </div>
               <div class="wizard-footer">
                  <div class="pull-right">
                     <input type='button' class='btn btn-next btn-fill btn-rose btn-round btn-wd' name='next' value='Next' />
                     <input type='submit' class='btn btn-finish btn-fill btn-rose   btn-round  btn-wd' name='finish' value='Finish' />
                  </div>
                  <div class="pull-left">
                     <input type='button' class='btn btn-previous btn-fill btn-primary  btn-round  btn-wd' name='previous' value='Previous' />
                  </div>
                  <div class="clearfix"></div>
               </div>
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

