<form  method="POST"  class="" action="{{ route('properties.store',['type'=>$type,'step' => 'finish','apartment_id' => request()->apartment_id]) }}">
    @csrf
    <div class="row p-attr border p-3  mb-1  variation-panel">
        <div class="col-md-12 col-xs-12 text-right  col-sm-12 ">  <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-minus"></i> Hide</a> </div>
        <section id="variation-panel" data-id="{{ $counter }}" class=" v-panel ">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Apartment Title </label>
                        <input type="text" name="apartment_name[{{ $counter }}]" class="form-control" id="" placeholder="" /> </div>
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
                            @for ($i = 1; $i< 11; $i++) <option value="{{ $i }}"> {{ $i }}</option> @endfor </select>
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
                            @for ($i = 1; $i< 4; $i++) <option value="{{ $i }}"> {{ $i }}</option> @endfor </select>
                    </div>
                </div>
                <div class="col-md-12 bed">
                    @for ($i = 1; $i< 5; $i++)
                    <div class="bedroom-{{ $i }}   d-none">
                        <h6>Bedroom {{ $i }}</h6>
                        <div class="d-flex flex-grow-1">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" class="custom-control-input" value="Single bed" id="bedroom-{{ $i }}-single-bed" name="bedroom-{{ $i }}[{{ $counter }}]"  />
                                <label class="custom-control-label" for="bedroom-{{ $i }}-single-bed">Single bed</label>
                            </div>
                            <div class="custom-control custom-radio mb-3 mr-3">
                                <input type="radio" class="custom-control-input" value="Double bed" id="bedroom-{{ $i }}-double-bed" name="bedroom-{{ $i }}[{{ $counter }}]"  />
                                <label class="custom-control-label" for="bedroom-{{ $i }}-double-bed">Double bed</label>
                                <div class="invalid-feedback">  </div>
                            </div>

                            <div class="custom-control custom-radio mb-3 mr-3">
                                <input type="radio" class="custom-control-input" value="Double bed" value="Large bed" id="bedroom-{{ $i }}-large-bed" name="bedroom-{{ $i }}[{{ $counter }}]"  />
                                <label class="custom-control-label" for="bedroom-{{ $i }}-large-bed">Large bed</label>
                                <div class="invalid-feedback">  </div>
                            </div>

                            <div class="custom-control custom-radio mb-3 mr-3">
                                <input type="radio" class="custom-control-input" value="King bed" id="bedroom-{{ $i }}-king-size-bed" name="bedroom-{{ $i }}[{{ $counter }}]"  />
                                <label class="custom-control-label" for="bedroom-{{ $i }}-king-size-bed">King size bed</label>
                                <div class="invalid-feedback">  </div>
                            </div>
                        </div>
                    </div>
                    @endfor
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
                                <input type="checkbox" class="custom-control-input" name="attribute_id[]" id="{{ $rule->name }}" />
                                <label class="custom-control-label" for="{{ $rule->name }}">{{ $rule->name }}</label>
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
                                <input type="checkbox" class="custom-control-input" name="attribute_id[]" id="{{ $extra_service->name }}" />
                                <label class="custom-control-label" for="{{ $extra_service->name }}">{{ $extra_service->name }}</label>
                            </div>

                            <div class="ml-3 col-md-3">
                                <div class="form-group">
                                <input name="price[{{ $counter }}]" type="number" class="form-control" id="" placeholder="Price   " /> 
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
                                @foreach($facility->children->sortBy('name') as $ob)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="attribute_id[]" id="{{ $ob->name }}" />
                                        <label class="custom-control-label" for="{{ $ob->name }}">{{ $ob->name }}</label>
                                    </div>
                                @endforeach
                            </li>
                        @endforeach 
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <div class="clearfix"></div>
    <div class="new-apartment"></div>

    <div class="row mt-5">
    <label class="col-md-12  col-xs-12 col-xs-12">
        <div class="text-right">
            <button type="button"  id="add-apartment" class="btn btn-round  btn-primary">
                Add Apartment
                <span class="btn-label btn-label-right">
                <i class="fa fa-plus"></i>
                </span>
            </button>
        </div>
    </label>
    </div>



    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('properties.create',['type' => $type, 'step' => 'two','apartment_id' => request()->apartment_id]) }}" class="btn btn-lg text-secondary btn-accent">
                <i class="far fa-long-arrow-left ml-1"></i>
                Prev
            </a>
        </div>
        <div class="col-md-6 text-right">
            <button type="submit" class="btn btn-lg text-secondary btn-accent">
                Finish
                <i class="far fa-long-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</form>
