@extends('admin.layouts.app')
@section('content')
@section('pagespecificstyles')
<link href="{{ asset('backend/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
@stop
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add SubLet</h4>
                <div class="toolbar">
                    <!--Here you can write extra buttons/actions for the toolbar  -->
                </div>
                <div class="material-datatables">
                    <form action="" method="post" enctype="multipart/form-data" id="form--attribute">
                        @csrf

                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="parent_id" class="form-control">
                                <option value="" selected="">--Choose Agent--</option>
                                @foreach($agents as $agent)
                                <option class="" value="{{ $agent->id }}">{{ $agent->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="type" required class="form-control">
                                <option value="" selected>Choose Property</option>
                                @foreach($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round  btn-fill">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-6 -->


</div> <!-- end row -->
@endsection
@section('page-scripts')
@stop

@section('inline-scripts')
$(document).ready(function() {

let activateFileExplorer = 'a.activate-file';
let delete_image = 'a.delete_image';
var main_file = $("input#file_upload_input");
Img.initUploadImage({
url:'/admin/upload/image?folder=attributes',
activator: activateFileExplorer,
inputFile: main_file,
});
Img.deleteImage({
url:'/admin/category/delete/image',
activator: delete_image,
inputFile: main_file,
});
$('.colorpicker').colorpicker()


});
@stop