<?php

namespace App\Http\Controllers\Admin\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Apartment;
use App\Models\UserReservation;
use App\Models\Reservation;
use App\Models\GuestUser;
use App\Models\Property;

use App\Jobs\SendInvoiceReceiptJob;
use App\Mail\ReservationReceipt;



use Carbon\Carbon;


use PDF;
use App\Models\SystemSetting;


class InvoicesController extends Controller
{
    public $settings;
    public function __construct()
    {

        // $this->middleware('admin');
        $this->settings = \DB::table('system_settings')->first();
    }

    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%' . $request->full_name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        $invoices = $query->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }


    public function create()
    {
        $apartments = \App\Models\Apartment::select('id', 'name', 'price')->get();
        $rate = json_decode(session('rate'), true);
        $rate = data_get($rate, 'rate', 1);

        // 🧭 Check for active PeakPeriod
        $today = now();
        $peak = \App\Models\PeakPeriod::first();

        $isInPeak = $peak
            && $today->between(
                $peak->start_date->startOfDay(),
                $peak->end_date->endOfDay()
            );

        // If active, prepare data
        $peakActive = false;
        $peakDiscount = 0;
        $peakDaysLimit = null;

        if ($peak) {
            $peakActive = true;
            $peakDiscount = $peak->discount; // percentage
            $peakDaysLimit = $peak->days_limit;
        }

        return view('admin.invoices.create', compact('isInPeak', 'apartments', 'rate', 'peak', 'peakActive', 'peakDiscount', 'peakDaysLimit'));
    }



    public function checkAvailability(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        $startDate = Carbon::parse($request->checkin);
        $endDate = Carbon::parse($request->checkout);

        $query = Apartment::query();
        $query->where('id', $request->apartment_id);

        $query->whereDoesntHave('reservations', function ($q) use ($startDate, $endDate) {
            $q->where(function ($subQ) use ($startDate) {
                $subQ->where('checkin', '<', $startDate)
                    ->where('reservations.is_blocked', false)
                    ->where('checkout', '>', $startDate);
            });
        });

        $apartments = $query->latest()->first();

        if ($apartments === null) {
            return response()->json([
                'available' => false,
                'message' => 'Apartment is not available for your selected dates.',
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Apartment is available.',
        ]);
    }


    public function download(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        // Generate or fetch existing PDF
        $invoice->load('invoice_items');
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice . '.pdf');
    }



    public function sendReceipt(Request $request)
    {
        $invoice = Invoice::with('invoice_items')->findOrFail($request->id);


        $property = Property::first();

        $fullName = trim($invoice->full_name);

        // Split into parts by space
        $nameParts = explode(' ', $fullName);

        // First name = first part
        $firstName = $nameParts[0] ?? '';

        // Last name = everything after the first
        $lastName = isset($nameParts[1])
            ? implode(' ', array_slice($nameParts, 1))
            : '';
        $rate = json_decode(session('rate'), true); // 
        $rate = data_get($rate, 'rate', 1);

        $guest = GuestUser::firstOrCreate(
            [
                'invoice_id' => $invoice->id,
            ],
            [
                'name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $invoice->phone ?? '',
                'image' => '',
            ]
        );


        // ✅ UserReservation (unique by invoice_id + guest_user_id)
        $user_reservation = UserReservation::firstOrCreate(
            [
                'invoice_id' => $invoice->id,
                'guest_user_id' => $guest->id,
            ],
            [
                'user_id' => 1,
                'invoice' => $invoice->invoice,
                'payment_type' => 'checkin',
                'property_id' => $property->id,
                'currency' => $invoice->currency,
                'checked' => true,
                'original_amount' => $invoice->subtotal,
                'coupon' => $invoice->discount ?? 0,
                'formatted_discount' => $invoice->formatted_discount,
                'coming_from' => 'checkin',
                'length_of_stay' => 1,
                'total' => $invoice->total,
                'caution_fee' => $invoice->caution_fee ?? 0,
                'ip' => $request->ip(),
            ]
        );

        //dd($invoice->invoice_items);
        foreach ($invoice->invoice_items as $item) {

            Reservation::firstOrCreate(
                [
                    'user_reservation_id' => $user_reservation->id,
                    'apartment_id' => $item->apartment_id,
                ],
                [
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'property_id' => $property->id,
                    'length_of_stay' => $item->quantity,
                    'checkin' => Carbon::parse($item->checkin),
                    'rate' => $rate,
                    'checkout' => Carbon::parse($item->checkout)

                ]
            );
        }



        try {

            if ($invoice->email) {

                $user_reservation->load('reservation');

                $user_reservation->discount = $invoice->discount_type === 'fixed'
                    ? '-' . $invoice->currency . number_format($invoice->discount)
                    : '-' . number_format($invoice->discount) . '%';
                $user_reservation->payment_type =  'checkin';

                $user_reservation->showCheckLink = $user_reservation->reservations->count() > 1 ? false : true;

                // dd($user_reservation->load('reservations'));
                //dd(true);
                \Mail::to($invoice->email)
                    ->bcc('avenuemontaigneconcierge@gmail.com')
                    ->bcc('info@avenuemontaigne.ng')
                    ->send(new ReservationReceipt($user_reservation, $this->settings));
            }
        } catch (\Throwable $th) {
            \Log::error("Mail error: " . $th->getMessage());
            // optionally: continue or throw if mail failure should abort transaction
        }

        // ✅ Dispatch email job (can safely resend anytime)
        //dispatch(new SendInvoiceReceiptJob($invoice, $user_reservation));

        // ✅ Mark invoice as sent
        $invoice->update(['sent' => true]);

        return back()->with('success', 'Receipt sent successfully! You can resend anytime.');
    }



