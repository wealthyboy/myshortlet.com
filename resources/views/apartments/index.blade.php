

@extends('layouts.app')
@section('content')
<section class="pb-8 page-title shadow">
   <div class="container-fluid ">
      <nav class="mt-5" aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
         </ol>
      </nav>
      <div class="row justify-content-end mb-5">
         <div class="col-lg-3 ">
            <div class="primary-sidebar-inner">
               <div class="card mb-4">
                  <div class="card-body px-6 py-4">
                     <h4 class="card-title fs-16 lh-2 text-dark mb-3">Find your home</h4>
                     <form>
                        <div class="form-group">
                           <label for="key-word" class="sr-only">Location</label>
                           <input type="text" class="form-control form-control-lg border-0 shadow-none" id="key-word" name="search" placeholder="Enter keyword...">
                        </div>
                        <div class="form-group">
                           <label for="key-word" class="sr-only">Check in - Check out</label>
                           <input type="text" class="form-control form-control-lg border-0 shadow-none"  id="flatpickr-input-f" name="search" placeholder="Enter keyword...">
                        </div>
                        
                        <div class="form-group">
                           <label for="type" class="sr-only">Adults</label>
                           <select class="form-control border-0 shadow-none form-control-lg selectpicker" name="type" title="All Types" data-style="btn-lg py-2 h-52" id="type">
                              <option>Apartment</option>
                           </select>
                        </div>
                        
                        <div class="form-row mb-4">
                           <div class="col">
                              <label for="bed" class="sr-only">Children</label>
                              <select class="form-control border-0 shadow-none form-control-lg selectpicker" title="Beds" data-style="btn-lg py-2 h-52" id="bed" name="beds">
                                 <option>3</option>
                                 <option>4</option>
                              </select>
                           </div>
                           <div class="col">
                              <label for="baths" class="sr-only">Rooms</label>
                              <select class="form-control border-0 shadow-none form-control-lg selectpicker" title="Baths" data-style="btn-lg py-2 h-52" id="baths" name="baths">
                                 <option>3</option>
                                 <option>4</option>
                              </select>
                           </div>
                        </div>
                        <a class="lh-17 d-inline-block" data-toggle="collapse" href="#other-feature" role="button" aria-expanded="false" aria-controls="other-feature">
                        <span class="text-primary d-inline-block mr-1"><i class="far fa-plus-square"></i></span>
                        <span class="fs-15 text-heading font-weight-500 hover-primary">Other Features</span>
                        </a>
                        <div class="collapse" id="other-feature">
                           <div class="card card-body border-0 px-0 pb-0 pt-3">
                              <ul class="list-group list-group-no-border">
                                 <li class="list-group-item px-0 pt-0 pb-2">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" name="features[]" id="check1">
                                       <label class="custom-control-label" for="check1">Air
                                       Conditioning</label>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <section class="">
                  <h4 class="fs-22 text-heading mb-6">Floor Plans</h4>
                  <div class="accordion accordion-03 mb-3" id="accordion-01">
                     <div class="card border-0 shadow-xxs-2">
                        <div class="card-header bg-gray-01 border-gray border-0 p-0" id="floor-plans-01">
                           <div class="heading d-flex justify-content-between align-items-center px-6" data-toggle="collapse" data-target="#collapse-01" aria-expanded="true" aria-controls="collapse-01" role="button">
                              <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">First Floor</h2>
                              
                           </div>
                        </div>
                        <div id="collapse-01" class="collapse show" aria-labelledby="floor-plans-01" data-parent="#accordion-01">
                           <div class="card-body card-body col-sm-6 offset-sm-3 mb-3">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="accordion accordion-03 mb-3" id="accordion-02">
                     <div class="card border-0 shadow-xxs-2">
                        <div class="card-header bg-gray-01 border-gray border-0 p-0" id="floor-plans-02">
                           <div class="heading d-flex justify-content-between align-items-center px-6 collapsed " data-toggle="collapse" data-target="#collapse-02" aria-expanded="true" aria-controls="collapse-02" role="button">
                              <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">Second Floor</h2>
                              
                           </div>
                        </div>
                        <div id="collapse-02" class="collapse " aria-labelledby="floor-plans-02" data-parent="#accordion-02">
                           <div class="card-body card-body col-sm-6 offset-sm-3 mb-3">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="accordion accordion-03 mb-3" id="accordion-03">
                     <div class="card border-0 shadow-xxs-2">
                        <div class="card-header bg-gray-01 border-gray border-0 p-0" id="floor-plans-03">
                           <div class="heading d-flex justify-content-between align-items-center px-6 collapsed " data-toggle="collapse" data-target="#collapse-03" aria-expanded="true" aria-controls="collapse-03" role="button">
                              <h2 class="mb-0 fs-16 text-heading font-weight-500 py-4 lh-13">Third Floor</h2>
                           </div>
                        </div>
                        <div id="collapse-03" class="collapse " aria-labelledby="floor-plans-03" data-parent="#accordion-03">
                           <div class="card-body card-body col-sm-6 offset-sm-3 mb-3">
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
         <div class="col-lg-9 mb-8 mb-lg-0 order-1 order-lg-2">
            <div class="row align-items-sm-center mb-4">
               <div class="col-md-6">
                  <h2 class="fs-15 text-dark mb-0">We found <span class="text-primary">45</span> properties
                     available for
                     you
                  </h2>
               </div>
               <div class="col-md-6 mt-4 mt-md-0">
                  <div class="d-flex justify-content-md-end align-items-center">
                     <div class="input-group border rounded input-group-lg w-auto bg-white mr-3">
                        <label class="input-group-text bg-transparent border-0 text-uppercase letter-spacing-093 pr-1 pl-3" for="inputGroupSelect01"><i class="fas fa-align-left fs-16 pr-2"></i>Sortby:</label>
                        <select class="form-control border-0 bg-transparent shadow-none p-0 selectpicker sortby" data-style="bg-transparent border-0 font-weight-600 btn-lg pl-0 pr-3" id="inputGroupSelect01" name="sortby">
                           <option selected>Top Selling</option>
                           <option value="1">Most Viewed</option>
                           <option value="2">Price(low to high)</option>
                           <option value="3">Price(high to low)</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            @if ($apartments->count())
            @foreach($apartments as $apartment)
            <div class="py-5 px-4 border rounded-lg shadow-hover-1 bg-white mb-4">
               <div class="media flex-column flex-sm-row no-gutters">
                  <div class="col-sm-3 mr-sm-5 card border-0 hover-change-image bg-hover-overlay mb-sm-5">
                     <a href="/apartment/{{ $apartment->slug }}" class="">
                     <img src="{{ $apartment->image_to_show_m }}" class="card-img" alt="{{ $apartment->name }}">
                     </a>
                     <div class="card-img-overlay p-2">
                        <ul class="list-inline mb-0 d-flex justify-content-center align-items-center h-100 hover-image">
                           <li class="list-inline-item">
                              <a href="/apartment/{{ $apartment->slug }}" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-heading bg-white border-white bg-hover-primary border-hover-primary hover-white">
                              <i class="far fa-heart"></i>
                              </a>
                           </li>
                           <li class="list-inline-item">
                              <a href="/apartment/{{ $apartment->slug }}" class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-heading bg-white border-white bg-hover-primary border-hover-primary hover-white">
                              <i class="fas fa-exchange-alt"></i>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="media-body mt-3 mt-sm-0">
                     <h2 class="my-0"><a href="/apartment/{{ $apartment->slug }}" class="fs-16 lh-2 text-dark hover-primary d-block">{{ $apartment->name }}</a></h2>
                     <p class="mb-1 font-weight-500 text-gray-light"><a href="/apartment/{{ $apartment->slug }}">{{ $apartment->city }}</a>,  <a href="">{{ $apartment->state }}</a></p>
                     <p class="fs-17 font-weight-bold text-heading mb-1">
                        $1.250.000
                     </p>
                     <p class="mb-2 ml-0"><small class="text-muted"><?php echo  str_limit(html_entity_decode($apartment->description), $limit = 200, $end = '...') ?> </small></p>
                  </div>
               </div>
               <div class="d-sm-flex justify-content-sm-between">
                  
                  <span class="badge badge-primary mr-xl-2 mt-3 mt-sm-0">4.7 (3 reviews)</span>
               </div>
            </div>
            @endforeach
            @else
            <div class="col-lg-9 main-content">No Apartments</div>
            @endif
            <nav class="pt-6">
               
            </nav>
         </div>
      </div>
   </div>
</section>
@endsection
@section('page-scripts')
@stop

