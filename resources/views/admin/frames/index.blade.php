@extends('admin.layouts.app')

@section('content')


<div class="row">
    <div class="col-md-6">
        @include('errors.errors')
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Frames</h4>
              
                <div class="material-datatables">
                <form action="{{ route('frames.store') }}" method="post" enctype="multipart/form-data" id="form-category">
                    @csrf
                        <div class="form-group label-floating">
                            <label class="control-label">
                                Name
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                name="title"
                                type="text"
                                required="true"
                            />
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label">
                                Price
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                name="price"
                                type="text"
                                required="true"
                            />
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
                                            <b>Frame Image </b> 
                                            </a>
                                    </div>
                                    <div id="remove_image" class="remove_image hide">
                                        <a class="delete_image"  href="#">Remove</a>
                                    </div>
                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="category_image"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" id="stored_image" name="image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="m_image"  class="uploadloaded_image text-center mb-3">
                                    <div class="upload-text"> 
                                            <a class="activate-file" href="#">
                                            <img src="{{ asset('backend/img/upload_icon.png') }}">
                                            <b>Big Frame Image </b> 
                                            </a>
                                    </div>
                                    <div id="remove_image" class="remove_image hide">
                                        <a class="delete_image"  href="#">Remove</a>
                                    </div>
                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="limage"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" id="stored_image" name="large_image">
                                </div>
                            </div>

                        </div>


                        <div class="hide">
                            <h3 class="info-text">Sizes</h3>
                            <div class="well well-sm" style="height: 350px; background-color: #fff; color: black; overflow: auto;">
                                <ul class="treeview" data-role="treeview">
                                    <li data-icon="" data-caption="">
                                        <ul>
                                            <li data-caption="Projects">
                                                <ul>
                                                    <li data-caption="Web">
                                                    <div class="checkbox">
                                                    <label> 
                                                       <input name="" value="" type="checkbox">
                                                    </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="">
                            <h3 class="info-text">Sizes</h3>
                            <div class="well well-sm" style="height: 200px; background-color: #fff; color: black; overflow: auto;">
                                <ul class="treeview" data-role="treeview">
                                    @foreach($sizes as $size)
                                        <li data-caption="Documents">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="size_id[]" value="{{ $size->id }}
                                                    " type="checkbox">
                                                    {{ $size->name }}
                                            </div>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round btn-group  btn-fill">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-6 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Frames</h4>
                    <div  class="checkbox col-md-6 text-left">
                        <label>
                            <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes" > Select All
                        </label>
                    </div>
                    <div  class="col-md-6 text-right">
                        <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-categories').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                            <i class="material-icons">close</i> Delete
                        </a>
                    </div> 
                    <div class="clearfix"></div> 

                    <form action="{{ route('frames.destroy',['frame'=>1]) }}" method="post" enctype="multipart/form-data" id="form-categories">
                    @csrf
                    @method('DELETE')
                    <div class="material-datatables">
                        @foreach($frames as $frame)
                            <div class="parent" value="{{ $frame->id }}">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{ $frame->id }}" name="selected[]" >
                                    {{ $frame->title }}  
                                    <a href="{{ route('frames.edit',['frame'=>$frame->id]) }}">
                                    <i class="fa fa-pencil"></i> Edit</a> 
                                </label>
                            </div>   
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
        url:'/admin/upload/image?folder=frames',
        activator: activateFileExplorer,
        inputFile: main_file,
    });

    Img.deleteImage({
        url:'/admin/category/delete/image?folder=frames',
        activator: delete_image,
        inputFile: main_file,
    });
});

@stop





