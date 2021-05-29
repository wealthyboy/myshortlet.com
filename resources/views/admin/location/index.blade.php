@extends('admin.layouts.app')

@section('content')

<style>
  .categories .categories {
     margin-left: 20px;
  }
</style>

<div class="row">
       

        <div class="col-md-6">
            @include('errors.errors')
            <div class="card">
                <div class="card-content">
                    <h4 class="card-title">Add Location</h4>
                    <div class="toolbar">
                        <!--Here you can write extra buttons/actions for the toolbar  -->
                    </div>
                    <div class="material-datatables">
                    <form action="{{ route('location.store') }}" method="post" enctype="multipart/form-data" id="form--location">
                        @csrf

                        <div class="form-group label-floating">
                            <label class="control-label">
                                Name
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                   name="name"
                                   type="text"
                                   required="true"
                            />
                        </div>
                        <div class="form-group ">
                            <label class="control-label"></label>
                            <select name="parent_id" class="form-control">
                            <option  value="">--Choose One--</option>
                                @foreach($locations as $location)
                                    <option class="" value="{{ $location->id }}" >{{ $location->name }} </option>
                                    @include('includes.children_options',['obj'=>$location,'space'=>'&nbsp;&nbsp;'])
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="location_type" required class="form-control">
                                <option  value="">--Choose Type--</option>
                                <option  value="country">Country</option>
                                <option  value="state">State</option>
                                <option  value="city">City</option>
                                <option  value="street">Street</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <div class="form-group ">
                                <label class="control-label"> </label>
                                <textarea name="description" 
                                id="description" class="form-control"  rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <h3 class="info-text">Upload Image</h3>
                            </div>
                            <div class="col-md-6">
                                <div id="m_image"  class="uploadloaded_image text-center mb-3">
                                    <div class="upload-text"> 
                                            <a class="activate-file" href="#">
                                            <img src="{{ asset('backend/img/upload_icon.png') }}">
                                            <b>Banner Image </b> 
                                            </a>
                                    </div>
                                    <div id="remove_image" class="remove_image hide">
                                        <a class="delete_image"  href="#">Remove</a>
                                    </div>
                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="location_image"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" id="stored_image" name="image">
                                </div>
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
                    <h4 class="card-title">Country/State</h4>
                        <div  class="checkbox col-md-6 text-left">
                            <label>
                                <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes" > Select All
                            </label>
                        </div>
                        <div  class="col-md-6 text-right">
                            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-location').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                <i class="material-icons">close</i> Delete
                            </a>
                        </div> 
                        <div class="clearfix"></div> 
                        <form action="{{ route('location.destroy',['location'=>1]) }}" method="post" enctype="multipart/form-data" id="form-location">
                        @csrf
                        @method('DELETE')
                        <div class="material-datatables">
                            @foreach($locations as $location)
                                <div class="parent" value="{{ $location->id }}">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="{{ $location->id }}" name="selected[]" >
                                        {{ $location->name }}  <a href="{{ route('location.edit',['location'=>$location->id]) }}"><i class="fa fa-pencil"></i> Edit</a> 
                                    </label>
                                </div>   
                                @include('includes.children',['obj'=>$location,'space'=>'&nbsp;&nbsp;','model' => 'location','url' => 'location'])
                            </div>
                            @endforeach  
                        </div>
                    </form>
                </div><!-- end content-->
            </div><!--  end card  -->
        </div> <!-- end col-md-6 -->
    </div> <!-- end row -->




@endsection

@section('inline-scripts')

$(document).ready(function() {
    let activateFileExplorer = 'a.activate-file';
    let delete_image = 'a.delete_image';
    var main_file = $("input#file_upload_input");

    Img.initUploadImage({
        url:'/admin/upload/image?folder=locations',
        activator: activateFileExplorer,
        inputFile: main_file,
    });

    Img.deleteImage({
        url:'/admin/location/delete/image',
        activator: delete_image,
        inputFile: main_file,
    });
});

@stop





