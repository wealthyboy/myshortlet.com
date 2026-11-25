<?php

namespace App\Http\Controllers\Admin\Block;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\GuestUser;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BlockApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blocks = Reservation::query()
            ->with(['apartment', 'user_reservation'])
            ->where('is_blocked', true)
            ->orderBy('checkin')
            ->orderBy('checkout')
            ->get();

        return view('admin.block.index', compact('blocks'));
    }


    public function block()
    {  
        $rooms = Apartment::orderBy('name', 'asc')->get();
        return view('checkin.block', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => ['required', 'integer', 'exists:apartments,id'],
            'checkin' => ['required', 'date_format:Y-m-d'],
            'checkout' => ['required', 'date_format:Y-m-d', 'after:checkin'],
        ]);

        $checkin = Carbon::createFromFormat('Y-m-d', $validated['checkin'])->startOfDay();
        $checkout = Carbon::createFromFormat('Y-m-d', $validated['checkout'])->startOfDay();

        $apartment = Apartment::with('property')->findOrFail($validated['apartment_id']);

        // Check-in is included in the block; check-out is the first free day.
        // This matches the storefront, ARI and OTA overlap rule exactly.
        $hasConflict = Reservation::query()
            ->where('apartment_id', $apartment->id)
            ->where('checkin', '<', $checkout)
            ->where('checkout', '>', $checkin)
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors(['checkin' => 'This apartment already has a reservation or block in the selected dates.']);
        }

        $property = $apartment->property ?: Property::query()->first();
        if (! $property) {
            return back()->withInput()->withErrors(['apartment_id' => 'The apartment must belong to a property before it can be blocked.']);
        }

        DB::transaction(function () use ($request, $apartment, $property, $checkin, $checkout) {
            $guest = GuestUser::firstOrCreate(
                ['email' => 'inventory-block@avenuemontaigne.invalid'],
                [
                    'name' => 'Inventory',
                    'last_name' => 'Block',
                    'phone_number' => 'N/A',
                ]
            );

            $nights = $checkin->diffInDays($checkout);
            $header = UserReservation::create([
                'user_id' => optional($request->user())->id,
                'guest_user_id' => $guest->id,
                'property_id' => $property->id,
                'invoice' => 'BLOCK-'.now()->format('YmdHis').'-'.strtoupper(substr(uniqid(), -5)),
                'payment_type' => 'block',
                'currency' => 'NGN',
                'currency_code' => 'NGN',
                'checked' => true,
                'coming_from' => 'block',
                'status' => 'confirmed',
                'total' => 0,
                'length_of_stay' => $nights,
                'ip' => $request->ip(),
            ]);

            $reservation = new Reservation;
            $reservation->quantity = 1;
            $reservation->apartment_id = $apartment->id;
            $reservation->property_id = $property->id;
            $reservation->user_reservation_id = $header->id;
            $reservation->price = 0;
            $reservation->sale_price = 0;
            $reservation->checkin = $checkin;
            $reservation->checkout = $checkout;
            $reservation->is_blocked = true;
            $reservation->length_of_stay = $nights;
            $reservation->save();
        });

        return redirect()->route('admin.blocks.index')
            ->with('success', 'Apartment blocked. Availability has been queued for synchronization.');
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $request = request();

        $selected = collect($request->input('selected', []))
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($selected->isEmpty()) {
            return back()->withErrors(['selected' => 'Select at least one dated block to remove.']);
        }

        DB::transaction(function () use ($selected) {
            Reservation::query()
                ->whereIn('id', $selected)
                ->where('is_blocked', true)
                ->get()
                ->each
                ->delete();
        });

        return redirect()->route('admin.blocks.index')
            ->with('success', 'Selected apartment blocks were removed and availability has been queued for synchronization.');
    }
}
