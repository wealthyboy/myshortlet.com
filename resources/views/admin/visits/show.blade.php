@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.visits.index') }}" rel="tooltip" title="Refresh" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>

        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Visits</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ $tracking->ip_address }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>{{ $tracking->user_agent }}</td>
                            </tr>
                            <tr>
                                <th>Visited At</th>
                                <td>{{ $tracking->visited_at }}</td>
                            </tr>

                            <tr>
                                <th>Apartment</th>
                                <td>{{ optional($tracking->apartment)->name }}</td>
                            </tr>
                            <tr>
                                <th>Session ID</th>
                                <td>{{ $tracking->session_id }}</td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>{{ $tracking->action }}</td>
                            </tr>
                            <tr>
                                <th>Time Spent</th>
                                <td>{{ $tracking->time_spent }}</td>
                            </tr>
                            <tr>
                                <th>Page URL</th>
                                <td>{{ $tracking->page_url }}</td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>{{ $tracking->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $tracking->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $tracking->email }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $tracking->code }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $tracking->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Services</th>
                                <td>{{ $tracking->services }}</td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td>{{ $tracking->currency }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $tracking->total }}</td>
                            </tr>
                            <tr>
                                <th>Property ID</th>
                                <td>{{ $tracking->property_id }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $tracking->country }}</td>
                            </tr>
                            <tr>
                                <th>Coupon</th>
                                <td>{{ $tracking->coupon }}</td>
                            </tr>
                            <tr>
                                <th>Original Amount</th>
                                <td>{{ $tracking->original_amount }}</td>
                            </tr>
                            <tr>
                                <th>Referer</th>
                                <td>{{ $tracking->referer }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
<!-- end row -->
@endsection
@section('pagespecificscripts')
<script src="/asset/js/jquery.datatables.js"></script>
@stop
@section('inline-scripts')
$(document).ready(function() {
$('#datatables').DataTable({
"pagingType": "full_numbers",
"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
responsive: true,
language: {
search: "_INPUT_",
searchPlaceholder: "Search records",
}
});
});
@stop