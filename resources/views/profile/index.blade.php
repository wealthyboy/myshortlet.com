@extends('layouts.user')
@section('content')


<div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
<div class="mb-6">
   <h2 class="mb-0 text-heading fs-22 lh-15">My Profile</h2>
   <p class="mb-1"></p>
</div>

@include('errors.errors')
@include('includes.success')

<form action="{{ route('profiles.update',['profile'=>$user->id])  }}" method="POST">

   <div class="row mb-6">
         @csrf
         @method('PATCH')

         <div class="col-lg-9">
            <div class="card mb-6">
               <div class="card-body px-6 pt-6 pb-5">
                  <h3 class="card-title mb-0 text-heading fs-22 lh-15">Contact information</h3>
                  <p class="card-text"></p>
                  <div class="form-row mx-n4">
                     <div class="form-group col-md-6 px-4">
                        <label for="firstName" class="text-heading">First name</label>
                        <input type="text" class="form-control form-control-lg border-0" id="firstName"  value="{{ $user->name }}" name="first_name">
                     </div>
                     <div class="form-group col-md-6 px-4">
                        <label for="lastName" class="text-heading">Last name</label>
                        <input type="text" class="form-control form-control-lg border-0" id="lastName" value="{{ $user->last_name }}"  name="last_name">
                     </div>
                  </div>
                  <div class="form-row mx-n4">
                     <div class="form-group col-md-6 px-4">
                        <label for="phone" class="text-heading">Phone</label>
                        <input type="text" class="form-control form-control-lg border-0" id="phone" value="{{ $user->phone_number }}"  name="phone_number">
                     </div>
                     <div class="form-group col-md-6 px-4 mb-md-0">
                        <label for="email" class="text-heading">Email</label>
                        <input type="email" class="form-control form-control-lg border-0" id="email"  value="{{ $user->email }}" name="email">
                     </div>
                  </div>
                  <div class="form-row mx-n4">
                     <div class="form-group col-md-12 px-4">
                        <label for="title" class="text-heading">Title</label>
                        <input type="text" class="form-control form-control-lg border-0" id="title" value="{{ $user->company_title }}" name="company_title">
                     </div>
                     
                  </div>

                  <div class="form-row mx-n4">
                     <div class="form-group col-md-12 px-4 mb-md-0">
                        <label for="bio">Company Bio</label>
                        <textarea class="form-control  border-0" name="bio" id="bio" rows="5">{{ $user->bio }}</textarea>
                     </div>
                  </div>

                  <div class="d-flex justify-content-end flex-wrap mt-5">
                     <button type="submit" class="btn btn-lg bg-hover-white border rounded-lg mb-3">Submit Profile</button>
                  </div>

                  
               </div>
            </div>
            
         </div>

         <div class="col-lg-3">
            <div id="j-drop" class=" j-drop">
               <input
                  accept="image/*"
                  class="upload_input"
                  data-msg="Upload  your image"
                  type="file"
                  name="img"
                  onchange="getFile(this,'image','Apartment',false)"
                  />
               <div class=" upload-text   {{ isset($apartment) &&  $apartment->image ? 'hide' : ''}}">
                  <a class="" href="#">
                  <img class="" src="/backend/img/upload_icon.png" />
                  <b>Add a profile image</b>
                  <p></p>
                  </a>
               </div>
               <div id="j-details" class="j-details">
                  @if(isset($apartment))
                        <div id="{{ $apartment->id }}" class="j-complete">
                           <div class="j-preview">
                              <img class="img-thumnail" src="{{ $apartment->image }}">
                              <div id="remove_image" class="remove_image remove-image">
                                    <a class="remove-image"  data-id="{{ $apartment->id }}" data-randid="{{ $apartment->id }}" data-model="Image" data-type="complete"  data-url="{{ $apartment->image }}" href="#">Remove</a>
                                    <input type="hidden" class="file_upload_input stored_image_url" value="{{ $apartment->image }}" name="edit_variation_images[{{ $apartment->id }}][]">
                              </div>
                           </div>
                        </div>
                  @endif
               </div>
            </div>
         </div>
   
   </div>

   </form>

   
</div>



@endsection
@section('page-scripts')
   <script src="{{ asset('backend/js/scrips.js') }}"></script>
@stop
@section('inline-scripts')
   $(document).ready(function() {
      let activateFileExplorer = 'a.activate-file';
      let delete_image = 'a.delete_image';
      var main_file = $("input#file_upload_input");

      Img.initUploadImage({
         url:'/admin/upload/image?folder=category',
         activator: activateFileExplorer,
         inputFile: main_file,
      });

      Img.deleteImage({
         url:'/admin/category/delete/image',
         activator: delete_image,
         inputFile: main_file,
      });
   });

@stop

