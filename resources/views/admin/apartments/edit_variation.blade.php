



@if ($apartment->rooms->count())
    @foreach($apartment->rooms as $room)
<div  class="row p-attr mb-2 variation-panel">
    
    <div class="col-md-9 col-xs-9 col-sm-9">
    </div>
    <div class="col-md-3 col-xs-12 text-right border col-sm-12 pt-2 pb-4">
        <a href="/admin/room/{{ $room->id }}/delete"   title="remove panel" class="delete-panel"><i class="fa fa-trash-o"></i> Remove</a>  |
        <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> 
    </div>

    <div id="variation-panel" data-id="{{ $room->id }}"   class="hide v-panel">
        <div class="clearfix"></div>
        <div class="col-md-12">
        <input name="edit_room"  value="1"   class="" type="hidden">

                
            <div class="col-md-4">
                <div class="form-group label-floating is-ty">
                    <label class="control-label">Accommodation Type Name</label>
                    <input name="edit_room_name[{{ $room->id }}]"  required="true" value="{{ $room->name }}" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating">
                    <label class="control-label">From Date Available</label>
                    <input name="edit_room_avaiable_from[{{ $room->id }}]"  required="true" value="{{ $helper::getReversedFormatedDate($room->available_from) }}" class="form-control  datepicker" type="text">
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group">
                    <select  name="room_number[{{ $room->id }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                        <option value="" selected>Choose Bedrooms</option>
                        @for ($i = 1; $i< 11; $i++) 
                            @if($room->no_of_rooms == $i)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
            </div>


            

            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Max Adults</label>
                    <input name="room_max_adults[{{ $room->id }}]"  required="true" value="{{ $room->max_adults }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Max Children</label>
                    <input name="room_max_children[{{ $room->id }}]"  required="true" value="{{ $room->max_children }}" class="form-control   variation" type="number">
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-3">
                <div class="form-group label-floating ">
                    <label class="control-label">Price  </label>
                    <input name="edit_room_price[{{ $room->id }}]"  required="true" value="{{ $room->price }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group label-floating ">
                    <label class="control-label">Sale Price</label>
                    <input name="edit_room_sale_price[{{ $room->id }}]"   value="{{ $room->sale_price }}"  class="form-control variation_sale_price variation" type="number">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group label-floating">
                    <label class="control-label">End Date</label>
                    <input class="form-control  datepicker pull-right" value="{{ $helper::getReversedFormatedDate($room->sale_price_expires) }}" name="edit_room_sale_price_expires[{{ $room->id }}]" id="datepicker" type="text">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group label-floating">
                    <select name="apartment_toilets[{{ $room->id }}]" id="children" class="form-control">
                        <option  value="" selected>Choose toilets... </option>
                        @for ($i = 1; $i< 4; $i++) 
                            @if($room->toilets == $i)
                            <option value="{{ $i }}" selected> {{ $i }}</option>
                            @else
                            <option value="{{ $i }}"> {{ $i }}</option>
                            @endif
                        @endfor 
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 bed mb-5">
                    @if ($bedrooms->count())

                    @foreach($bedrooms as $key =>  $parent)

                        @if ($room->no_of_rooms > $key )
                            <div class="bedroom-{{ $key + 1 }} mt-3  {{ $key }}">
                                <h6> {{ $parent->name }} </h6>
                                @foreach($parent->children as $bedroom)
                                
                                <label for="bedroom-{{ $bedroom->id }}-{{ $room->id }}"  class="radio-inline">
                                    <input  {{  $room->bedrooms->contains($bedroom) ? 'checked' : ''}}  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $room->id }}" name="{{ $parent->slug }}_{{ $room->id }}" type="radio" >{{ $bedroom->name }}
                                </label>
                                @endforeach

                            </div>
                        @else
                            <div class="bedroom-{{ $key + 1 }} d-none  {{ $key }}">
                                <div>{{ $parent->name }} </div>
                                    @foreach($parent->children as $bedroom)
                                    <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
                                        <input  value="{{ $bedroom->id }}" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $room->id }}" type="radio" >{{ $bedroom->name }}
                                    </label>
                                    @endforeach
                            
                            </div>
                        @endif

                    @endforeach

                    @endif
                </div>

            
            <div class="col-sm-12">
                <div id="j-drop"  class="j-drop">
                <input accept="image/*"   onchange="getFile(this,'new_room_images[{{ $room->id }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                   <div   class=" upload-text {{ $room->images->count() ||  $room->image ? 'hide' : ''}}"> 
                        <a  class="" href="#">
                            <img class="" src="/backend/img/upload_icon.png">
                            <b>Click on anywhere to upload image</b> 
                        </a>
                    </div>
                    <div id="j-details"  class="j-details">
                        @if($room->images->count())
                            @foreach($room->images as $image)
                            <div id="{{ $image->id }}" class="j-complete">
                                <div class="j-preview">
                                    <img class="img-thumnail" src="{{ $image->image }}">
                                    <div id="remove_image" class="remove_image remove-image">
                                        <a class="remove-image"  data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete"  data-url="{{ $image->image }}" href="#">Remove</a>
                                        <input type="hidden" class="file_upload_input stored_image_url" value="{{ $room->image }}" name="edit_room_images[{{ $room->id }}][]">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3 pr-5 ">
           <h5>Rules </h5>
           @foreach($rules as $rule)
                <div class="togglebutton">
                    <label>
                    <input   
                        {{ $helper->check($room->attributes , $rule->id) ? 'checked' : '' }} 

                    name="attribute_id[]"  value="{{ $rule->id }}" type="checkbox" >
                    {{ $rule->name }}  
                    </label>
                </div>
            
            @endforeach  
            

            
        </div>

        <div class="col-md-12 mt-1 pr-5 ">
            <h5>Facilities </h5>
            @foreach($facilities as $facility)
               <div>{{ $facility->name }}</div>                       

               @foreach($facility->children->sortBy('name') as $child)
                <div class="mt-2 mb-2">
                    <div class="togglebutton">
                        <label>
                        <input   
                          {{ $helper->check($room->attributes , $child->id) ? 'checked' : '' }} 
                          name="facility_id[]"  value="{{ $child->id }}" type="checkbox" >
                        {{ $child->name }}                        
                    </label>
                    </div>
                </div>
                @endforeach

            @endforeach
            
        </div>

        <div class="col-md-12 mt-1 pr-5 ">
            <h5>Extra Services </h5>
                @foreach($extra_services as $extra_service)
                    <div class="togglebutton">
                        <label>
                        <input     
                          {{ $helper->check($room->attributes , $extra_service->id) ? 'checked' : '' }} 
                          name="attribute_id[]"  value="{{ $extra_service->id }}" type="checkbox" >
                        {{ $extra_service->name }}                    
                    </label>
                    </div>
                    <div class="ml-3 col-md-6">
                        <div class="form-group">
                            <input name="extra_services_price[{{ $extra_service->id }}][{{ optional($extra_service->attribute_price)->id }}]" type="number" value="{{ optional($extra_service->attribute_price)->price }}" class="form-control" id="" placeholder="Price   " /> 
 
                            optional
                        </div>
                    </div>
                @endforeach  
        </div>
    </div> 
    
</div>

@endforeach
@endif












    




    
