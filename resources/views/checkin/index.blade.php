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
                <div class=" position-relation mt-4 mb-4">
                    <div id="alert-success" class="alert d-none alert-success">
                        Thank you for checking in .Enjoy your stay
                    </div>

                    <form method="POST" id="submit" class=" pl-4 pr-4 border form-validate bg-white " action="/check-in">

                        <div class="text-center">
                            <a href="/" class="navbar-brand mt-5">
                                <div class="logo-small"><img src="/images/logo/avem-logo.png" alt="" srcset=""></div>
                            </a>
                            <p class="bold-2">Fill in the form to check-in </p>
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
                                <label class="bmd-label-floating">First name</label>
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{  old('first_name') }}" required>
                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Last name</label>
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Email</label>
                                <input id="email" type="email" class="form-control" name="email" autocomplete="off">

                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Phone</label>
                                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required>
                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Check-in </label>
                                <input type="text" id="checkin" class="form-control " name="checkin" required>
                            </div>
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Check-out</label>
                                <input type="text" id="checkout" class="form-control " name="checkout" required>
                            </div>



                            <div class="form-group bmd-form-group col-md-12 col-12  align-items-center">
                                <select name="apartment_id" id="mySelect" class="form-control ">
                                    <option selected value="">Choose Apartment</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{optional($room->attribute)->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>


                        <p class="p-1 col-12 ">
                            <label for="pictures " class="bmd-label-floating upload">Upload ID (Only government issued IDs are accepted. e.g International Passport, Driver’s License, National ID e.t.c)</label>
                        <div class="dropzone col-12 mb-4" id="my-dropzone"></div>
                        <div id="pic-error" class="error text-danger"></div>
                        </p>

                        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn-primary btn-round btn-lg btn-block mb-5" name="login" value="Log in">Submit</button>
                    </form>

                    <div id="overlay" class="position-absolute  top-0 w-100 start-0 bottom-0 end-0 d-none align-items-center justify-content-center bg-dark-0 bg-opacity-50 text-white">
                        <p style="font-size: 2.2rem;" class="text-lg display-3">Please wait while we check you in...</p>
                    </div>

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
<script src="/js/upload.js?version={{ str_random(6) }}"></script>

@stop

@section('inline-scripts')

@stop