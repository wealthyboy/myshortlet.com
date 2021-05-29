
@extends('admin.layouts.app')

@section('content')
<div class="row">
        <div class="col-md-10">
            @include('errors.errors')
            <div class="card">
                <form id="" action="{{ route('location.update',['location'=>$location->id]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="card-content">
                        <h4 class="card-title">Edit </h4>
                        <div class="form-group label-floating">
                            <label class="control-label">
                              Name
                                <small>*</small>
                            </label>
                            <input 
                                class="form-control"
                                name="name"
                                type="text"
                                value="{{ $location->name }}"
                                required="true"
                             />
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="parent_id" class="form-control">
                            <option  value="">--Choose One--</option>
                                @foreach($locations as $loc)
                                   @if($location->parent_id ==  $loc->id )
                                        <option class="" value="{{ $loc->id }}" selected="selected">{{ $loc->name }} </option>                                        
                                        @include('includes.children_options',['obj'=>$loc,'space'=>'&nbsp;&nbsp;'])
                                    @else
                                        <option class="" value="{{ $loc->id }}" >{{ $loc->name }} </option>
                                        @include('includes.children_options',['model' => $location,'obj'=>$loc,'space'=>'&nbsp;&nbsp;'])
                                    @endif
                                @endforeach
                            </select>
                        </div> 

                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="location_type" required class="form-control">
                                <option  value="">--Choose Type--</option>
                                <option  {{  $location->location_type ==  'country' ? 'selected' : "" }} value="country">Country</option>
                                <option  {{  $location->location_type ==  'state' ? 'selected' : "" }}  value="state">State</option>
                                <option  {{  $location->location_type ==  'city' ? 'selected' : "" }}  value="city">City</option>
                                <option  {{  $location->location_type ==  'street' ? 'selected' : "" }}  value="street">Street</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <div class="form-group ">
                                <label class="control-label"> </label>
                                <textarea name="description" 
                                id="description" class="form-control"  rows="7">{{ $location->description }}</textarea>
                            </div>
                        </div>

                        
                        <h4 class="info-text">Upload Image Here</h4>
                            <div class="">
                                <div id="m_image"  class="uploadloaded_image text-center mb-3">
                                    <div class="upload-text {{ $location->image !== null  ?  'hide' : '' }}"> 
                                         
                                            <a class="activate-file" href="#">
                                            <img src="{{ asset('backend/img/upload_icon.png') }}">
                                            <b>Add Image </b> 
                                            </a>
                                    </div>
                                    <div id="remove_image" class="remove_image {{ $location->image !== null  ?  '' : 'hide' }}">
                                        <a class="delete_image" data-id="{{ $location->id }}" href="#">Remove</a> 
                                    </div>

                                    <input accept="image/*"  class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="location_image"  />
                                    <input type="hidden"  class="file_upload_input  stored_image" value="{{ $location->image }}" name="image">
                                    @if ( $location->image )
                                       <img id="stored_image" class="img-thumnail" src="{{ $location->image }}" alt="">
                                    @endif
                                    
                                </div>
                            </div>                           
                        <div class="form-footer text-right">
                            <button type="submit" class="btn btn-rose btn-round  btn-fill">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>


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






