<h4 class="info-text ">Enter Apartment Details</h4> 
          
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Apartment Name</label>
                    <input  required="true" name="apartment_name" data-msg="" value="{{ isset($apartment) ? $apartment->name :  old('apartment_name') }}" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-4">
                   <div class="form-group">
                        <select name="attribute_id[]" required class="form-control">
                        <option  value="" selected="">--Choose Property Type--</option>
                            @foreach($property_types  as $property_type)
                                <option class="" value="{{ $property_type->id }}">{{ $property_type->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ isset($apartment) ? ''  : 'label-floating is-empty' }}">
                    <label class="control-label">Address</label>
                    <input  required="true" name="address" data-msg="" value="{{ isset($apartment) ? $apartment->address :  old('address') }}" class="form-control" type="text">
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
                            {{ isset($apartment) ? $apartment->description : old('description') }}
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
                    <input {{ isset($apartment) && $apartment->allow == 1 ? 'checked' : ''}}  name="allow"  value="1" type="checkbox" checked>
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
                        <input {{ isset($apartment) && $apartment->featured == 1 ? 'checked' : '' }} name="featured"  value="1" type="checkbox" >
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
                        <input accept="image/*"  required="true" onchange="getFile(this,'image','Apartment',false)" class="upload_input"   data-msg="Upload  your image" type="file"  name="img"  />
                        <div   class="upload-text"> 
                            <a   class="" href="#">
                                <img class="" src="/backend/img/upload_icon.png">
                                <b>Click to upload image</b> 
                            </a>
                        </div>
                        <div id="j-details"  class="j-details"></div>
                    </div>
                </div>
            </div>
            <label>Location </label>
            <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
                @foreach($locations as $location)
                    <div class="parent">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{ $location->id }}" name="location_id[]" >
                                {{ $location->name }}  
                                <a href="#">
                                <i class="fa fa-pencil"></i> Edit</a> 
                            </label>
                        </div>   
                        @include('includes.product_categories',['obj'=>$location,'space'=>'&nbsp;&nbsp;','model' => 'location','url' => 'location'])
                    </div>
                @endforeach
            </div>
            
            
        </div>
    </div>
</div>
    