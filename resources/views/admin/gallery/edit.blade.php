@extends('admin.layouts.app')

@section('content')
<form method="post" action="{{ route('admin.galleries.update', ['gallery'=> $gallery->id]) }}">
    @csrf
    @method('PATCH')


    <div class="card">
        <div class="row p-attr mb-2 variation-panel">

            <div id="variation-panel" data-id="" class=" v-panel">
                <div class="clearfix"></div>
                <div class="col-md-12">

                    <div class="col-md-12">
                        <div class="form-group label-floating is-ty">
                            <label class="control-label">Title</label>
                            <input name="title" required="true" value="{{ $gallery->title }}" class="form-control  variation" type="text">
                            <span class="material-input"></span>
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Image Links</label>
                            <input value="{{ $gallery->image_link }}" class="form-control   pull-right" name="image_link" type="text">
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Video Links</label>
                            <input value="{{ $gallery->video_link }}" class="form-control   pull-right" name="video_link" type="text">
                        </div>
                    </div>


                    <div class="clearfix"></div>

                    <div class="col-sm-12 mt-5">
                        <div id="j-drop" class="j-drop">
                            <input accept="image/*" required="true" data-msg="Upload  at least 5 images" onchange="getFile(this,'images[]')" class="upload_input" multiple="true" type="file" id="upload_file_input" name="product_image" />
                            <div class=" upload-text ">
                                <a class="" href="#">
                                    <img class="" src="/backend/img/upload_icon.png">
                                    <b>Click on anywhere to upload image</b>
                                </a>
                            </div>
                            <div id="j-details" class="j-details">
                                @if($gallery->images->count())
                                @foreach($gallery->images as $image)
                                <div id="{{ $image->id }}" class="j-complete">
                                    <div class="j-preview">
                                        <img class="img-thumnail" src="{{ $image->image }}">
                                        <div id="remove_image" class="remove_image remove-image">
                                            <a class="remove-image" data-id="{{ $image->id }}" data-randid="{{ $image->id }}" data-model="Image" data-type="complete" data-url="{{ $image->image }}" href="#">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-footer text-right">
                        <button type="submit" class="btn btn-rose btn-round btn-group  btn-fill">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



@endsection
@section('page-scripts')
<script src="{{ asset('backend/js/products.js') }}"></script>
<script src="{{ asset('backend/js/uploader.js') }}"></script>
@stop
@section('inline-scripts')
$(document).ready(function() {

});
@stop