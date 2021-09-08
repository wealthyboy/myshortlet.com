



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
                    <label class="control-label">Accommodation Type Name 33</label>
                    <input name="edit_room_name[{{ $apartment->id }}]"  required="true" value="{{ $apartment->name }}" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group label-floating">
                    <label class="control-label">From Date Available</label>
                    <input name="edit_room_avaiable_from[{{ $apartment->id }}]"  required="true" value="{{ $helper::getReversedFormatedDate($apartment->available_from) }}" class="form-control  datepicker" type="text">
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <select  name="room_number[{{ $apartment->id }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
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

            <div class="col-lg-4">
                <div class="form-group label-floating">
                    <select name="apartment_toilets[{{ $apartment->id }}]" id="children" class="form-control">
                        <option  value="">Choose toilets... </option>
                        @for ($i = 1; $i< 4; $i++) 
                            @if($apartment->toilets == $i)
                            <option value="{{ $i }}" selected> {{ $i }}</option>
                            @else
                            <option value="{{ $i }}"> {{ $i }}</option>
                            @endif
                        @endfor 
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group label-floating ">
                    <label class="control-label">Max Adults</label>
                    <input name="room_max_adults[{{ $apartment->id }}]"  required="true" value="{{ $apartment->max_adults }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group label-floating ">
                    <label class="control-label">Max Children</label>
                    <input name="room_max_children[{{ $apartment->id }}]"  required="true" value="{{ $apartment->max_children }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group label-floating ">
                    <label class="control-label">Price  </label>
                    <input name="edit_room_price[{{ $apartment->id }}]"  required="true" value="{{ $apartment->price }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-4">
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
            
            <div class="clearfix"></div>

            <div class="col-md-12 bed mb-5">
                @if ($bedrooms->count())

                    @foreach($bedrooms as $key =>  $parent)
                        @if ($apartment->no_of_rooms > $key )
                            <div class="bedroom-{{ $key + 1 }} mt-3">
                                <h6> {{ $parent->name }} </h6>
                                @foreach($parent->children as $bedroom)
                                <label for="bedroom-{{ $bedroom->id }}-{{ $apartment->id }}"  class="radio-inline">
                                    <input  {{  $apartment->bedrooms->contains($bedroom) ? 'checked' : ''}}  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $apartment->id }}" name="{{ $parent->slug }}" type="radio" >{{ $bedroom->name }}
                                </label>
                                @endforeach
                            </div>
                        @else
                            <div class="bedroom-{{ $key + 1 }} d-none  {{ $key }}">
                                <div>{{ $parent->name }} </div>
                                @foreach($parent->children as $bedroom)
                                <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
                                    <input  value="{{ $bedroom->id }}" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $apartment->id }}" type="radio" >{{ $bedroom->name }}
                                </label>
                                @endforeach
                            </div>
                        @endif

                    @endforeach

                @endif
            </div>

            
            <div class="col-sm-12">
                <div id="j-drop"  class="j-drop">
                <input accept="image/*"   onchange="getFile(this,'new_room_images[{{ $apartment->id }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
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
        </div>


    </div> 
    
</div>

@endforeach
@endif












    




    
