


@extends('fashion.layouts.app')
 
@section('content')
@include('fashion._partials.top_banner')

<section class="breadcrumb no-banner  justify-content-center">
    <div class="breadcrumb-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  text-center border-bottom">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav breadcrumb-link">
                        <div class="container d-flex justify-content-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
                            </ol>
                        </div>
                    </nav>
                    <h2 class="breadcrumb-title"> DESIGNER {{ $breadcrumb }} FOR  {{ $parent_category }}</h2>
                    <p class="text-center"> {{ isset($category) ? $category->description : '' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container-fluid mb-3">
    <div  class="row">
        
       @if ( isset($category) &&  isset($category_attributes) && $category_attributes->count() )
            <div class="col-lg-9 main-content">
                <div class="product-overlay d-none">
                    <div class="loading">
                        <div class="loader"></div>
                    </div>
                </div>
       @else
            <div class="col-lg-12 main-content">
        @endif
        @if ($products->count())
            <nav class="toolbox horizontal-filter filter-sorts">
                <div class="toolbox-left">
                    <div class="toolbox-item toolbox-sort pr-1">
                        <label class="ml-3"></label>
                    </div><!-- End .toolbox-item -->
                </div><!-- End .toolbox-left -->


                <div class="toolbox-right">
                   <div class="select-custom">
                        <select  name="sort_by" id="sort_by" class="form-control">
                            <option value="" selected="selected">Sort By</option>
                            <option value="created_at,asc">Oldest</option>
                            <option value="created_at,desc">Newest</option>
                            <option value="price,asc">Lowest Price</option>
                            <option value="price,desc">Highest Price</option>
                        </select>
                    </div><!-- End .select-custom -->

                </div><!-- End .toolbox-right -->
            </nav>
        @endif
            @if ( isset($category) &&  isset($category_attributes) && !empty($category_attributes) )
                @include('fashion._partials.products',['no_attr'=>false])
            @else
                @include('fashion._partials.products',['no_attr' => true])
            @endif

            <div id="pagination" class="col-md-10 text-center mb-20 col-md-offset-1">
                @if(!empty($products->hasMorePages()))
                <a href="{{ $products->nextPageUrl() }}" id="load_more" class="btn loadmore btn-loadmore load_more mt-4 mb-2">
                   <span class="spinner-grow spinner-grow-md d-none"></span>
                   Load More...
                </a>
                @endif
            </div>

        </div><!-- End .col-lg-9 -->

        
        @if ($products->count())
            @if ( isset($category) &&  isset($category_attributes) && $category_attributes->count()  )
                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
                <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                    <div class="pin-wrapper" style="">
                        <div class="sidebar-wrapper" style="">
                            @include('fashion._partials.search',['category_attributes'=>$category_attributes])
                        </div>
                    </div>
                </aside><!-- End .col-lg-3 -->
            @endif
        @endif
    </div><!-- End .row -->
    <form>
        <input type="hidden" name="sort_by" id="sort" />
    </form>

</div>
@endsection
@section('inline-scripts')
    $(document).ready(function() {
        $("#load-products").loadProducts({
           'form':$('form#collections input'),
           'form_data':$("form#collections"),
           'form_sort_by':$("select#sort_by"),
           'target':'load-products',
           'loggedInStatus':8,
           'load_more':$(document).find('a.load_more'),
           'filter_url':'{{ request()->fullUrl() }}',
           'overlay': '.product-overlay'
        });
   
        //reset form
        $("#reset-search-form").on("click", function () {
           //  Reset all selections fields to default option.          
           $('input[type=checkbox]').each(function () {
               this.checked = false;
           }); 
        });   
   });
   
@stop


