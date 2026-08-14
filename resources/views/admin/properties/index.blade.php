@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.properties.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>

            <a href="{{ route('admin.properties.create', ['mode'=>'shortlet']) }}" rel="tooltip" title="Add New" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">add</i>
                Add Property
            </a>
            <a href="{{ route('admin.channex.certification.logs') }}" rel="tooltip" title="Channex Logs" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">assignment</i>
                Channex Certification Logs
            </a>
            <a href="{{ route('admin.channex.ari_updates.index') }}" rel="tooltip" title="Rates & Availability" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">event_available</i>
                Rates & Availability
            </a>
            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-apartments').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
                                <label class="control-label">Search Properties</label>
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
                    <form action="{{ route('admin.properties.destroy',['property'=>1]) }}" method="post" enctype="multipart/form-data" id="form-apartments">
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
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>category</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($properties as $property)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{ $property->id }}" name="selected[]">
                                            </label>
                                        </div>
                                    </td>

                                    <td><a target="_blank">{{ $property->name }} {{ optional($property->city)->name }} {{ optional($property->state)->name }}</a></td>
                                    <td>{{ $property->allow == 1 ? 'Live' : 'Offline' }}</td>
                                    <td>
                                        {{ optional(optional($property->categories)->first())->name }}
                                    </td>
                                    <td class="td-actions d-flex justify-content-between text-right">
                                        <a href="{{ route('admin.properties.edit',['property'=>$property->id,'mode' => $property->mode ] ) }}" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">edit</i>
                                            Edit
                                        </a>

                                        <a href="/admin/properties/sync?id={{$property->id}}" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">refresh</i>
                                            Sync Property to Channex
                                        </a>

                                        @if($property->channex_property_id)
                                        <button type="submit" form="channex-full-sync-{{ $property->id }}" class="btn btn-warning btn-simple btn-xs" rel="tooltip" title="Send 500-day availability, rates and restrictions">
                                            <i class="material-icons">sync</i>
                                            Full Sync (500 Days)
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>

                    @foreach($properties as $property)
                        @if($property->channex_property_id)
                        <form id="channex-full-sync-{{ $property->id }}" action="{{ route('admin.properties.full_sync') }}" method="POST" style="display:none" onsubmit="return confirm('Send a 500-day full sync for this property to Channex?');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $property->id }}">
                        </form>
                        @endif
                    @endforeach
                </div>
                <div class="pull-right">{{ $properties->links() }}</div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection
@section('inline-scripts')
$(document).ready(function() {

});
@stop
