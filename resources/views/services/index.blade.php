@extends('services.layouts.app')

@section('content')

<div class="position-relative overflow-hidden  text-center bg-light">
  <div class="col-md-8 p-lg-5 mx-auto my-5">
    <h1 class="display-4 font-weight-normal">Find deals on Apartments.</h1>
    <p class="lead font-weight-normal"></p>
        <form>
            <div class="form-row">
                <div class="col">
                <input type="text" class="form-control" placeholder="location">
                </div>
                <div class="col">
                <input type="text" id="flatpickr-input" class="form-control " placeholder="Check in-Check out">
                </div>
                <div class="">
                <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
           <h2> Top destinations</h2>
           <p>See the top destinations people are traveling to</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-raised card-background" style="background-image: url('./assets/img/examples/office2.jpg')">
                <div class="card-body">
                    <h6 class="card-category text-info"></h6>
                    <a href="#pablo">
                        <h3 class="card-title"></h3>
                    </a>
                    <p class="card-description">
                    </p>
                    <a href="#pablo" class="btn btn-danger btn-round"></a>
                </div>
            </div>
        </div>
        
    </div>


    <div class="row">
      <div class="col-md-12">
           <h2> Top destinations</h2>
           <p>See the top destinations people are traveling to</p>
       </div>

       <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>

    </div>
</div>

<div class="position-relative overflow-hidden  text-center bg-light">
  <div class="col-md-7 p-lg-5 mx-auto my-5">
    <h1 class="display-4 font-weight-normal">Sign Up for .</h1>
    <p class="lead font-weight-normal"></p>
        <form>
            <div class="form-row">
                <div class="col">
                   <input type="text" class="form-control" placeholder="email">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary">Signe Up</button>
                </div>
            </div>
        </form>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>

   
@endsection
@section('page-scripts')
@stop


