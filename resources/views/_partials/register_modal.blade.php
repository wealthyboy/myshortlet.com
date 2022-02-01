<form method="POST" class="d-none register-form sign_in-or-sign-up" action="/register">
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
      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus>
      <label id="auth-email-error" class="error" for=""></label>

   </div>

   <div class="form-row">
        <div class="form-group bmd-form-group col-3">
            <select name="phone_none" class="form-control" id="">
                <option value="" > Select code</option>
                @foreach ($helper::phoneCodes() as  $key => $code)
                @if ($key == '234')
                <option value="{{ $key }}" selected> {{ $code }}</option>
                @else
                <option value="{{ $key }}" > {{ $code }}</option>

                @endif
                @endforeach
            </select>
        </div>

        <div class="form-group bmd-form-group col-9">
            <label class="bmd-label-floating">Phone number</label>
            <input  type="text"  class="form-control" name="phone_number" value="{{ old('phone_number') }}"  autofocus>
            <label id="auth-phone-number-error" class="error" for=""></label>

        </div>
   </div>

   <div class="form-row">
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">Password</label>
            <input id="r-password" type="password" class="form-control" name="password" >
        </div>
        <div class="form-group bmd-form-group col-6">
            <label class="bmd-label-floating">Confirm Password</label>
            <input id="r-confirmation" type="password" class="form-control" name="password_confirmation" >
        </div>
   </div>
   
   <div class="clearfix"></div>
   <p class="form-group mt-3">
      <button type="submit"   class=" ml-1 btn btn-primary btn-round  btn-block  auth-form-button">
        <div class="auth-spinner d-none">
            @include('_partials.spinner',['bgcolor' => '#ffffff'])
         </div> 
        <span class="lt bold text-white">Sign up</span> 
      </button>
   </p>
   <div class="mt-4 pt-4 text-center border-top">
      <p class="form-group col-12">
        Alraedy have an account?  <a class="auth-form bold text-white" data-to="login"   href="#">Login</a>
      </p>
      </p>
   </div>
</form>