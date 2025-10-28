@extends('admin.layouts.app')

@section('content')

<div class="row">
   <div class="col-md-12">
      <div class="text-right">
         <a href="/admin/reservations?coming_from=checkin" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
            <i class="material-icons">arrow_back</i>
            Back
         </a>
      </div>
   </div>

   <div class="col-md-12">
      <div class="card">
         <div class="card-content">
            <h4 class="card-title">Add Reservation - <small class="category"></small></h4>

            @if(session('error'))
            <div class="alert alert-danger">
               {{ session('error') }}
            </div>
            @endif

            <form class="form" action="/admin/reservations?coming_from=payment" method="POST">
               @csrf
               <div class="form-row">
                  <!-- Apartments -->
                  <div class="form-group col-md-12">
                     <label for="apartment_id">Apartments</label>
                     <select name="apartment_id" id="apartment_id" class="form-control" required>
                        <option value="">Choose one</option>
                        @foreach($apartments as $apartment)
                        <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               <div class="form-row">
                  <!-- First Name -->
                  <div class="form-group col-md-6">
                     <label for="first_name">First Name</label>
                     <input type="text" class="form-control" id="first_name" name="first_name" required>
                  </div>

                  <!-- Last Name -->
                  <div class="form-group col-md-6">
                     <label for="last_name">Last Name</label>
                     <input type="text" class="form-control" id="last_name" name="last_name" required>
                  </div>
               </div>

               <div class="form-row">
                  <!-- Email -->
                  <div class="form-group col-md-6">
                     <label for="email">Email</label>
                     <input type="email" class="form-control" id="email" name="email" required>
                  </div>

                  <!-- Phone -->
                  <div class="form-group col-md-6">
                     <label for="phone">Phone</label>
                     <input type="text" class="form-control" id="phone" name="phone_number" required>
                  </div>
               </div>

               <!-- Currency Selector -->




               <div class="form-row">
                  <!-- From Date -->
                  <div class="form-group col-md-6">
                     <label for="from-date">From</label>
                     <input class="form-control  datepicker pull-right" name="checkin" id="datepicker" type="text" required>
                  </div>

                  <!-- To Date -->
                  <div class="form-group col-md-6">
                     <label for="to-date">To</label>
                     <input class="form-control  datepicker pull-right" name="checkout" id="datepicker-to" type="text" required>
                  </div>
               </div>

               <div class="form-row">
                  <!-- Apartments -->
                  <div class="form-group col-md-2">
                     <label for="currency">Currency</label>
                     <select name="currency" id="currency" class="form-control" required>
                        <option value="₦" selected>Naira (₦)</option>
                        <option value="$">US Dollar ($)</option>
                     </select>
                  </div>
                  <div class="form-group col-md-2">
                     <label for="currency">Discount Type</label>
                     <select name="discount_type" id="discount_type" class="form-control">
                        <option value="percent">%</option>
                        <option value="fixed">Fixed</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4">
                     <label for="discount">Discount</label>
                     <input type="text" class="form-control" id="discount" name="discount">
                  </div>


                  <div class="form-group col-md-4">
                     <label for="caution_fee">Caution Fee</label>
                     <input type="text" class="form-control" id="caution_fee" name="caution_fee">
                  </div>


               </div>

               <div class="clearfix"></div>






               <div class="form-row">
                  <div class="form-group col-md-2">
                     <button type="submit" class="btn btn-primary rounded">Submit</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>





</div> <!-- end row -->
@endsection
@section('page-scripts')
<script src="{{ asset('backend/js/products.js') }}"></script>
<script src="{{ asset('backend/js/uploader.js') }}"></script>
@stop
@section('inline-scripts')
$(document).ready(function () {
$(".form").on("submit", function (e) {
let checkin = $("#datepicker").val();
let checkout = $("#datepicker-to").val();

// Convert dates to JS Date objects for comparison
let checkinDate = new Date(checkin);
let checkoutDate = new Date(checkout);

// Validate dates
if (checkoutDate <= checkinDate) {
   e.preventDefault();
   alert("Checkout date must be later than Checkin date.");
   return false;
   }

   // Loader on button
   let btn=$(this).find("button[type='submit' ]");
   btn.prop("disabled", true);
   btn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
   });
   });
   @stop