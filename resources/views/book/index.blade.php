@extends('layouts.book')
@section('content')
<div class="container">
   <div class="row">
      <div class="col-12"></div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <h1>Your Details</h1>
         <form>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label for="inputEmail4">First Name</label>
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
               </div>
               <div class="form-group col-md-6">
                  <label for="inputPassword4">Last Name</label>
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
               </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                  <label for="inputEmail4">Email</label>
                  <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
               </div>
               <div class="form-group col-md-6">
                  <label for="inputPassword4">Phone Number</label>
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
               </div>
            </div>
            <div class="form-group">
               <label for="exampleFormControlTextarea1">Special Requests</label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            
            
            <div class="input-group mb-3">
               <input type="text" class="form-control" placeholder="Have a coupon? Enter here" aria-label="coupon" aria-describedby="coupon">
               <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">Apply Coupon</button>
               </div>
            </div>

            
            <div class="form-row">
               <div class=" col-md-6">
                  <button type="submit" class="btn btn-block btn-outline-primary">Pay at hotel</button>
               </div>
               <div class=" col-md-6">
               <button type="submit" class="btn btn-block  btn-primary">Make Payment </button>
               </div>
            </div>
         </form>
      </div>
      <div class="col-md-6">
         <h1>Your booking details</h1>
         <div class="rooms">
            <div class=" mb-3" style="">
               <div class="row no-gutters">
                  <div class="col-md-3">
                     <img src="http://myshortlet.test/images/apartments/m/kArGSug3Z7RlHvo7p94Ih2QXKjDyLD7X1MKkQtGt.jpg" class="img-fluid" alt="..." />
                  </div>
                  <div class="col-md-8">
                     <div class="card-body">
                        <h5 class="card-title">Apt</h5>
                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                           <span class="fs-14 font-weight-500 text-gray-light">
                           /night</span
                              >
                        </p>
                        <div class="card-text">
                           <small href=""
                              >3 adults max , 2 Children Max, 3 bedroom</small
                              >
                        </div>
                        <div class="facility"></div>
                     </div>
                  </div>
               </div>
               <div class="row no-gutters mt-3">
                  <div class="col-6">
                     <h2>Check in</h2>
                     <span class="">
                     Mon, 21 Jun 2021
                     </span>
                  </div>
                  <div class="col6-">
                     <h2>Check in</h2>
                     <span class="">
                     Mon, 21 Jun 2021
                     </span>
                  </div>
                  <div>
                     <h1>Total length of stay</h1>
                     <p>1 night</p>
                  </div>
               </div>
               <div class="row no-gutters mt-3">
                  <div class="col-7">
                     <span>0 Rooms 1 Night</span>
                     <span>0 Rooms 1 Night</span>
                     <span>0 Rooms 1 Night</span>
                  </div>
                  <div class="change col-5">
                     <button type="submit" class="btn btn-lg btn-primary px-9">Change</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('page-scripts')
@stop

