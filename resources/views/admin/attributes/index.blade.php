@extends('admin.layouts.app')
@section('content')
@section('pagespecificstyles')
<link href="{{ asset('backend/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
@stop
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Attributes</h4>
                <div class="toolbar">
                    <!--Here you can write extra buttons/actions for the toolbar  -->
                </div>
                <div class="material-datatables">
                    <form action="{{ route('attributes.store',['type'=> $type ?? '']) }}" method="post" enctype="multipart/form-data" id="form--attribute">
                        @csrf
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Name
                                <small>*</small>
                            </label>
                            <input class="form-control" name="name" type="text" required="true" />
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Sort Order
                                <small>*</small>
                            </label>
                            <input class="form-control" name="sort_order" type="text" />
                        </div>


                        <div class="form-group label-floating">
                            <label class="control-label">
                                Price
                                <small>*</small>
                            </label>
                            <input class="form-control" name="price" type="text" />
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Svg icon
                                <small>*</small>
                            </label>
                            <input class="form-control" name="svg" type="text" />
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="parent_id" class="form-control">
                                <option value="" selected="">--Choose Parent--</option>
                                @foreach($parents as $attribute)
                                <option class="" value="{{ $attribute->id }}">{{ $attribute->name }} </option>
                                @include('includes.product_attr',['attributes'=>$attribute])
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="type" required class="form-control">
                                <option value="" selected>Choose Type</option>
                                @foreach($helper::attribute_types() as $key => $attribute_type)
                                <option value="{{ $key }}">{{ $attribute_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Apartment Owner
                            </label>
                            <input class="form-control" name="apartment_owner" type="text" />
                        </div>
                        <h4 class="info-text">Upload Image Here</h4>
                        <div class="">
                            <div id="m_image" class="uploadloaded_image text-center mb-3">
                                <div class="upload-text">
                                    <a class="activate-file" href="#">
                                        <img src="{{ asset('backend/img/upload_icon.png') }}">
                                        <b>Add Image </b>
                                    </a>
                                </div>
                                <div id="remove_image" class="remove_image hide">
                                    <a class="delete_image" href="#">Remove</a>
                                </div>

                                <input accept="image/*" class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="category_image" />
                                <input type="hidden" class="file_upload_input  stored_image" id="stored_image" name="image">
                            </div>
                        </div>

                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round  btn-fill">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-6 -->

    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Attributes</h4>
                <div class="checkbox col-md-6 text-left">
                    <label>
                        <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes"> Select All
                    </label>
                </div>
                <div class="col-md-6 text-right">
                    <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-attribute').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                        <i class="material-icons">close</i> Delete
                    </a>
                </div>
                <div class="clearfix"></div>
                <form action="{{ route('attributes.destroy',['attribute'=>1]) }}" method="post" id="form-attribute">
                    @csrf
                    @method('DELETE')
                    <div class="material-datatables">
                        @foreach($attributes as $key => $attrs)
                        <h3 class="text-capitalize">{{ $str::replaceFirst('_', ' ', $key) }}</h3>
                        <div class="well well-sm" style="height: 250px; background-color: #fff; color: black; overflow: auto;">
                            @foreach($attrs as $key => $attribute)
                            <div class="parent" value="{{ $attribute->id }}">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="{{ $attribute->id }}" name="selected[]">
                                        <strong>{{ $attribute->name }}</strong> <a href="{{ route('attributes.edit',['attribute'=>$attribute->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
                                    </label>
                                </div>
                                @include('includes.children',['obj'=>$attribute,'space'=>'&nbsp;&nbsp;','model' => 'attributes','url' => 'attribute'])
                            </div>
                            @endforeach
                        </div>

                        @endforeach
                    </div>
                </form>
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