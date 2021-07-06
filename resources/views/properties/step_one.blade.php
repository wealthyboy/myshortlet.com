
<section>
   <h2>Title</h2>
   <form  class="form-row" method="POST"  action="{{ route('properties.store',['type'=>$type,'step' => 'two']) }}">
       @csrf
      <div class="col-md-7">
         <div class="form-group">
            <label for="apartment_name">Title </label>
            <input type="text" name="apartment_title" class="form-control" id="apartment_title" placeholder="" />
         </div>
         <div class="form-group">
            <label for="address">Address </label>
            <input type="text" class="form-control" name="address" id="address" placeholder="" />
         </div>
         <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
         </div>

         
         <div class="form-row">
            
            <div class="form-group col-md-4">
               <label for="location-state">State</label>
               <select  name="location_id[]" id="location-state" class="form-control">
                  <option value="0" selected>Choose...</option>
                  @foreach($locations as $location)
                     <option value="{{ $location->id }}">{{ $location->name  }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group col-md-4">
               <label for="location-city">City</label>
               <select  name="location_id[]" id="location-city" class="form-control">
                  <option value="0" selected>Choose...</option>
               </select>
            </div>

            <div class="form-group col-md-4">
               <label for="location-town">Town</label>
               <select name="location_id[]" id="location-town" class="form-control">
                  <option selected>Choose...</option>
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
            <div class=" upload-text">
               <a class="" href="#">
               <img class="" src="/backend/img/upload_icon.png" />
               <b>Add a cover image</b>
               <p>This image will shown</p>
               </a>
            </div>
            <div id="j-details" class="j-details">
               
            </div>
         </div>
         <div class="information">
            <div class="information-box border"></div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-row">
            <div class=" col-md-6">
               <a href="{{ route('properties.create',['type' => $type, 'step' => null ]) }}" class="btn btn-lg text-secondary btn-accent">
                  <i class="far fa-long-arrow-left ml-1"></i>
                  Prev
               </a>
            </div>
            <div class=" col-md-6 text-right">
               <button
                  type="submit"
                  class="btn btn-lg text-secondary btn-accent"
                  >
               Next
               <i class="far fa-long-arrow-right ml-1"></i>
               </button>
            </div>
         </div>
      </div>
   </form>
</section>
