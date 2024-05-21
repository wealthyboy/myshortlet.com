<!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
<div class="wizard-header">
   <h3 class="wizard-title">
      Edit Apartment
   </h3>
</div>
<div class="wizard-navigation">
   <ul>
      <li><a href="wizard.html#ProductData" data-toggle="tab">Reservation Data</a></li>
      <li><a href="wizard.html#Cancelation" data-toggle="tab">Cancelation </a></li>
      <li><a href="wizard.html#ProductVariations" data-toggle="tab">Rooms</a></li>
   </ul>
</div>
<div class="tab-content">
   <div class="tab-pane" id="ProductData">
      <h4 class="info-text ">Enter Property Details</h4>
      <div class="row">
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-8">
                  <div class="form-group {{ isset($property) ? ''  : 'label-floating is-empty' }}">
                     <label class="control-label">Apartment Name</label>
                     <input required="true" name="apartment_name" data-msg="" value="{{ isset($property) ? $property->name :  old('apartment_name') }}" class="form-control" type="text">
                  </div>
               </div>


               <div class="col-md-4">

               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group {{ isset($property) ? ''  : 'label-floating is-empty' }}">
                     <label class="control-label">Address</label>
                     <input required="true" name="address" data-msg="" value="{{ isset($property) ? $property->address :  old('address') }}" class="form-control" type="text">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group">
                     <label>Description</label>
                     <div class="form-group ">
                        <label class="control-label"> Enter description here</label>
                        <textarea name="description" id="description" class="form-control" rows="50">
                        {{ isset($property) ? $property->description : old('description') }}
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
                        <input {{ isset($property) && $property->allow == 1 ? 'checked' : ''}} name="allow" value="1" type="checkbox" checked>
                        Enable/Disable
                     </label>
                  </div>
               </div>
               <div class="col-md-6">
                  <legend>
                     Featured Apartment
                  </legend>
                  <div class="togglebutton">
                     <label>
                        <input {{ isset($property) && $property->featured == 1 ? 'checked' : '' }} name="featured" value="1" type="checkbox">
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
                  <div class="col-md-12">
                     <div id="j-drop" class=" j-drop">
                        <input accept="image/*" onchange="getFile(this,'image','Product',false)" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
                        <div class="{{ optional($property)->images ? 'hide' : '' }} upload-text">
                           <a class="" href="#">
                              <img class="" src="/backend/img/upload_icon.png">
                              <b>Click to upload image</b>
                           </a>
                        </div>
                        <div id="j-details" class="j-details">
                           <div id="{{ $property->id }}" class="j-complete">
                              <div class="j-preview">
                                 <img class="img-thumnail" src="{{ $property->image }}">
                                 <div id="remove_image" class="remove_image remove-image">
                                    <a class="remove-image" data-mode="edit" data-randid="{{ $property->id }}" data-id="{{ $property->id }}" data-url="{{ $property->image }}" href="#">Remove</a>
                                 </div>
                                 <input type="hidden" class="file_upload_input stored_image_url" value="{{ $property->image }}" name="image">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <label>Country/State/City </label>
            <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
               @include('admin.properties.location')
            </div>
         </div>
      </div>
   </div>
   <div class="tab-pane" id="Cancelation">
      <div class="row">
         <div class="col-md-6">
            <div class="card-content">
               <div class="form-group">
                  <label class="label-control">Check in iime</label>
                  <input type="text" required="true" name="check_in_time" class="form-control timepicker" value="{{ $property->check_in_time }}" />
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card-content">
               <div class="form-group">
                  <label class="label-control">Check out Time</label>
                  <input name="check_out_time" required="true" type="text" class="form-control timepicker" value="{{ $property->check_out_time }}" />
               </div>
            </div>
         </div>
         <div class="col-md-12 mt-3 pr-5 ">
            <h5>Cancellation </h5>
            <div class="togglebutton cancel form-inline">
               <label>
                  <input name="is_refundable" id="allow_cancellation" value="1" type="checkbox" {{ isset($property) &&  $property->is_refundable ? 'checked' : ''}}>
                  Refundable
               </label>
            </div>
         </div>
         <div class="col-sm-7  cancellation-message   {{ isset($property) &&  $property->allow_cancellation ? '' : 'd-none'}} ">
            <div class="form-group">
               <label for="cancellation_message">Cancellation Policy</label>
               <textarea class="form-control" name="cancellation_message" id="cancellation_message" rows="5">{{ isset($property) ?   $property->cancellation_message : '' }}</textarea>
            </div>
         </div>
         <div class="col-md-12 mt-1 pr-5 ">
            @include('admin.apartments.attributes',['attris'=> $attributes, 'ob' => $property])
         </div>
         <div class="col-md-12 mt-1 pr-5 ">
            @include('admin.apartments.attributes',['attris'=> $others,'ob' => $property])
         </div>
         <div class="col-md-12 mt-1 pr-5 ">
            <h4 class="text-capitalize">Property Extras</h4>
            @include('admin.apartments.extras',[
            'obj' => $property,
            'name' => 'property_extra_services',
            'attribute_name' => 'property_extras'
            ])
         </div>
      </div>
   </div>
   <div class="tab-pane" id="ProductVariations">
      <h4 class="info-text">Apartment </h4>
      <div class="clearfix"></div>
      <div class="col-md-12">
         <div class="form-group">
            <label class="control-label">Apartment Type</label>
            <select name="type" id="apartment-type" class="form-control" required="true" title="Please select product type" title="" data-size="7">
               <option value="multiple">Multiple</option>
            </select>
         </div>
      </div>
      <div class="simple-apartment hide">
         <div id="" data-id="{{ $counter }}" class="">
            <div class="clearfix"></div>
            <div class="col-md-12">
               <div class="col-md-3">
                  <div class="form-group label-floating is-ty">
                     <label class="control-label">Bedrooms</label>
                     <select name="single_room_number" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                        @for ($i = 1; $i< 6; $i++) @if(optional($property->single_room)->no_of_rooms == $i)
                           <option value="{{ $i }}" selected>{{ $i }}</option>
                           @else
                           <option value="{{ $i }}">{{ $i }}</option>
                           @endif
                           @endfor
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group label-floating is-ty">
                     <label class="control-label">Toilets</label>
                     <select name="single_room_toilets" id="children" class="form-control">
                        @for ($i = 1; $i< 4; $i++) @if(optional($property->single_room)->toilets == $i)
                           <option value="{{ $i }}" selected> {{ $i }}</option>
                           @else
                           <option value="{{ $i }}"> {{ $i }}</option>
                           @endif
                           @endfor
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group label-floating ">
                     <label class="control-label">Max Adults</label>
                     <input name="single_room_max_adults" required="true" value="{{ optional($property->single_room)->max_adults }}" class="form-control   variation" type="number">
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group label-floating ">
                     <label class="control-label">Max Children</label>
                     <input name="single_room_max_children" required="true" value="{{ optional($property->single_room)->max_children }}" class="form-control   variation" type="number">
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="col-md-4">
                  <div class="form-group label-floating ">
                     <label class="control-label">Price per/night</label>
                     <input name="single_room_price" required="true" value="{{ optional($property->single_room)->price }}" class="form-control   variation" type="number">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group label-floating ">
                     <label class="control-label">Sale Price</label>
                     <input name="single_room_sale_price" value="{{ optional($property->single_room)->sale_price }}" class="form-control variation_sale_price variation" type="number">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group label-floating">
                     <label class="control-label">End Date {{ optional($property->single_room)->no_of_rooms }}</label>
                     <input class="form-control  datepicker pull-right" value="{{ $helper::getReversedFormatedDate(optional($property->single_room)->sale_price_expires) }}" name="single_room_sale_price_expires" id="datepicker" type="text">
                  </div>
               </div>
               <div class="col-md-12 bed mb-5">
                  @if ($bedrooms->count() && null !== $property->single_room)
                  @foreach($bedrooms as $key => $parent)
                  @if ($property->single_room->no_of_rooms > $key )
                  <div class="bedroom-{{ $key + 1 }} mt-3">
                     <h6> {{ $parent->name }} </h6>
                     @foreach($parent->children as $bedroom)
                     <label for="bedroom-{{ $bedroom->id }}-{{ $property->single_room->id }}" class="radio-inline">
                        <input class="radio-button" {{  $property->single_room->bedrooms->contains($bedroom) ? 'checked' : ''}} value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $property->single_room->id }}" name="{{ $parent->slug }}" type="radio">{{ $bedroom->name }}
                        <div class="bed-count">
                           <input name="bed_count[{{ 212 }}][{{ $bedroom->id }}]" placeholder="Number of beds 3333" class="form-control bed-qty" value="444{{ $property->single_room->bedrooms->contains($bedroom) ? $helper->check(optional($property->single_room)->bedrooms, $bedroom->id,'bed_count') : ''  }}" type="number">
                        </div>
                     </label>
                     @endforeach
                  </div>
                  @else
                  <div class="bedroom-{{ $key + 1 }} d-none  {{ $key }} mt-3">
                     <div>{{ $parent->name }} </div>
                     @foreach($parent->children as $bedroom)
                     <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
                        <input value="{{ $bedroom->id }}" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $property->id }}" type="radio">{{ $bedroom->name }}
                        <div class="bed-count">
                           <input name="bed_count[{{ $property->id }}]" placeholder="Number of beds2222" class="form-control bed-qty" value="222" type="number">
                        </div>
                        <div class="bed-count">
                           <input name="bed_count[{{ 212 }}][{{ $bedroom->id }}]" placeholder="Number of beds1111" class="form-control bed-qty" value="{{ $helper->check(optional($property->single_room)->bedrooms, $bedroom->id,'bed_count')   }}" type="number">
                        </div>
                     </label>
                     @endforeach
                  </div>
                  @endif
                  @endforeach
                  @endif
               </div>
               <div class="clearfix"></div>
               <div class="col-sm-12">
                  <div id="j-drop" class="j-drop">
                     <input accept="image/*" onchange="getFile(this,'room_images[]','Image')" class="upload_input" multiple="true" type="file" id="upload_file_input" name="product_image" />
                     <div class=" upload-text {{ optional(optional($property->single_room)->images)->count() ?   'hide' :  ''}}">
                        <a class="" href="#">
                           <img class="" src="/backend/img/upload_icon.png">
                           <b>Click on anywhere to upload image</b>
                        </a>
                     </div>
                     <div id="j-details" class="j-details">
                        @if( optional(optional($property->single_room)->images)->count() )
                        @foreach($property->single_room->images as $image)
                        <div id="{{ $image->id }}" class="j-complete">
                           <div class="j-preview">
                              <img class="img-thumnail" src="{{ $image->image }}">
                              <div id="remove_image" class="remove_image remove-image">
                                 <a class="remove-image" data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete" data-url="{{ $image->image }}" href="#">Remove</a>
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @endif
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mt-5 pr-5 kkk">
                  @include('admin.apartments.apartment_fac',['apartment' => $property->single_room,'model' => $property->single_room])
               </div>
               <div class="col-md-12 mt-1 pr-5 ">
                  <!-- include('admin.apartments.extras',[
                  'obj' => $property->single_room, 
                  'name' => 'single_apartment_extra_services',
                  'attribute_name' => 'single_apartment_extras',
                  ]) -->
                  <h4 class="text-capitalize">Apartment Extras</h4>
                  @foreach($extras as $child)
                  <div class="mt-2 mb-2">
                     <div class="togglebutton d-flex">
                        <label>
                           <input {{ $helper->check(optional($property->single_room)->attributes , $child->id) ? 'checked' : '' }} name="single_apartment_extras[{{ 212 }}][]" value="{{ $child->id }}" type="checkbox">
                           {{ $child->name }}
                        </label>
                     </div>
                     <div class="extras-se  form-group">
                        <input name="single_apartment_extra_services[{{ 212 }}][{{ $child->id }}]" value="{{ $helper->check(optional($property->single_room)->extra_services, $child->id,'price') }}" placeholder="Leave blank if you want it free" class="form-control" type="number">
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
      <div class="row p-attr  new-room variable-product {{ $property->type == 'single' ? 'hide' : '' }}">
         <label class="col-md-12  col-xs-12 col-xs-12">
            <div class="pull-right">
               <button type="button" id="add-room" class="btn btn-round  btn-primary">
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