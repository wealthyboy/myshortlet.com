<form method="GET" action="/property/search">
    <div class="row no-gutters">
        <div class="col-md-3 pr-1">
            <div class="form-group search border pl-2">
                <label class="pl-2" for="Location-input">Location</label>
                <input type="text" class="form-control" name="going_to" value="{{ request()->going_to }}" id="Location-input" placeholder="Where are you going">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group  search border pl-2">
                <label  class="pl-2" for="flatpickr-input-f">Check-in - Check-out </label>
                <input type="text" name="check_in_check_out" class="form-control" id="flatpickr-input-f" value="{{ request()->check_in_check_out }}" placeholder=" Add Dates">
            </div>
        </div>
        <div id="people-number" class="col-md-4 cursor-pointer">
           <div  class="people-number  border pl-2 pb-1 ">
               <div  class="pl-1">Rooms and Guests</div>
                <div class="people-dropdown-info">
                   <span class="adults">1</span>  adults 
                   <span class="children">1</span> children -
                   <span class="rooms">1</span>  rooms 
                </div>
            </div>
            <div style="min-width: 100%; z-index: 1; background: #ffffff; opacity: 0;" id="people-dropdown" class="people-dropdown d-none pl-4 pt-3 pb-4 pr-4 position-absolute  border">
                <div class=" d-flex p-2 justify-content-between">
                    <div class="text-left">
                        <div class="" id="">Adults</div>
                        <div class="text-muted " id="">Ages 13 or above</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button
                            type="button"
                            disabled=""
                            aria-label="decrease value"
                            aria-describedby=""
                            class="mr-3 cursor-pointer add-subtract  min-adults"
                            data-name="adults"
                            data-math="minus"

                            >
                            <span class=""><i class="fas fa-minus"></i></span>
                        </button>
                        <div class="">
                            <span  aria-hidden="true" class="adults">0</span>
                        </div>
                        <button                             
                            data-math="add"
                            data-name="adults" 
                            data-number="1"  
 
                            class="ml-3 cursor-pointer add-subtract"  type="button">
                            <span class="">
                                <i class="far fa-plus"></i>
                            </span>
                        </button>

                    </div>
                </div>

                <div class=" d-flex p-2  justify-content-between">
                    <div class="text-left">
                        <div class="" id="">Children</div>
                        <div class="text-muted" id="">0 to 13 </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button
                            type="button"
                            disabled=""
                            aria-label="decrease value"
                            aria-describedby=""
                            class="mr-3 min-children cursor-pointer  add-subtract"
                            data-name="children"
                            data-math="minus"
                        >
                            <span ><i class="fas fa-minus"></i></span>
                        </button>
                        <div class="">
                            <span class="children" aria-hidden="true">0</span>
                        </div>
                        
                        <button                             
                            data-math="add"
                            data-number="1"
                            data-name="children"  class="ml-3 cursor-pointer add-subtract"  type="button">
                            <span class="">
                                <i class="far fa-plus"></i>
                            </span>
                        </button>

                    </div>
                </div>

                <div class=" d-flex  p-2 justify-content-between">
                    <div class="text-left">
                        <div class="" id="">Rooms</div>
                        <div class="text-muted " id="">Ages 13 or above</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button
                            type="button"
                            disabled=""
                            aria-label="decrease value"
                            aria-describedby=""        
                            data-math="minus"
                            data-name="rooms"
                            class="mr-3 min-rooms cursor-pointer add-subtract"
                            >
                            <span class=""><i class="fas fa-minus"></i></span>
                        </button>
                        <div class="">
                            <span class="rooms" aria-hidden="true">0</span>
                        </div>
                        

                        <button                             
                            data-math="add"
                            data-number="0"  
                            data-name="rooms"  
                            class="ml-3 cursor-pointer add-subtract"  type="button">
                            <span class="">
                                <i class="far fa-plus"></i>
                            </span>
                        </button>

                    </div>
                </div>
            </div>

            <input type="hidden"  name="rooms"  value="1"/>
            <input type="hidden"  name="children" />
            <input type="hidden"  name="adults" value="1"  />
            
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block">
            <i class="material-icons">search</i> Search
            </button>
        </div>
    </div>
</form>
