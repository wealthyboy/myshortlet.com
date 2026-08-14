@extends('admin.layouts.app')

@section('pagespecificstyles')
<style>
    .live-verify-page .card-content { padding: 28px 30px 32px; }
    .live-verify-heading { align-items: flex-start; display: flex; gap: 20px; justify-content: space-between; margin-bottom: 24px; }
    .live-verify-heading h4 { color: #252b36; font-size: 22px; font-weight: 600; margin: 0 0 6px; }
    .live-verify-heading p { color: #7b8391; font-size: 13px; margin: 0; }
    .live-verify-status { border-radius: 999px; flex: 0 0 auto; font-size: 12px; font-weight: 700; padding: 9px 15px; text-transform: uppercase; }
    .live-verify-status.ready { background: #e7f7ed; color: #168149; }
    .live-verify-status.not-ready { background: #fdeaea; color: #c23535; }
    .live-verify-form { align-items: flex-end; background: #f7f8fa; border: 1px solid #e7eaee; border-radius: 12px; display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; padding: 15px; }
    .live-verify-form .form-group { flex: 1; margin: 0 !important; min-width: 280px; }
    .live-verify-form label { color: #5f6875; display: block; font-size: 11px; font-weight: 700; margin: 0 0 6px !important; text-transform: uppercase; }
    .live-verify-form .form-control { background: #fff; border: 1px solid #dce1e7; border-radius: 8px; box-shadow: none; font-size: 13px; height: 42px; padding: 8px 12px; width: 100%; }
    .live-verify-form .btn { border-radius: 999px !important; height: 42px; margin: 0 !important; padding: 10px 18px !important; text-transform: none; }
    .live-verify-summary { display: grid; gap: 14px; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 24px; }
    .live-verify-stat { background: #fff; border: 1px solid #e7eaee; border-radius: 12px; padding: 16px; }
    .live-verify-stat span { color: #858d98; display: block; font-size: 10px; font-weight: 700; letter-spacing: .04em; margin-bottom: 7px; text-transform: uppercase; }
    .live-verify-stat strong { color: #252b35; display: block; font-size: 14px; font-weight: 600; overflow-wrap: anywhere; }
    .live-verify-section { border: 1px solid #e7eaee; border-radius: 12px; margin-bottom: 22px; overflow: hidden; }
    .live-verify-section-heading { align-items: center; background: #f7f8fa; border-bottom: 1px solid #e7eaee; display: flex; justify-content: space-between; padding: 14px 17px; }
    .live-verify-section-heading h5 { color: #303642; font-size: 14px; font-weight: 700; margin: 0; }
    .live-verify-section-heading small { color: #89919c; font-size: 11px; }
    .live-verify-checks { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 8px 16px; }
    .live-verify-check { align-items: flex-start; border-bottom: 1px solid #edf0f3; display: flex; gap: 9px; min-height: 48px; padding: 13px 6px; }
    .live-verify-check:nth-last-child(-n+2) { border-bottom: 0; }
    .live-verify-check .material-icons { font-size: 19px; }
    .live-verify-check.pass .material-icons { color: #19945a; }
    .live-verify-check.fail .material-icons { color: #d13d3d; }
    .live-verify-check.warning .material-icons { color: #d9921c; }
    .live-verify-check span:last-child { color: #4e5662; font-size: 12px; line-height: 1.55; }
    .live-verify-table { overflow-x: auto; }
    .live-verify-table .table { margin: 0; min-width: 850px; }
    .live-verify-table thead { background: #f7f8fa; }
    .live-verify-table thead th { border-bottom: 1px solid #e5e8ec !important; color: #303744; font-size: 11px; font-weight: 700; letter-spacing: .035em; padding: 12px 15px !important; text-transform: uppercase; }
    .live-verify-table tbody td { border-color: #edf0f3 !important; color: #4c5460; font-size: 12px; padding: 14px 15px !important; vertical-align: middle; }
    .live-verify-table strong { color: #282e38; font-size: 13px; font-weight: 600; }
    .live-verify-uuid { background: #f3f5f7; border-radius: 6px; color: #4d5663; display: inline-block; font-family: monospace; font-size: 11px; padding: 5px 7px; white-space: nowrap; }
    .live-verify-pill { border-radius: 999px; display: inline-block; font-size: 10px; font-weight: 700; padding: 5px 9px; text-transform: uppercase; }
    .live-verify-pill.pass { background: #e7f7ed; color: #168149; }
    .live-verify-pill.fail { background: #fdeaea; color: #c23535; }
    .live-email-wrap { padding: 18px; }
    .live-email-wrap textarea { background: #fbfbfc; border: 1px solid #dfe3e8; border-radius: 10px; box-shadow: none; color: #3e4651; font-family: inherit; font-size: 12px; line-height: 1.6; min-height: 370px; padding: 15px; resize: vertical; width: 100%; }
    .live-email-actions { align-items: center; display: flex; justify-content: space-between; margin-top: 12px; }
    .live-email-actions small { color: #858d98; }
    .live-email-actions .btn { border-radius: 999px !important; margin: 0 !important; text-transform: none; }
    .live-empty { color: #7f8792; padding: 40px 20px; text-align: center; }
    @media (max-width: 991px) {
        .live-verify-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 767px) {
        .live-verify-page .card-content { padding: 24px 15px; }
        .live-verify-heading { flex-direction: column; }
        .live-verify-summary, .live-verify-checks { grid-template-columns: 1fr; }
        .live-verify-check:nth-last-child(-n+2) { border-bottom: 1px solid #edf0f3; }
        .live-verify-check:last-child { border-bottom: 0; }
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card live-verify-page">
            <div class="card-header card-header-icon" data-background-color="rose">
                <i class="material-icons">verified_user</i>
            </div>
            <div class="card-content">
                <div class="live-verify-heading">
                    <div>
                        <h4 class="card-title">Channex Live Verification</h4>
                        <p>Read-only checks for the live property, room mappings, UUIDs, queue and remote entities.</p>
                    </div>
                    @if($report)
                        <span class="live-verify-status {{ $report['ready'] ? 'ready' : 'not-ready' }}">
                            {{ $report['ready'] ? 'Ready' : 'Not ready' }}
                        </span>
                    @endif
                </div>

                <form method="GET" action="{{ route('admin.channex.live_verification') }}" class="live-verify-form">
                    <div class="form-group">
                        <label for="property_id">Mapped test property</label>
                        <select id="property_id" name="property_id" class="form-control">
                            @foreach($properties as $option)
                                <option value="{{ $option->id }}" {{ $property && $property->id === $option->id ? 'selected' : '' }}>
                                    #{{ $option->id }} — {{ $option->name }}{{ $option->channex_property_id ? ' — ' . $option->channex_property_id : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="remote" value="1">
                    <button type="submit" class="btn btn-primary">
                        <i class="material-icons">refresh</i> Refresh verification
                    </button>
                </form>

                @if(!$property || !$report)
                    <div class="live-verify-section">
                        <div class="live-empty">
                            <i class="material-icons">info_outline</i>
                            <p>No mapped Channex test property was found on this server.</p>
                        </div>
                    </div>
                @else
                    <div class="live-verify-summary">
                        <div class="live-verify-stat"><span>Local property</span><strong>#{{ $property->id }} — {{ $property->name }}</strong></div>
                        <div class="live-verify-stat"><span>Property UUID</span><strong>{{ $property->channex_property_id ?: 'Not mapped' }}</strong></div>
                        <div class="live-verify-stat"><span>Rooms</span><strong>{{ $report['rooms']->count() }} mapped room record(s)</strong></div>
                        <div class="live-verify-stat"><span>Checked</span><strong>{{ $report['checked_at']->format('d M Y, H:i:s') }}</strong></div>
                    </div>

                    <div class="live-verify-section">
                        <div class="live-verify-section-heading">
                            <h5>Verification checks</h5>
                            <small>{{ $report['failures'] }} failure(s) · {{ $report['warnings'] }} warning(s)</small>
                        </div>
                        <div class="live-verify-checks">
                            @foreach($report['checks'] as $check)
                                <div class="live-verify-check {{ $check['status'] }}">
                                    <i class="material-icons">{{ $check['status'] === 'pass' ? 'check_circle' : ($check['status'] === 'warning' ? 'warning' : 'cancel') }}</i>
                                    <span>{{ $check['message'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="live-verify-section">
                        <div class="live-verify-section-heading"><h5>Room and rate-plan UUIDs</h5><small>Values read from this server</small></div>
                        <div class="live-verify-table">
                            <table class="table table-hover">
                                <thead><tr><th>Room</th><th>Room UUID</th><th>Rate plan</th><th>Default rate</th><th>Rate-plan UUID</th><th>Status</th></tr></thead>
                                <tbody>
                                @forelse($report['rooms'] as $room)
                                    @php($activePlans = $room->channexRatePlans->where('is_active', true))
                                    @if($activePlans->isEmpty())
                                        <tr>
                                            <td><strong>#{{ $room->id }} {{ $room->name }}</strong></td>
                                            <td><span class="live-verify-uuid">{{ $room->channex_room_type_id ?: 'Not mapped' }}</span></td>
                                            <td colspan="3">No active rate plan</td>
                                            <td><span class="live-verify-pill fail">Incomplete</span></td>
                                        </tr>
                                    @else
                                        @foreach($activePlans as $plan)
                                            <tr>
                                                <td><strong>#{{ $room->id }} {{ $room->name }}</strong></td>
                                                <td><span class="live-verify-uuid">{{ $room->channex_room_type_id ?: 'Not mapped' }}</span></td>
                                                <td>{{ $plan->name }}</td>
                                                <td>USD {{ number_format((float) $plan->default_rate, 2) }}</td>
                                                <td><span class="live-verify-uuid">{{ $plan->channex_rate_plan_id ?: 'Not mapped' }}</span></td>
                                                <td><span class="live-verify-pill {{ $room->channex_synced && $plan->channex_rate_plan_id ? 'pass' : 'fail' }}">{{ $room->channex_synced && $plan->channex_rate_plan_id ? 'Mapped' : 'Check' }}</span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @empty
                                    <tr><td colspan="6" class="text-center">No rooms found.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(count($report['remote']))
                        <div class="live-verify-section">
                            <div class="live-verify-section-heading"><h5>Remote Channex status</h5><small>No data was changed</small></div>
                            <div class="live-verify-table">
                                <table class="table table-hover">
                                    <thead><tr><th>Entity</th><th>Name</th><th>UUID</th><th>HTTP</th><th>Result</th></tr></thead>
                                    <tbody>
                                    @foreach($report['remote'] as $entity)
                                        <tr>
                                            <td>{{ $entity['type'] }}</td>
                                            <td><strong>{{ $entity['name'] }}</strong></td>
                                            <td><span class="live-verify-uuid">{{ $entity['uuid'] }}</span></td>
                                            <td>{{ $entity['http_status'] ?: '—' }}</td>
                                            <td><span class="live-verify-pill {{ $entity['exists'] ? 'pass' : 'fail' }}">{{ $entity['exists'] ? 'Confirmed' : 'Failed' }}</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="live-verify-section">
                        <div class="live-verify-section-heading"><h5>Copy-ready email for Channex</h5><small>Add your video link before sending</small></div>
                        <div class="live-email-wrap">
                            <textarea id="channex-email" readonly>{{ $report['email'] }}</textarea>
                            <div class="live-email-actions">
                                <small id="copy-email-status">This email contains the UUIDs currently saved on the live server.</small>
                                <button type="button" class="btn btn-primary" id="copy-channex-email"><i class="material-icons">content_copy</i> Copy email</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
    (function () {
        var button = document.getElementById('copy-channex-email');
        var email = document.getElementById('channex-email');
        var status = document.getElementById('copy-email-status');
        if (!button || !email) return;

        button.addEventListener('click', function () {
            var copied = function () {
                status.textContent = 'Email copied. Paste it into your message and add the video link.';
                button.innerHTML = '<i class="material-icons">check</i> Copied';
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(email.value).then(copied);
                return;
            }

            email.removeAttribute('readonly');
            email.select();
            document.execCommand('copy');
            email.setAttribute('readonly', 'readonly');
            copied();
        });
    }());
</script>
@endsection
