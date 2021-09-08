<section  class="fadeInRight animated">

@if(isset($apartment) && isset($update))
      <form  class="form-row" method="POST"  action="{{ route('properties.update',['property'=>$apartment->id,'type'=>$type, 'step' => 'finish', 'token' => request()->token,  'back_one' => request()->back_one ])  }}">
   @else
     <form  method="POST"  class="form-row" action="{{ route('properties.store',['type'=>$type,'step' => 'finish','token' => request()->token]) }}">
   @endif

   @csrf
   @if(isset($apartment)   && isset($update) )
      @method('PATCH')
   @endif

        @if ($apartment->rooms->count())
        @foreach($apartment->rooms as $k => $room)
        <div  class="row p-attr w-100 border p-3  mb-1  variation-panel">
            <div class="col-md-12 col-xs-12 text-right  col-sm-12 "> 
                <a href="/admin/room/{{ $room->id }}/delete"   title="remove panel" class="delete-panel"><i class="fa fa-trash-o"></i> Remove</a>  |
                <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-plus"></i> Expand</a> 
             </div>
            <section id="variation-panel"   class="v-panel w-100 hide">
                <div class="row">
                    @if ($type == 'multiple')
                    <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Apartment Title  {{ $room->id }}</label>
                        <input type="text" name="edit_apartment_name[{{ $room->id }}]" value="{{ $room->name }}" class="form-control" id="" placeholder="" /> 
                    </div>
                    </div>
                    @endif
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="bedrooms">Bedrooms</label>
                        <select  name="edit_apartment_bedrooms[{{ $room->id }}]" name="bedrooms" id="bedrooms" class="form-control  bedrooms">
                            <option value="" selected>Choose...</option>
                            @for ($i = 1; $i< 5; $i++) 
                               @if($room->no_of_rooms == $i)
                               <option value="{{ $i }}" selected> {{ $i }}</option>
                               @else
                                <option value="{{ $i }}"> {{ $i }}</option>
                               @endif
                            @endfor 
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="adults">Adults</label> {{ $room->max_adults}}
                        <select name="edit_apartment_adults[{{ $room->id }}]" id="adults" class="form-control">
                            <option value="" selected>Choose...</option>
                            @for ($i = 1; $i < 11; $i++) 
                               @if($room->max_adults == $i)
                               <option value="{{ $i }}" selected> {{ $i }}</option>
                               @else
                                <option value="{{ $i }}"> {{ $i }}</option>
                               @endif
                            @endfor 
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="children">Children</label>
                        <select name="edit_apartment_children[{{ $room->id }}]" id="children" class="form-control">
                            <option  value="" selected>Choose...</option>
                            @for ($i = 1; $i< 11; $i++) 
                               @if($room->max_children == $i)
                               <option value="{{ $i }}" selected>{{ $i }}</option>
                               @else
                                <option value="{{ $i }}">{{ $i }}</option>
                               @endif
                            @endfor 
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Price</label>
                        <input name="edit_apartment_price[{{ $room->id }}]" type="number" value="{{  $room->price  }}" class="form-control" id="" placeholder="" /> 
                    </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="form-group">
                        <label for="children">Toilets</label>
                        <select name="edit_apartment_toilets[{{ $room->id }}]" id="children" class="form-control">
                            <option  value="" selected>Choose...</option>
                            @for ($i = 1; $i< 4; $i++) 
                               @if($room->toilets == $i)
                               <option value="{{ $i }}" selected> {{ $i }}</option>
                               @else
                                <option value="{{ $i }}"> {{ $i }}</option>
                               @endif
                            @endfor 
                        </select>
                    </div>
                    </div>
                    <div class="col-md-12 bed mb-5">
                    @if ($bedrooms->count())

                    @foreach($bedrooms as $key =>  $parent)

                        @if ($room->no_of_rooms > $key  )
                        <div class="bedroom-{{ $key + 1 }} mt-3">
                            <h6> {{ $parent->name }} </h6>
                            <div class="d-flex flex-grow-1">
                                    @foreach($parent->children as $bedroom)
                                    <div class="custom-control custom-radio mr-3">
                                        <input {{  $room->bedrooms->contains($bedroom) ? 'checked' : ''}} type="radio" class="custom-control-input"  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}-{{ $room->id }}" name="{{ $parent->slug }}_{{ $room->id }}"  />
                                        <label class="custom-control-label" for="bedroom-{{ $bedroom->id }}-{{ $room->id }}">{{ $bedroom->name }}</label>
                                    </div>
                                    @endforeach

                            </div>
                        </div>

                        @else
                        <div class="bedroom-{{ $key + 1 }} d-none mt-3">
                            <h6> {{ $parent->name }} </h6>
                            <div class="d-flex flex-grow-1">

                                    @foreach($parent->children as $bedroom)
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" class="custom-control-input"  value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $counter }}"  />
                                        <label class="custom-control-label" for="bedroom-{{ $bedroom->id }}">{{ $bedroom->name }}</label>
                                    </div>
                                    @endforeach

                            </div>
                        </div>

                        @endif

                    @endforeach

                    @endif
                    </div>
                    <div class="col-md-12">
                    <div id="j-drop" class="j-drop">
                        <input accept="image/*"   onchange="getFile(this,'new_apartment_images[{{ $room->id }}][]')" class="upload_input"  multiple="true"   type="file" id="upload_file_input" name="product_image"  />
                        <div   class=" upload-text {{ $room->images->count() ||  $room->image ? 'hide' : ''}}"> 
                            <a class="" href="#"> 
                                <img class="" src="/backend/img/upload_icon.png" /> 
                                <b>Click to upload image</b> 
                            </a>
                        </div>
                        <div id="j-details"  class="j-details">
                        @if($room->images->count())
                            @foreach($room->images as $image)
                                <div id="{{ $image->id }}" class="j-complete">
                                    <div class="j-preview">
                                        <img class="img-thumnail" src="{{ $image->image }}">
                                        <div id="remove_image" class="remove_image remove-image">
                                            <a class="remove-image"  data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete"  data-url="{{ $image->image }}" href="#">Remove</a>
                                            <input type="hidden" class="file_upload_input stored_image_url" value="{{ $image->image }}" name="edit_apartment_images[{{ $room->id }}][]">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
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
                                <input type="checkbox" 
                                  {{ $helper->check($room->attributes , $rule->id) ? 'checked' : '' }} 
                                   class="custom-control-input" value="{{ $rule->id }}" name="attribute_id[]" id="{{ $rule->name }}-{{ $room->id }}" 
                                />
                                <label class="custom-control-label" for="{{ $rule->name }}-{{ $room->id }}">{{ $rule->name }}</label>
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
                                <input type="checkbox" 
                                {{ $helper->check($room->attributes , $extra_service->id) ? 'checked' : '' }} 
                                    class="custom-control-input" value="{{ $extra_service->id }}" name="attribute_id[]" id="{{ $extra_service->name }}-{{ $room->id }}" />
                                <label class="custom-control-label" for="{{ $extra_service->name }}-{{ $room->id }}">{{ $extra_service->name }}</label>
                                </div>
                                <div class="ml-3 col-md-3">
                                    <div class="form-group">
                                        <input name="extra_services_price[{{ $extra_service->id }}][{{ optional($extra_service->attribute_price)->id }}]" type="number" value="{{ optional($extra_service->attribute_price)->price }}" class="form-control" id="" placeholder="Price   " /> 
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
                                <input type="checkbox" 
                                {{ $helper->check($room->attributes , $child->id) ? 'checked' : '' }} 

                                class="custom-control-input" value="{{ $child->id }}" name="facility_id[]" id="{{ $child->name }}-{{ $room->id }}" />
                                <input type="hidden" name="parent_id[]" value="{{ $facility->id }}"  />
                                <label class="custom-control-label" for="{{ $child->name }}-{{ $room->id }}">{{ $child->name }}</label>
                                </div>
                                @endforeach
                            </li>
                            @endforeach 
                        </ul>
                    </div>
                    </div>
            </section>
        </div>
        @endforeach

        
        @else


        <div  class="row p-attr w-100 border p-3  mb-1  variation-panel">
            <div class="col-md-12 col-xs-12 text-right  col-sm-12 ">  
                <a href="#" title="open/close panel" class="open-close-panel"><i class="fa fa-minus"></i> Hide</a> 
            </div>
            <section id="variation-panel"   class="v-panel w-100">
                <div class="row">
                    @if ($type == 'multiple')
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Apartment Title </label>
                            <input type="text" name="apartment_name[{{ $counter }}]" class="form-control" id="" placeholder="" /> 
                            <input name="new_room"     value="1"   class="" type="hidden">
                        </div>
                    </div>
                    @endif
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
                    <div class="col-md-12 bed mb-5">
                    @if ($bedrooms->count())
                    @foreach($bedrooms as $key =>  $parent)
                    <div class="bedroom-{{ $key + 1 }} d-none">
                        <h6>{{ $parent->name }}</h6>
                        <div class="d-flex flex-grow-1">
                            @foreach($parent->children as $bedroom)
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" class="custom-control-input" value="{{ $bedroom->id }}" id="bedroom-{{ $bedroom->id }}" name="{{ $parent->slug }}_{{ $counter }}"  />
                                <label class="custom-control-label" for="bedroom-{{ $bedroom->id }}">{{ $bedroom->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @endif
                    </div>
                    <div class="col-md-12">
                    <div id="j-drop" class="j-drop">
                        <input accept="image/*" required="true" onchange="getFile(this,'apartment_images[{{ $counter }}][]')" class="upload_input" data-msg="Upload  your image" type="file" name="img" />
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
                                <input type="checkbox" class="custom-control-input" value="{{ $rule->id }}" name="attribute_id[]" id="{{ $rule->name }}" />
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
                                   <input type="checkbox" class="custom-control-input" value="{{ $extra_service->id }}" name="attribute_id[]" id="{{ $extra_service->name }}" />
                                    <label class="custom-control-label" for="{{ $extra_service->name }}">{{ $extra_service->name }}</label>
                                </div>
                                <div class="ml-3 col-md-3">
                                    <div class="form-group">
                                        <input name="extra_services_price[{{ $extra_service->id }}]" type="number" class="form-control" id="" placeholder="Price   " /> 
                                        optional
                                    </div>
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
                                <input type="checkbox" class="custom-control-input" value="{{ $child->id }}" name="facility_id[]" id="{{ $child->name }}" />
                                <input type="hidden" name="parent_id[]" value="{{ $facility->id }}"  />
                                <label class="custom-control-label" for="{{ $child->name }}">{{ $child->name }}</label>
                                </div>
                                @endforeach
                            </li>
                            @endforeach 
                        </ul>
                    </div>
                    </div>
            </section>
        </div>


        @endif
        
      <div class="clearfix"></div>
      <div class="new-apartment"></div>
      @if ($type === 'multiple')
      <div class="row mt-5 w-100">
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
      @endif
      <div   class="row  w-100 mt-5">
         <div class="col-md-6">
            <a href="{{ route('properties.create',['type' => $type, 'step' => 'two','token' => request()->token, 'back_two' => request()->user()->id]) }}" class="btn btn-lg text-secondary btn-accent text-left">
            <i class="far fa-long-arrow-left ml-1"></i>
            Prev
            </a>
         </div>
         <div class="col-md-6 text-right">
            <button type="submit" class="btn btn-lg text-secondary btn-accent text-right">
            Finish
            <i class="far fa-long-arrow-right ml-1"></i>
            </button>
         </div>
      </div>
   </form>
</section>