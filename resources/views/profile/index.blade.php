

@extends('layouts.user')
@section('content')


<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
<div class="mb-6">
   <h2 class="mb-0 text-heading fs-22 lh-15">My Profile</h2>
   <p class="mb-1"></p>
</div>
<form>
   <div class="row mb-6">
      <div class="col-lg-6">
         <div class="card mb-6">
            <div class="card-body px-6 pt-6 pb-5">
               <div class="row">
                  <div class="col-sm-4 col-xl-12 col-xxl-7 mb-6">
                     <h3 class="card-title mb-0 text-heading fs-22 lh-15">Photo</h3>
                     <p class="card-text">Upload your profile photo.</p>
                  </div>
                  <div class="col-sm-8 col-xl-12 col-xxl-5">
                     <img src="images/my-profile.png" alt="My Profile" class="w-100">
                     <div class="custom-file mt-4 h-auto">
                        <input type="file" class="custom-file-input" hidden id="customFile" name="file">
                        <label class="btn btn-secondary btn-lg btn-block" for="customFile">
                        <span class="d-inline-block mr-1"><i class="fal fa-cloud-upload"></i></span>Upload
                        profile image</label>
                     </div>
                     <p class="mb-0 mt-2">
                        *minimum 500px x 500px
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="card mb-6">
            <div class="card-body px-6 pt-6 pb-5">
               <h3 class="card-title mb-0 text-heading fs-22 lh-15">Contact information</h3>
               <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
               <div class="form-row mx-n4">
                  <div class="form-group col-md-6 px-4">
                     <label for="firstName" class="text-heading">First name</label>
                     <input type="text" class="form-control form-control-lg border-0" id="firstName" name="firsName">
                  </div>
                  <div class="form-group col-md-6 px-4">
                     <label for="lastName" class="text-heading">Last name</label>
                     <input type="text" class="form-control form-control-lg border-0" id="lastName" name="lastname">
                  </div>
               </div>
               <div class="form-row mx-n4">
                  <div class="form-group col-md-6 px-4">
                     <label for="phone" class="text-heading">Phone</label>
                     <input type="text" class="form-control form-control-lg border-0" id="phone" name="phone">
                  </div>
                  <div class="form-group col-md-6 px-4">
                     <label for="mobile" class="text-heading">Mobile</label>
                     <input type="text" class="form-control form-control-lg border-0" id="mobile" name="mobile">
                  </div>
               </div>
               <div class="form-row mx-n4">
                  <div class="form-group col-md-6 px-4 mb-md-0">
                     <label for="email" class="text-heading">Email</label>
                     <input type="email" class="form-control form-control-lg border-0" id="email" name="email">
                  </div>
                  <div class="form-group col-md-6 px-4 mb-md-0">
                     <label for="skype" class="text-heading">Skype</label>
                     <input type="text" class="form-control form-control-lg border-0" id="skype" name="skype">
                  </div>
               </div>
            </div>
         </div>
         
      </div>
      
   </div>
   <div class="d-flex justify-content-end flex-wrap">
      <button class="btn btn-lg bg-hover-white border rounded-lg mb-3">Delete Profile</button>
   </div>
</form>
</div>



@endsection
@section('page-scripts')
@stop

