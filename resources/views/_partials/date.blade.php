<label  class="pl-2" for="flatpickr-input-f">Check-in - Check-out</label>
<div class="input-group input-group-lg">
    <div class="input-group-prepend">
        <span
            class="input-group-text  border-0 text-muted fs-18"
            id="inputGroup-sizing-lg"
        >
            <i class="fal fa-calendar-week"></i>
        </span>
    </div>
    <input type="text" class="form-control ml-2"  value="{{ request()->check_in_checkout }}" name="check_in_checkout" id="flatpickr-input-f" placeholder="Add Dates">
</div>
