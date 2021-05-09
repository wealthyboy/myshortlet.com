    <h4 class="info-text ">Enter Apartment Details</h4>        
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($reservation) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Apartment Name</label>
                    <input  required="true" name="apartment_name" data-msg="" value="{{ isset($reservation) ? $reservation->name :  old('apartment_name') }}" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="form-group {{ isset($reservation) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Address</label>
                    <input  required="true" name="address" data-msg="" value="{{ isset($reservation) ? $reservation->address :  old('address') }}" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <select name="city_id" required="true" class="form-control">
                            <option  value="" selected="">--Choose City--</option>
                            @foreach($locations as $location)
                                <option class="" disabled value="" >{{ $location->name }} </option>
                                @foreach($location->children as $children)
                                  <option   disabled value="{{ '' }}">&nbsp;&nbsp;&nbsp;{{ $children->name }} </option>
                                   @foreach($children->children as $childs)
                                        @if( isset($reservation->city_id) && $reservation->city_id == $childs->id)
                                           <option  value="{{ $childs->id }}" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $childs->name }} </option>
                                        @else
                                         <option  value="{{ $childs->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $childs->name }} </option>
                                        @endif
                                    @endforeach
                                @endforeach  
                            @endforeach  
                        </select>
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
                            {{ isset($reservation) ? $reservation->description : old('description') }}
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
                    <input {{ isset($reservation) && $reservation->allow == 1 ? 'checked' : ''}}  name="allow"  value="1" type="checkbox" checked>
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
                        <input {{ isset($reservation) && $reservation->allow == 1 ? 'checked' : '' }} name="featured_product"  value="1" type="checkbox" >
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
                        @if (!isset($reservation))
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
                            <div   class="{{ optional($reservation)->images ? 'hide' : '' }} upload-text"> 
                                <a   class="" href="#">
                                <img class="" src="/backend/img/upload_icon.png">
                                <b>Click to upload image</b> 
                                </a>
                            </div>
                            <div id="j-details"  class="j-details">
                                <div id="{{ $reservation->id }}" class="j-complete">
                                    <div class="j-preview">
                                        <img class="img-thumnail" src="{{ $reservation->image }}">
                                        <div id="remove_image" class="remove_image remove-image">
                                            <a class="remove-image" data-mode="edit" data-randid="{{ $reservation->id }}"  data-id="{{ $reservation->id }}" data-url="{{ $reservation->image }}" href="#">Remove</a> 
                                        </div>
                                        <input type="hidden" class="file_upload_input stored_image_url" value="{{ $reservation->image }}" name="image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif


                    </div>
                </div>
            </div>
            <label>Facilities</label>
            <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
                @foreach($facilities as $facility)
                    <div class="parent" value="{{ $facility->id }}">
                        <div class="checkbox">
                            <label>
                                @if (isset($reservation))
                                    <input 
                                        type="checkbox" 
                                        value="{{ $facility->id }}" 
                                        name="facility_id[]"
                                        {{ $helper->check($reservation->facilities , $facility->id) ? 'checked' : '' }} 
                                    >
                                @else
                                    <input 
                                        type="checkbox" 
                                        value="{{ $facility->id }}" 
                                        name="facility_id[]"
                                    >
                                @endif
                                {{ $facility->name }}  
                            </label>
                        </div>   
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
    
