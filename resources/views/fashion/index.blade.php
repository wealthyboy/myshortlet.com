@extends('fashion.layouts.app')

@section('content')

@include('fashion._partials.top_banner')

<div class="container-fliud mt-3">
    <div  class="row align-items-start ">
        @foreach( $banners as $banner )
            <div data-title="{{ $banner->title }}" class="{{ $banner->col }} {{ $banner->col == 'col-lg-3' ?  'col-6    p-0' : 'pr-1 pl-1' }}  mb-1 {{ $banner->title }} p-0 text-center">
                <div class="banner-box">
                    <a class="portfolio-thumb" href="{{ $banner->link }}">
                        <img src="{{ $banner->image }}" alt="" />
                    </a>
                </div>
            </div> 
        @endforeach
    </div>
</div>

@if ( $products->count() )


<div class="container-fluid mt-5 mb-5">
    

    <div class="products-section pt-0">
        <h2 class="section-title bold text-center">Most Sorted</h2>

        <div class="products-slider owl-carousel owl-theme dots-top">
            @foreach( $products as $feautered_product)

            <div class="product-default inner-quickview inner-icon">
                <figure>
                    <a href="{{ $feautered_product->link }}">
                        <img src="{{ $feautered_product->image_to_show_m }}">
                    </a>
                    
                    
                </figure>
                <div class="product-details text-center">
                    <div class="mx-auto">
                        
                        @if($feautered_product->colours->count()  && $feautered_product->colours->count() > 1)
                            <div  class="justify-content-center d-flex mb-1">
                                @foreach($feautered_product->colours as $color)
                                <div   style="border:1px solid #222; height: 15px; width: 15px; border-radius: 50%; background-color: {{ $color->color_code }};" class="mr-1"></div>
                                @endforeach
                            </div>
                        @endif
                        @if($feautered_product->brand_name)
                            <div  class="product-brand bold">
                                {{ $feautered_product->brand_name }} 
                            </div>
                        @endif

                        <div class="color--primary">
                            <a href="{{ $feautered_product->link }}">{{ $feautered_product->product_name }}</a>
                        </div>
                    </div>
                    <div class="price-box mx-auto mt-1">
                        @if( $feautered_product->default_discounted_price)
                            <span class="old-price">{{ $feautered_product->currency }}{{ number_format($feautered_product->converted_price)   }}</span>
                            <span class="product-price  ml-1">
                                |
                                @if( $feautered_product->default_percentage_off )
                                    {{ $feautered_product->default_percentage_off }}% OFF
                                @endif
                                <span class="text-danger">
                                   {{ $feautered_product->currency }}{{ number_format($feautered_product->default_discounted_price)  }}
                                </span>
                            </span>
                        @else
                            <span class="product-price">{{ $feautered_product->currency }}{{ number_format($feautered_product->converted_price) }}</span>
                        @endif
                    </div><!-- End .price-box -->
                </div><!-- End .product-details -->
            </div>


            @endforeach
           
        </div><!-- End .products-slider -->
    </div><!-- End .products-section -->

</div><!-- End .container -->
@endif




<!--End Portfolio-->
    <!--End Categories-->
    @if ($posts->count()) 

    <!--Blog-->
    <section class="pb-4 pt-4 bg--primary mb-1">
        <div class="container">
            <div class="page-head">
                <span class="page-sub-title"></span>
                <h2 class="page-title  heading-hr-margin-white">BLOG</h2>
            </div>
        </div>
       <div class="container">
            <div class="blog-slider owl-carousel owl-theme text-center">
                 @foreach($posts as $post)
                    <!--Item-->
                    <div class="item raised animated fadeIn  bg--light mb-4">
                        <div class="blog-item">
                            <div class="blog-item-image">
                                <a title="{{  $post->title }}" href="{{ route('blog.show',['blog'=> $post->slug]) }}" class="blog-img-link">
                                    <img  title="{{  $post->title }}" src="{{ $post->image }}" alt="{{  $post->title }}" />
                                </a>
                            </div>
                            <div class="blog-item-content">
                                <p class="info mb-2">
                                    <i class="fa fa-clock-o"></i><span>{{ $post->created_at->diffForHumans() }}</span>
                                </p>
                                <div class="tag bold">
                                    @foreach($post->attributes as $tag)
                                    <a href="/blog/tag/{{ $tag->id }}"><i class="fa fa-tags"></i> {{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <h6 class="blog-title text-uppercase"> 
                                    <a title="{{  $post->title }}" href="{{ route('blog.show',['blog'=> $post->slug]) }}" class="">
                                        {{ $post->title }}
                                    </a> 
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
               
            </div>
        </div>
    </section>
    <!--End Blog-->
    @endif

@endsection
@section('page-scripts')
@stop


