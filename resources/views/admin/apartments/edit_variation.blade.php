



@if ($property->apartments->count() && $property->type != 'single')
    @foreach($property->apartments as $apartment)
    <div  class="row p-attr mb-2 variation-panel">
    
    <div class="col-md-9 col-xs-9 col-sm-9">
    </div>
    <div class="col-md-3 col-xs-12 text-right border col-sm-12 pt-2 pb-4">
        <a href="/admin/room/{{ $apartment->id }}/delete"   title="remove panel" class="delete-panel"><i class="fa fa-trash-o"></i> Remove</a>  |
        <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> 
    </div>

    <div id="variation-panel" data-id="{{ $apartment->id }}"   class="hide v-panel">
        <div class="clearfix"></div>
        <div class="col-md-12">
            <input name="edit_room"  value="1"   class="" type="hidden">
            <div class="col-md-6">
                <div class="form-group label-floating is-ty">
                    <label class="control-label">Accommodation Type Name</label>
                    <input name="edit_room_name[{{ $apartment->id }}]"  required="true" value="{{ $apartment->name }}" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>

            <div class="col-md-2">
                <select  name="room_quantity[{{ $counter }}]" name="quantity" id="" required="true" class="form-control">
                    <option value="" selected>Select Quantity</option>
                    @for ($i = 1; $i< 10; $i++) 
                        @if($apartment->quantity == $i)
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>

        
            <div class="col-md-2">
               <div class="form-group label-floating is-ty">
                    <label class="control-label">Bedrooms</label>
                    <select  name="room_number[{{ $apartment->id }}]" name="bedrooms" id="bedrooms" required class="form-control  bedrooms">
                        <option value="" selected>Choose Bedrooms</option>
                        @for ($i = 1; $i< 11; $i++) 
                            @if($apartment->no_of_rooms == $i)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
              <div class="form-group label-floating is-ty">
                <label class="control-label">Toilets</label>
                    <select name="apartment_toilets[{{ $apartment->id }}]" id="children" class="form-control">
                        <option  value="">Choose toilets... </option>
                        @for ($i = 1; $i< 10; $i++) 
                            @if($apartment->toilets == $i)
                            <option value="{{ $i }}" selected> {{ $i }}</option>
                            @else
                            <option value="{{ $i }}"> {{ $i }}</option>
                            @endif
                        @endfor 
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group label-floating ">
                    <label class="control-label">Max Adults</label>
                    <input name="room_max_adults[{{ $apartment->id }}]"  required="true" value="{{ $apartment->max_adults }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating ">
                    <label class="control-label">Max Children</label>
                    <input name="room_max_children[{{ $apartment->id }}]"  required="true" value="{{ $apartment->max_children }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating ">
                    <label class="control-label">Price  </label>
                    <input name="edit_room_price[{{ $apartment->id }}]"  required="true" value="{{ $apartment->price }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group label-floating ">
                    <label class="control-label">Sale Price</label>
                    <input name="edit_room_sale_price[{{ $apartment->id }}]"   value="{{ $apartment->sale_price }}"  class="form-control variation_sale_price variation" type="number">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group label-floating">
                    <label class="control-label">End Date</label>
                    <input class="form-control  datepicker pull-right" value="{{ $helper::getReversedFormatedDate($apartment->sale_price_expires) }}" name="edit_room_sale_price_expires[{{ $apartment->id }}]" id="datepicker" type="text">
                </div>
            </div>
            

            <div class="col-md-12 bed mb-5">
               @include('admin.apartments.beds')
            </div>

            
            <div class="col-sm-12">
                <div id="j-drop"  class="j-drop">
                <input accept="image/*"   data-msg="Upload  at least 5 images"  onchange="getFile(this,'new_room_images[{{ $apartment->id }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                   <div   class=" upload-text {{ $apartment->images->count() ||  $apartment->image ? 'hide' : ''}}"> 
                        <a  class="" href="#">
                            <img class="" src="/backend/img/upload_icon.png">
                            <b>Click on anywhere to upload image</b> 
                        </a>
                    </div>
                    <div id="j-details"  class="j-details">
                        @if($apartment->images->count())
                            @foreach($apartment->images as $image)
                            <div id="{{ $image->id }}" class="j-complete">
                                <div class="j-preview">
                                    <img class="img-thumnail" src="{{ $image->image }}">
                                    <div id="remove_image" class="remove_image remove-image">
                                        <a class="remove-image"  data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete"  data-url="{{ $image->image }}" href="#">Remove</a>
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
                @include('admin.apartments.apartment_fac',['model'=>$apartment])
            </div>


            <div class="col-md-12 mt-1 pr-5 ">
                <h4 class="text-capitalize">Apartment Extras</h4>
                @include('admin.apartments.extras',[
                    'obj' => $apartment, 
                    'name' => 'multiple_apartment_extra_services',
                    'attribute_name' => 'multiple_apartment_extras',
                ])
            </div>
        </div>


    </div> 
    
</div>

@endforeach
@endif












    




    
