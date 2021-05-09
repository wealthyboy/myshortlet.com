
@if ($products->count())

@foreach($products as $product)

@if( !optional($product->product)->allow )
 @continue
@endif
<div  class="col-6   {{ isset($category_attributes) && $category_attributes->count() ? 'col-md-4' : 'col-md-3' }}">
    <div class="product-default inner-quickview inner-icon">
        <figure>
            <a href="{{ optional($product)->link }}">
                <img src="{{ $product->image_to_show_m }}" alt="{{ $product->product_name }}" />
            </a>
            <div class="btn-icon-group"></div>
            <!-- <a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="btn-quickvie" title="Quick View">Quick View</a>  -->
        </figure>
        
        <div class="product-details">
            <div class="">
                @if(optional($product->product)->colours->count())
                    <div  class="justify-content-start d-flex mb-1">
                        @foreach($product->product->colours as $color)
                        
                            @if( $color->image)
                                <div style="border:{{ optional($product->active_color)->color_code == $color->color_code ? '1.5px' : '1px' }} solid #CCC; height: 12px; width: 12px; border-radius: 50%; background-size: cover;  background-image: url({{ $color->image }})" class="mr-1"></div>
                            @else
                                <div style="border:{{ optional($product->active_color)->color_code == $color->color_code ? '1.5px' : '1px' }} solid #CCC; height: 12px; width: 12px; border-radius: 50%; background-color: {{  $color->color_code }}" class="mr-1"></div>
                            @endif 
                        @endforeach
                    </div>
                @endif
                @if($product->brand_name)
                    <div  class="product-brand bold">
                        {{ $product->brand_name }}
                    </div>
                @endif
                <div class=" d-lg-flex d-xl-flex color--primary">
                    <div class="text-left  mr-5">
                        <a href="{{ $product->link }}">{{ $product->name }}</a>
                    </div> 
                    <div class="text-right">
                        @if( $product->default_discounted_price)
                            <span class="old-price bold">{{ $product->currency }}{{ number_format($product->converted_price)   }}</span>
                            <span class="product-price bold text-danger">{{ $product->currency }}{{ number_format($product->default_discounted_price) }}</span>
                        @else
                            <span class="product-price bold">{{ $product->currency }}{{ number_format($product->converted_price)}}</span>
                        @endif
                    </div><!-- End .price-box -->
                </div>
            </div>
        </div><!-- End .product-details -->
    </div>

</div><!-- End .col-sm-4 -->
@endforeach

@else
    <div class="col-12 d-flex justify-content-center">
        <div class="text-center pb-3">
            <img  width="200" height="200" src="/images/utilities/empty_product.svg" /> 
            <p class="bold">No products found</p>
        </div>
    </div>
@endif


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

   

