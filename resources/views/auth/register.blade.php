@extends('layouts.auth')

@section('content')

<!--Content-->
<section class="sec-padding">
   <div class="container">
      <div class="row justify-content-center">
         <div class="ml-1 col-md-7   mr-1">
            <div class=" mt-4 mb-4">
               <form method="POST" class=" pl-4 pr-4" action="/register">
                  <div class="text-center">
                     <h2 class="bold-3">Register</h2>
                     <p class=""> Have access to your bookings history , .e.t.c</p>
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
                     <div class="form-group bmd-form-group col-6">
                        <label class="bmd-label-floating">First name</label>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>

                     </div>


                     <div class="form-group bmd-form-group col-md-6 col-12">
                        <label class="bmd-label-floating">Last name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                     </div>

                     <div class="form-group bmd-form-group col-md-6 col-12">
                        <label class="bmd-label-floating">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                     </div>

                     <div class="form-group bmd-form-group col-md-6 col-12">
                        <label class="bmd-label-floating">Phone</label>
                        <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required>
                     </div>

                     <div class="form-group bmd-form-group col-md-6 col-12">
                        <label class="bmd-label-floating">Confirm Password</label>
                        <input id="password" type="password" class="form-control" name="password_confirmation" required>

                     </div>

                     <div class="form-group bmd-form-group col-md-6 col-12">
                        <label class="bmd-label-floating">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                     </div>

                  </div>

                  <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn-primary btn-round btn-lg btn-block" name="login" value="Log in">Submit</button>

                  <div class="mt-4 pt-4 text-center border-top">
                     <p class="form-group col-12">
                        Have an account? <a class="color--primary bold-2" href="/login">Login</a></p>
                     </p>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!--End Content-->
@endsection