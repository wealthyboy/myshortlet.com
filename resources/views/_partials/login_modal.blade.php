<form method="POST" class="d-none login-form sign-in-or-sign-up pl-4 pr-4" action="/login">
   @csrf
   <div class="text-center">
      <h2>Login</h2>
      <p class="">Sign in to unlock the best of AVM.</p>
   </div>
   <div class="form-group bmd-form-group">
      <label class="bmd-label-floating">Email address</label>
      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
      <label id="auth-error" class="error" for=""></label>
   </div>
   <div class="form-group bmd-form-group">
      <label class="bmd-label-floating">Password</label>
      <input id="password" type="password" class="form-control" name="password" required>
   </div>
   <div class="clearfix"></div>

   <div class="d-flex justify-content-between align-items-center">
      <div class="remeber">
         <div class="checkbox  flex-grow-1">
            <label id="box50" class="checkbox-label">
               <input for="box50" name="remember_me" value="1" class="" type="checkbox">
               <span class="checkbox-custom rectangular"></span>
               <span class="checkbox-label-text mt-1">Remember </span>
            </label>
         </div>
      </div>

      <div class="text-right mt-2">
         <!-- <a class="bold" href="/password/reset">Forget your password?</a> -->
      </div>
   </div>
   <div class="clearfix"></div>
   <p class="form-group mt-3">
      <button type="submit" class="ml-1 btn btn-primary btn-round  btn-block auth-form-button">
         <div class="auth-spinner d-none">
            @include('_partials.spinner',['bgcolor' => '#ffffff'])
         </div>
         <span class="lt bold text-white bold">Login</span>
      </button>
   </p>
   <div class="mt-4 pt-4 text-center border-top">
      <p class="form-group col-12">
         Dont have an account yet? <a class="auth-form bold" data-to="register" href="#">Create One</a>
      </p>
      </p>
   </div>
</form>