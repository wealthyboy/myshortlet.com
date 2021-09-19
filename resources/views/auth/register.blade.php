@extends('layouts.auth')
 
@section('content')
   
 <!--Content-->
    <section class="sec-padding mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="ml-1 col-md-8   mr-1">
                    <div class=" mt-4 mb-4">
                      <form method="POST" class=" pl-4 pr-4" action="/login">
                      <div class="text-center"> 
                          <h1>Register</h1>
                          <p class=""> Have access to your bookings history ,  .e.t.c</p>
                        </div>
                        @csrf

                        <div class="form-row">
                           <div class="form-group bmd-form-group col-6">
                           <label class="bmd-label-floating">Email address</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                 @if ($errors->all() )
                                    @foreach($errors->all()  as $error)
                                       <span class="error">
                                             <strong class="text-danger">{{ $error }}</strong>
                                       </span>
                                    @endforeach
                                 @endif
                           </div>

                           <div class="form-group bmd-form-group col-md-6 col-12">
                           <label class="bmd-label-floating">Email address</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                 @if ($errors->all() )
                                    @foreach($errors->all()  as $error)
                                       <span class="error">
                                             <strong class="text-danger">{{ $error }}</strong>
                                       </span>
                                    @endforeach
                                 @endif
                           </div>

                           <div class="form-group bmd-form-group col-md-6 col-12">
                           <label class="bmd-label-floating">Email address</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                 @if ($errors->all() )
                                    @foreach($errors->all()  as $error)
                                       <span class="error">
                                             <strong class="text-danger">{{ $error }}</strong>
                                       </span>
                                    @endforeach
                                 @endif
                           </div>

                           <div class="form-group bmd-form-group col-md-6 col-12">
                           <label class="bmd-label-floating">Email address</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                 @if ($errors->all() )
                                    @foreach($errors->all()  as $error)
                                       <span class="error">
                                             <strong class="text-danger">{{ $error }}</strong>
                                       </span>
                                    @endforeach
                                 @endif
                           </div>

                           <div class="form-group bmd-form-group col-md-6 col-12">
                           <label class="bmd-label-floating">Email address</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                 @if ($errors->all() )
                                    @foreach($errors->all()  as $error)
                                       <span class="error">
                                             <strong class="text-danger">{{ $error }}</strong>
                                       </span>
                                    @endforeach
                                 @endif
                           </div>



                        
                        <div class="clearfix"></div>

                        <p class="form-group ">
                              <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn--primary btn-round btn-lg btn-block" name="login" value="Log in">Log In</button>
                        </p>
                        </div>

                     
                        

                        <div class="mt-4 pt-4 text-center border-top">
                              <p class="form-group col-12">
                                 Dont have an account yet?  <a class="color--primary bold" href="/register">Create One</a></p>
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
