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
            <form enctype="multipart/form-data" id="product-form" action="{{ route('admin.apartments.update',['apartment'=>$apartment->id])  }}" method="post">
               @method('PATCH')
               @csrf
               @csrf
               <!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
               <div class="wizard-header">
                  <h3 class="wizard-title">
                     Edit Apartment
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

                  <h4 class="info-text ">Enter Apartment Details</h4>        
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Apartment Name</label>
                    <input  required="true" name="apartment_name" data-msg="" value="{{ isset($apartment) ? $apartment->name :  old('apartment_name') }}" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group label-floating is-ty">
                        <label class="control-label">Virtual Tour</label>
                        <input name="virtual_tour"  required="true" value="{{ isset($apartment) ? $apartment->virtual_tour :  old('virtual_tour') }}" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Address</label>
                    <input  required="true" name="address" data-msg="" value="{{ isset($apartment) ? $apartment->address :  old('address') }}" class="form-control" type="text">
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Description</label>
                    <div class="form-group ">
                        <label class="control-label"> Enter description here</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            class="form-control" 
                            rows="50">
                            {{ isset($apartment) ? $apartment->description : old('description') }}
                        </textarea>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <legend>  
                    Enable/Disable
                    </legend>
                    <div class="togglebutton">
                    <label>
                    <input {{ isset($apartment) && $apartment->allow == 1 ? 'checked' : ''}}  name="allow"  value="1" type="checkbox" checked>
                    Enable/Disable
                    </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <legend>  
                    Featured Product
                    </legend>
                    <div class="togglebutton">
                    <label>
                        <input {{ isset($apartment) && $apartment->featured == 1 ? 'checked' : '' }} name="featured"  value="1" type="checkbox" >
                        Yes/No
                    </label>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-4">
            <div class="">
                <div class="row mb-3">
                    <div  class="col-md-12">
                        @if (!isset($apartment))
                        <div id="j-drop" class=" j-drop">
                        <input accept="image/*"  required="true" onchange="getFile(this,'image','Product',false)" class="upload_input"   data-msg="Upload  your image" type="file"  name="img"  />
                        <div   class="upload-text"> 
                            <a   class="" href="#">
                                <img class="" src="/backend/img/upload_icon.png">
                                <b>Click to upload image</b> 
                            </a>
                        </div>
                        <div id="j-details"  class="j-details"></div>

                        @else

                        <div id="j-drop" class=" j-drop">
                            <input accept="image/*"   onchange="getFile(this,'image','Product',false)" class="upload_input"   data-msg="Upload  your image" type="file"  name="img"  />
                            <div   class="{{ optional($apartment)->images ? 'hide' : '' }} upload-text"> 
                                <a   class="" href="#">
                                <img class="" src="/backend/img/upload_icon.png">
                                <b>Click to upload image</b> 
                                </a>
                            </div>
                            <div id="j-details"  class="j-details">
                                <div id="{{ $apartment->id }}" class="j-complete">
                                    <div class="j-preview">
                                        <img class="img-thumnail" src="{{ $apartment->image }}">
                                        <div id="remove_image" class="remove_image remove-image">
                                            <a class="remove-image" data-mode="edit" data-randid="{{ $apartment->id }}"  data-id="{{ $apartment->id }}" data-url="{{ $apartment->image }}" href="#">Remove</a> 
                                        </div>
                                        <input type="hidden" class="file_upload_input stored_image_url" value="{{ $apartment->image }}" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif


                    </div>
                </div>
            </div>
            <label>Country/State/City </label>
            <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
               @foreach($locations as $location)
                  <div class="parent" value="{{ $location->id }}">
                        <div class="checkbox">
                           <label>
                              <input type="checkbox" 
                              {{ $helper->check($apartment->locations , $location->id) ? 'checked' : '' }} 
                              value="{{ $location->id }}" name="location_id[]" >
                              {{ $location->name }}  
                           </label>
                        </div>   
                        @include('includes.product_categories_children',['obj'=>$location,'space'=>'&nbsp;&nbsp;','model' => 'location','url' => 'location'])
                  </div>
               @endforeach
            </div>
            
            
        </div>
    </div>
</div>
    

                  

                  <div class="tab-pane" id="ProductVariations">
                     <h4 class="info-text">Apartment Type</h4>
                     <div class="clearfix"></div>
                     <div class="row new-room">
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
                     @include('admin.apartments.edit_variation')
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

