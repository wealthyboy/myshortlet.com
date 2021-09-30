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
         <form enctype="multipart/form-data" id="product-form" action="{{ route('admin.properties.store') }}" method="post">
            @csrf
            <!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
            <div class="wizard-header">
               <h3 class="wizard-title">
                  Upload Property
               </h3>
            </div>
            <div class="wizard-navigation">
               <ul>
                  <li><a href="wizard.html#ProductData" data-toggle="tab">Property Data</a></li>
                  <li><a href="wizard.html#Cancelation" data-toggle="tab">Cancelation/Rules/Facilities </a></li>
                  <li><a href="wizard.html#ProductVariations" data-toggle="tab">Aprtment</a></li>
               </ul>
            </div>
            <div class="tab-content">
               <div class="tab-pane" id="ProductData">
                  @include('admin.apartments.apartment_data')
               </div>
               <div class="tab-pane" id="Cancelation">
                  <div class="row">
                     <div class="col-md-6">
                       <div class="card-content">
                           <div class="form-group">
                              <label class="label-control">Check in iime</label>
                              <input type="text" required="true" name="check_in_time" class="form-control timepicker" value="14:00"/>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                       <div class="card-content">
                           <div class="form-group">
                              <label class="label-control">Check out Time</label>
                              <input name="check_out_time"  required="true" type="text" class="form-control timepicker" value="14:00"/>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 mt-3 pr-5 ">
                        <h4 class="card-title">Cancellation</h4>

                        <div class="togglebutton cancel form-inline">
                           <label>
                           <input  name="is_refundable" id="allow_cancellation"  value="1" type="checkbox">
                              Refundable 
                           </label>
                           
                        </div>
                     </div>
                     <div class="col-sm-7  cancellation-message  d-none  {{ isset($apartment) &&  $apartment->allow_cancellation ? '' : ''}} ">
                        <div class="form-group">
                           <label for="cancellation_message">Cancellation Policy</label>
                           <textarea class="form-control" name="cancellation_message" id="cancellation_message" rows="5">{{ isset($apartment) ?   $apartment->is_refundable : '' }}</textarea>
                        </div>
                     </div>

                     <div class="col-md-12 mt-1 pr-5 ">
                       @include('admin.apartments.attributes',['attris'=> $attributes, 'ob' => null])
                     </div>

                     <div class="col-md-12 mt-1 pr-5 ">
                       @include('admin.apartments.attributes',['attris'=> $others,'ob' => null])
                     </div>

                     <div class="col-md-12 mt-1 pr-5 ">
                        <h4 class="">Property Extras</h4>
                        @include('admin.apartments.extras',[
                           'obj' => null, 
                           'name' => 'property_extra_services',
                           'attribute_name' => 'property_extras'
                        ])
                     </div>

                     

                  </div>
               </div>
               <div class="tab-pane" id="ProductVariations">
                  <h4 class="info-text">Apartment</h4>
                  <div class="clearfix"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label">Apartment Type</label>
                        <select name="type" id="apartment-type" class="form-control"  required="true" title="Please select product type"  title="" data-size="7">
                           <option  value="" selected>Choose One</option>
                           <option  value="single">Single</option>
                           <option  value="multiple">Multiple</option>
                        </select>
                     </div>
                  </div>
                  <div class="simple-apartment hide">
                     <div id="" data-id="{{ $counter }}"   class="">
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                           <input name="has_more_room"     value="1"   class="" type="hidden">
                           <input name="new_room"     value="1"   class="" type="hidden">  
                        
                           <div class="col-md-3">
                              <div class="form-group">
                                 <select  name="single_room_number" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                                    <option value="" selected>Choose Bedrooms</option>
                                    @for ($i = 1; $i< 7; $i++) 
                                    <option value="{{ $i }}"> {{ $i }}</option>
                                    @endfor 
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <select name="single_room_toilets" id="children" class="form-control">
                                    <option  value="" selected>Choose Toilets</option>
                                    @for ($i = 1; $i< 6; $i++) 
                                    <option value="{{ $i }}"> {{ $i }}</option>
                                    @endfor 
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group label-floating is-empty">
                                 <label class="control-label">Max Adults</label>
                                 <input name="single_room_max_adults"  required="true" value="" class="form-control   variation" type="number">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group label-floating is-empty">
                                 <label class="control-label">Max Children</label>
                                 <input name="single_room_max_children"  required="true" value="" class="form-control   variation" type="number">
                              </div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="col-md-4">
                              <div class="form-group label-floating is-empty">
                                 <label class="control-label">Price per/night</label>
                                 <input name="single_room_price"  required="true" value="{{ old('price') }}" class="form-control   variation" type="number">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group label-floating is-empty">
                                 <label class="control-label">Sale Price</label>
                                 <input name="single_room_sale_price"   value=""  class="form-control variation_sale_price variation" type="number">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group label-floating">
                                 <label class="control-label">End Date</label>
                                 <input class="form-control  datepicker pull-right" name="single_room_sale_price_expires" id="datepicker" type="text">
                              </div>
                           </div>
                           <div class="col-md-12 bed mb-5">
                           @if ($bedrooms->count())
                              @foreach($bedrooms as $key =>  $parent)
                                 <div class="bedroom-{{ $key + 1 }} d-none mb-2">
                                 <div class="mb-2">{{ $parent->name }} </div>
                                    @foreach($parent->children as $bedroom)
                                    <label for="bedroom-{{ $bedroom->id }}-{{ $counter }}" class="radio-inline">
                                       <input  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $counter }}" name="{{ $parent->slug }}" type="radio" name="optradio">{{ $bedroom->name }}
                                       <div class="bed-count">
                                          <input name="bed_count[{{ $bedroom->id }}]"  placeholder="Number of beds" class="form-control" value="" type="number">
                                       </div>
                                    </label>
                                    @endforeach
                                 </div>
                              @endforeach
                           @endif
                           </div>
                           <div class="clearfix"></div>
                           <div class="col-sm-12">
                              <div id="j-drop"  class="j-drop">
                                 <input accept="image/*" required="true"  data-msg="Upload  at least 5 images"   onchange="getFile(this,'room_images[]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                                 <div   class=" upload-text  {{ $counter }}"> 
                                    <a  class="" href="#">
                                    <img class="" src="/backend/img/upload_icon.png">
                                    <b>Click on anywhere to upload image</b> 
                                    </a>
                                 </div>
                                 <div id="j-details"  class="j-details"></div>
                              </div>
                           </div>

                           


                           <div class="col-md-12 mt-5 pr-5 kkk">
                              @include('admin.apartments.apartment_fac',['model' => 'apartment'])
                           </div>

                           <div class="col-md-12 mt-1 pr-5 ">
                              <h4 class="text-capitalize">Apartment Extras</h4>
                              @include('admin.apartments.extras',[
                                 'obj' => '', 
                                 'name' => 'single_apartment_extra_services',
                                 'attribute_name' => 'single_apartment_extras'
                              ])
                           </div>

                           <div class="col-md-6">
                              @include('admin.apartments.occupied')
                           </div>
                           
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="row p-attr  new-room  hide">
                     <label class="col-md-12  col-xs-12 col-xs-12">
                        <div class="pull-right">
                           <button type="button"  id="add-room" class="btn btn-round  btn-primary">
                           Add Apartment
                           <span class="btn-label btn-label-right">
                              <i class="fa fa-plus"></i>
                           </span>
                           </button>
                        </div>
                     </label>
                  </div>
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








