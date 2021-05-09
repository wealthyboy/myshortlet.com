 
  


@extends('fashion.layouts.app')
 
@section('content')
@include('fashion._partials.top_banner')


<section class="breadcrumb no-banner cart-page justify-content-center">
    <div class="breadcrumb-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12  text-center border-bottom">
                    <h2 class="breadcrumb-title">Your Cart</h2>
                </div>
            </div>
        </div>
    </div>
</section>
  
   <!--Content-->
   
<section class="">          
    <div class="container-fluid">
        <div id="js-loading"  class="full-bg">
            <div class="signup--middle">
                <div class="loading">
                    <div class="loader"></div>
                </div>
                <img src="{{ $system_settings->logo_path() }}" height="110" width="80" alt="The Luxury sale Logo">
            </div>        
        </div>
        <cart-summary  />

    </div>
    <div class="container-fluid mt-3">
        <div class="feature-boxes-container row ">
            <div class="col-6 col-md-3">
                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                    <i class="fas fa-truck"></i>

                    <div class="feature-box-content">
                        <h3 class="mb-0 pb-1">Express Delivery</h3>
                        <h5 class="m-b-3">Same day delivery within Lagos.</h5>

                        <p></p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-md-4 -->

            <div class="col-md-3 col-6">
                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                    <i class="icon-credit-card"></i>

                    <div class="feature-box-content">
                        <h3 class="mb-0 pb-1">Secured Payment</h3>
                        <h5 class="m-b-3">Safe &amp; Fast</h5>

                        <p></p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-md-4 -->

       

            <div class="col-md-3 col-6">
                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                    <i class="fab fa-whatsapp"></i>

                    <div class="feature-box-content">
                        <h3 class="mb-0 pb-1">WHATSAPP</h3>
                        <h5 class="m-b-3">Add us on +234 9043111111</h5>
                        <p></p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-md-4 -->

            <div class="col-md-3 col-6">
                <div class="feature-box px-sm-5 px-md-4 mx-sm-5 mx-md-3 feature-box-simple text-center">
                    <i class="icon-action-undo"></i>

                    <div class="feature-box-content">
                        <h3 class="mb-0 pb-1">Returns</h3>
                        <h5 class="m-b-3">Hassle free returns policy. Order with peace of mind</h5>

                        <p></p>
                    </div><!-- End .feature-box-content -->
                </div><!-- End .feature-box -->
            </div><!-- End .col-md-4 -->
        </div>

    </div>
    
</section>
    <!--End Content-->
@endsection










