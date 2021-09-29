    <legend>  
        Enable/Disabled
    </legend>
    <div class="togglebutton">
    <label>
        <input {{ isset($property) && optional($property->single_room)->is_occupied == 1 ? 'checked' : ''}}  name="is_occupied"  value="1" type="checkbox" >
        Ocuupied
    </label>
    </div>
