@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.apartments.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>

            <a href="{{ url('/admin/block') }}" rel="tooltip" title="Add New" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">add</i>
                Block Apartment
            </a>
           

            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-apartments').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                <i class="material-icons">close</i>
                Remove
            </a>

        </div>
    </div>

   

    <div class="col-md-12">
        <div class="card">

            <div class="card-content">

                <h4 class="card-title">Blocked apartment dates</h4>
                <p class="category">A block includes the check-in date and releases the apartment on the check-out date.</p>
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <form action="{{ route('admin.blocks.destroy',['block'=>1]) }}" method="post" enctype="multipart/form-data" id="form-apartments">
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
                                    <th>Apartment</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Nights</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($blocks as $block)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{ $block->id }}" name="selected[]">
                                            </label>
                                        </div>
                                    </td>

                                    <td>{{ optional($block->apartment)->name ?: 'Deleted apartment' }}</td>
                                    <td>{{ optional($block->checkin)->format('Y-m-d') }}</td>
                                    <td>{{ optional($block->checkout)->format('Y-m-d') }}</td>
                                    <td>{{ $block->checkin && $block->checkout ? $block->checkin->diffInDays($block->checkout) : '—' }}</td>
                                   
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No apartment dates are currently blocked.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="pull-right">{{-- $apartments->links() --}}</div>
            </div><!-- end content-->
        </div><!--  end card  -->
    </div> <!-- end col-md-12 -->
</div> <!-- end row -->
@endsection
@section('inline-scripts')
$(document).ready(function() {

});
@stop
