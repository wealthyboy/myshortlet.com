
<section  id="section" class="fadeInRight animated">
   <h2>Title</h2>
   @if(isset($apartment) && isset($update))
   <form  class="form-row" method="POST"  action="{{ route('properties.update',['property'=>$apartment->id,'type'=>$type, 'step' => 'two', 'token' => request()->token,  'back_one' => request()->back_one ])  }}">

   @else
    <form  class="form-row r" method="POST"  action="{{ route('properties.store',['type'=>$type,'step' => 'two', 'token' => request()->token,  'back_one' => request()->back_one ])  }}">
   @endif

      @csrf
      @if(isset($apartment)   && isset($update) )
         @method('PATCH')
      @endif


      <div class="col-md-7">
         <div class="form-group">
            <label for="apartment_name">Title </label>
            <input type="text" name="apartment_title" value="{{ isset($apartment) ? $apartment->name :  old('apartment_title') }}" class="form-control" id="apartment_title" placeholder="" />
         </div>
         <div class="form-group">
            <label for="address">Address </label>
            <input type="text" class="form-control" name="address" value="{{ isset($apartment) ? $apartment->address :  old('address') }}" id="address" placeholder="" />
         </div>
         <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5">{{ isset($apartment) ? $apartment->description :  old('description') }}</textarea>
         </div>

         
         <div class="form-row">
            
            <div class="form-group col-md-4">
               <label for="location-state">State</label>
               <select  name="location_id[]" id="location-state" class="form-control">
                  <option value="" >Choose...</option>
                  @foreach($locations as $location)
                  @if(isset($apartment)   && isset($update)  && $location->id == optional(optional($apartment->states)->first())->id )
                     <option value="{{ $location->id }}" selected>{{ $location->name  }}</option>
                     @else
                     <option value="{{ $location->id }}">{{ $location->name  }}</option>
                     @endif
                  @endforeach
               </select>
            </div>
            <div class="form-group col-md-4">
               <label for="location-city">City</label>
               <select  name="location_id[]" id="location-city" class="form-control">
                  <option value="">Choose...</option>
                  
               </select>
            </div>

            <div class="form-group col-md-4">
               <label for="location-town">Town</label>
               <select name="location_id[]" id="location-town" class="form-control">
                  <option value="">Choose...</option>
                     
               </select>
            </div>
         </div>
      </div>
      <div class="col-md-4">
        <div class="info">Add an image</div>
         <div id="j-drop" class=" j-drop">
            <input
               accept="image/*"
               class="upload_input"
               data-msg="Upload  your image"
               type="file"
               name="img"
               onchange="getFile(this,'image','Apartment',false)"
            />
            <div class=" upload-text   {{ isset($apartment) &&  $apartment->image ? 'hide' : ''}}">
               <a class="" href="#">
               <img class="" src="/backend/img/upload_icon.png" />
               <b>Add a cover image</b>
               <p>This image will shown</p>
               </a>
            </div>
            <div id="j-details" class="j-details">
               @if(isset($apartment))
                     <div id="{{ $apartment->id }}" class="j-complete">
                        <div class="j-preview">
                           <img class="img-thumnail" src="{{ $apartment->image }}">
                           <div id="remove_image" class="remove_image remove-image">
                                 <a class="remove-image"  data-id="{{ $apartment->id }}" data-randid="{{ $apartment->id }}" data-model="Image" data-type="complete"  data-url="{{ $apartment->image }}" href="#">Remove</a>
                                 <input type="hidden" class="file_upload_input stored_image_url" value="{{ $apartment->image }}" name="image">
                           </div>
                        </div>
                     </div>
               @endif
            </div>
         </div>
         <div class="information">
            <div class="information-box border"></div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-row">
            @if( isset($apartment)  && !request()->token )
            <div class=" col-md-12 text-right">
               <button
                  type="submit"
                  class="btn btn-lg text-secondary btn-accent"
                  >
               Next
               <i class="far fa-long-arrow-right ml-1"></i>
               </button>
            </div>

            @else
            
            <div class=" col-md-6">
               <a href="{{ route('properties.create',['type' => $type, 'step' => null, 'token' => request()->token ]) }}" class="btn btn-lg text-secondary btn-accent">
                  <i class="far fa-long-arrow-left ml-1"></i>
                  Prev
               </a>
            </div>

            <div class=" col-md-6 text-right">
               <button
                  type="submit"
                  id="next-button"
                  class="btn btn-lg text-secondary btn-accent"
                  >
               Next
               <i class="far fa-long-arrow-right ml-1"></i>
               </button>
            </div>
            @endif
         </div>
      </div>
   </form>
</section>


