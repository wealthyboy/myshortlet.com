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
        <input name="has_more_room"     value="1"   class="" type="hidden">
        <input name="new_room"     value="1"   class="" type="hidden">
        
                
            <div class="col-md-4">
                <div class="form-group label-floating is-ty">
                    <label class="control-label">Accommodation Type Name</label>
                    <input name="room_name[{{ $counter }}]"  required="true" value="{{ old('price') }}" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group label-floating">
                    <label class="control-label">From Date Available</label>
                    <input name="room_avaiable_from[{{ $counter }}]"  required="true" value="" class="form-control  datepicker" type="text">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select  name="room_number[{{ $counter }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                        <option value="" selected>Choose Bedrooms</option>
                        @for ($i = 1; $i< 5; $i++) 
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

            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Price per/night</label>
                    <input name="room_price[{{ $counter }}]"  required="true" value="{{ old('price') }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-4">
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
                            <label for="bedroom-{{ $bedroom->id }}" class="radio-inline">
                                <input  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $counter }}" type="radio" name="optradio">{{ $bedroom->name }}
                            </label>
                            @endforeach
                          
                        </div>
                    @endforeach
                @endif
            </div>
            
           
            <div class="clearfix"></div>
            
            <div class="col-sm-12">
                <div id="j-drop"  class="j-drop">
                <input accept="image/*"   onchange="getFile(this,'room_images[{{ $counter }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                    <div   class=" upload-text  {{ $counter }}"> 
                    <a  class="" href="#">
                        <img class="" src="/backend/img/upload_icon.png">
                        <b>Click on anywhere to upload image</b> 
                    </a>
                    </div>
                    <div id="j-details"  class="j-details"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3 pr-5 pl-5">
           <h5>Rules </h5>
           @foreach($rules as $rule)
                <div class="col-md-6">
                    <div class="togglebutton">
                        <label>
                        <input   name="attribute_id[]"  value="{{ $rule->id }}" type="checkbox" >
                        <span class='toggle'></span>  
                        {{ $rule->name }}  
                        </label>
                    </div>
                </div>
            @endforeach  
        </div>

        <div class="col-md-12 mt-1 pr-5 pl-5">
            <h5>Facilities </h5>
            @foreach($facilities as $facility)
               <div>{{ $facility->name }}</div>                       

               @foreach($facility->children->sortBy('name') as $child)

                <div class="mt-2 mb-2">
                    <div class="togglebutton">
                        <label>
                        <input   name="facility_id[]"  value="{{ $child->id }}" type="checkbox" >
                        <span class='toggle'></span>  
                        {{ $child->name }}                        
                    </label>
                    </div>
                </div>
                @endforeach

            @endforeach
            
        </div>

        <div class="col-md-12 mt-1 mb-3 pr-5 pl-5">
            <h5>Extra Services </h5>
            <div class="">
                @foreach($extra_services as $extra_service)
                <div class="col-md-3">
                    <div class="togglebutton">
                        <label>
                        <input   name="attribute_id[]"  value="{{ $extra_service->id }}" type="checkbox" >
                        <span class='toggle'></span>  
                        {{ $extra_service->name }}                    
                    </label>
                    </div>
                </div>
                <div class="ml-3 col-md-6">
                        <div class="form-group">
                            <input name="extra_services_price[{{ $extra_service->id }}]" type="number" class="form-control" id="" placeholder="Price   " /> 
                            optional
                        </div>
                    </div>
                @endforeach  
            </div>
        </div>

    </div> 
    
</div>












    
