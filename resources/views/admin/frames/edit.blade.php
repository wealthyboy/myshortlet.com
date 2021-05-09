
@extends('admin.layouts.app')

@section('content')

   <div class="row">
   <form  action="{{ route('frames.update',['frame' => $frame->id ]) }}" method="post">
       
        <div class="col-md-8">
            @include('errors.errors')
            <div class="card">
                   @csrf
                   @method('PATCH')
                    <div class="card-content">
                        <h4 class="card-title">Edit Category</h4>
                        <div class="form-group label-floating">
                            <label class="control-label">
                              Title
                                <small>*</small>
                            </label>
                            <input class="form-control"
                                   name="title"
                                   type="text"
                                   value="{{ $frame->title }}"
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
                                value="{{ $frame->price }}"

                            />
                        </div>

                        
                       
                        

                        <div class="row">
                            <div class="col-md-12">
                               <h3 class="info-text">Upload Image</h3>
                            </div>
               
                            <div class="col-md-6">
                                <div id="m_image"  class="uploadloaded_image text-center mb-3">
                                    <div class="upload-text  {{ $frame->image !== null  ?  'hide' : '' }}"> 
                                        <a class="activate-file" href="#">
                                        <img src="{{ asset('backend/img/upload_icon.png') }}">
                                        <b>Frame Image </b> 
                                        </a>
                                    </div>
                                    <div id="remove_image" class="remove_image {{ $frame->image !== null  ?  '' : 'hide' }}">
                                        <a class="delete_image"  href="#">Remove</a>
                                    </div>
                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="frame_image"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" id="stored_image" value="{{ $frame->image }}" name="frame_image">
                                    @if ( $frame->image )
                                       <img id="stored_image" class="img-thumnail" src="{{ $frame->image }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="m_image"  class="uploadloaded_image text-center mb-3">
                                    <div class="upload-text  {{ $frame->large_image !== null  ?  'hide' : '' }}"> 
                                        <a class="activate-file" href="#">
                                            <img src="{{ asset('backend/img/upload_icon.png') }}">
                                            <b>Frame Image </b> 
                                        </a>
                                    </div>
                                    <div id="remove_image" class="remove_image {{ $frame->large_image !== null  ?  '' : 'hide' }}">
                                        <a class="delete_image"  href="#">Remove</a>
                                    </div>
                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="frame_large_image"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" id="stored_image" value="{{ $frame->large_image }}"  name="frame_large_image">
                                    @if ( $frame->large_image )
                                       <img id="stored_image" class="img-thumnail" src="{{ $frame->large_image }}" alt="">
                                    @endif
                                </div>
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
                                                   <input name="size_id[]" value="{{ $size->id }}" type="checkbox">
                                                   {{ $size->name }}
                                                </label>
                                            </div>
                                        </li>
                                   @endforeach
                                </ul>
                            </div>

                        </div>

                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round  btn-fill">Submit</button>
                        </div>
                    </div>
            </div>
        </div>
       
   
    </form>

</div>
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
        url:'/admin/category/delete/image',
        activator: delete_image,
        inputFile: main_file,

    });
});
@stop






