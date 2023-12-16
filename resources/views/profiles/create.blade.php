@extends('layouts.auth')

@section('content')

<div class="">

    @include('_partials.mobile_nav')

    <div class="container">
        <div class="row">
            @include('_partials.nav')
            <div class="col-md-5 mt-5">
                <h2 class="page-title ">Account</h2>
                @include('includes.success')

                <form class="login_form pl-4 pr-4" method="POST" action="{{ route('profiles.update', ['profile' => $user->id ]) }}" aria-label="">
                    @csrf
                    @method('PATCH')

                    <!--<p class="large">Great to have you back!</p>-->
                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">First Name</label>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->name }}" required autofocus>
                        @if ($errors->all() )
                        @foreach($errors->all() as $error)
                        <span class="error">
                            <strong class="text-danger">{{ $error }}</strong>
                        </span>
                        @endforeach
                        @endif
                    </div>


                    <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{  $user->last_name }}" required>
                    </div>

                    <div class="form-group bmd-form-group mb-5">
                        <label class="bmd-label-floating">Phone Number</label>
                        <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{  $user->phone_number }}" required>
                    </div>




                    <div class="clearfix"></div>
                    <p class="form-group ">
                        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn bold-2 btn-primary btn-round " name="login"> Submit</button>
                    </p>


                </form>

            </div>
        </div>
    </div>

</div>
<!--End Contact Form & Info-->

@endsection