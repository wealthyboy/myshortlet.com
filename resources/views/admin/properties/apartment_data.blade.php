<h4 class="info-text ">Enter Apartment Details</h4> 

          
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Property Name</label>
                        <input  required="true" name="apartment_name" data-msg="" value="{{ isset($property) ? $property->name :  old('apartment_name') }}" class="form-control" type="text">
                    </div>
                </div>

                

            </div>

            @if($house_attributes)
            <div class="row">
                    @if($house_attributes->count())
                        @foreach($house_attributes as $key => $house_attribute)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="attribute_id[]" required="true" class="form-control">
                                    <option  value="" selected="">--Choose {{ ucfirst($key) }}--</option>
                                        @foreach($house_attribute  as $house)
                                            <option  value="{{ $house->id }}"                       
                                                {{ isset($property) && $helper->check(optional($property)->attributes , $house->id) ? 'selected' : '' }} 
                                            >
                                            {{ $house->name }} 
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    @endif

            </div>
            @endif



            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                       <label class="control-label">Address</label>
                       <input  required="true" name="address" data-msg="" value="{{ isset($property) ? $property->address :  old('address') }}" class="form-control" type="text">
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
                    <input {{ isset($property) && $property->allow == 1 ? 'checked' : ''}}  name="allow"  value="1" type="checkbox" >
                    Enable/Disable
                    </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <legend>  
                    Featured Propert
                    </legend>
                    <div class="togglebutton">
                    <label>
                        <input {{ isset($property) && $property->featured == 1 ? 'checked' : '' }} name="featured"  value="1" type="checkbox" >
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
                        <div id="j-drop" class=" j-drop">
                        <input accept="image/*"   onchange="getFile(this,'image','Apartment',false)" class="upload_input"   data-msg="Upload  your image" type="file"  name="img"  />
                        <div   class="{{ isset($property) && $property->image ? 'hide' : '' }}  upload-text"> 
                            <a   class="" href="#">
                                <img class="" src="/backend/img/upload_icon.png">
                                <b>Click to upload image</b> 
                            </a>
                        </div>
                        <div id="j-details"  class="j-details">
                           @if(isset($property))
                                <div id="{{ $property->id }}" class="j-complete">
                                    <div class="j-preview">
                                    <img class="img-thumnail" src="{{ $property->image }}">
                                    <div id="remove_image" class="remove_image remove-image">
                                        <a class="remove-image" data-mode="edit" data-randid="{{ $property->id }}"  data-id="{{ $property->id }}" data-url="{{ $property->image }}" href="#">Remove</a> 
                                    </div>
                                    <input type="hidden" class="file_upload_input stored_image_url" value="{{ $property->image }}" name="image">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            



            <label>Location </label>
            <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
               @include('admin.apartments.location')
            </div>
        </div>
    </div>
</div>
    