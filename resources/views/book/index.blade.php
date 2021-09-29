@inject('helper', 'App\Http\Helper')
@extends('layouts.checkout')
@section('content')
   <div class="container vh-100">
       
      <div class="row">
        <div class="col-md-7">
           <h3>Review and book</h3>
        </div>
         
        <div class="col-md-7">
          <form action="" method="get">
            <div class=" bg-white">
                <div class=" position-relative loaded-apartments">
                  <div class="row no-gutters">
                      <div class="col-md-3 position-relative">
                        <div class="">
                            <a href="#">
                              <img class="img  img-fluid" src="{{ $property->image_m }}">
                            </a>
                        </div>
                      </div>
                      <div class="col-md-9 position-relative col-12 pl-3">
                        <div class="d-flex  justify-content-between">
                            <div class="">
                              <a href="#">{{ $property->name }}</a>
                            </div>
                            <div class="d-block d-sm-none">
                        
                            </div>
                        </div>
                        
                        <div class="">
                            <small class="">{{ $property->address }} </small>
                        </div>

                        <div class="mb-5">
                            
                        </div>

                        <div class="d-flex position-absolute apartment-review justify-content-between mt-1 align-items-end">
                            <div class="">
                              3 reviews
                            </div>
                            <div class="d-none d-lg-block d-xl-block text-right mr-2">
                              400
                            </div>
                        </div>
                      </div>
                      
                  </div>
                </div>
            </div>
            <div class=" bg-white mt-1">
              <div class="card-body">
                  Sign in <a href="">here</a> to unlock
              </div>
            </div>
            
            <div class=" bg-white ">
              <h4 class="card-title p-3 border-bottom">Who's checking in?</h4>
              <div class="card-body">
                <form method="POST" class=" register-form sign_in-or-sign-up" action="/">
                  @csrf
                  
                  <div class="form-row">
                        <div class="form-group bmd-form-group col-6">
                            <label class="bmd-label-floating">First name</label>
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  autofocus>
                        </div>
                        <div class="form-group bmd-form-group col-6">
                            <label class="bmd-label-floating">Last name</label>
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus>
                        </div>
                  </div>
                  

                  

                  <div class="form-row">
                      <div class="form-group bmd-form-group col-2">
                          <select name="phone_none" class="form-control" id="">
                              <option value="" > Select code</option>
                              @foreach ($helper::phoneCodes() as  $key => $code)
                              @if ($key == '234')
                              <option value="{{ $key }}" selected> {{ $code }}</option>
                              @else
                              <option value="{{ $key }}" > {{ $code }}</option>

                              @endif
                              @endforeach
                          </select>
                      </div>

                      <div class="form-group bmd-form-group col-5">
                          <label class="bmd-label-floating">Phone number</label>
                          <input  type="text"  class="form-control" name="phone_number" value="{{ old('phone_number') }}"  autofocus>
                          <label id="auth-phone-number-error" class="error" for=""></label>
                      </div>
                      <div class="form-group bmd-form-group col-5">
                          <label class="bmd-label-floating">Email address</label>
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus>
                          <label id="auth-email-error" class="error" for=""></label>
                      </div>

                      
                  </div>

                  
                  
                </form>
                
              </div>
            </div>
            <div class=" bg-white">
              <h4 class="card-title p-3">Superior King Room</h4>
              <div class="card-body">
                  <div> Superior King Room</div>

                  <div>FREE cancellation before 18:00 on 30 September 202</div>
                  <div>FREE cancellation before 18:00 on 30 September 202</div>
                  <div>Sleeps: cancellation before 18:00 on 30 September 202</div>
                  <div class="card-footer  mt-1  bg-transparent d-flex justify-content-between p-0 align-items-center">

                      <div class="checkbox">
                        <label  id="box50" class="checkbox-label">
                        <input for="box50" name="prices[]" value="" class="filter-property" type="checkbox">
                            <span class="checkbox-custom rectangular"></span>
                            <span class="checkbox-label-text mt-1">Breakfast</span> 
                        </label>
                      </div>
                      <span class="fs-32 mt-4 font-weight-bold text-heading total-price">4000</span>

                  </div>

              </div>
            </div>

            <div class=" bg-white">
              <h4 class="card-title p-3 border-bottom">Special Request</h4>
              <div class="card-body">
                  <div class="form-group label-floating bmd-form-group">
                      <label class="form-control-label bmd-label-floating" for="exampleInputTextarea"> You can write your text here...</label>
                      <textarea class="form-control" rows="5" id="exampleInputTextarea"></textarea>
                  </div>
              </div>
            </div>

            <div class=" bg-white">
              <h4 class="card-title p-3 border-bottom">Important Trip Information</h4>
              <div class="card-body">
                <div>
                    <h5>House Rules</h5>
                    <ul class="mb-0">
                      <li class="">
                        <p class="font-weight-500 text-heading mb-0">No pets</p>
                      </li>
                    </ul>
                  </div>

                  <div>
                    <h5>Other Information</h5>
                    <ul class=" mb-0 ">
                      <li class="">
                        <p class="font-weight-500 text-heading mb-0">No pets</p>
                      </li>
                    </ul>
                  </div>
              </div>
            </div>


            <div class=" bg-white ">
              <h4 class="card-title p-3 border-bottom">Payment</h4>
              <div class="card-body">
                <div>By clicking on the button below, I acknowledge that I have reviewed the Privacy Statement</div>
                <p class="form-group mt-3">
                    <button type="submit"  data-total=""  class=" ml-1 btn btn-primary btn-round  btn-block  auth-form-button">
                      <div class="auth-spinner d-none">
                          @include('_partials.spinner',['bgcolor' => '#ffffff'])
                      </div> 
                      <span class="lt">Make Payment</span> 
                    </button>
                </p>
                We use secure transmission and encrypted storage .

              </div>
            </div>
          </form>
       </div>
       <div class="col-md-5">
          <div class="bg-white">
          <h4 class="card-title p-3 border-bottom">Your Booking Details</h4>
              
              <div>
                  <ul class="list-unstyled mb-0 p-2">
                    <li class="d-flex justify-content-between lh-22">
                      <p class="text-gray-light mb-0">Check in</p>
                      <p class="font-weight-500 text-heading mb-0">s</p>
                    </li>

                    <li class="d-flex justify-content-between lh-22">
                      <p class="text-gray-light mb-0">Check out</p>
                      <p class="font-weight-500 text-heading mb-0">s</p>
                    </li>

                    <li class="d-flex justify-content-between lh-22">
                    <p class="text-gray-light mb-0">Total length of stay</p>
                    <p class="font-weight-500 text-heading mb-0">2 nights</p>
                    </li>
                  </ul>
              </div>


              <div class=" p-2  bg-transparent d-flex justify-content-between p-0 align-items-center">
                  <p class="text-heading mb-0">1 X Superior King Room</p>
                  <span class="fs-32 font-weight-bold text-heading total-price">5000</span>
              </div>
              
                    
              <div class="card-footer p-2  bg-transparent d-flex justify-content-between p-0 align-items-center">
                  <p class="text-heading mb-0">Total Price:</p>
                  <span class="fs-32 font-weight-bold text-heading total-price">0</span>
              </div>
          </div>

       </div>
       
     </div>
   </div>
@endsection
@section('page-scripts')
@stop

