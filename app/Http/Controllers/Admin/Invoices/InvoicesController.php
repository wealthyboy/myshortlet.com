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


use Carbon\Carbon;


use PDF;

class InvoicesController extends Controller
{
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
        return view('admin.invoices.create', compact('apartments'));
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

        return $pdf->download('invoice-' . $invoice->id . '.pdf');
    }

    public function sendReceipt(Request $request)
    {
        $invoice = Invoice::with('invoice_items')->findOrFail($request->id);
        $property = Property::first();

        // ✅ Guest user linked to this invoice
        $guest = GuestUser::firstOrCreate(
            [
                'invoice_id' => $invoice->id,
            ],
            [
                'name' => $invoice->full_name,
                'last_name' => $invoice->full_name,
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
                'invoice' => $invoice->invoice_number,
                'payment_type' => 'checkin',
                'property_id' => $property->id,
                'currency' => $invoice->currency,
                'checked' => true,
                'original_amount' => $invoice->invoice_items->sum('price'),
                'coupon' => $invoice->discount ?? 0,
                'coming_from' => 'checkin',
                'length_of_stay' => 1,
                'total' => $invoice->total,
                'caution_fee' => $invoice->caution_fee ?? 0,
                'ip' => $request->ip(),
            ]
        );

        // ✅ Reservation items (firstOrCreate to prevent duplicates)
        foreach ($invoice->invoice_items as $item) {
            Reservation::firstOrCreate(
                [
                    'user_reservation_id' => $user_reservation->id,
                    'apartment_id' => $item->apartment_id,
                    'checkin' => Carbon::parse($item['checkin']),
                    'checkout' => Carbon::parse($item['checkout']),
                ],
                [
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'property_id' => $property->id,
                    'rate' => 1,
                ]
            );
        }

        // ✅ Dispatch email job (can safely resend anytime)
        dispatch(new SendInvoiceReceiptJob($invoice, $user_reservation));

        // ✅ Mark invoice as sent
        $invoice->update(['sent' => true]);

        return back()->with('success', 'Receipt sent successfully! You can resend anytime.');
    }



    public function store(Request $request)
    {


        $validated = $request->all();

        DB::beginTransaction();

        $latest = Invoice::latest('id')->first();
        $nextNumber = $latest ? $latest->id + 1 : 1;
        $invoiceNumber = "INV-" . date('Y') . "-" . rand(10000, time());
        //dd($validated);

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
            ]);

            // Create each invoice item
            foreach ($validated['items'] as $item) {

                $startDate = Carbon::parse($item['checkin']);
                $endDate = Carbon::parse($item['checkout']);

                $invoice->invoice_items()->create([
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'apartment_id' => $item['apartment_id'],
                    'total' => $item['total'],
                    'checkin' =>  $item['checkin'] ?? null,
                    'checkout' => $item['checkout'] ?? null,
                ]);
            }

            DB::commit();

            // === Handle Action Buttons ===
            $action = $request->input('action');

            if ($action === 'save') {

                return redirect()
                    ->route('admin.invoices.index')
                    ->with('success', 'Invoice saved successfully.');
            }

            // Load invoice with relations for PDF
            $invoice->load('invoice_items');
            $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

            if ($action === 'save_send') {
                if (!empty($invoice->email)) {
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

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

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
