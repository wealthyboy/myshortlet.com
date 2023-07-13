@extends('admin.layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Add Sublet</h4>
                <div class="toolbar">
                    <!--Here you can write extra buttons/actions for the toolbar  -->
                </div>
                <div class="material-datatables">
                    @include('admin.errors.errors')

                    <form action="{{ route('admin.sublets.update', ['sublet' => $sublet->id]) }}" method="post" enctype="multipart/form-data" id="form-attribute">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="control-label"></label>
                            <select name="user_id" required="selected" class="form-control">
                                <option value="" selected="">--Choose Agent--</option>
                                @foreach($agents as $agent)
                                <option class="" value="{{ $agent->id }}" {{ $sublet->user_id ==  $agent->id ?  'selected' : null  }}>{{ $agent->fullname() }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <div class="">
                                <h4 class="card-title">Properties</h4>
                                <div class="">
                                    <div class="well well-sm" style="height: 200px; background-color: #fff; color: black; overflow: auto;">
                                        <ul class="treeview p-0" data-role="treeview">
                                            <li data-icon="" data-caption="">
                                                <ul class="p-0">
                                                    @foreach($properties as $property)
                                                    <li data-caption="Documents">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input {{ $helper->check($sublet->user->properties, $property->id) }} name="property_id[]" value="{{ $property->id }}
                                                    " type="checkbox">
                                                                {{ $property->name }}
                                                        </div>
                                                    </li>
                                                    @if($property->children->count())
                                                    @foreach($property->children as $children)
                                                    <li data-caption="Projects">
                                                        <ul>
                                                            <li data-caption="Web">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input name="apartment_id[]" {{ $helper->check($sublet->user->apartments, $children->id) }} value="{{  $children->id }}" type="checkbox">
                                                                        {{$children->name}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- end content-->
                        </div><!--  end card  -->



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