<!--  You can switch " data-color="purple"   with one of the next bright colors: "green", "orange", "red", "blue"       -->
<div class="wizard-header">
   <h3 class="wizard-title">
      Upload Property
   </h3>
</div>
<div class="wizard-navigation">
   <ul>
      <li><a href="wizard.html#ProductData" data-toggle="tab">Property Data</a></li>
      <li><a href="wizard.html#Cancelation" data-toggle="tab">Facilities </a></li>
      <li><a href="wizard.html#ProductVariations" data-toggle="tab">Other Data</a></li>
   </ul>
</div>
<div class="tab-content">
<div class="tab-pane" id="ProductData">
   @include('admin.apartments.apartment_data')

</div>
<div class="tab-pane" id="Cancelation">
   <div class="row">
      <div class="col-md-12 mt-1 pr-5 ">
         @include('admin.apartments.attributes',['attris'=> $attributes, 'ob' => isset($property) ? $property: null])
      </div>
   </div>
</div>
<div class="tab-pane" id="ProductVariations">
   <h4 class="info-text">Property</h4>
   <div class="clearfix"></div>
   <div class="col-md-12">
      <div class="form-group">
         <label class="control-label">Other Data</label>
         <select name="type" id="" class="form-control"  required="true" title="Please select product type"  title="" data-size="7">
            <option  value="" selected>Choose One</option>
            <option  {{ isset($property) && $property->type == 'lands' ? 'selected' : '' }}  value="lands">Lands</option>
            <option  {{ isset($property) && $property->type == 'house-for-rent' ? 'selected' : '' }}  value="house-for-rent">House for rent</option>
            <option  {{ isset($property) && $property->type == 'house-for-sale' ? 'selected' : '' }}  value="house-for-sale">House for sale</option>
         </select>
      </div>
   </div>
   <div class="simple-apartment ">
      <div id="" data-id=""   class="">
         <div class="clearfix"></div>
         <div class="col-md-12">
            @if(request()->mode != 'lands')
            <div class="col-md-6 mb-2">
               <div class="form-group">
                  <select  name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                    <option value="">Choose Bedrooms</option>
                  
                    @for ($i = 1; $i< 9; $i++) 
                     @if( isset($property) && $property->bedrooms == $i)
                     <option value="{{ $i }}" selected>{{ $i }}</option>
                     @else
                     <option value="{{ $i }}">{{ $i }}</option>
                     @endif
                     @endfor
                  </select>
               </div>
            </div>
            <div class="col-md-6  mb-2">
               <div class="form-group">
                  <select name="toilets" id="children" class="form-control">
                     <option  value="">Choose Toilets</option>
                  
                     @for ($i = 1; $i< 9; $i++) 
                        @if( isset($property) && $property->toilets == $i)
                        <option value="{{ $i }}" selected> {{ $i }}</option>
                        @else
                        <option value="{{ $i }}"> {{ $i }}</option>
                        @endif
                     @endfor
                  </select>
               </div>
            </div>
            @endif
            
            <div class="col-md-4  mb-2">
               <div class="form-group label-floating ">
                  <label class="control-label">Price</label>
                  <input name="price"  required="true" value="{{ isset($property) ? $property->price : old('price') }}" class="form-control   variation" type="number">
               </div>
            </div>


            <div class="col-md-4">
               <div class="form-group">
                  <select  name="price_mode" id="" class="form-control ">
                     <option value="" selected>Choose Price mode</option>
                     <option value="per night">Per night</option>
                     <option value="per year" >Per year</option>
                     <option value="per month" >Per month</option>
                     <option value="per week" >Per week</option>
                     <option value="per plot" >Per plot</option>
                  </select>
               </div>
            </div>

            <div class="col-md-4 mb-2">
               <div class="form-group label-floating ">
                  <label class="control-label">Size(sq)</label>
                  <input name="size" 
                  required="true" 
                  value="{{ isset($property) ? $property->size : old('size') }}" class="form-control   variation" type="number">
               </div>
            </div>

            <div class="row">
               <div class="col-md-6">
                  <div class="togglebutton">
                    <label>
                       <input {{ isset($property) && $property->is_price_negotiable == 1 ? 'checked' : ''}}  name="is_price_negotiable"  value="1" type="checkbox" checked>
                       Price is negotiable
                    </label>
                  </div>
               </div>
            </div>
            
            
            <div class="clearfix"></div>
            <div class="col-sm-12 mt-3">
               <div id="j-drop"  class="j-drop">
                  <input accept="image/*"   data-msg="Upload  at least 5 images"   onchange="getFile(this,'images[]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                  <div   class=" upload-text  {{ isset($property) &&  optional($property)->images ? 'hide' : '' }}"> 
                     <a  class="" href="#">
                     <img class="" src="/backend/img/upload_icon.png">
                     <b>Click on anywhere to upload image</b> 
                     </a>
                  </div>
                  

                  <div id="j-details"  class="j-details">
                     @if( isset($property) && optional($property->images)->count() )
                        @foreach($property->images as $image)
                           <div id="{{ $image->id }}" class="j-complete">
                              <div class="j-preview">
                                 <img class="img-thumnail" src="{{ $image->image }}">
                                 <div id="remove_image" class="remove_image remove-image">
                                    <a class="remove-image"  data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete"  data-url="{{ $image->image }}" href="#">Remove</a>
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
   <div class="clearfix"></div>
   
</div>
<div class="wizard-footer">
   <div class="pull-right">
      <input type='button' class='btn btn-next btn-fill btn-rose btn-round btn-wd' name='next' value='Next' />
      <input type='submit' class='btn btn-finish btn-fill btn-rose   btn-round  btn-wd' name='finish' value='Finish' />
   </div>
   <div class="pull-left">
      <input type='button' class='btn btn-previous btn-fill btn-primary  btn-round  btn-wd' name='previous' value='Previous' />
   </div>
   <div class="clearfix"></div>
</div>