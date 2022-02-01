<div class="row p-attr border p-3  mb-1  variation-panel w-100">
<div class="col-md-12 col-xs-12 text-right  col-sm-12 "> <a href="#" title="remove panel" class="remove-panel"><i class="fa fa-trash-o"></i> Remove</a> | <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> </div>
<section id="variation-panel" data-id="{{ $counter }}" class=" v-panel hide">
   <div class="row">

      <div class="col-lg-12">
         <div class="form-group">
            <label for="">Apartment Title </label>
            <input type="text" name="apartment_name[{{ $counter }}]" class="form-control" id="" placeholder="" /> 
            <input name="new_room"     value="1"   class="" type="hidden">

         </div>
      </div>
      <div class="col-lg-3">
         <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <select  name="bedrooms[{{ $counter }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
               <option value="" selected>Choose...</option>
               @for ($i = 1; $i< 5; $i++) 
               <option value="{{ $i }}"> {{ $i }}</option>
               @endfor 
            </select>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="form-group">
            <label for="adults">Adults</label>
            <select name="adults[{{ $counter }}]" id="adults" class="form-control">
               <option value="" selected>Choose...</option>
               @for ($i = 1; $i < 11; $i++) 
               <option value="{{ $i }}"> {{ $i }}</option>
               @endfor 
            </select>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="form-group">
            <label for="children">Children</label>
            <select name="children[{{ $counter }}]" id="children" class="form-control">
               <option  value="" selected>Choose...</option>
               @for ($i = 1; $i< 11; $i++) 
               <option value="{{ $i }}"> {{ $i }}</option>
               @endfor 
            </select>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="form-group">
            <label for="">Price</label>
            <input name="price[{{ $counter }}]" type="number" class="form-control" id="" placeholder="" /> 
         </div>
      </div>
      <div class="col-lg-3">
         <div class="form-group">
            <label for="children">Toilets</label>
            <select name="toilets[{{ $counter }}]" id="children" class="form-control">
               <option  value="" selected>Choose...</option>
               @for ($i = 1; $i< 4; $i++) 
               <option value="{{ $i }}"> {{ $i }}</option>
               @endfor 
            </select>
         </div>
      </div>
      <div class="col-md-12 bed">
         @if ($bedrooms->count())
         @foreach($bedrooms as $key =>  $parent)
         <div class="bedroom-{{ $key + 1 }} d-none">
            <h6> {{ $parent->name }} </h6>
            <div class="d-flex flex-grow-1">
               @foreach($parent->children as $bedroom)
               <div class="custom-control custom-radio mr-3">
                  <input type="radio" class="custom-control-input" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $counter }}" name="{{ $parent->slug }}_{{ $counter }}"  />
                  <label class="custom-control-label" for="bedroom-{{ $bedroom->id }}-{{ $counter }}">{{ $bedroom->name }}</label>
               </div>
               @endforeach
            </div>
         </div>
         @endforeach
         @endif
      </div>
      <div class="col-md-12">
         <div id="j-drop" class="j-drop">
            <input accept="image/*" required="true" onchange="getFile(this,'apartment_images[{{ $counter=8 }}]')" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
            <div class="upload-text">
               <a class="" href="#"> <img class="" src="/backend/img/upload_icon.png" /> <b>Click to upload image</b> </a>
            </div>
            <div id="j-details" class="j-details"></div>
         </div>
      </div>
   </div>
   <h5 class="mt-5">Rules</h5>
   <div class="row">
      <div class="col-sm-6 col-lg-3">
         <ul class="list-group list-group-no-border">
            @foreach($rules as $rule)
            <li class="list-group-item px-0 pt-0 pb-2">
               <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" value="{{ $rule->id }}" name="attribute_id[]" id="{{ $rule->name }}-{{ $counter }}" />
                  <label class="custom-control-label" for="{{ $rule->name }}-{{ $counter }}">{{ $rule->name }}</label>
               </div>
            </li>
            @endforeach 
         </ul>
      </div>
   </div>
   <h5>Extra Services</h5>
   <div class="row">
      <div class="col-sm-6 col-lg-6">
         <ul class="list-group list-group-no-border">
            @foreach($extra_services as $extra_service)
            <li class="list-group-item px-0 pt-0 pb-2">
               <div class="d-flex">
                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" value="{{ $extra_service->id }}" name="attribute_id[]" id="{{ $extra_service->name }}-{{ $counter }}" />
                     <label class="custom-control-label" for="{{ $extra_service->name }}-{{ $counter }}">{{ $extra_service->name }}</label>
                  </div>
                  <div class="ml-3 col-md-3">
                     <div class="form-group">
                        <input name="extra_services_price[{{ $extra_service->id }}]" type="number" class="form-control" id="" placeholder="Price   " /> 
                        optional
                     </div>
                  </div>
            </li>
            @endforeach 
         </ul>
         </div>
      </div>
      <h5>Facilities</h5>
      <div class="row">
         <div class="col-sm-6 col-lg-6">
            <ul class="list-group list-group-no-border">
               @foreach($facilities as $facility)
               <h4>{{ $facility->name }}</h4>
               <li class="list-group-item px-0 pt-0 pb-2">
                  @foreach($facility->children->sortBy('name') as $child)
                  <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input" value="{{ $child->id }}" name="facility_id[]" id="{{ $child->name }}-{{ $counter }}" />
                     <input type="hidden" name="parent_id[]" value="{{ $facility->id }}"  />
                     <label class="custom-control-label" for="{{ $child->name }}-{{ $counter }}">{{ $child->name }}</label>
                  </div>
                  @endforeach
               </li>
               @endforeach 
            </ul>
         </div>
      </div>
</section>
</div>