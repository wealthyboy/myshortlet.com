<?php

namespace App\Http\Controllers\Admin\ChannexPro;

use App\Http\Controllers\Controller;
use App\Models\ApartmentChannelPriceRule;
use App\Models\Property;
use App\Models\User;
use App\Services\ChannexPro\ChannelPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChannelPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless($request->user() && $request->user()->users_permission && User::userHasPermission(2), 403);
            return $next($request);
        });
    }

    public function index(Request $request, Property $property, ChannelPricing $pricing)
    {
        $channels = []; $catalogueUnavailable = false;
        try { $channels = $pricing->channels(); } catch (\Throwable $e) { $catalogueUnavailable = true; }
        $apartments = $property->apartments()->with(['channexRatePlans' => fn ($q) => $q->where('is_active', true)->orderByDesc('is_default')])->orderBy('name')->get();
        foreach (ApartmentChannelPriceRule::whereIn('apartment_id', $apartments->pluck('id'))->pluck('channel')->unique() as $code) {
            if (! collect($channels)->contains('code', $code)) $channels[] = ['code' => $code, 'title' => $code];
        }
        $channel = (string) $request->query('channel', $channels[0]['code'] ?? '');
        abort_unless($channel === '' || collect($channels)->contains('code', $channel), 404);
        $rules = ApartmentChannelPriceRule::whereIn('apartment_id', $apartments->pluck('id'))->where('channel', $channel)->get()->keyBy('apartment_id');
        return response()->view('admin.channexpro.channel-pricing', compact('property', 'apartments', 'channels', 'channel', 'rules', 'catalogueUnavailable'))->header('Cache-Control', 'no-store, private');
    }

    public function update(Request $request, Property $property, ChannelPricing $pricing)
    {
        $data = $request->validate(['channel' => ['required', 'string', 'regex:/^[A-Za-z0-9][A-Za-z0-9_.-]{0,95}$/'],
            'rules' => ['required', 'array', 'max:1000'], 'rules.*.percent' => ['required', 'numeric', 'gt:-100', 'max:1000'],
            'rules.*.amount' => ['required', 'numeric', 'between:-1000000,1000000']]);
        $known = ApartmentChannelPriceRule::whereIn('apartment_id', $property->apartments()->pluck('id'))->where('channel', $data['channel'])->exists();
        if (! $known) {
            try { $valid = collect($pricing->channels())->contains('code', $data['channel']); }
            catch (\Throwable $error) { throw ValidationException::withMessages(['channel' => 'Could not verify the channel list. Your prices have not changed. Try again shortly.']); }
            if (! $valid) throw ValidationException::withMessages(['channel' => 'Choose a valid ChannexPro channel.']);
        }
        DB::transaction(function () use ($property, $data, $pricing) {
            Property::whereKey($property->id)->lockForUpdate()->firstOrFail();
            $apartments = $property->apartments()->with('channexRatePlans')->get()->keyBy('id');
            $rows = [];
            foreach ($data['rules'] as $id => $rule) {
                $apartment = $apartments->get($id);
                if (! $apartment) throw ValidationException::withMessages(['rules' => 'An apartment does not belong to this property.']);
                $percent = round((float) $rule['percent'], 4); $amount = round((float) $rule['amount'], 2);
                $default = $apartment->channexRatePlans->where('is_active', true)->sortByDesc('is_default')->first();
                $pricing->validatePrice((float) ($default->default_rate ?? $apartment->price), $percent, $amount);
                foreach ($apartment->dailyRates()->where('date', '>=', now()->toDateString())->whereNotNull('price')->pluck('price') as $daily) $pricing->validatePrice((float) $daily, $percent, $amount);
                $rows[] = ['apartment_id' => $apartment->id, 'channel' => $data['channel'], 'currency' => 'USD', 'percent' => $percent, 'amount' => $amount];
            }
            foreach ($rows as $row) ApartmentChannelPriceRule::updateOrCreate(['apartment_id' => $row['apartment_id'], 'channel' => $row['channel']], $row);
            $pricing->notify($property);
        });
        return redirect()->route('admin.channel-pricing.index', [$property->id, 'channel' => $data['channel']])
            ->with('success', 'Channel prices saved and a ChannexPro refresh queued. Direct website prices are unchanged.');
    }
}
