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

                <form action="{{ route('admin.invoices.index') }}" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                placeholder="Search by full name" value="{{ request('full_name') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Search by phone" value="{{ request('phone') }}">
                        </div>

                        <div class="form-group col-md-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
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
                                            <a target="_blank" href="/check-in?id={{$invoice->user_reservation->id}}"
                                                class="btn btn-success btn-simple" title="Check in link">
                                                Check in
                                            </a>
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