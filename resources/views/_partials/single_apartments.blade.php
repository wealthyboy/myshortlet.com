<div class="name  rounded mt-1 bg-white">
    <div class="card-body">
        <form action="/book/{{ $property->slug }}" method="GET" class="">
        <input type="hidden" name="apartment_quantity[{{ $property->single_room->uuid }}]" id="qty">
        <div class="d-flex pb-3 border-bottom mb-3 justify-content-between">
            @if( $property->single_room->discounted_price)
                <div class="">
                    <div><del>{{ $property->currency }} {{ $property->single_room->converted_price }}</del></div>
                    <span>{{ $property->currency }}{{ number_format($property->single_room->discounted_price) }}</span><span>  per night</span>
                </div>
                <div class=""> {{ $property->single_room->percentage_off }}% off</div>
            @else
                <div class="">
                    <span>{{ $property->currency }}{{ $property->single_room->converted_price }}</span><span>  per night</span>
                </div>
            @endif
        </div>
        <div class="mb-4"><i class="fas fa-info-circle mr-2"></i>Non - refundable</div>
        <div class="form-row mt-2">
            @if ($date && $property_is_not_available) 
                <div class="text-danger mb-2">This property is not available for your selected date. Try changing your dates</div>
            @endif

            <div class="form-group form-border search border rounded pl-2 col-md-12">
                @include('_partials.date')
            </div>
        </div>

        @if (!$property_is_not_available) 
            <div>
                <ul class="list-unstyled mb-4 ">
                    <li class="d-flex justify-content-between lh-22">
                    <p class="text-gray-light mb-0">{{ 3 }} nights </p>
                    @if( $property->single_room->discounted_price)
                        <p class="font-weight-500 text-heading mb-0">{{ $property->currency }} {{ $property->single_room->discounted_price * $days }}</p>
                    @else
                        <p class="font-weight-500 text-heading mb-0">{{ $property->currency }} {{ $property->single_room->converted_price }}</p>
                    @endif
                    </li>
                </ul>
            </div>

            <div class="card-footer pt-4 bg-transparent d-flex justify-content-between p-0 align-items-center">
                <p class="text-heading mb-0">Total Price:</p>
                @if( $property->single_room->discounted_price)
                    <span class="fs-32 font-weight-bold text-heading total-price">{{ $property->currency }} {{ $property->single_room->discounted_price * $days }}</span>
                @else
                    <span class="fs-32 font-weight-bold text-heading total-price">{{ $property->currency }} {{ $property->single_room->converted_price * $days }}</span>
                @endif
            </div>

            <button type="submit"   class=" btn btn-primary btn-round  mt-3  btn-block">
                <div class="auth-spinner d-none">
                    @include('_partials.spinner',['bgcolor' => '#ffffff'])
                </div> 
                <span class="lt">Reserve</span> 
            </button>
        @endif

        </form>


    </div>
</div>