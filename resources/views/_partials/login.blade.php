<form method="POST" class="login_form pl-4 pr-4" action="/login">
    @csrf
    <div class="text-center">
        <h2 class="bold-3">Login</h2>
        <p class="">Welcome Back!</p>
    </div>
    <!--<p class="large">Great to have you back!</p>-->
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">Email address</label>
        <input id="email" type="email" class="form-control custom-no-focus-outline" name="email" value="{{ old('email') }}" required autofocus>
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
        <input id="password" type="password" class="form-control custom-no-focus-outline" autocomplete="off" name="password" required>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class="checkbox flex-grow-1">
            <label id="box50" class="checkbox-label">
                <input for="box50" name="remember" value="1" class="" type="checkbox">
                <span class="checkbox-custom rectangular"></span>
                <span class="checkbox-label-text">Remember Me</span>
            </label>
        </div>
        <div class="text-right mt-2 ">
            <a class="bold-2" href="/password/reset">Forget your password?</a>
        </div>
    </div>
    <div class="clearfix"></div>
    <p class="form-group ">
        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn bold btn-primary btn-round btn-lg btn-block bold-2" name="login" value="Log in">Log In</button>
    </p>

    <div class="mt-4 pt-4 text-center border-top">
        <p class="form-group col-12 bold">
            Dont have an account yet? <a class=" bold-2" href="/register">Create One</a></p>
        </p>
    </div>
</form>