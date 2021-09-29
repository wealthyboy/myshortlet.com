<div  class="row p-attr mb-2 variation-panel">
    <div class="col-md-9 col-xs-9 col-sm-9">
    </div>
    <div class="col-md-3 col-xs-12 text-right border col-sm-12 pt-2 pb-4">
        <a href="#"   title="remove panel" class="remove-panel"><i class="fa fa-trash-o"></i> Remove</a>  |
        <a href="#"   title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> 
    </div>

    <div id="variation-panel" data-id="{{ $counter }}"   class="hide v-panel">
        <div class="clearfix"></div>
        <div class="col-md-12">
            <input name="has_more_room"  value="1"   class="" type="hidden">
            <input name="new_room"       value="1"   class="" type="hidden">
            <div class="col-md-6">
                <div class="form-group label-floating is-ty">
                    <label class="control-label">Accommodation Type Name</label>
                    <input name="room_name[{{ $counter }}]"  required="true" value="" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>
           
            <div class="col-md-2">
                <div class="form-group">
                    <select  name="room_quantity[{{ $counter }}]" name="quantity" id="" required="true" class="form-control">
                        <option value="" selected>Select Quantity</option>
                        @for ($i = 1; $i< 10; $i++) 
                        <option value="{{ $i }}"> {{ $i }}</option>
                        @endfor 
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select  name="room_number[{{ $counter }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                        <option value="" selected>Choose Bedrooms</option>
                        @for ($i = 1; $i< 10; $i++) 
                            <option value="{{ $i }}"> {{ $i }}</option>
                        @endfor 
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select name="room_toilets[{{ $counter }}]" id="children" class="form-control">
                        <option  value="" selected>Choose Toilets</option>
                        @for ($i = 1; $i< 10; $i++) 
                        <option value="{{ $i }}"> {{ $i }}</option>
                        @endfor 
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Max Adults</label>
                    <input name="room_max_adults[{{ $counter }}]"  required="true" value="" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Max Children</label>
                    <input name="room_max_children[{{ $counter }}]"  required="true" value="" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Price per/night</label>
                    <input name="room_price[{{ $counter }}]"  required="true" value="{{ old('price') }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Sale Price</label>
                    <input name="room_sale_price[{{ $counter }}]"   value=""  class="form-control variation_sale_price variation" type="number">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group label-floating">
                    <label class="control-label">End Date</label>
                    <input class="form-control  datepicker pull-right" name="room_sale_price_expires[{{ $counter }}]" id="datepicker" type="text">
                </div>
            </div>

            
            <div class="col-md-12 bed mb-5">
                @if ($bedrooms->count())
                    @foreach($bedrooms as $key =>  $parent)
                        <div class="bedroom-{{ $key + 1 }} d-none mb-2">
                        <div class="mb-2">{{ $parent->name }} </div>
                            @foreach($parent->children as $bedroom)
                            <label for="bedroom-{{ $bedroom->id }}-{{ $counter }}" class="radio-inline">
                                <input  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $counter }}" name="{{ $parent->slug }}_{{ $counter }}" type="radio" name="optradio">{{ $bedroom->name }}
                                <div class="bed-count form-group">
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
                <input accept="image/*"  required="true"  data-msg="Upload  at least 5 images"  onchange="getFile(this,'room_images[{{ $counter }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
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
               @include('admin.apartments.apartment_fac',['model' => 'apartment','variation' => true])
            </div>

            <div class="col-md-12 mt-1 pr-5 ">
                <h4 class="text-capitalize">Room Extras</h4>
                @include('admin.apartments.extras',[
                    'obj' => '', 
                    'name' => 'multiple_apartment_extra_services',
                    'attribute_name' => 'multiple_apartment_extras',
                    'model' => 'apartment',
                    'variation' => true
                ])
            </div>
        </div>
        
    </div> 
    
</div>












    
