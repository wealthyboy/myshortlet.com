<form method="" action="">
    <div class="row no-gutters">
        <div class="col-md-3 pr-1">
            <div class="form-group search border pl-2">
                <label class="pl-2" for="Location-input">Location</label>
                <input type="text" class="form-control" id="Location-input" placeholder="Where are you going">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group  search border pl-2">
                <label  class="pl-2" for="flatpickr-input-f">Check-in - Check-out</label>
                <input type="text" class="form-control" id="flatpickr-input-f" placeholder="Add Dates">
            </div>
        </div>
        <div class="col-md-3 cursor-pointer">
           <div class="people-number  border pl-2 pb-1 cursor-pointer">
               <div  class="pl-1">Rooms and Guests</div>
                <div class="people-dropdown-info">
                    3 guests
                </div>
            </div>
            <div class="people-dropdown">
                <div class="adults d-flex  justify-content-between">
                    <div class="text-left">
                        <div class="" id="">Adults</div>
                        <div class="text-muted " id="">Ages 13 or above</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button
                            type="button"
                            disabled="adults == 0"
                            aria-label="decrease value"
                            aria-describedby=""
                            class="mr-3 cursor-pointer"
                            >
                            <span class=""><i class="fas fa-minus"></i></span>
                        </button>
                        <div class="">
                            <span aria-hidden="true">00</span>
                        </div>
                        <button class="ml-3 cursor-pointer"  type="button">
                            <span class="">
                                <i class="far fa-plus"></i>
                            </span>
                        </button>

                    </div>
                </div>
                
            </div>
            
        </div>
        <div class="col-md-2 bmd-form-group">
            <button type="button" class="btn btn-primary btn-block">
            <i class="material-icons">search</i> Search
            </button>
        </div>
    </div>
</form>