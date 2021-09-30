@if( $property->type != 'single' )
    <?php  $multiple_rooms =  $property->multiple_rooms ?>
    <div class="price-box">
        <div class="d-inline-flex ">
            @if ( optional($multiple_rooms[0])->discounted_price )
                <div class="">{{ $property->currency }}{{ $multiple_rooms[0]->discounted_price }}</div>
                <div class="">{{ $property->currency }}{{ $multiple_rooms[0]->price }}</div>
            @else
                <div class="">{{ $property->currency }}{{ $multiple_rooms[0]->price }}</div>
            @endif
        </div>
        <div>per night</div> 
    </div> 
    @else
        <div class="d-inline-flex">
            @if ( optional($property->single_room)->discounted_price )
                <div>{{ $property->currency }}{{ optional($property->single_room)->price  }}</div>
                <div>{{ $property->currency }}{{ optional($property->single_room)->discounted_price }}</div>
            @else
                <div>{{ $property->currency }}{{ optional($property->single_room)->price  }}</div>
            @endif
        </div>
        <div>per night</div>
    @endif
    @if( $property->is_refundable )
        <div class=""> Fully Refundable</div>
    @else
        <div class=""> Non - Refundable</div>
    @endif