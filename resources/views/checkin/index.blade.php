@extends('layouts.auth')
@section('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.css" integrity="sha512-bbUR1MeyQAnEuvdmss7V2LclMzO+R9BzRntEE57WIKInFVQjvX7l7QZSxjNDt8bg41Ww05oHSh0ycKFijqD7dA==" crossorigin="anonymous" />
@endsection

@section('content')
<!--Content-->
<section style="background-color: rgb(248, 245, 244);" class="sec-padding">
    <div class="container ">
        <div class="row justify-content-center">
            <div class="ml-1 col-md-7   mr-1">
                <div class=" mt-4 mb-4">
                    @if (session('success'))
                    <div class="alert alert-success">
                        Thank you for checking in .Enjoy your stay
                    </div>

                    @else
                    <form method="POST" id="submit" class=" pl-4 pr-4 border form-validate bg-white " action="/checkin">

                        <div class="text-center">
                            <a href="/" class="navbar-brand mt-5">
                                <div class="logo-small"><img src="/images/logo/avem-logo.png" alt="" srcset=""></div>
                            </a>
                            <p class="bold-2">Fill in the form to check-in </p>
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
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">First name</label>
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>

                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Last name</label>
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Email</label>
                                <input id="email" type="email" class="form-control" name="email" autocomplete="off">

                            </div>

                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Phone</label>
                                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required>
                            </div>


                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Checkin </label>
                                <input type="text" class="form-control selector" name="checkin">
                            </div>
                            <div class="form-group bmd-form-group col-md-6 col-12">
                                <label class="bmd-label-floating">Checkout</label>
                                <input type="text" class="form-control selector" name="checkout">
                            </div>

                            <div class="form-group bmd-form-group col-md-12 col-12">
                                <select name="apartment_id" class="form-control">
                                    <option selected>Choose Apartment</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <p class="form-field-wrapper p-1 col-12 ">
                            <label for="pictures">Upload Pictures</label>
                        <div class="dropzone col-12 mb-4" id="my-dropzone"></div>
                        <div id="pic-error" class="error"></div>
                        </p>

                        <button type="submit" id="login_form_button" data-loading="Loading" class=" ml-1 btn btn-primary btn-round btn-lg btn-block" name="login" value="Log in">Submit</button>


                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<div style="height: 200px;"></div>
<!--End Content-->
@endsection

@section('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.1/min/dropzone.min.js" integrity="sha512-En/Po50Bl8kIECa2WkhxhdYeoKDcrJpBKMo9tmbuwbm9RxHWZV8/Y5xM9sh3QbrnFgM3hVR/2umJ33qGJk45pQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
@stop

@section('inline-scripts')

$(".selector").flatpickr();


Dropzone.autoDiscover = false;

jQuery(window).on('load', function(){
var d = $("div#my-dropzone")

if (d.length){

myDropzone = new Dropzone("div#my-dropzone",{
url: "/file/uploads",
paramName: "file",
maxFilesize: 10,
timeout: 180000,
acceptedFiles: 'image/*',
addRemoveLinks: true,
uploadMultiple:true,
maxFiles: 1,

headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
init: function() {

$("#submit").on('click', function(e) {
if (!myDropzone.files || !myDropzone.files.length) {
$("div.error").html('Please upload your id.')
}
});
this.on("addedfile", function(file) { $("div.error").html('')});
}
})
}


var $validator = $('form.form-validate').validate({
rules: {
first_name: {
required: true,
},
last_name: {
required: true,
},
email: {
required: true,
email: true
},

relationship: {
required: true,
},

},
messages: {
email: {
required: "Please enter your email",
email: "Please enter a valid email"
},

},
submitHandler: function(form) {
//Check if dropzone is uploading
if(myDropzone){
myDropzone.on("uploadprogress", function(file) {
$("div.error").html('Please allow your image to finish uploading')
return false;
});
}

$("#form").addClass('header-filter')


form.submit();
}

});
})

@stop