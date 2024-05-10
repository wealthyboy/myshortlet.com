@extends('admin.layouts.app')
@section('content')

<div class="row">
    <div class="col-md-10">
        @include('errors.errors')
        <div class="card">
            <form id="" action="{{ route('attributes.update',['attribute'=>$attr->id]) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="card-content">
                    <h4 class="card-title">Edit</h4>
                    <div class="form-group label-floating">
                        <label class="control-label">
                            Name
                            <small>*</small>
                        </label>
                        <input class="form-control" name="name" type="text" value="{{ $attr->name }}" required="true" />
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">
                            Sort Order
                            <small>*</small>
                        </label>
                        <input class="form-control" name="sort_order" type="text" value="{{ $attr->sort_order }}" />
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">
                            Price
                            <small>*</small>
                        </label>
                        <input class="form-control" name="price" type="text" value="{{ $attr->price }}" />
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">
                            Svg icon
                            <small>*</small>
                        </label>
                        <input class="form-control" name="svg" type="text" value="{{ $attr->svg }}" />
                    </div>

                    <div class="form-group ">
                        <label class="control-label"></label>
                        <select name="parent_id" class="form-control">
                            <option value="">--Choose Parent--</option>

                            @foreach($attributes as $attribute)
                            @if($attr->parent_id == $attribute->id )
                            <option class="" value="{{ $attribute->id }}" selected="selected">{{ $attribute->name }} </option>
                            @include('includes.children_options',['obj'=>$attribute,'space'=>'&nbsp;&nbsp;'])

                            @else
                            <option class="" value="{{ $attribute->id }}">{{ $attribute->name }} </option>
                            @include('includes.children_options',['model' => $attr,'obj'=>$attribute,'space'=>'&nbsp;&nbsp;'])
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"></label>
                        <select name="type" required class="form-control">
                            <option value="">Choose Type</option>
                            @foreach($helper::attribute_types() as $key => $attribute_type)
                            @if($key == $attr->type)
                            <option value="{{ $key }}" selected>{{ $attribute_type }}</option>
                            @else
                            <option value="{{ $key }}">{{ $attribute_type }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">
                            Apartment Owner
                        </label>
                        <input class="form-control" value="{{ $attr->apartment_owner }}" name="apartment_owner" type="text" />
                    </div>
                    <h4 class="info-text">Upload Image Here</h4>
                    <div class="">
                        <div id="m_image" class="uploadloaded_image text-center mb-3">
                            <div class="upload-text {{ $attr->image !== null  ?  'hide' : '' }}">
                                <a class="activate-file" href="#">
                                    <img src="{{ asset('backend/img/upload_icon.png') }}">
                                    <b>Add Image </b>
                                </a>
                            </div>
                            <div id="remove_image" class="remove_image {{ $attr->image !== null  ?  '' : 'hide' }}">
                                <a class="delete_image" data-id="{{ $attr->id }}" href="#">Remove</a>
                            </div>

                            <input accept="image/*" class="upload_input" data-msg="Upload  your image" type="file" id="file_upload_input" name="_image" />
                            <input type="hidden" class="file_upload_input  stored_image" value="{{ $attr->image }}" name="image">
                            @if ( $attr->image )
                            <img id="stored_image" class="img-thumnail" src="{{ $attr->image }}" alt="">
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
});
@stop