<div class="col-12 d-block d-sm-none">
    <div class="owl-carousel owl-theme ">
        @foreach($property->images  as $key => $image)
            <div class="item">  
                <img src="{{ $image->image }}" />  
            </div>
        @endforeach
    </div>
</div>