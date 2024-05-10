<div class="row p-attr mb-2 variation-panel">
    <div class="col-md-9 col-xs-9 col-sm-9">
    </div>
    <div class="col-md-3 col-xs-12 text-right border col-sm-12 pt-2 pb-4">
        <a href="#" title="remove panel" class="remove-panel"><i class="fa fa-trash-o"></i> Remove</a> |
        <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a>
    </div>

    <div id="variation-panel" data-id="{{ $counter }}" class="hide v-panel">
        <div class="clearfix"></div>
        <div class="col-md-12">
            <input name="has_more_room" value="1" class="" type="hidden">
            <input name="new_room" value="1" class="" type="hidden">
            <div class="col-md-4">
                <div class="form-group label-floating is-ty">
                    <label class="control-label">Accommodation Type Name</label>
                    <input name="room_name[{{ $counter }}]" required="true" value="" class="form-control  variation" type="text">
                    <span class="material-input"></span>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select name="price_mode[{{ $counter }}]" id="" required="true" class="form-control">
                        <option value="">Price Mode</option>
                        <option value="per night">Per night</option>
                        <option value="per week"> Per week</option>
                        <option value="per month">Per month</option>
                        <option value="per year"> Per year</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select name="apartment_id[{{ $counter }}]" id="" required="true" class="form-control">
                        <option value="">Apartment</option>
                        @foreach($room_ids as $key => $room_id)
                        <option value="{{ $room_id->id }}">{{ $room_id->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>



            <div class="col-md-2">
                <div class="form-group">
                    <select name="room_quantity[{{ $counter }}]" name="quantity" id="" required="true" class="form-control">
                        <option value="" selected>Select Quantity</option>
                        @for ($i = 1; $i< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select name="room_number[{{ $counter }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                        <option value="" selected>Choose Bedrooms</option>
                        @for ($i = 1; $i< 10; $i++) <option value="{{ $i }}"> {{ $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <select required="required" name="room_toilets[{{ $counter }}]" id="children" class="form-control">
                        <option value="" selected>Choose Toilets</option>
                        @for ($i = 1; $i< 10; $i++) @php $value=$i * 0.5; @endphp <option value="{{ $value }}"> {{ $value }}</option>
                            @endfor
                    </select>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Total Guests</label>
                    <input name="room_max_adults[{{ $counter }}]" required="true" value="" class="form-control   variation" type="number">
                </div>
            </div>

            <!-- <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Max Children</label>
                    <input name="room_max_children[{{ $counter }}]" required="true" value="" class="form-control   variation" type="number">
                </div>
            </div> -->

            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Price per/night</label>
                    <input name="room_price[{{ $counter }}]" required="true" value="{{ old('price') }}" class="form-control   variation" type="number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group label-floating is-empty">
                    <label class="control-label">Sale Price</label>
                    <input name="room_sale_price[{{ $counter }}]" value="" class="form-control variation_sale_price variation" type="number">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group label-floating">
                    <label class="control-label">End Date</label>
                    <input class="form-control  datepicker pull-right" name="room_sale_price_expires[{{ $counter }}]" id="datepicker" type="text">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <label class="control-label">Image Links</label>
                    <textarea rows="20" name="room_image_links[{{ $counter }}]" class="form-control  variation" type="text"></textarea>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <label class="control-label">Video Links</label>
                    <input class="form-control   pull-right" name="room_video_links[{{ $counter }}]" type="text">
                </div>
            </div>



            <div class="col-md-12 bed mb-5">
                @if ($bedrooms->count())
                @foreach($bedrooms as $key => $parent)
                <div class="bedroom-{{ $key + 1 }} d-none mb-2">
                    <div class="mb-2">{{ $parent->name }} </div>
                    @foreach($parent->children as $bedroom)
                    <label for="bedroom-{{ $bedroom->id }}-{{ $counter }}" class="radio-inline">
                        <input class="radio-button" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $counter }}" name="{{ $parent->slug }}_{{ $counter }}" type="radio" name="optradio">{{ $bedroom->name }}
                        <div class="bed-count form-group">
                            <input name="bed_count[{{ $counter }}][{{ $bedroom->id }}]" placeholder="Number of beds" class="form-control" value="" type="number">
                        </div>
                    </label>
                    @endforeach
                </div>
                @endforeach
                @endif
            </div>


            <div class="clearfix"></div>

            <div class="col-sm-12">
                <div id="j-drop" class="j-drop">
                    <input accept="image/*" required="true" data-msg="Upload  at least 5 images" onchange="getFile(this,'images[{{ $counter }}][]')" class="upload_input" multiple="true" type="file" id="upload_file_input" name="product_image" />
                    <div class=" upload-text  {{ $counter }}">
                        <a class="" href="#">
                            <img class="" src="/backend/img/upload_icon.png">
                            <b>Click on anywhere to upload image</b>
                        </a>
                    </div>
                    <div id="j-details" class="j-details"></div>
                </div>
            </div>


            <div class="col-md-12 mt-5 pr-5">
                @foreach( $apartment_facilities as $apartment_facility )
                <div>{{ $apartment_facility->name }}</div>
                @foreach($apartment_facility->children->sortBy('name') as $child)
                <div class="mt-2 mb-2">
                    <div class="togglebutton">
                        <label>
                            <input name="apartment_facilities_id[{{ $counter }}][]" value="{{ $child->id }}" type="checkbox">
                            <span class="toggle"></span>
                            {{ $child->name }}
                        </label>
                        @include('includes.loop',['obj'=>$child,'space'=>'&nbsp;&nbsp;'])
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>

            <div class="col-md-12 mt-1 pr-5 ">
                <h4 class="text-capitalize">Room Extras</h4>
                <!-- include('admin.apartments.extras',[
                    'obj' => '', 
                    'name' => 'multiple_apartment_extra_services',
                    'attribute_name' => 'multiple_apartment_extras',
                    'model' => 'apartment',
                    'variation' => true
                ]) -->


                @foreach($extras as $child)
                <div class="mt-2 mb-2">
                    <div class="togglebutton d-flex">
                        <label>
                            <input name="multiple_apartment_extras[{{ $counter }}][]" value="{{ $child->id }}" type="checkbox">
                            <span class="toggle"></span>
                            {{ $child->name }}
                        </label>
                        @include('includes.loop',['child'=>$child,'space'=>'&nbsp;&nbsp;','model' => 'Attribute','name' => 'attribute_id'])
                    </div>
                    <div class="extras-se  form-group">
                        <input name="multiple_apartment_extra_services[{{ $counter }}][{{ $child->id }}]" value="" placeholder="Leave blank if you want it free" class="form-control" type="number">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-6">
                    <legend>
                        Enable/Disabled
                    </legend>
                    <div class="form-check form-switch">
                        <input class="form-check-input" value="1" name="apartment_allow[{{ $counter }}]" type="checkbox" id="flexSwitchCheckChecked">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Enable/Disable</label>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>