@extends('layouts.auth')

@section('content')

<div class="">
    @include('_partials.mobile_nav')
    <div class="container">
        <div class="row">
            @include('_partials.nav')
            <div class="col-md-5  mt-5">
                <h3 class="page-title ">Change Password</h3>
                @include('includes.success')

                <form class="login_form pl-4 pr-4" method="POST" action="/change/password" aria-label="">
                    @csrf

                    <!--<p class="large">Great to have you back!</p>-->
                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Old Password</label>
                        <input id="old_password" type="password" class="form-control" name="old_password" value="" required autofocus>
                        @if ($errors->all() )
                        @foreach($errors->all() as $error)
                        <span class="error">
                            <strong class="text-danger">{{ $error }}</strong>
                        </span>
                        @endforeach
                        @endif
                    </div>


                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group bmd-form-group mb-5">
                        <label class="bmd-label-floating">Confirm Password</label>
                        <input id="phone_number" type="password" class="form-control" name="password_confirmation" required>
                    </div>




                    <p class="form-group ">
                        <button type="submit" data-loading="Loading" class=" ml-1 btn bold-3 btn-primary btn-round "> Submit</button>
                    </p>


                </form>
            </div>
        </div>
    </div>
</div>
<!--End Contact Form & Info-->

@endsection