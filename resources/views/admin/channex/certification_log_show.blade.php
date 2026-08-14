@extends('admin.layouts.app')

@section('pagespecificstyles')
<style>
    .log-show-page { color: #303744; }
    .log-show-header { align-items: center; display: flex; justify-content: space-between; margin-bottom: 20px; }
    .log-show-eyebrow { color: #e91e63; font-size: 10px; font-weight: 700; letter-spacing: .08em; margin-bottom: 6px; text-transform: uppercase; }
    .log-show-header h3 { color: #242a36 !important; font-size: 22px; font-weight: 500 !important; margin: 0 0 5px; }
    .log-show-header p { color: #7e8793; font-size: 12px; margin: 0; }
    .log-back { align-items: center; border-radius: 999px !important; display: inline-flex; gap: 5px; margin: 0 !important; text-transform: none !important; }
    .log-back .material-icons { font-size: 17px; }
    .log-show-card { border-radius: 14px; overflow: hidden; }
    .log-show-card .card-content { padding: 26px 28px 30px; }
    .log-summary-grid { display: grid; gap: 12px; grid-template-columns: repeat(4, 1fr); }
    .log-summary-card { background: #f7f8fa; border: 1px solid #e7eaee; border-radius: 10px; min-width: 0; padding: 13px 14px; }
    .log-summary-card small, .log-summary-card strong { display: block; }
    .log-summary-card small { color: #89919d; font-size: 9px; font-weight: 600; letter-spacing: .04em; margin-bottom: 6px; text-transform: uppercase; }
    .log-summary-card strong { color: #2b313c; font-size: 12px; font-weight: 500; overflow-wrap: anywhere; }
    .log-status { border-radius: 999px; display: inline-block; font-size: 9px; font-weight: 700; padding: 5px 10px; text-transform: uppercase; }
    .log-status.success { background: #e8f7ee; color: #18824a; }
    .log-status.failed { background: #fdecec; color: #c53c3c; }
    .log-section { border-top: 1px solid #eceef1; margin-top: 22px; padding-top: 20px; }
    .log-section-heading { align-items: center; display: flex; justify-content: space-between; margin-bottom: 12px; }
    .log-section h4 { color: #2b313c !important; font-size: 14px; font-weight: 600 !important; margin: 0; }
    .log-count { background: #f0f2f5; border-radius: 999px; color: #6f7885; font-size: 10px; padding: 4px 8px; }
    .log-update-list { display: grid; gap: 8px; }
    .log-update { align-items: center; background: #fbfbfc; border: 1px solid #e8ebef; border-radius: 9px; display: grid; gap: 10px; grid-template-columns: 160px 1fr 1fr; padding: 11px 13px; }
    .log-update strong { color: #303744; font-size: 12px; font-weight: 500; }
    .log-update span, .log-update small { color: #7c8591; font-size: 10px; overflow-wrap: anywhere; }
    .log-task-list { display: flex; flex-wrap: wrap; gap: 7px; }
    .log-task-list code { background: #f2f3f6; border-radius: 6px; color: #4c5563; font-size: 10px; padding: 6px 8px; }
    .log-notes { background: #fffaf2; border: 1px solid #f3e4c5; border-radius: 9px; color: #6e6046; font-size: 12px; margin: 0; padding: 12px 14px; }
    .log-data-grid { display: grid; gap: 16px; grid-template-columns: 1fr 1fr; }
    .log-data-card { border: 1px solid #e7eaee; border-radius: 11px; overflow: hidden; }
    .log-data-title { background: #f5f6f8; border-bottom: 1px solid #e3e7eb; color: #303744; font-size: 12px; font-weight: 700; margin: 0; padding: 13px 15px; }
    .log-data-table { margin: 0 !important; }
    .log-data-table th { background: #fafafb; color: #303744 !important; font-size: 12px !important; font-weight: 700 !important; letter-spacing: .04em; padding: 10px 13px !important; text-transform: uppercase; }
    .log-data-table td { border-color: #edf0f3 !important; font-size: 13px !important; padding: 10px 13px !important; vertical-align: top !important; }
    .log-data-table td:first-child { color: #687281; font-weight: 500; width: 42%; }
    .log-data-table td:last-child { color: #272e39; overflow-wrap: anywhere; }
    .log-empty-data { color: #9299a3; font-size: 11px; margin: 0; padding: 18px 15px; }
    @media (max-width: 991px) { .log-summary-grid, .log-data-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 767px) {
        .log-show-header { align-items: flex-start; gap: 14px; }
        .log-show-card .card-content { padding: 22px 15px; }
        .log-summary-grid, .log-data-grid { grid-template-columns: 1fr; }
        .log-update { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    $availabilityValues = (array) data_get($submittedData, 'availability_values', []);
    $restrictionValues = (array) data_get($submittedData, 'restriction_values', []);
    $queuedUpdates = (array) data_get($submittedData, 'updates', []);
    $taskIds = (array) $log->task_ids;
    $updateCount = count($availabilityValues) + count($restrictionValues) + count($queuedUpdates);
@endphp
<div class="row log-show-page">
    <div class="col-md-12">
        <div class="log-show-header">
            <div>
                <div class="log-show-eyebrow">Channex activity</div>
                <h3>Log #{{ $log->id }} — {{ ucwords(str_replace('_', ' ', $log->source)) }}</h3>
                <p>{{ $log->created_at }} · {{ $log->scenario ?: 'General activity' }}</p>
            </div>
            <a href="{{ route('admin.channex.certification.logs') }}" class="btn btn-default btn-sm log-back"><i class="material-icons">arrow_back</i> Back to logs</a>
        </div>

        <div class="card log-show-card">
            <div class="card-content">
                <div class="log-summary-grid">
                    <div class="log-summary-card"><small>Status</small><strong><span class="log-status {{ $log->status === 'success' ? 'success' : 'failed' }}">{{ $log->status }}</span></strong></div>
                    <div class="log-summary-card"><small>Property</small><strong>{{ $log->property_id ?: '—' }}</strong></div>
                    <div class="log-summary-card"><small>Apartment</small><strong>{{ $log->apartment_id ?: '—' }}</strong></div>
                    <div class="log-summary-card"><small>Property UUID</small><strong>{{ $propertyUuid ?: 'Not recorded' }}</strong></div>
                </div>

                <div class="log-summary-grid" style="margin-top: 12px;">
                    <div class="log-summary-card"><small>Source</small><strong>{{ ucwords(str_replace('_', ' ', $log->source)) }}</strong></div>
                    <div class="log-summary-card"><small>Scenario</small><strong>{{ $log->scenario ?: 'General activity' }}</strong></div>
                    <div class="log-summary-card"><small>Created</small><strong>{{ $log->created_at }}</strong></div>
                    <div class="log-summary-card"><small>Last updated</small><strong>{{ $log->updated_at }}</strong></div>
                </div>

                <section class="log-section">
                    <div class="log-section-heading"><h4>ARI updates</h4><span class="log-count">{{ $updateCount }}</span></div>
                    @if($updateCount)
                        <div class="log-update-list">
                            @foreach($availabilityValues as $value)
                                <div class="log-update"><strong>Availability: {{ data_get($value, 'availability', '—') }}</strong><span>{{ data_get($value, 'date_from', '—') }}{{ data_get($value, 'date_to') && data_get($value, 'date_to') !== data_get($value, 'date_from') ? ' to '.data_get($value, 'date_to') : '' }}</span><small>Room type: {{ data_get($value, 'room_type_id', '—') }}</small></div>
                            @endforeach
                            @foreach($restrictionValues as $value)
                                <div class="log-update"><strong>Rate and restrictions</strong><span>{{ data_get($value, 'date_from', '—') }}{{ data_get($value, 'date_to') && data_get($value, 'date_to') !== data_get($value, 'date_from') ? ' to '.data_get($value, 'date_to') : '' }}</span><small>Rate plan: {{ data_get($value, 'rate_plan_id', '—') }}</small></div>
                            @endforeach
                            @foreach($queuedUpdates as $value)
                                <div class="log-update"><strong>Queued PMS update</strong><span>{{ data_get($value, 'date_from', '—') }}{{ data_get($value, 'date_to') && data_get($value, 'date_to') !== data_get($value, 'date_from') ? ' to '.data_get($value, 'date_to') : '' }}</span><small>Apartment {{ data_get($value, 'apartment_id', '—') }} · Rate plan {{ data_get($value, 'rate_plan_id', '—') }}</small></div>
                            @endforeach
                        </div>
                    @elseif($log->source === 'full_sync')
                        <p class="text-muted">{{ data_get($requestPayload, 'days', 500) }}-day full sync request.</p>
                    @else
                        <p class="text-muted">No individual ARI values were recorded for this activity.</p>
                    @endif
                </section>

                <section class="log-section">
                    <div class="log-section-heading"><h4>Task IDs</h4><span class="log-count">{{ count($taskIds) }}</span></div>
                    @if(count($taskIds))<div class="log-task-list">@foreach($taskIds as $taskId)<code>{{ $taskId }}</code>@endforeach</div>@else<p class="text-muted">No task IDs were returned.</p>@endif
                </section>

                <section class="log-section"><div class="log-section-heading"><h4>Notes</h4></div><p class="log-notes">{{ $log->notes ?: 'No notes recorded.' }}</p></section>

                <section class="log-section">
                    <div class="log-section-heading"><h4>Complete activity data</h4></div>
                    <div class="log-data-grid">
                        <div class="log-data-card">
                            <h5 class="log-data-title">Data sent</h5>
                            @if(count($submittedFields))
                                <div class="table-responsive"><table class="table log-data-table"><thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>@foreach($submittedFields as $field)<tr><td>{{ $field['label'] }}</td><td>{{ $field['value'] }}</td></tr>@endforeach</tbody></table></div>
                            @else
                                <p class="log-empty-data">No submitted data was recorded.</p>
                            @endif
                        </div>
                        <div class="log-data-card">
                            <h5 class="log-data-title">Result received</h5>
                            @if(count($returnedFields))
                                <div class="table-responsive"><table class="table log-data-table"><thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>@foreach($returnedFields as $field)<tr><td>{{ $field['label'] }}</td><td>{{ $field['value'] }}</td></tr>@endforeach</tbody></table></div>
                            @else
                                <p class="log-empty-data">No returned data was recorded.</p>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
