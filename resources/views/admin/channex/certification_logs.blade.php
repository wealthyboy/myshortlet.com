@extends('admin.layouts.app')

@section('pagespecificstyles')
<style>
    .channex-log-page .card-content { padding: 28px 30px 30px; }
    .channex-log-heading { align-items: flex-start; display: flex; justify-content: space-between; margin-bottom: 24px; }
    .channex-log-heading h4 { font-size: 22px; font-weight: 500; margin: 0 0 5px; }
    .channex-log-heading p { color: #7b8391; font-size: 13px; margin: 0; }
    .channex-log-filters { align-items: flex-end; background: #f7f8fa; border: 1px solid #e8ebef; border-radius: 12px; display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; padding: 15px; }
    .channex-log-filters .form-group { margin: 0 !important; min-width: 125px; }
    .channex-log-filters .form-group.scenario-filter { flex: 1; min-width: 210px; }
    .channex-log-filters label { color: #626b78; display: block; font-size: 11px; font-weight: 500; margin: 0 0 5px !important; text-transform: uppercase; }
    .channex-log-filters .form-control { background: #fff; border: 1px solid #dfe3e8; border-radius: 8px; box-shadow: none; font-size: 13px; height: 40px; padding: 8px 11px; width: 100%; }
    .channex-log-filters .btn { height: 40px; margin: 0; }
    .channex-log-table { border: 1px solid #e8ebef; border-radius: 12px; overflow: hidden; }
    .channex-log-table .table { margin: 0; }
    .channex-log-table thead { background: #f5f6f8; }
    .channex-log-table thead th { border-bottom: 1px solid #e4e7eb !important; color: #303744; font-size: 12px; font-weight: 700; letter-spacing: .04em; padding: 13px 16px !important; text-transform: uppercase; }
    .channex-log-table tbody td { border-color: #edf0f3 !important; padding: 16px !important; vertical-align: middle; }
    .channex-log-id { color: #202633; display: block; font-size: 14px; font-weight: 600; }
    .channex-log-time { color: #89919d; display: block; font-size: 11px; line-height: 1.5; margin-top: 3px; }
    .channex-log-source { color: #242a36; display: block; font-size: 13px; font-weight: 500; }
    .channex-log-scenario { color: #7e8692; display: block; font-size: 11px; margin-top: 4px; }
    .channex-log-property strong, .channex-log-property small { display: block; }
    .channex-log-property strong { color: #303643; font-size: 13px; font-weight: 500; }
    .channex-log-property small { color: #89919c; font-size: 11px; margin-top: 4px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .channex-status { border-radius: 999px; display: inline-block; font-size: 10px; font-weight: 600; padding: 5px 10px; text-transform: uppercase; }
    .channex-status.is-success { background: #e8f7ee; color: #18824a; }
    .channex-status.is-failed { background: #fdecec; color: #c53c3c; }
    .channex-result-meta { color: #7b8390; display: block; font-size: 11px; margin-top: 7px; }
    .channex-view-log { align-items: center; border-radius: 999px !important; display: inline-flex; gap: 5px; margin: 0 !important; padding: 8px 13px !important; text-transform: none !important; }
    .channex-view-log .material-icons { font-size: 16px; }
    .channex-empty { color: #9299a3; padding: 36px !important; }
    @media (max-width: 767px) {
        .channex-log-page .card-content { padding: 24px 15px; }
        .channex-log-heading { gap: 12px; }
        .channex-log-filters .form-group { min-width: calc(50% - 6px); }
        .channex-log-table { overflow-x: auto; }
        .channex-log-table .table { min-width: 760px; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.channex.certification.logs') }}" class="btn btn-primary btn-simple btn-xs">
                <i class="material-icons">refresh</i>
                Refresh
            </a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card channex-log-page">
            <div class="card-header card-header-icon" data-background-color="rose">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <div class="channex-log-heading">
                    <div><h4 class="card-title">Channex Certification Logs</h4><p>Review the summary, then open a record to inspect its complete request and response.</p></div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('admin.channex.certification.logs') }}" class="channex-log-filters">
                    <div class="form-group">
                        <label>Test #</label>
                        <select name="test_number" class="form-control">
                            <option value="">All</option>
                            @for($n = 1; $n <= 14; $n++)
                                <option value="{{ $n }}" {{ (string) request('test_number') === (string) $n ? 'selected' : '' }}>
                                    {{ $n }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Source</label>
                        <select name="source" class="form-control">
                            <option value="">All</option>
                            <option value="full_sync" {{ request('source') === 'full_sync' ? 'selected' : '' }}>full_sync</option>
                            <option value="ari_outbox" {{ request('source') === 'ari_outbox' ? 'selected' : '' }}>ari_outbox</option>
                            <option value="ari_ui_queue" {{ request('source') === 'ari_ui_queue' ? 'selected' : '' }}>ari_ui_queue</option>
                            <option value="ari_batch_queue" {{ request('source') === 'ari_batch_queue' ? 'selected' : '' }}>ari_batch_queue</option>
                            <option value="booking_webhook" {{ request('source') === 'booking_webhook' ? 'selected' : '' }}>booking_webhook</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>success</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>failed</option>
                        </select>
                    </div>

                    <div class="form-group scenario-filter">
                        <label>Scenario</label>
                        <input type="text" name="scenario" value="{{ request('scenario') }}" class="form-control" placeholder="test_1_full_sync">
                    </div>

                    <button type="submit" class="btn btn-rose btn-sm">Filter</button>
                </form>

                <div class="channex-log-table">
                    <table class="table table-striped table-no-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Log</th>
                                <th>Activity</th>
                                <th>Property</th>
                                <th>Result</th>
                                <th class="text-right">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    $testNumber = null;
                                    if (!empty($log->scenario) && preg_match('/^test_(\d+)/', $log->scenario, $matches)) {
                                        $testNumber = $matches[1];
                                    }
                                    $requestPayload = (array) $log->request_payload;
                                    $responsePayload = (array) $log->response_payload;
                                    $availabilityValues = (array) data_get($requestPayload, 'availability_values', []);
                                    $restrictionValues = (array) data_get($requestPayload, 'restriction_values', []);
                                    $taskIds = (array) $log->task_ids;
                                    $propertyUuid = data_get($requestPayload, 'property_uuid');
                                    $updateCount = count($availabilityValues) + count($restrictionValues);
                                @endphp
                                <tr>
                                    <td><span class="channex-log-id">#{{ $log->id }}</span><span class="channex-log-time">{{ optional($log->created_at)->format('M j, Y') }}<br>{{ optional($log->created_at)->format('g:i:s A') }}</span></td>
                                    <td><span class="channex-log-source">{{ ucwords(str_replace('_', ' ', $log->source)) }}</span><span class="channex-log-scenario">{{ $log->scenario ?: 'General activity' }}{{ $testNumber ? ' · Test '.$testNumber : '' }}</span></td>
                                    <td class="channex-log-property"><strong>Property {{ $log->property_id ?: '—' }}{{ $log->apartment_id ? ' · Apartment '.$log->apartment_id : '' }}</strong><small title="{{ $propertyUuid ?: 'No property UUID' }}">{{ $propertyUuid ?: 'No property UUID recorded' }}</small></td>
                                    <td><span class="channex-status {{ $log->status === 'success' ? 'is-success' : 'is-failed' }}">{{ $log->status }}</span><span class="channex-result-meta">{{ $log->source === 'full_sync' ? data_get($requestPayload, 'days', 500).'-day full sync' : $updateCount.' update(s)' }} · {{ count($taskIds) }} task ID(s)</span></td>
                                    <td class="text-right"><a class="btn btn-rose btn-sm channex-view-log" href="{{ route('admin.channex.certification.logs.show', ['log' => $log->id]) }}"><i class="material-icons">visibility</i> View details</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center channex-empty">No certification logs yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pull-right">{{ $logs->links() }}</div>

            </div>
        </div>
    </div>
</div>
@endsection
