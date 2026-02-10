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
                                <input id="first_name" type="text" disabled="true" class="form-control" name="first_name" value="{{ $user_reservation->guest_user->name }}" required>
                                <input id="first_ame" type="hidden" class="form-control" name="first_name" value="{{ $user_reservation->guest_user->name }}">

                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Last name</label>
                                <input id="last_name" type="text" disabled="true" class="form-control" name="last_name" value="{{ $user_reservation->guest_user->last_name  }}" required>
                                <input id="last_nam" type="hidden" class="form-control" name="last_name" value="{{ $user_reservation->guest_user->last_name  }}">


                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Email</label>
                                <input id="email" type="email" disabled="true" class="form-control" name="email" value="{{ $user_reservation->guest_user->email  }}" autocomplete="off">
                                <input id="emai" type="hidden" name="email" value="{{ $user_reservation->guest_user->email  }}" autocomplete="off">
                                <input id="user_reservation" type="hidden" name="user_reservation_id" value="{{ $user_reservation->id  }}">
                                <input id="guest_id" type="hidden" name="guest_id" value="{{ $user_reservation->guest_user->id  }}">

                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Phone</label>
                                <input id="phone_number" type="text" disabled="true" class="form-control" name="phone_number" value="{{  $user_reservation->guest_user->phone_number }}" required>
                                <input id="phone_numbe" type="hidden" name="phone_number" value="{{  $user_reservation->guest_user->phone_number }}" required>

                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Check-in </label>
                                <input type="text" class="form-control selector" disabled="true" value="{{$user_reservation->reservations[0]->checkin->format('Y-m-d') }}" name="checkin">
                                <input type="hidden" value="{{ $user_reservation->checkin }}" name="checkin">

                            </div>
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Check-out</label>
                                <input type="text" class="form-control selector" disabled="true" value="{{$user_reservation->reservations[0]->checkout->format('Y-m-d') }}" name="checkout">
                                <input type="hidden" value="{{ $user_reservation->checkout }}" name="checkout">
                            </div>



                            <div class="form-group bmd-form-group col-md-12 col-12  align-items-center">
                                <select disabled="true" name="apartment_id" id="mySelect" class="form-control ">
                                    <option selected value="">Choose Apartment</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>


                                    @if($user_reservation->apartment_id == $room->id)
                                    <option value="{{  $room->id }}" selected>{{ $room->name }}</option>
                                    @else
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endif
                                    @endforeach


                                </select>

                                <input type="hidden" value="{{ $user_reservation->apartment_id }}" name="apartment_id">


                            </div>
                        </div>

                        <p class="p-1 col-12 ">
                            <label for="pictures " class="bmd-label-floating upload">Upload ID (Only government issued IDs are accepted. e.g International Passport, Driver’s License, National ID e.t.c)</label>
                        <div class="dropzone col-12 mb-4" id="my-dropzone"></div>
                        <div id="pic-error" class="error text-danger"></div>
                        </p>

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

@stop