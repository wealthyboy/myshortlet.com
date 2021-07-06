

@extends('layouts.user')
@section('content')


<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
<div class="mb-6">
   <h2 class="mb-0 text-heading fs-22 lh-15">My Profile</h2>
   <p class="mb-1"></p>
</div>
<form>
   <div class="row mb-6">
      <form action="">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body px-6 pt-6 pb-5">
                <h3 class="card-title mb-0 text-heading fs-22 lh-15">Change password</h3>
                <p class="card-text"></p>
                <div class="form-group">
                    <label for="oldPassword" class="text-heading">Old Password</label>
                    <input type="password" class="form-control form-control-lg border-0" id="oldPassword" name="oldPassword">
                </div>
                <div class="form-row mx-n4">
                    <div class="form-group col-md-6 col-lg-12 col-xxl-6 px-4">
                        <label for="newPassword" class="text-heading">New Password</label>
                        <input type="password" class="form-control form-control-lg border-0" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group col-md-6 col-lg-12 col-xxl-6 px-4">
                        <label for="confirmNewPassword" class="text-heading">Confirm New Password</label>
                        <input type="password" class="form-control form-control-lg border-0" id="confirmNewPassword" name="confirmNewPassword">
                    </div>
                </div>
                </div>

                <div class="d-flex justify-content-end flex-wrap">
                    <button class="btn btn-lg btn-primary ml-4 mb-3">Update</button>
                </div>
            </div>
        </div>
      </form>
      
   </div>
   
</form>
</div>



@endsection
@section('page-scripts')
@stop

