
<!--Widget-->


<form id="collections" action="">



<div class="widget">
    <h3 class="widget-title ">
        <a data-toggle="collapse" href="#widget-prices" role="button" class="bold" aria-expanded="true" aria-controls="widget-body-2">Prices</a>
    </h3>
    <div class="collapsed bold" id="widget-prices">
        <div class="widget-body">
            <ul class="cat-list">
               
                <li>
                    <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                        <input for="box50" name="prices[]" value="2500" class="filter-product" type="checkbox">
                            <span class="checkbox-custom rectangular"></span>
                            <span class="checkbox-label-text">Less Than  2500</span> 
                        </label>
                    </div>
                </li>
                <li>
                    <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                        <input for="box50" name="prices[]" value="5000" class="filter-product" type="checkbox">
                            <span class="checkbox-custom rectangular"></span>
                            <span class="checkbox-label-text">Less Than  5000</span> 
                        </label>
                    </div>
                </li>
 
                <li>
                    <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                        <input for="box50" name="prices[]" value="10000" class="filter-product" type="checkbox">
                            <span class="checkbox-custom rectangular"></span>
                            <span class="checkbox-label-text">Less Than  10000</span> 
                        </label>
                    </div>
                </li>

                <li>
                    <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                        <input for="box50" name="hprices[]" value="10000" class="filter-product" type="checkbox">
                            <span class="checkbox-custom rectangular"></span>
                            <span class="checkbox-label-text">More than 10,000</span> 
                        </label>
                    </div>
                </li>
               

            </ul>
        </div><!-- End .widget-body -->
    </div><!-- End .collapse -->
</div><!-- End .widget -->

@foreach($category_attributes as $category)
    <div  class="widget">
        <h3 class="widget-title">
            <a class="collapsed bold"   data-toggle="collapse" href="#widget-body-4{{ $category->id }}" role="button" aria-expanded="true" aria-controls="widget-body-4{{ $category->id}}">{{ optional($category->attribute)->name }}</a>
        </h3>
        <div class="collapse"  id="widget-body-4{{ $category->id }}">
            <div class="widget-body">
                <ul class="cat-list  {{ $category->children->count() > 6  ?  'widget-scroll' : '' }}">
                   @foreach($category->children as $category_attribute)
                       @if (optional($category_attribute->attribute)->name  == ''  )
                       @continue
                       @endif
                        <li class="">
                            <div class="checkbox">
                                <label  id="box{{ optional($category->attribute)->slug }}" class="checkbox-label">
                                <input for="box{{ optional($category->attribute)->slug }}" name="{{ optional($category->attribute)->slug }}[]" value="{{ optional($category_attribute->attribute)->slug }}" class="filter-product" type="checkbox">
                                    <span class="checkbox-custom rectangular"></span>
                                     <span class="checkbox-label-text color--primary">{{ optional($category_attribute->attribute)->name }}   </span> 
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div><!-- End .widget-body -->
        </div><!-- End .collapse -->
    </div><!-- End .widget -->
@endforeach
    <!-- Content -->
    
</form>