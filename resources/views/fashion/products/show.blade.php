@extends('fashion.layouts.app')
@section('content')

@include('fashion._partials.top_banner')




<div class="container-fluid mt-1">
    <div>
        <product-show :attributes="{{ $attributes }}"  :product="{{ $product}}" />
    </div>
    @if ( optional($product)->related_products->count() )

    <div class="products-section pt-0">
        <h2 class="">Related Products</h2>

        <div class="products-slider owl-carousel owl-theme dots-top">
            @foreach( $related_products as $related_product)

            <div class="product-default inner-quickview inner-icon">
                <figure>
                    <a href="{{ optional($related_product->product)->link }}">
                        <img src="{{ optional($related_product->product)->image_to_show_m }}">
                    </a>
                    @if (optional($related_product->product)->default_percentage_off)
                    <div class="label-group">
                        <span class="product-label label-sale">-{{ optional($related_product->product)->default_percentage_off }}%</span>
                    </div>
                    @endif
                    
                </figure>
                <div class="product-details text-center">
                    <div class="mx-auto">
                        <div class="color--primary">
                            <a href="{{ optional($related_product->product_variation)->link }}">{{ optional($related_product->product)->product_name }}</a>
                        </div>
                    </div>
                    <div class="price-box mx-auto mt-1">
                        @if (optional($related_product->product)->default_discounted_price ) 
                            <span class="old-price">{{ optional($related_product->product)->currency }}{{ number_format(optional($related_product->product)->converted_price)  }}</span>
                            <span class="product-price">{{ optional($related_product->product)->currency }}{{ number_format(optional($related_product->product)->default_discounted_price)  }}</span>
                        @else
                           <span class="product-price">{{ optional($related_product->product)->currency }}{{ number_format(optional($related_product->product)->converted_price)  }}</span>
                        @endif
                    </div><!-- End .price-box -->

                </div><!-- End .product-details -->
            </div>


            @endforeach
           
        </div><!-- End .products-slider -->
    </div><!-- End .products-section -->

    @endif
    </div><!-- End .container -->
@endsection





