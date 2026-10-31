<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeCtrl extends Controller
{
    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $days = in_array((int) $request->query('days', 30), [7, 30, 90], true)
            ? (int) $request->query('days', 30) : 30;
        $from = Carbon::today()->subDays($days - 1)->startOfDay();
        $to = Carbon::today()->endOfDay();
        $bookings = UserReservation::query()->whereBetween('created_at', [$from, $to]);
        $statusExists = Schema::hasColumn('user_reservations', 'status');
        $otaExists = Schema::hasColumn('user_reservations', 'ota_name');
        $sourceExists = Schema::hasColumn('user_reservations', 'coming_from');
        $currencyExists = Schema::hasColumn('user_reservations', 'currency_code');
        $rows = (clone $bookings)->orderByDesc('created_at')->limit(5000)
            ->get(array_values(array_filter(['id','created_at','total', $statusExists ? 'status' : null,
                $otaExists ? 'ota_name' : null, $sourceExists ? 'coming_from' : null,
                $currencyExists ? 'currency_code' : null])));
        $excludedStatuses = ['cancelled', 'canceled', 'failed', 'rejected', 'void'];
        $active = $rows->filter(function ($r) use ($excludedStatuses) {
            return !in_array(strtolower(trim((string) ($r->status ?? ''))), $excludedStatuses, true);
        });
        $currencyGroups = $active->groupBy(function ($r) { return strtoupper(trim((string) ($r->currency_code ?? 'Unknown'))) ?: 'Unknown'; });
        $revenue = $currencyGroups->map(function ($group) {
            return round($group->sum(function ($r) {
                $v = str_replace(',', '', (string) $r->total);
                return is_numeric($v) ? (float) $v : 0;
            }), 2);
        })->all();
        $channels = $active->groupBy(function ($r) {
            $ota = trim((string) ($r->ota_name ?? ''));
            if ($ota !== '') return ucwords(strtolower($ota));
            $source = strtolower(trim((string) ($r->coming_from ?? '')));
            return in_array($source, ['', 'website', 'web', 'direct'], true) ? 'Direct / Website' : ucwords(str_replace('_', ' ', $source));
        })->map->count()->sortDesc()->all();
        $daily = $active->groupBy(function ($r) { return $r->created_at->format('Y-m-d'); })->map->count();
        $trend = [];
        for ($date = $from->copy(); $date->lte($to); $date->addDay()) {
            $key = $date->format('Y-m-d');
            $trend[] = ['date' => $date->format('M j'), 'bookings' => (int) ($daily[$key] ?? 0)];
        }
        return view('admin.index', [
            'days' => $days, 'bookingCount' => $active->count(),
            'cancelledCount' => $rows->count() - $active->count(),
            'channelCounts' => $channels, 'bookingTrend' => $trend,
            'bookingValueByCurrency' => $revenue,
            'recentBookings' => $rows->take(8),
            'resultLimited' => $rows->count() === 5000,
        ]);
    }
}
