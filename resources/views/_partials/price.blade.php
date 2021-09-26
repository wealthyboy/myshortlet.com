@if( $property->apartments->count() && $property->apartments->count() >  1  )
    <span class="">From {{ $property->currency }}{{ optional($property->single_room)->price }} </span>
    @else
    <span class="">{{ $property->currency }}{{ optional(optional($property->apartments)->first())->price }}</span> 
    @endif
@if (!$property->allow_cancellation)
    <div class="">FREE CANCELLATION</div>
@endif