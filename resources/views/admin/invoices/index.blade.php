@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        {{-- ✅ Success & Error Messages --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('error') }}
        </div>
        @endif

        {{-- ✅ Header Buttons --}}
        <div class="text-right mb-3">
            <a href="{{ url()->current() }}" class="btn btn-primary btn-simple btn-xs" title="Refresh">
                <i class="material-icons">refresh</i> Refresh
            </a>

            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-simple btn-xs" title="Add Invoice">
                <i class="material-icons">add</i> Add Invoice
            </a>

            <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-invoices').submit() : false;"
                class="btn btn-danger btn-simple btn-xs" title="Remove">
                <i class="material-icons">close</i> Remove
            </a>
        </div>
    </div>

    {{-- ✅ Filter Card --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="rose">
                <i class="material-icons">filter_list</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Filter Invoices</h4>

                <form action="{{ route('admin.invoices.index') }}" method="GET" class="mb-3">

                    <div class="form-row">

                        <div class="form-group col-md-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="full_name" value="{{ request('full_name') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ request('phone') }}">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>

                        <div class="form-group col-md-2">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Any</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="not_paid" {{ request('status') == 'not_paid' ? 'selected' : '' }}>Not Paid</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">

                        <!-- ⭐ NEW: Apartments Filter -->
                        <div class="form-group col-md-3">
                            <label>Apartment</label>
                            <select name="apartment_id" class="form-control">
                                <option value="">Any</option>

                                @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}"
                                    {{ request('apartment_id') == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->name ?? $apartment->apartment_name ?? 'Apartment '.$apartment->id }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary btn-block rounded">Filter</button>
                        </div>

                        <div class="form-group col-md-2">
                            <a href="{{ route('admin.invoices.export', request()->query()) }}"
                                class="btn btn-info btn-simple">
                                Download PDF Report
                            </a>
                        </div>

                        <div class="form-group col-md-2">
                            <a href="{{ route('admin.invoices.emailReport', request()->query()) }}"
                                class="btn btn-info btn-simple">
                                Email Report
                            </a>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- ✅ Invoices Table --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Invoices</h4>

                <div class="material-datatables">
                    {{-- ✅ Added table-responsive wrapper --}}
                    <div class="table-responsive">
                        <form action="{{ route('admin.invoices.destroy', ['invoice' => 1]) }}" method="POST"
                            enctype="multipart/form-data" id="form-invoices">
                            @method('DELETE')
                            @csrf

                            <table id="datatables"
                                class="table table-striped table-shopping table-no-bordered table-hover"
                                cellspacing="0" width="100%">
                                <thead class="text-primary">
                                    <tr>
                                        <th>
                                            <div class="checkbox">
                                                <label>
                                                    <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                                                        type="checkbox" name="optionsCheckboxes">
                                                </label>
                                            </div>
                                        </th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Receipt Sent</th>
                                        <th>Invoice Sent</th>
                                        <th>Status</th>
                                        <th>Date Added</th>
                                        <th>Total</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="{{ $invoice->id }}" name="selected[]">
                                                </label>
                                            </div>
                                        </td>

                                        <td>{{ $invoice->invoice }}</td>
                                        <td>{{ $invoice->full_name }}</td>

                                        {{-- ✅ Colored status badges --}}
                                        <td>
                                            @if($invoice->sent)
                                            <span style="background-color: green;" class="badge badge-success">Yes</span>
                                            @else
                                            <span class="badge badge-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($invoice->resent)
                                            <span style="background-color: green;" class="badge badge-warning">Yes</span>
                                            @else
                                            <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($invoice->sent)
                                            <span style="background-color: green;" class="badge badge-warning">Paid</span>
                                            @else
                                            <span class="badge badge-secondary">Not Paid</span>
                                            @endif
                                        </td>

                                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $invoice->currency ?? '₦' }}{{ number_format($invoice->total) }}</td>

                                        <td class="td-actions text-right">
                                            @if($invoice->sent)

                                            <a target="_blank" href="/check-in?id={{optional($invoice->user_reservation)->id}}"
                                                class="btn btn-success btn-simple" title="Check in link">
                                                Check in
                                            </a>
                                            @endif
                                            <a href="{{ url("/admin/invoices/{$invoice->id}/send-receipt") }}"
                                                class="btn btn-success btn-simple" title="Send Receipt">
                                                Send Receipt
                                            </a>

                                            <a href="{{ url("/admin/invoices/{$invoice->id}/resend") }}"
                                                class="btn btn-warning btn-simple" title="Send Invoice">
                                                Send Invoice
                                            </a>

                                            <a href="{{ url("/admin/invoices/{$invoice->id}/download") }}"
                                                class="btn btn-info btn-simple" title="Download">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No invoices found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <div class="pull-right mt-3">
                    {{ $invoices->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('backend/js/products.js') }}"></script>
@stop