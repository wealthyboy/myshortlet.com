<div class="d-none gallery-images" style="
   position: fixed; 
   display: block;
   width: 100%; 
   height: 100vh; 
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   z-index: 2090; 
   background-color: rgba(0,0,0,.5);
   cursor: pointer;" >
   <div style="" class="">
      <button style="z-index: 2; right:10px; top: 10px;" class="close-icon  cursor-pointer raised position-absolute"><i class="fal fa-times"></i></button>
      <div id="gallery-images" class="carousel slide carousel-fade" data-ride="carousel">
         <ol class="carousel-indicators">
            @foreach($property_type->images  as $key => $image)
            <li data-target="#gallery-images" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : ''}}"></li>
            @endforeach
         </ol>
         <div class="carousel-inner">
            @foreach($property_type->images  as $key => $image)
            <div class="carousel-item {{ $key == 0 ? 'active' : ''}}">
               <div  class="full-background" style="background-image: url('{{ $image->image }}');">
                  <div class="container">
                     <div class="row">
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
         <a class="carousel-control-prev" href="#gallery-images" role="button" data-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#gallery-images" role="button" data-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="sr-only">Next</span>
         </a>
      </div>
   </div>
</div>