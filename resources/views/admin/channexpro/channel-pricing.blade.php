@extends('admin.layouts.app')
@section('pagespecificstyles')
<style>
.cp-prices{max-width:1400px;margin:20px auto;padding:18px;color:#17253f}.cp-prices h1{font-size:30px;font-weight:700}.cp-panel{background:white;border:1px solid #e1e5ec;border-radius:18px;padding:26px;margin:20px 0;box-shadow:0 6px 24px #17253f08}.cp-prices label{font-weight:600}.cp-prices input,.cp-prices select{border-radius:8px;border:1px solid #d4dce8;padding:10px;min-height:42px}.cp-prices table{width:100%;min-width:760px}.cp-prices th,.cp-prices td{padding:16px 10px;border-bottom:1px solid #edf0f4}.cp-prices th{background:#f7f8fc}.cp-prices small{display:block;color:#65718a}.cp-prices .cp-notice{position:fixed;right:24px;top:24px;max-width:420px;z-index:2000;padding:18px 22px;background:#e8f8ef;color:#175236;border-radius:12px;box-shadow:0 6px 24px #0002}.cp-prices .cp-error{background:#fff0ef;color:#842b24}.cp-actions{display:flex;gap:16px;justify-content:space-between;align-items:center;flex-wrap:wrap}.cp-preview{font-size:19px;color:#152c4d}.cp-prices .btn{border-radius:9px;padding:11px 20px}
</style>
@endsection
@section('content')
<main class="cp-prices"><header class="cp-actions"><div><small>{{ $property->name }} · DISTRIBUTION PRICING</small><h1>Set the price for each channel.</h1><p>Keep your direct-booking price. Add a markup or markdown only where you need it.</p></div><a class="btn btn-default" href="{{ route('admin.apartments.index') }}">Back to apartments</a></header>
@if(session('success'))<div role="status" class="cp-notice">{{ session('success') }}</div>@endif
@if($errors->any())<div role="alert" class="cp-notice cp-error">{{ $errors->first() }}</div>@endif
<section class="cp-panel"><form method="get"><label for="cp-channel">Sales channel</label><select id="cp-channel" name="channel" class="form-control" onchange="this.form.submit()"><option value="">Choose a channel</option>@foreach($channels as $option)<option value="{{ $option['code'] }}" {{ $channel === $option['code'] ? 'selected' : '' }}>{{ $option['title'] }}</option>@endforeach</select></form>
@if($catalogueUnavailable || !$channels)<p class="text-warning">Could not refresh the ChannexPro channel list. Existing saved channels remain available. Check the source connection and deploy ChannexPro's channel-pricing update first.</p>@endif
<p style="margin-top:16px">Website base price → <strong>this website adjustment</strong> → optional ChannexPro adjustment → channel.</p><small>These settings travel with your ARI feed as separate channel rules. They do not change the public website price or the price sent to other channels.</small></section>
@if($channel !== '')
<form method="post" action="{{ route('admin.channel-pricing.update', $property->id) }}">@csrf @method('PUT')<input type="hidden" name="channel" value="{{ $channel }}">
<section class="cp-panel"><div class="cp-actions"><h2>{{ $channel }} pricing</h2><span>USD · per apartment / night</span></div><p>Use positive numbers to add and negative numbers to subtract. Percent is applied first, followed by the fixed amount. Use 0 for no adjustment.</p><div style="overflow-x:auto"><table><thead><tr><th>Apartment</th><th>Base price</th><th>Adjustment %</th><th>Adjustment amount (USD)</th><th>Price sent for this channel</th></tr></thead><tbody>
@foreach($apartments as $apartment)
@php
    $rule = $rules->get($apartment->id);
    $base = (float) ($apartment->channexRatePlans->first()->default_rate ?? $apartment->price);
@endphp
<tr data-source-price-row data-base="{{ $base }}"><td><strong>{{ $apartment->name }}</strong><small>Apartment #{{ $apartment->id }}</small></td><td>${{ number_format($base, 2) }}</td><td><label class="sr-only" for="cp-percent-{{ $apartment->id }}">{{ $apartment->name }} percent adjustment</label><input id="cp-percent-{{ $apartment->id }}" class="form-control" type="number" min="-99.9999" max="1000" step="0.0001" name="rules[{{ $apartment->id }}][percent]" value="{{ old('rules.'.$apartment->id.'.percent', $rule->percent ?? 0) }}" data-percent required></td><td><label class="sr-only" for="cp-amount-{{ $apartment->id }}">{{ $apartment->name }} fixed adjustment</label><input id="cp-amount-{{ $apartment->id }}" class="form-control" type="number" min="-1000000" max="1000000" step="0.01" name="rules[{{ $apartment->id }}][amount]" value="{{ old('rules.'.$apartment->id.'.amount', $rule->amount ?? 0) }}" data-amount required></td><td><strong class="cp-preview" data-final>—</strong><small>Before any additional ChannexPro rule</small></td></tr>
@endforeach
</tbody></table></div><p style="margin-top:18px"><small>Preview uses the default base price; daily/seasonal rates receive the same rule for their date. Channel taxes, promotions, commission and package discounts can still apply afterward.</small></p><button class="btn btn-primary">Save &amp; refresh ChannexPro</button></section></form>
<script>
document.querySelectorAll('[data-source-price-row]').forEach(row => {
    const update = () => {
        const final = Math.round((Number(row.dataset.base) * (1 + Number(row.querySelector('[data-percent]').value) / 100) + Number(row.querySelector('[data-amount]').value) + Number.EPSILON) * 100) / 100;
        row.querySelector('[data-final]').textContent = Number.isFinite(final) && final > 0 ? '$' + final.toFixed(2) : 'Check adjustment';
    };
    row.addEventListener('input', update); update();
});
</script>
@endif
</main>
@endsection
