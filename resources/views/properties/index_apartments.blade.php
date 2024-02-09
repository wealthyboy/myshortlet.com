@extends('layouts.listing')
@section('content')

<div style="background-color: #f8f5f4;">
    <div class="category-header header-filter" style="background-image: url({{  isset($category) && $category->image != null ? $category->image : 'https://royalbnbproperties.com/uploads/R3DxvKHrMoDy8ib2uoeo4X3yWMzjejiMoIiUMPoz.jpg'}});">
        <div class="container">
            <div class="row">
                <div class="col-md-9 ml-auto mr-auto">
                    <div class="search-form">
                        @if( isset($category) && strtolower($category->name) == 'apartments')
                        <category-search :reload="0" />
                        @else
                        <location />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid {{ $properties->count() < 1 ? 'full-bg' : '' }} position-relative mt-3">

        <div class="sidebar-toggle d-block d-sm-none "> <i class="fas fa-sort-amount-up   filter adjust"></i> filter</div>
        <div class="sidebar-overlay d-none"></div>
        <div class="row no-gutters ">
            <div class="col-12">
                <properties-count />
            </div>

            @if ($properties->count() < 1) <div id="load-products" class="col-md-10 pl-1 d-flex justify-content-center  align-items-center">
                <div class="no-properties-found ">
                    <div class="text-center">
                        <i class="fas fa-home fa-5x"></i>
                        <p>We could not match any properties to your search</p>
                    </div>
                </div>
        </div>
        @else
        <div class="col-md-3 pr-2 mobile-sidebar">
            <div class=" bg-white  sidebar-section">
                <filter-search :category="{{ isset($category) ? $category : '{}' }}" :locations="{{ $locations }}" :attrs="{{ $attributes }}" />
            </div>
        </div>
        <div id="load-products" class="col-md-9 col-12 pl-1 mb-5">
            <products-index :total="{{ collect(['total' => $total]) }}" :next_page="{{ collect($next_page) }}" :propertys="{{ $properties->load('facilities','free_services') }}" />
        </div>
        @endif

    </div>
</div>

</div>


@endsection
@section('page-scripts')

@stop