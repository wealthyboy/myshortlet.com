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
                        <input name="room_name" required="true" value="" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="price_mode" id="" required="true" class="form-control">
                           <option value="">Price Mode</option>
                           <option value="per night">Per night</option>
                           <option value="per week"> Per week</option>
                           <option value="per month">Per month</option>
                           <option value="per year"> Per year</option>
                        </select>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="apartment_id" id="" required="true" class="form-control">
                           <option value="">Apartment</option>
                           @foreach($room_ids as $key => $room_id)
                           <option value="{{ $room_id->id }}">{{ $room_id->name }}</option>
                           @endforeach

                        </select>
                     </div>
                  </div>


                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="floor" id="" required="true" class="form-control">
                           <option value="">Floor</option>
                           @if(isset($floors))
                           @foreach($floors as $key => $floor)
                           <option value="{{ $floor }}">{{ $floor }}</option>
                           @endforeach
                           @endif

                        </select>
                     </div>
                  </div>


                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="property_id" id="" required="true" class="form-control">
                           <option value="">Properties</option>
                           @foreach($properties as $key => $room_id)
                           <option value="{{ $room_id->id }}">{{ $room_id->name }}</option>
                           @endforeach

                        </select>
                     </div>
                  </div>


                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="room_quantity" name="quantity" id="" required="true" class="form-control">
                           <option value="" selected>Select Quantity</option>
                           @for ($i = 1; $i< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option>
                              @endfor
                        </select>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="form-group">
                        <select name="room_number" name="bedrooms" id="bedrooms-update" class="form-control ">
                           <option value="" selected>Choose Bedrooms</option>
                           @for ($i = 1; $i< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option>@endfor
                        </select>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="form-group">
                        <select required="required" name="room_toilets" id="children" class="form-control">
                           <option value="" selected>Choose Toilets</option>
                           @for ($i = 1; $i< 10; $i++) @php $value=$i * 0.5; @endphp <option value="{{ $value }}"> {{ $value }}</option>
                              @endfor
                        </select>
                     </div>
                  </div>


                  <div class="col-md-2">
                     <div class="form-group label-floating is-empty">
                        <label class="control-label">Total Guests</label>
                        <input name="room_max_adults" required="true" value="" class="form-control   variation" type="number">
                     </div>
                  </div>



                  <div class="col-md-2">
                     <div class="form-group label-floating is-empty">
                        <label class="control-label">Price per/night</label>
                        <input name="room_price" required="true" value="{{ old('price') }}" class="form-control   variation" type="number">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group label-floating is-empty">
                        <label class="control-label">Sale Price</label>
                        <input name="room_sale_price" value="" class="form-control variation_sale_price variation" type="number">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group label-floating">
                        <label class="control-label">End Date</label>
                        <input class="form-control  datepicker pull-right" name="room_sale_price_expires" id="datepicker" type="text">
                     </div>
                  </div>


                  <div class="col-md-12 bed mb-5">
                     <div id="bedroom-dropdowns-container">  

               


                 

                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group label-floating">
                        <label class="control-label">Image Links</label>
                        <textarea rows="20" name="room_image_links" class="form-control  variation" type="text"></textarea>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group label-floating">
                        <label class="control-label">Video Links</label>
                        <input class="form-control   pull-right" name="room_video_links" type="text">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Agent Email</label>
                        <input name="owner_email" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Wifi password</label>
                        <input name="wifi_password" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Wifi ssid</label>
                        <input name="wifi_ssid" class="form-control  variation" type="text">
                        <span class="material-input"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group label-floating is-ty">
                        <label class="control-label">Teaser</label>
                        <textarea name="teaser" row="20" class="form-control  variation"></textarea>
                        <span class="material-input"></span>
                     </div>
                  </div>

                  <div class="clearfix"></div>

                  <div class="col-sm-12">
                     <div id="j-drop" class="j-drop">
                        <input accept="image/*" required="true" data-msg="Upload  at least 5 images" onchange="getFile(this,'images[]')" class="upload_input" multiple="true" type="file" id="upload_file_input" name="product_image" />
                        <div class=" upload-text">
                           <a class="" href="#">
                              <img class="" src="/backend/img/upload_icon.png">
                              <b>Click on anywhere to upload image</b>
                           </a>
                        </div>
                        <div id="j-details" class="j-details"></div>
                     </div>
                  </div>


                  <div class="col-md-12 mt-5 d-flex pr-5">
                     @foreach( $apartment_facilities as $apartment_facility )
                     <div class="ml-4">
                        <h5>{{ $apartment_facility->name }}</h5>
                        @foreach($apartment_facility->children->sortBy('name') as $child)
                        <div class="mt-2 mb-2">
                           <div class="">
                              <label role="button">
                                 <input name="apartment_facilities_id[]" value="{{ $child->id }}" type="checkbox">
                                 <span class="toggle"></span>
                                 {{ $child->name }}
                              </label>
                           </div>
                        </div>
                        @endforeach
                     </div>

                     @endforeach
                  </div>

                  <div class="col-md-12 mt-1 pr-5 ">
                     <h4 class="text-capitalize">Room Extras</h4>



                     @foreach($extras as $child)
                     <div class="mt-2 mb-2">
                        <div class=" d-flex">
                           <label role="button">
                              <input name="multiple_apartment_extras[]" value="{{ $child->id }}" type="checkbox">
                              <span class="toggle"></span>
                              {{ $child->name }}
                           </label>
                           @include('includes.loop',['child'=>$child,'space'=>'&nbsp;&nbsp;','model' => 'Attribute','name' => 'attribute_id'])
                        </div>
                        <div class="extras-se  form-group">
                           <input name="multiple_apartment_extra_services[]" value="" placeholder="Leave blank if you want it free" class="form-control" type="number">
                        </div>
                     </div>
                     @endforeach
                  </div>

                  <div class="row">
                     <div class="col-md-6">

                        <div class="">
                           <label role="button">
                              <input name="apartment_allow" value="1" type="checkbox">
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