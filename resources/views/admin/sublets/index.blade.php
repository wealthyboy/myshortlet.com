@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.sublets.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>

            <a href="{{ route('admin.sublets.create', ['mode'=>'sublet']) }}" rel="tooltip" title="Add New" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">add</i>
                Add Apartment
            </a>
            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-sublets').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                <i class="material-icons">close</i>
                Remove
            </a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="rose">
                <i class="material-icons">Filter</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Filter - <small class="category"></small></h4>

                <form action="{{-- route('search_apartments') --}}" method="get">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="form-group label-floating ">
                                <label class="control-label">Search Agents</label>
                                <input required type="text" value="" name="q" class="form-control">
                            </div>
                        </div>

                    </div>
                    <input name="search" type="submit" value="search" class="btn btn-rose  btn-round pull-right">
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">

            <div class="card-content">

                <h4 class="card-title">Properties</h4>
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <form action="{{ route('admin.sublets.destroy',['sublet'=>1]) }}" method="post" enctype="multipart/form-data" id="form-sublets">
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
                                    <th>Agent</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($sublets as $sublet)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{ $sublet->id }}" name="selected[]">
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.sublets.edit',['sublet'=> $sublet->id ] ) }}" rel="tooltip" class="">
                                            {{ optional($sublet->user)->fullname()}}
                                        </a>
                                    </td>

                                    <td class="td-actions  text-right">
                                        <a href="{{ route('admin.sublets.edit',['sublet'=> $sublet->id ] ) }}" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs">
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
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection
@section('inline-scripts')
$(document).ready(function() {

});
@stop