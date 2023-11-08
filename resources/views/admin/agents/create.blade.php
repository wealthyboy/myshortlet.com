@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @include('admin.errors.errors')
        <div class="card">
            <form id="register" method="POST" action="{{ route('admin.agents.store') }}">
                @csrf
                <div class="card card-login card-hidden">
                    <div class="card-header text-center" data-background-color="rose">
                        <h4 class="card-title">Register</h4>
                    </div>
                    <p class="category text-center"></p>
                    <div class="card-content px-4">

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">First Name</label>
                                    <input id="first_name" required="true" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Last Name</label>
                                    <input id="last_name" required="true" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" autofocus>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input id="email" required="true" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Phone</label>
                                    <input id="Phone" required="true" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" autofocus>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Password</label>
                                    <input id="password" required="true" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" autofocus>
                                </div>
                            </div>

                        </div>

                        <div class="row">





                        </div>
                    </div>
                    <div class="footer  pull-right ">
                        <button type="submit" name="admin" value="submit" class="btn btn-rose  btn-wd btn-lg py-2 mr-4">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('inline-scripts')
@stop