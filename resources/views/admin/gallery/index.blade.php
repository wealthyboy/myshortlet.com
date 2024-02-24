@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.galleries.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>

            <a href="{{ route('admin.galleries.create') }}" rel="tooltip" title="Add New" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">add</i>
                Add Folder
            </a>
            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-galleries').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                <i class="material-icons">close</i>
                Remove
            </a>
        </div>
    </div>



    <div class="col-md-12">
        <div class="card">

            <div class="card-content">

                <h4 class="card-title">Properties</h4>
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar-->
                </div>
                <div class="material-datatables">
                    <form action="{{ route('admin.galleries.destroy',['gallery'=>1]) }}" method="post" enctype="multipart/form-data" id="form-galleries">
                        @method('DELETE')
                        @csrf

                        <table id="datatables" class="table table-striped table-shopping table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>

                                <tr>
                                    <th>
                                        <div class="checkbox">
                                            <label>
                                                <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes">
                                            </label>
                                        </div>
                                    </th>

                                    <th>Title</th>

                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($galleries as $gallery)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{ $gallery->id }}" name="selected[]">
                                            </label>
                                        </div>
                                    </td>

                                    <td><a target="_blank">{{ $gallery->title }} </a></td>

                                    <td class="td-actions ">
                                        <a href="{{ route('admin.galleries.edit',['gallery'=>$gallery->id ] ) }}" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">edit</i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="pull-right">{{ $galleries->links() }}</div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection
@section('inline-scripts')
$(document).ready(function() {

});
@stop