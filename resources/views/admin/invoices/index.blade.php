@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        {{-- ✅ Success & Error Messages --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ session('error') }}
        </div>
        @endif

        {{-- ✅ Header Buttons --}}
        <div class="text-right mb-3">
            <a href="{{ url()->current() }}"
                class="btn btn-primary btn-simple btn-xs"
                data-confirm="Refresh this page?"
                title="Refresh">
                <i class="material-icons">refresh</i> Refresh
            </a>

            <a href="{{ route('admin.invoices.create') }}"
                class="btn btn-primary btn-simple btn-xs"
                data-confirm="Create a new invoice?"
                title="Add Invoice">
                <i class="material-icons">add</i> Add Invoice
            </a>

            <a href="#"
                class="btn btn-danger btn-simple btn-xs"
                data-confirm="Are you sure you want to remove selected invoices?"
                data-submit="#form-invoices"
                title="Remove">
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
                    <div class="row">

                        <div class="col-md-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="full_name" value="{{ request('full_name') }}">
                        </div>

                        <div class="col-md-2">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ request('phone') }}">
                        </div>

                        <div class="col-md-2">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-1">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Any</option>
                                <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Paid</option>
                                <option value="not_paid" {{ request('status')=='not_paid' ? 'selected' : '' }}>Not Paid</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <button type="submit"
                                class="btn btn-primary btn-block"
                                data-confirm="Apply invoice filters?">
                                Apply Filter
                            </button>
                        </div>
                    </div>

                    <hr>

                    @php
                    $allowedEmails = [
                    'jacob.atam@gmail.com',
                    'oluwa.tosin@avenuemontaigne.ng'
                    ];
                    @endphp

                    @if(in_array(Auth::user()->email, $allowedEmails))
                    <div class="row">

                        <div class="col-md-3">
                            <a href="{{ route('admin.invoices.export', request()->query()) }}"
                                class="btn btn-success btn-block"
                                data-confirm="Download PDF report?">
                                Download PDF Report
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.invoices.invoices', request()->query()) }}"
                                class="btn btn-success btn-block"
                                data-confirm="Download invoices ZIP file?">
                                Download Invoices (ZIP)
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.invoices.emailReport', request()->query()) }}"
                                class="btn btn-success btn-block"
                                data-confirm="Email invoice report?">
                                Email Report
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('admin.invoices.emailReportInvoices', request()->query()) }}"
                                class="btn btn-success btn-block"
                                data-confirm="Email report and invoices?">
                                Email Report & Invoices
                            </a>
                        </div>

                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- ✅ Invoices Table --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Invoices</h4>

                <div class="table-responsive">
                    <form action="{{ route('admin.invoices.destroy', ['invoice' => 1]) }}"
                        method="POST"
                        id="form-invoices">
                        @csrf
                        @method('DELETE')

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox"
                                            onclick="$('input[name*=selected]').prop('checked', this.checked)">
                                    </th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Receipt Sent</th>
                                    <th>Invoice Sent</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($invoices as $invoice)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected[]" value="{{ $invoice->id }}">
                                    </td>

                                    <td>{{ $invoice->invoice }}</td>
                                    <td>{{ $invoice->full_name }}</td>
                                    <td>{!! $invoice->sent ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}</td>
                                    <td>{!! $invoice->resent ? '<span class="badge badge-warning">Yes</span>' : '<span class="badge badge-secondary">No</span>' !!}</td>
                                    <td>{{ $invoice->sent ? 'Paid' : 'Not Paid' }}</td>
                                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    <td>{{ number_format($invoice->total) }}</td>

                                    <td class="text-right">
                                        <a href="{{ route('admin.invoices.create', ['copy_id'=>$invoice->id]) }}"
                                            class="btn btn-primary btn-simple"
                                            data-confirm="Create invoice from this one?">
                                            Create
                                        </a>

                                        <a href="{{ url("/admin/invoices/{$invoice->id}/send-receipt") }}"
                                            class="btn btn-success btn-simple"
                                            data-confirm="? You must confirm payment before sending receipt">
                                            Receipt
                                        </a>

                                        <a href="{{ url("/admin/invoices/{$invoice->id}/resend") }}"
                                            class="btn btn-warning btn-simple"
                                            data-confirm="Resend invoice email?">
                                            Invoice
                                        </a>

                                        <a href="{{ url("/admin/invoices/{$invoice->id}/download") }}"
                                            class="btn btn-info btn-simple"
                                            data-confirm="Download invoice?">
                                            Download
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No invoices found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="pull-right">
                    {{ $invoices->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('inline-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('[data-confirm]').forEach(function(el) {

            el.addEventListener('click', function(e) {
                e.preventDefault();

                let message = this.dataset.confirm || 'Are you sure?';
                let submitForm = this.dataset.submit;
                let href = this.getAttribute('href');

                if (!confirm(message)) return;

                if (submitForm) {
                    document.querySelector(submitForm).submit();
                    return;
                }

                if (href && href !== '#') {
                    window.location.href = href;
                }
            });

        });

    });
</script>
@stop