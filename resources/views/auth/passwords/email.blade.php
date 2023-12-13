@extends('layouts.auth')

@section('content')

<!--Content-->
<section class="sec-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="ml-1 col-md-7   mr-1">
                <div class=" mt-4 mb-4">
                    <form method="POST" class=" pl-4 pr-4" action="{{ route('password.email') }}">
                        <div class=" text-center">
                            <h2 class="bold-3">Forgot Password</h2>
                            <p class=""> Having trouble accessing your password</p>
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

                            <div class="form-group bmd-form-group col-md-12 col-12">
                                <label class="bmd-label-floating">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                            </div>


                        </div>

                        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn-primary btn-round btn-lg btn-block" name="login" value="Log in">Submit</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Content-->
@endsection