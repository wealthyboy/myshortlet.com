@extends('layouts.auth')
@section('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.css" integrity="sha512-bbUR1MeyQAnEuvdmss7V2LclMzO+R9BzRntEE57WIKInFVQjvX7l7QZSxjNDt8bg41Ww05oHSh0ycKFijqD7dA==" crossorigin="anonymous" />
@endsection

@section('content')
<!--Content-->
<section style="background-color: rgb(248, 245, 244);" class="sec-padding">
    <div class="container ">
        <div class="row justify-content-center">
            <div class="ml-1 col-md-7   mr-1">
                <div class="position-relative mt-4 mb-4">
                    <div id="alert-success" class="alert d-none alert-success">
                        Apartment has been blocked
                    </div>

                    <form method="POST" id="admin-apartment-block" class="pl-4 pr-4 border bg-white" action="{{ route('admin.blocks.store') }}">

                        <div class="text-center">
                            <a href="/" class="navbar-brand mt-5">
                                <div class="logo-small"><img src="/images/logo/avem-logo.png" alt="" srcset=""></div>
                            </a>
                            <p class="bold-2">Fill in the form to block an apartment</p>
                        </div>
                        @csrf

                        @if ($errors->all() )
                        @foreach($errors->all() as $error)
                        <span class="error d-block">
                            <strong class="text-danger">{{ $error }}</strong>
                        </span>
                        @endforeach
                        @endif

                        <div class="form-row">
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label for="checkin" class="bmd-label-floating">Check-in </label>
                                <input type="text" id="checkin" class="form-control" name="checkin" value="{{ old('checkin') }}" autocomplete="off" required>
                            </div>
                            
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label for="checkout" class="bmd-label-floating">Check-out</label>
                                <input type="text" id="checkout" class="form-control" name="checkout" value="{{ old('checkout') }}" autocomplete="off" required>

                            </div>

                            <div class="form-group bmd-form-group col-md-12 col-12  align-items-center">
                                <select  name="apartment_id" id="mySelect" class="form-control ">
                                    <option value="">Choose Apartment</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ (string) old('apartment_id') === (string) $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                    @endforeach

                                </select>



                            </div>
                        </div>

                      

                        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn-primary btn-round btn-lg btn-block mb-5" name="login" value="Log in">Submit</button>


                    </form>


                    <!-- Overlay -->
                    <!-- <div class="position-absolute top-0 w-100 start-0 bottom-0 end-0 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white">
                        <p class="text-lg display-4">Please wait while we check you in...</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<div style="height: 200px; background-color: rgb(248, 245, 244);"></div>
<!--End Content-->
@endsection

@section('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.js" integrity="sha512-En/Po50Bl8kIECa2WkhxhdYeoKDcrJpBKMo9tmbuwbm9RxHWZV8/Y5xM9sh3QbrnFgM3hVR/2umJ33qGJk45pQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/upload.js') }}"></script>

@stop

@section('inline-scripts')
document.addEventListener('DOMContentLoaded', function () {
    var checkin = flatpickr('#checkin', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: function (selectedDates) {
            checkout.set('minDate', selectedDates[0] || 'today');
            if (checkout.selectedDates[0] && selectedDates[0] && checkout.selectedDates[0] <= selectedDates[0]) {
                checkout.clear();
            }
        }
    });

    var checkout = flatpickr('#checkout', {
        dateFormat: 'Y-m-d',
        minDate: checkin.selectedDates[0] || 'today'
    });
});
@stop
