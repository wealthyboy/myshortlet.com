<div class="wizard-header">
   <h3 class="wizard-title">
      Upload Apartment
   </h3>
</div>
<div class="wizard-navigation">
   <ul>

      <li><a href="wizard.html#ProductVariations" data-toggle="tab">Aprtment</a></li>
   </ul>
</div>
<div class="tab-content">


   <div class="tab-pane" id="ProductVariations">


      <div class="clearfix"></div>


      <div class="row p-attr mb-2 variation-panel">
         <div class="col-md-9 col-xs-9 col-sm-9">
         </div>
         <div class="col-md-3 col-xs-12 text-right border col-sm-12 pt-2 pb-4">
            <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a>
         </div>

         <div id="variation-panel" data-id="" class=" v-panel">
            <div class="clearfix"></div>
            <div class="col-md-12">
               <input name="has_more_room" value="1" class="" type="hidden">
               <input name="new_room" value="1" class="" type="hidden">
               <div class="col-md-4">
                  <div class="form-group label-floating is-ty">
                     <label class="control-label">Accommodation Type Name</label>
                     <input name="room_name" value="{{ $apartment->name }}" required="true" value="" class="form-control  variation" type="text">
                     <span class="material-input"></span>
                  </div>
               </div>

               <div class="col-md-2">
                  <div class="form-group">
                     <select name="price_mode" id="" required="true" class="form-control">
                        <option value="">Price Mode</option>
                        <option value="per night" {{ $apartment->price_mode == 'per night' ? 'selected' : '' }}>Per night</option>
                        <option value="per week" {{ $apartment->price_mode == 'per week'  ? 'selected' : '' }}> Per week</option>
                        <option value="per month" {{ $apartment->price_mode == 'per month' ? 'selected' : '' }}>Per month</option>
                        <option value="per year" {{ $apartment->price_mode == 'per year'  ? 'selected' : '' }}> Per year</option>
                     </select>
                  </div>
               </div>

               <div class="col-md-2">
                  <div class="form-group">
                     <select name="apartment_id" id="" required="true" class="form-control">
                        <option value="">Apartment</option>
                        @foreach($room_ids as $key => $room_id)

                        @if($room_id->id == $apartment->apartment_id)
                        <option value="{{ $room_id->id }}" selected>{{ $room_id->name }}</option>

                        @else
                        <option value="{{ $room_id->id }}">{{ $room_id->name }}</option>
                        @endif
                        @endforeach

                     </select>
                  </div>
               </div>


               <div class="col-md-2">
                  <div class="form-group">
                     <select name="floor" id="" required="true" class="form-control">
                        <option value="">Floor</option>


                        @foreach($floors as $key => $floor)

                        @if($apartment->floor == $floor)
                        <option value="{{  $floor }}" selected>{{ $floor }}</option>
                        @else
                        <option value="{{ $floor }}">{{ $floor }}</option>
                        @endif
                        @endforeach

                     </select>
                  </div>
               </div>


               <div class="col-md-2">
                  <div class="form-group">
                     <select name="property_id" id="" required="true" class="form-control">
                        <option value="">Properties</option>
                        @foreach($properties as $key => $property)

                        @if($apartment->property_id == $property->id)
                        <option value="{{  $property->id }}" selected>{{ $property->name }}</option>
                        @else
                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                        @endif
                        @endforeach

                     </select>
                  </div>
               </div>


               <div class="col-md-2">
                  <div class="form-group">
                     <select name="room_quantity" name="quantity" id="" required="true" class="form-control">
                        <option value="" selected>Select Quantity</option>
                        @for ($i = 1; $i< 10; $i++) @if($apartment->quantity == $i)
                           <option value="{{ $i }}" selected>{{ $i }}</option>
                           @else
                           <option value="{{ $i }}">{{ $i }}</option>
                           @endif
                           @endfor
                     </select>
                  </div>
               </div>

               <div class="col-md-2">
                  <div class="form-group">
                     <select name="room_number" name="bedrooms" id="bedrooms-update" class="form-control">
                        <option value="" selected>Choose Bedrooms</option>
                         @for ($i = 1; $i< 11; $i++) @if($apartment->no_of_rooms == $i)
                           <option value="{{ $i }}" selected>{{ $i }}</option>
                           @else
                           <option value="{{ $i }}">{{ $i }}</option>
                           @endif
                           @endfor
                     </select>
                  </div>
               </div>

           

               <div class="col-md-2">
                  <div class="form-group">
                     <select required="required" name="room_toilets" id="children" class="form-control">
                        <option value="" selected>Choose Toilets</option>

                        @for ($i = 1; $i< 10; $i++) @php $value=$i * 0.5; @endphp @if($apartment->toilets == $value)
                           <option value="{{ $value}}" selected> {{ $value }}</option>
                           @else
                           <option value="{{ $value }}"> {{ $value }}</option>
                           @endif
                           @endfor
                     </select>
                  </div>
               </div>


               <div class="col-md-2">
                  <div class="form-group label-floating is-empty">
                     <label class="control-label">Total Guests</label>
                     <input name="room_max_adults" required="true" value="{{ $apartment->max_adults }}" class="form-control   variation" type="number">
                  </div>
               </div>



               <div class="col-md-2">
                  <div class="form-group label-floating is-empty">
                     <label class="control-label">Price per/night</label>
                     <input name="room_price" required="true" value="{{ $apartment->price }}" class="form-control   variation" type="number">
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group label-floating is-empty">
                     <label class="control-label">Sale Price</label>
                     <input name="room_sale_price" value="{{ $apartment->sale_price }}" class="form-control variation_sale_price variation" type="number">
                  </div>
               </div>
             


               <div class="col-md-4">
                  <div class="form-group label-floating">
                     <label class="control-label">End Date</label>
                     <input class="form-control  datepicker pull-right" value="{{ $helper::getReversedFormatedDate($apartment->sale_price_expires) }}" name="room_sale_price_expires" id="datepicker" type="text">
                  </div>
               </div>


               <div class="col-md-4">
                  <div class="form-group label-floating is-ty">
                     <label class="control-label">Agent Email</label>
                     <input name="owner_email" value="{{ $apartment->owner_email }}" class="form-control  variation" type="text">
                     <span class="material-input"></span>
                  </div>
               </div>

               <div>
                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Wifi password</label>
                        <input name="wifi_password" value="{{ $apartment->wifi_password }}" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Wifi ssid</label>
                        <input name="wifi_ssid" value="{{ $apartment->wifi_ssid }}" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Teaser</label>
                        <textarea name="teaser" class="form-control  variation">{{ $apartment->teaser }}</textarea>
                        <span class="material-input"></span>
                     </div>
                  </div>
               </div>

             


               <div class="col-md-12 bed mb-5">
                  @if ($bedrooms->count())
                  @foreach($bedrooms as $key => $parent)
                  <div class="bedroom-{{ $key + 1 }} d-none mb-2">

                     <h5 class="mb-2">{{ $parent->name }} </h5>
                     @foreach($parent->children as $bedroom)
                     <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
                        <input class="radio-button" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="bed_count[{{$parent->id}}]" type="radio">{{ $bedroom->name }}
                     </label>
                     @endforeach

                  </div>
                  @endforeach
                  @endif
               </div>
               <div id="bedroom-dropdowns-container mb-5">
                  @for ($i = 1; $i <= $apartment->no_of_rooms; $i++)
                     <div class="form-group col-md-2 ">
                        <label for="bedroom_{{ $i }}">Bedroom {{ $i }}</label>
                        <select name="bedroom_{{ $i }}" id="bedroom_{{ $i }}" class="form-control">
                              <option value="" selected>Choose bed type</option>
                              <option value="Extra-large double bed" {{ $apartment->{'bedroom_'.$i} == 'Extra-large double bed' ? 'selected' : '' }}>Extra-large double bed</option>
                              <option value="Single bed" {{ $apartment->{'bedroom_'.$i} == 'Single bed' ? 'selected' : '' }}>Single bed</option>
                              <option value="Large bed" {{ $apartment->{'bedroom_'.$i} == 'Large bed' ? 'selected' : '' }}>Large bed</option>
                        </select>
                     </div>
                  @endfor
               </div>
               <div class="col-md-12">
                  <div class="form-group label-floating">
                     <label class="control-label">Image Links</label>
                     <textarea rows="20" name="room_image_links" class="form-control  variation" type="text">{{ $apartment->image_link }}</textarea>

                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group label-floating">
                     <label class="control-label">Video Links</label>
                     <input class="form-control   pull-right" name="room_video_links" value="{{ $apartment->video_link }}" type="text">
                  </div>
               </div>





               <div class="clearfix"></div>



               <div class="col-sm-12">
                  <div id="j-drop" class="j-drop">
                     <input accept="image/*" data-msg="Upload  at least 5 images" onchange="getFile(this,'images[]')" class="upload_input" multiple="true" type="file" id="upload_file_input" name="product_image" />
                     <div class=" upload-text {{ $apartment->images->count() ||  $apartment->image ? 'hide' : ''}}">
                        <a class="" href="#">
                           <img class="" src="/backend/img/upload_icon.png">
                           <b>Click on anywhere to upload image</b>
                        </a>
                     </div>
                     <div id="j-details" class="j-details">
                        @if($apartment->images->count())
                        @foreach($apartment->images as $image)
                        <div id="{{ $image->id }}" class="j-complete">
                           <div class="j-preview">
                              <img class="img-thumnail" src="{{ $image->image }}">
                              <div id="remove_image" class="remove_image remove-image">
                                 <a class="remove-image" data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete" data-url="{{ $image->image }}" href="#">Remove</a>
                                 <input type="hidden" class="file_upload_input stored_image_url" value="{{ $apartment->image }}" name="edit_room_images[{{ $apartment->id }}][]">
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @endif
                     </div>
                  </div>
               </div>




               <div class="col-md-12 mt-5 pr-5 kkk">
                  @foreach( $apartment_facilities as $apartment_facility )
                  <div>{{ $apartment_facility->name }}</div>
                  @foreach($apartment_facility->children->sortBy('name') as $child)
                  <div class="mt-2 mb-2">
                     <div class="togglebutton">
                        <label>
                           <input {{ $helper->check($apartment->attributes , $child->id) ? 'checked' : '' }} name="apartment_facilities_id[]" value="{{ $child->id }}" type="checkbox">

                           {{ $child->name }}

                        </label>
                        @include('includes.loop',['obj'=>$child,'space'=>'&nbsp;&nbsp;','model' => $apartment])
                     </div>
                  </div>
                  @endforeach
                  @endforeach
               </div>

               <div class="col-md-12 mt-1 pr-5 ">
                  <h4 class="text-capitalize">Apartment Extras</h4>
                  <!-- include('admin.apartments.extras',[
                    'obj' => $apartment, 
                    'name' => 'multiple_apartment_extra_services',
                    'attribute_name' => 'multiple_apartment_extras',
                ]) -->
                  @foreach($extras as $child)
                  <div class="mt-2 mb-2">
                     <div class="togglebutton d-flex">
                        <label>
                           <input {{ $helper->check($apartment->attributes , $child->id) ? 'checked' : '' }} name="multiple_apartment_extras[{{ $apartment->id }}][]" value="{{ $child->id }}" type="checkbox">
                           {{ $child->name }}
                        </label>
                        @include('includes.loop',['child'=>$child,'space'=>'&nbsp;&nbsp;','model' => 'Attribute','name' => 'attribute_id'])
                     </div>
                     <div class="extras-se  form-group">
                        <input name="multiple_apartment_extra_services[]" value="{{ $helper->check(optional($apartment)->extra_services, $child->id,'price')   }}" placeholder="Leave blank if you want it free" class="form-control" type="number">
                     </div>
                  </div>
                  @endforeach
               </div>



               <div class="row">
                  <div class="col-md-6">

                     <div class="">
                        <label role="button">
                           <input name="apartment_allow" {{ isset($apartment) && $apartment->allow == 1 ? 'checked' : ''}} value="1" type="checkbox">
                           <span class="toggle"></span>
                           Enable/Disabled
                        </label>
                     </div>


                  </div>

               </div>
            </div>

         </div>

      </div>
   </div>
   <div class="wizard-footer">
      <div class="pull-right">
         <input type='button' class='btn btn-next btn-fill btn-rose btn-round btn-wd' name='next' value='Next' />
         <input type='submit' class='btn btn-finish btn-fill btn-rose   btn-round  btn-wd' name='Submit' value='Finish' />
      </div>
      <div class="pull-left">
         <input type='button' class='btn btn-previous btn-fill btn-primary  btn-round  btn-wd' name='previous' value='Previous' />
      </div>
      <div class="clearfix"></div>
   </div>