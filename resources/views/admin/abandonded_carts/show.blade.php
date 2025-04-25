@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-right">


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
                                <td>{{ $cart->ip_address }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>{{ $cart->user_agent }}</td>
                            </tr>
                            <tr>
                                <th>Visited At</th>
                                <td>{{ $cart->visited_at }}</td>
                            </tr>
                            <tr>
                                <th>Apartment</th>
                                <td>{{ optional($cart->apartment)->name }}</td>
                            </tr>
                            <tr>
                                <th>Session ID</th>
                                <td>{{ $cart->session_id }}</td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>{{ $cart->action }}</td>
                            </tr>
                            <tr>
                                <th>Time Spent</th>
                                <td>{{ $cart->time_spent }}</td>
                            </tr>
                            <tr>
                                <th>Page URL</th>
                                <td>{{ $cart->page_url }}</td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>{{ $cart->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $cart->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $cart->email }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $cart->code }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $cart->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Services</th>
                                <td>{{ $cart->services }}</td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td>{{ $cart->currency }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $cart->total }}</td>
                            </tr>
                            <tr>
                                <th>Property ID</th>
                                <td>{{ $cart->property_id }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $cart->country }}</td>
                            </tr>
                            <tr>
                                <th>Coupon</th>
                                <td>{{ $cart->coupon }}</td>
                            </tr>
                            <tr>
                                <th>Original Amount</th>
                                <td>{{ $cart->original_amount }}</td>
                            </tr>
                            <tr>
                                <th>Referer</th>
                                <td>{{ $cart->referer }}</td>
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