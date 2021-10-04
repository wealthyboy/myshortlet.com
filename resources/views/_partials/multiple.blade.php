
<div class="position-relative">
    @csrf
    <input type="hidden" name="property_id" value="{{ $property->id }}" />
    
    @if ($property->apartments->count())
        @foreach($property->apartments as $apartment)
        <div class="row border-bottom mb-1 mt-1 pl-1 pb-1">
            <div class="col-md-3 position-relative">
                <div class="">
                <img class="img  img-fluid" src="{{ $apartment->images[0]->image_m }}">
                </div>
            </div>
            <div class="col-md-7">
            <div> This property is not available on your selected fate</div>

                <div class="card-title">
                   <a href="#">{{ $apartment->name }}</a>
                </div>
                <div class=""><i class="fas fa-info-circle mr-2"></i>Instant Confirmation</div>
                <div class="entire-apartment">
                    @include('_partials.entire_apartments',['obj' => $apartment])
                </div>

                @if($property->facilities->count())
                    @foreach($property->facilities->take(3) as $facility)
                        <div class="position-relative ">
                           <span class="position-absolute svg-icon-section">
                                <?php echo  html_entity_decode($facility->svg) ?>
                            </span>
                            <span class="svg-icon-text">{{ $facility->name }}</span>
                        </div>
                        
                    @endforeach
                @endif


                @if( $apartment->free_services->count() )
                    <div class="d-inline-flex flex-wrap">
                    @foreach( $apartment->free_services as $free_service)
                    <div class="position-relative">
                        <span class="position-absolute svg-icon-section">
                            <?php echo  html_entity_decode($free_service->svg) ?>
                        </span>
                        <span class="svg-icon-text">{{ $free_service->name }} included</span>
                    </div>
                    @endforeach
                </div>
                @endif


                @if($bedrooms->count())
                    @foreach($bedrooms as $key => $beds)
                        @foreach($beds as $bed)
                        <div class="position-relative ">
                           <span class="position-absolute svg-icon-section">
                                <?php echo  html_entity_decode($bed->svg) ?>
                            </span>
                            <span class="svg-icon-text">{{ $key }}</span>    <span class="svg-icon-text">{{ $bed->pivot->bed_count }} {{ $bed->name }}</span>
                        </div>
                        @endforeach
                    @endforeach
                @endif

                <div class="">
                    @include('_partials.price')
                </div>
            
            </div>
            <div class="col-md-2 position-relative">
                <div class="form-group">
                    <label for="qty">Qty</label>
                    <select class="form-control" name="apartment_quantity[{{ $apartment->uuid }}]" id="qty">
                       <option value="">0</option>
                        @for($i = 1; $i <= $apartment->quantity; $i++ )
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
            </div>
        </div>
        @endforeach
    @endif
    
    <div>
    <ul class="list-unstyled mb-0 p-2">
        <li class="d-flex justify-content-between lh-22">
            <p class="text-gray-light mb-0">2nights</p>
            <p class="font-weight-500 text-heading mb-0">s</p>
        </li>
        <li class="d-flex justify-content-between lh-22">
            <p class="text-gray-light mb-0">Apartment</p>
            <p class="font-weight-500 text-heading mb-0">2</p>
        </li>
    </ul>
    </div>
        
    <div class="card-footer p-2  bg-transparent d-flex justify-content-between p-0 align-items-center">
    <p class="text-heading mb-0">Total Price:</p>
    <span class="fs-32 font-weight-bold text-heading total-price">0</span>
    </div>
    <button type="submit"   class="ml-1 btn btn-primary btn-round  mr-1 btn-block">
        <div class="auth-spinner d-none">
            @include('_partials.spinner',['bgcolor' => '#ffffff'])
        </div> 
        <span class="lt">Book now</span> 
    </button>

</div>