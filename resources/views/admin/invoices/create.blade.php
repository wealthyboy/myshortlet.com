<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            background-color: rgb(248, 245, 244);
        }

        .bg-dark {
            background-color: #342c27 !important;
        }

        .invoice-item-row+.invoice-item-row {
            margin-top: 10px;
        }

        .remove-item {
            margin-top: 32px;
        }

        @media (max-width: 767.98px) {
            .invoice-item-row .form-group {
                margin-bottom: 10px;
            }

            .remove-item {
                margin-top: 0;
            }
        }

        .logo img {
            height: 60px;
        }

        .bg-peak {
            background-color: #b91c1c !important;
            /* deep red tone */
            transition: background-color 0.4s ease;
        }

        .bg-peak input,
        .bg-peak select {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5">
        <div class="d-flex align-items-center mb-4">
            <a href="https://avenuemontaigne.ng/admin/invoices" class="logo mr-3 bg-dark">
                <img src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" alt="Logo" />
            </a>
            <h4 class="m-0">Create Invoice</h4>


            <small class="m-0 ml-4"><a href="/admin/invoices">Back</a></small>

        </div>


        @if($isInPeak)
        <div class="alert alert-warning text-dark font-weight-bold">
            🌴 Peak Period Active! Prices increased by {{ $peakDiscount }}%
            @if($peakDaysLimit)
            — Minimum stay: {{ $peakDaysLimit }} nights
            @endif
        </div>
        @endif


        <form
            id="invoiceForm"
            method="POST"
            action="{{ route('admin.invoices.store') }}">
            @csrf

            <!-- Personal / Company Details -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Personal / Company Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Full Name / Company Name</label>


                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $invoiceData->full_name ?? '') }}"
                                placeholder="Enter name or company" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $invoiceData->email ?? '') }}"
                                placeholder="Enter email" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $invoiceData->phone ?? '') }}"
                                placeholder="Enter phone" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Currency</label>
                            <select name="currency" id="currency" class="form-control" required>
                                <option value="">Select currency</option>

                                <option value="₦"
                                    {{ old('currency', $invoiceData->currency ?? '') == '₦' ? 'selected' : '' }}>
                                    NGN (₦)
                                </option>

                                <option value="$"
                                    {{ old('currency', $invoiceData->currency ?? '') == '$' ? 'selected' : '' }}>
                                    USD ($)
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $invoiceData->address ?? '') }}"
                                placeholder="Enter address" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Country</label>

                            <input type="text" name="country" class="form-control"
                                value="{{ old('country', $invoiceData->country ?? '') }}"
                                placeholder="Country" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Invoice Items</span>
                    <button type="button" id="addItem" class="btn btn-sm btn-success">+ Add Item</button>
                </div>

                <div class="card-body" id="invoiceItems">
                    <div class="form-row invoice-item-row">
                        <div class="form-group col-md-3">
                            <label>Apartment</label>
                            <select class="form-control apartment-select" name="items[0][apartment_id]" required>
                                <option value="">Select Apartment</option>
                                @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" data-price="{{ $apartment->price }}" data-name="{{ $apartment->name }}">
                                    {{ $apartment->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Check-in</label>
                            <input type="date" class="form-control checkin" name="items[0][checkin]" required />
                        </div>

                        <div class="form-group col-md-2">
                            <label>Check-out</label>
                            <input type="date" class="form-control checkout" name="items[0][checkout]" required />
                        </div>

                        <div class="form-group col-md-2">
                            <label>Nights</label>
                            <input type="number" name="items[0][qty]" class="form-control qty" value="1" readonly />
                        </div>

                        <div class="form-group col-md-2">
                            <label>Unit Price</label>
                            <input type="number" name="items[0][price]" class="form-control price" readonly />
                        </div>

                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm removeItem">delete</button>
                        </div>

                        <input type="hidden" name="items[0][name]" class="item-name" />
                        <input type="hidden" name="items[0][total]" class="item-total" />
                    </div>
                </div>
            </div>

            <!-- Extra Charges / Invoice Items -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Additional Invoice Items</span>
                    <button type="button" id="addExtraItem" class="btn btn-sm btn-success">+ Add Item</button>
                </div>

                <div class="card-body" id="extraItems">
                    <div class="form-row extra-item-row">
                        <div class="form-group col-md-5">
                            <label>Description</label>
                            <input type="text" name="extra_items[0][description]" class="form-control description" placeholder="Item description" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Qty</label>
                            <input type="number" name="extra_items[0][qty]" class="form-control extra-qty" value="1" min="1">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Rate</label>
                            <input type="number" name="extra_items[0][rate]" class="form-control extra-rate" value="0">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Total</label>
                            <input type="number" name="extra_items[0][total]" class="form-control extra-total" readonly>
                        </div>

                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm removeExtraItem">delete</button>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Summary -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Summary</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Subtotal</label>
                            <input type="text" id="subTotal" name="sub_total" class="form-control" readonly />
                        </div>

                        <div class="form-group col-md-3">
                            <label>Discount</label>
                            <div class="input-group">
                                <input type="number" id="discount" name="discount" class="form-control" value="0" />
                                <div class="input-group-append">
                                    <select id="discountType" name="discount_type" class="form-control">
                                        <option value="fixed" selected>F</option>
                                        <option value="percent">%</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Caution Fee</label>
                            <input type="number" id="cautionFee" name="caution_fee" class="form-control" value="0" />
                        </div>

                        <div class="form-group col-md-3">
                            <label>Total</label>
                            <input type="text" id="grandTotal" name="total" class="form-control font-weight-bold" readonly />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description / Notes -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Additional Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Bank Details</label>
                        <textarea name="payment_info" class="form-control" rows="4" placeholder="Add any details such as bank account info, payment instructions, or special notes">
Please make payment using the following details:
Avenue Montaigne Limited
Providus Bank
1305006894
                        </textarea>
                    </div>
                </div>
            </div>


            <!-- Description / Notes -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Additional Information</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Invoice Notes</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Add any details such as bank account info, payment instructions, or special notes">
Check-in time is 2pm
Check-out time is 12 noon
Apartment is non-smoking; smoking in the apartment will result in forfeiture of the caution fee.
Payment confirms reservation. 50% cancellation fee applies 48 hours after confirmation.
Caution deposit will be refunded within 5 working days after checkout.
                        </textarea>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="text-right mt-4">
                <button type="button" class="btn btn-primary bg-dark" data-action="save">Save</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const PEAK_START = "{{ optional($peak)->start_date }}";
        const PEAK_END = "{{ optional($peak)->end_date }}";
        const PEAK_DISCOUNT = "{{ optional($peak)->discount ?? 0 }}";
        const peakDiscount = parseFloat(PEAK_DISCOUNT) || 0;

        $(function() {
            const peakStartDate = "{{ $peak->start_date ?? '' }}";
            const peakEndDate = "{{ $peak->end_date ?? '' }}";
            const peakPercentage = parseFloat("{{ $peak->discount ?? 0 }}"); // it's an addition %
            const peakDaysLimit = parseInt("{{ $peak->days_limit ?? 0 }}");

            const rate = "{{ $rate }}";
            const exchangeRate = parseFloat(rate);

            let index = 1;

            // 🌀 Loader HTML
            const loader = `
  <div id="pageLoader" style="
      display:none;
      position:fixed;
      inset:0;
      background:rgba(0,0,0,0.5);
      z-index:9999;
      color:white;
      font-size:1.5rem;
      text-align:center;
      padding-top:20%;
  ">
    <div class="spinner-border text-light" style="width:3rem;height:3rem;" role="status"></div>
    <div class="mt-3">Processing... please wait</div>
  </div>`;
            $('body').append(loader);

            // Add new item row
            $('#addItem').on('click', function() {
                const newRow = $('#invoiceItems .invoice-item-row:first').clone();
                newRow.find('input, select').val('');
                newRow.find('.qty').val(1);
                newRow.find('.price, .item-total, .item-name').val('');
                newRow.find('.date-warning').remove();
                newRow.find('select, input').each(function() {
                    const name = $(this).attr('name');
                    $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                });
                $('#invoiceItems').append(newRow);
                index++;
            });

            // Remove item row
            $(document).on('click', '.removeItem', function() {
                if ($('.invoice-item-row').length > 1) {
                    $(this).closest('.invoice-item-row').remove();
                }
                calculateTotals();
            });

            let extraIndex = 1;

            // Add Extra Item
            $('#addExtraItem').on('click', function() {
                const newRow = $('#extraItems .extra-item-row:first').clone();

                newRow.find('input').val('');
                newRow.find('.extra-qty').val(1);
                newRow.find('.extra-rate').val(0);
                newRow.find('.extra-total').val('');

                newRow.find('input').each(function() {
                    const name = $(this).attr('name');
                    $(this).attr('name', name.replace(/\[\d+\]/, `[${extraIndex}]`));
                });

                $('#extraItems').append(newRow);
                extraIndex++;
            });

            // Remove row
            $(document).on('click', '.removeExtraItem', function() {
                if ($('.extra-item-row').length > 1) {
                    $(this).closest('.extra-item-row').remove();
                }
                calculateTotals();
            });

            // Recalculate total for each row
            $(document).on('input', '.extra-qty, .extra-rate', function() {
                const row = $(this).closest('.extra-item-row');
                const qty = parseFloat(row.find('.extra-qty').val()) || 0;
                const rate = parseFloat(row.find('.extra-rate').val()) || 0;

                row.find('.extra-total').val((qty * rate).toFixed(2));

                calculateTotals();
            });

            // Update when apartment, dates, or currency changes
            $(document).on('change', '.apartment-select, .checkin, .checkout', function() {
                updateRow($(this).closest('.invoice-item-row'));
            });

            // Currency switch
            $('#currency').on('change', function() {
                $('.invoice-item-row').each(function() {
                    updateRow($(this));
                });
                calculateTotals();
            });


            function validateInvoiceForm() {
                let valid = true;
                let errorMsg = '';

                // Validate main fields
                const name = $('input[name="name"]').val().trim();
                const email = $('input[name="email"]').val().trim();
                const phone = $('input[name="phone"]').val().trim();

                if (!name) {
                    valid = false;
                    errorMsg += '⚠️ Full Name is required.\n';
                }
                if (!email) {
                    valid = false;
                    errorMsg += '⚠️ Email is required.\n';
                }
                if (!phone) {
                    valid = false;
                    errorMsg += '⚠️ Phone is required.\n';
                }

                // Validate each item row
                $('.invoice-item-row').each(function(index) {
                    const apartment = $(this).find('.apartment-select').val();
                    if (!apartment) {
                        valid = false;
                        errorMsg += `⚠️ Apartment is required for item row ${index + 1}.\n`;
                    }

                    const checkin = $(this).find('.checkin').val();
                    const checkout = $(this).find('.checkout').val();
                    if (!checkin || !checkout) {
                        valid = false;
                        errorMsg += `⚠️ Check-in and Check-out are required for item row ${index + 1}.\n`;
                    }
                });

                if (!valid) alert(errorMsg);
                return valid;
            }


            // Function: Update each row
            function updateRow(row) {
                const apartment = row.find('.apartment-select option:selected');
                const apartmentId = row.find('.apartment-select').val();
                const basePrice = parseFloat(apartment.data('price')) || 0;
                const aptName = apartment.data('name') || '';
                const currency = $('#currency').val();
                const checkinVal = row.find('.checkin').val();
                const checkoutVal = row.find('.checkout').val();

                row.find('.date-warning').remove();

                if (!checkinVal || !checkoutVal) {
                    row.find('.qty, .price, .item-total').val('');
                    row.find('.item-name').val('');
                    calculateTotals();
                    return;
                }

                const checkin = new Date(checkinVal);
                const checkout = new Date(checkoutVal);

                if (checkout <= checkin) {
                    row.find('.qty, .price, .item-total').val('');
                    row.find('.item-name').val('');
                    const warning = $('<small class="text-danger date-warning d-block mt-1">⚠️ Check-out must be after check-in</small>');
                    row.find('.checkout').after(warning);
                    calculateTotals();
                    return;
                }

                // Check availability
                $.ajax({
                    url: "{{ route('admin.apartments.checkAvailability') }}",
                    type: "POST",
                    data: {
                        apartment_id: apartmentId,
                        checkin: checkinVal,
                        checkout: checkoutVal,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.available) {
                            alert("⚠️ This apartment is not available for the selected dates.");
                        }
                    }
                });

                // --- PEAK period setup ---
                const peakStart = PEAK_START ? new Date(PEAK_START) : null;
                const peakEnd = PEAK_END ? new Date(PEAK_END) : null;
                const peakDiscount = parseFloat(PEAK_DISCOUNT) || 0;
                const exchangeRate = parseFloat("{{ $rate }}") || 1;

                // --- Calculate price per night
                const pricePerNight = currency === '₦' ? basePrice * exchangeRate : basePrice;

                // --- Calculate total nights ---
                const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));

                let total = 0;
                let peakNights = 0;
                let regularNights = 0;

                // Loop through each night to check if it's in the peak period
                for (let d = new Date(checkin); d < checkout; d.setDate(d.getDate() + 1)) {
                    const current = new Date(d);
                    if (peakStart && peakEnd && current >= peakStart && current <= peakEnd) {
                        total += pricePerNight * (1 + peakDiscount / 100);
                        peakNights++;
                    } else {
                        total += pricePerNight;
                        regularNights++;
                    }
                }

                console.log(`🗓️ Nights: ${nights}, Peak: ${peakNights}, Regular: ${regularNights}`);

                const avgPrice = total / nights;

                row.find('.qty').val(nights);
                row.find('.price').val(avgPrice.toFixed(2));
                row.find('.item-total').val(total.toFixed(2));
                row.find('.item-name').val(aptName);

                // Optional visual cue
                if (peakNights > 0) {
                    row.addClass('bg-peak');
                } else {
                    row.removeClass('bg-peak');
                }

                calculateTotals();
            }






            // Totals
            function calculateTotals() {
                const currency = $('#currency').val() || '';

                let apartmentSubtotal = 0;
                let extraItemsSubtotal = 0;

                // ---- Main apartment items ----
                $('.invoice-item-row').each(function() {
                    const total = parseFloat($(this).find('.item-total').val()) || 0;
                    apartmentSubtotal += total;
                });

                // ---- Extra invoice items ----
                $('.extra-item-row').each(function() {
                    const total = parseFloat($(this).find('.extra-total').val()) || 0;
                    extraItemsSubtotal += total;
                });

                // Get discount + caution fee
                const discountVal = parseFloat($('#discount').val()) || 0;
                const discountType = $('#discountType').val();
                const cautionFee = parseFloat($('#cautionFee').val()) || 0;

                // Discount ONLY on apartments
                let discountAmount =
                    discountType === 'percent' ?
                    (apartmentSubtotal * discountVal) / 100 :
                    discountVal;

                if (discountAmount > apartmentSubtotal) {
                    discountAmount = apartmentSubtotal; // safety
                }

                // final formula
                const grandTotal =
                    (apartmentSubtotal - discountAmount) + extraItemsSubtotal + cautionFee;

                // Display totals
                $('#subTotal').val(currency + (apartmentSubtotal + extraItemsSubtotal).toFixed(2));
                $('#grandTotal').val(currency + grandTotal.toFixed(2));

                // Optional numeric fields
                $('#subTotalNumeric').val((apartmentSubtotal + extraItemsSubtotal).toFixed(2));
                $('#grandTotalNumeric').val(grandTotal.toFixed(2));
            }



            // Preview
            $('#previewBtn').on('click', function() {
                const confirmPreview = confirm("✅ Please confirm all details are correct before previewing.");
                if (!confirmPreview) return;

                const formData = $('#invoiceForm').serialize();
                const previewUrl = `/admin/invoices/preview?${formData}`;
                window.open(previewUrl, '_blank');
            });

            // Recalculate on change
            $('#discount, #discountType, #cautionFee').on('input change', function() {
                calculateTotals();
            });

            // Save buttons — confirm + loader
            $('[data-action]').on('click', function() {
                if (!validateInvoiceForm()) return; // stop submission if invalid

                const action = $(this).data('action');
                const confirmed = confirm("⚠️ Please review all invoice details before proceeding. Continue?");
                if (!confirmed) return;

                // 🧹 Clean currency symbols before submission
                $('#subTotal, #grandTotal').each(function() {
                    $(this).val($(this).val().replace(/[^\d.]/g, ''));
                });

                $('#pageLoader').fadeIn(200);
                $('<input>').attr({
                    type: 'hidden',
                    name: 'action',
                    value: action
                }).appendTo('#invoiceForm');

                setTimeout(() => $('#invoiceForm').submit(), 400); // short delay to show loader
            });
        });
    </script>





</body>

</html>