    public function store(Request $request)
    {

        $validated = $request->all();

        DB::beginTransaction();

        $latest = Invoice::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $random = rand(1000, 9999);

        $invoiceNumber = "INV-" . date('Y') . "-" . $nextId . $random;
        $rate = json_decode(session('rate'), true); // use true to get an associative array
        $rate = data_get($rate, 'rate', 1);

        try {
            // Create the invoice record
            $invoice = Invoice::create([
                'invoice' => $invoiceNumber,
                'full_name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'country' => $validated['country'] ?? null,
                'currency' => $validated['currency'],
                'subtotal' => $validated['sub_total'],
                'discount' => $validated['discount'] ?? 0,
                'discount_type' => $validated['discount_type'] ?? 'fixed',
                'caution_fee' => $validated['caution_fee'] ?? 0,
                'total' => $validated['total'],
                'payment_info' => $validated['payment_info'] ?? null,
                'description' => $validated['description'] ?? null,
                'rate' => $rate
            ]);

            foreach ($validated['items'] as $item) {

                $startDate = !empty($item['checkin']) ? Carbon::parse($item['checkin']) : null;
                $endDate   = !empty($item['checkout']) ? Carbon::parse($item['checkout']) : null;

                $apartment = Apartment::find($item['apartment_id']);

                $checkin  = $startDate ? $startDate->format('D, M d, Y') : '';
                $checkout = $endDate ? $endDate->format('D, M d, Y') : '';

                $name = 'Booking for ' . $item['name'] .
                    ($checkin ? ' from ' . $checkin : '') .
                    ($checkout ? ' to ' . $checkout : '') .
                    ' (' . $item['qty'] . 'night(s))';


                $invoice->invoice_items()->create([
                    'name' => $name,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'apartment_id' => $item['apartment_id'],
                    'total' => $item['total'],
                    'checkin' =>  $item['checkin'] ?? null,
                    'checkout' => $item['checkout'] ?? null,
                    'rate' => $rate
                ]);
            }

            // Create each invoice item
            if (!empty($validated['extra_items']) && is_array($validated['extra_items'])) {
                foreach ($validated['extra_items'] as $item) {
                    // Skip invalid items
                    if (empty($item['description']) && empty($item['qty']) && empty($item['rate']) && empty($item['total'])) {
                        continue;
                    }

                    $invoice->invoice_items()->create([
                        'name'     => $item['description'] ?? 'Extra Item',
                        'quantity' => $item['qty'] ?? 1,
                        'price'    => $item['rate'] ?? 0,
                        'total'    => $item['total'] ?? 0,
                        'rate'     => $rate
                    ]);
                }
            }




            DB::commit();

            // === Handle Action Buttons ===
            $action = $request->input('action');

            if ($action === 'save') {

                return redirect()
                    ->route('admin.invoices.index')
                    ->with('success', 'Invoice saved successfully.');
            }

            dd($validated);


            // Load invoice with relations for PDF
            $invoice->load('invoice_items');
            $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

            if ($action === 'save_send') {
                if (!empty($invoice->email)) {
                    $invoice->discount = $invoice->discount_type === 'fixed'
                        ? '-' . $invoice->currency . number_format($invoice->discount)
                        : '-' . number_format($invoice->discount) . '%';
                    \App\Jobs\SendInvoiceJob::dispatch($invoice);
                }

                return redirect()
                    ->route('admin.invoices.index')
                    ->with('warning', 'Invoice saved, but no email provided for sending.');
            }


            return redirect()
                ->route('admin.invoices.index')
                ->with('success', 'Invoice saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function resend($id)
    {

        $invoice = Invoice::findOrFail($id);

        $invoice->load('invoice_items');


        if (!empty($invoice->email)) {
            \App\Jobs\SendInvoiceJob::dispatch($invoice);
        }


        $invoice->update(['resent' => true]);


        return back()->with('success', 'Invoice resent successfully!');
    }


    public function preview(Request $request)
    {
        $data = $request->all();
        return view('admin.invoices.preview', compact('data'));
    }

    public function destroy(Request $request, $id)
    {
        \App\Models\User::canTakeAction(5);
        $rules = array(
            '_token' => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (empty($request->selected)) {
            $validator->getMessageBag()->add('Selected', 'Nothing to Delete');
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $count = count($request->selected);
        // (new Activity)->Log("Deleted  {$count} Products");
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');



        foreach ($request->selected as $selectedId) {
            $invoice = Invoice::find($selectedId);

            //if ($invoice && empty($invoice->sent)) { // delete only unsent invoices
            $invoice->delete();
            //}
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        return redirect()->back();
    }
}
