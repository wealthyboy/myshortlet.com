<form method="POST" class="d-none register-form sign-in-or-sign-up" action="/register">
   @csrf
   <div class="text-center">
      <h2>Register</h2>
      <p class="">Sign up to unlock the best of Avm.</p>
   </div>
   <div class="form-row">
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">First name</label>
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"  autofocus>
        </div>
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">Last name</label>
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus>
        </div>
   </div>
   

   <div class="form-group bmd-form-group">
      <label class="bmd-label-floating">Email address</label>
      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
   </div>

   <div class="form-row">
        <div class="form-group bmd-form-group col-3">
                <select class="form-control" id="">
                    @foreach ($helper::phoneCodes() as  $key => $code)
                    <option value="{{ $key }}" > {{ $code }}</option>
                    @endforeach
                </select>
        </div>

        <div class="form-group bmd-form-group col-9">
            <label class="bmd-label-floating">Phone number</label>
            <input  type="text"  class="form-control" name="phone_number" value="{{ old('phone_number') }}" required autofocus>
        </div>
   </div>

   <div class="form-row">
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">Password</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">Confirm Password</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>
   </div>
   
   <div class="clearfix"></div>
   <p class="form-group mt-3">
      <button type="submit"  data-loading="Loading" class=" ml-1 btn btn-primary btn-round  btn-block">
        <div class="auth-spinner d-none">
            @include('_partials.spinner',['bgcolor' => '#ffffff'])
         </div> 
        <span class="lt">Sign up</span> 
      </button>
   </p>
   <div class="mt-4 pt-4 text-center border-top">
      <p class="form-group col-12">
        Alraedy have an account?  <a class="auth-form" data-to="login"   href="#">Login</a>
      </p>
      </p>
   </div>
</form>