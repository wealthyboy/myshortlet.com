@extends('admin.layouts.app')

@section('pagespecificstyles')
<style>
   .reservation-form .form-group > label {
      color: #101828 !important;
      font-size: 14px !important;
      font-weight: 800 !important;
      line-height: 1.35;
      opacity: 1 !important;
   }
</style>
@stop

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

            @if($errors->any())
            <div class="alert alert-danger">
               <strong>Please correct the highlighted fields.</strong>
               <ul class="mb-0">
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif

            <form class="form reservation-form" action="{{ route('admin.reservations.store') }}" method="POST" novalidate>
               @csrf
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="property_id">Property</label>
                     <select name="property_id" id="property_id" class="form-control @error('property_id') is-invalid @enderror" required>
                        <option value="">Select a property</option>
                        @foreach($properties as $property)
                        <option value="{{ $property->id }}" {{ (string) old('property_id') === (string) $property->id ? 'selected' : '' }}>
                           {{ $property->name }}
                        </option>
                        @endforeach
                     </select>
                     <small class="text-muted">Only apartments belonging to this property will be shown.</small>
                  </div>

                  <div class="form-group col-md-6">
                     <label for="apartment_id">Apartment</label>
                     <select name="apartment_id" id="apartment_id" class="form-control @error('apartment_id') is-invalid @enderror" required disabled>
                        <option value="">Select a property first</option>
                        @foreach($properties as $property)
                           @foreach($property->apartments as $apartment)
                           <option
                              value="{{ $apartment->id }}"
                              data-property-id="{{ $property->id }}"
                              data-price="{{ $apartment->price }}"
                              {{ (string) old('apartment_id') === (string) $apartment->id ? 'selected' : '' }}
                           >
                              {{ $apartment->name }}
                           </option>
                           @endforeach
                        @endforeach
                     </select>
                     <small id="apartment-help" class="text-muted">Choose the apartment to reserve.</small>
                  </div>
               </div>
               <div class="form-row">
                  <!-- First Name -->
                  <div class="form-group col-md-6">
                     <label for="first_name">First Name</label>
                     <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                  </div>

                  <!-- Last Name -->
                  <div class="form-group col-md-6">
                     <label for="last_name">Last Name</label>
                     <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                  </div>
               </div>

               <div class="form-row">
                  <!-- Email -->
                  <div class="form-group col-md-6">
                     <label for="email">Email</label>
                     <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                  </div>

                  <!-- Phone -->
                  <div class="form-group col-md-6">
                     <label for="phone">Phone</label>
                     <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone" name="phone_number" value="{{ old('phone_number') }}" required>
                  </div>
               </div>

               <!-- Currency Selector -->




               <div class="form-row">
                  <!-- From Date -->
                  <div class="form-group col-md-6">
                     <label for="from-date">From</label>
                     <input class="form-control datepicker pull-right @error('checkin') is-invalid @enderror" name="checkin" id="datepicker" type="text" value="{{ old('checkin') }}" autocomplete="off" required>
                  </div>

                  <!-- To Date -->
                  <div class="form-group col-md-6">
                     <label for="to-date">To</label>
                     <input class="form-control datepicker pull-right @error('checkout') is-invalid @enderror" name="checkout" id="datepicker-to" type="text" value="{{ old('checkout') }}" autocomplete="off" required>
                  </div>
               </div>

               <div class="form-row">
                  <!-- Apartments -->
                  <div class="form-group col-md-2">
                     <label for="currency">Currency</label>
                     <select name="currency" id="currency" class="form-control" required>
                        <option value="₦" {{ old('currency', '₦') === '₦' ? 'selected' : '' }}>Naira (₦)</option>
                        <option value="$" {{ old('currency') === '$' ? 'selected' : '' }}>US Dollar ($)</option>
                     </select>
                  </div>
                  <div class="form-group col-md-2">
                     <label for="currency">Discount Type</label>
                     <select name="discount_type" id="discount_type" class="form-control">
                        <option value="percent" {{ old('discount_type', 'percent') === 'percent' ? 'selected' : '' }}>%</option>
                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4">
                     <label for="discount">Discount</label>
                     <input type="number" min="0" step="0.01" class="form-control" id="discount" name="discount" value="{{ old('discount', 0) }}">
                  </div>


                  <div class="form-group col-md-4">
                     <label for="caution_fee">Caution Fee</label>
                     <input type="number" min="0" step="0.01" class="form-control" id="caution_fee" name="caution_fee" value="{{ old('caution_fee', 0) }}">
                  </div>


               </div>

               <div class="clearfix"></div>






               <div class="form-row">
                  <div class="form-group col-md-2">
                     <button type="submit" class="btn btn-primary rounded">Create reservation</button>
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
const propertySelect = $("#property_id");
const apartmentSelect = $("#apartment_id");
const apartmentOptions = apartmentSelect.find("option[data-property-id]").clone();
const selectedApartment = @json(old('apartment_id'));

function loadApartments(propertyId, apartmentId) {
   apartmentSelect.empty();

   if (!propertyId) {
      apartmentSelect.append(new Option("Select a property first", ""));
      apartmentSelect.prop("disabled", true);
      return;
   }

   apartmentSelect.append(new Option("Select an apartment", ""));

   apartmentOptions.each(function () {
      if (String($(this).attr("data-property-id")) === String(propertyId)) {
         apartmentSelect.append($(this).clone());
      }
   });

   apartmentSelect.prop("disabled", false);

   if (apartmentId && apartmentSelect.find('option[value="' + apartmentId + '"]').length) {
      apartmentSelect.val(apartmentId);
   }
}

propertySelect.on("change", function () {
   loadApartments($(this).val(), null);
});

loadApartments(propertySelect.val(), selectedApartment);

$(".form").on("submit", function (e) {
let checkin = $("#datepicker").val();
let checkout = $("#datepicker-to").val();

if (!this.checkValidity()) {
   e.preventDefault();
   this.reportValidity();
   return false;
}

if (!propertySelect.val() || !apartmentSelect.val()) {
   e.preventDefault();
   alert("Please select both a property and an apartment.");
   return false;
}

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
   let btn=$(this).find("button[type='submit']");
   btn.prop("disabled", true);
   btn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
   });
   });
   @stop
