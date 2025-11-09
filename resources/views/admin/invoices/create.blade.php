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
                            <input type="text" name="name" class="form-control" placeholder="Enter name or company" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Currency</label>
                            <select name="currency" id="currency" class="form-control" required>
                                <option value="">Select currency</option>
                                <option value="₦">NGN (₦)</option>
                                <option value="$">USD ($)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter address" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" placeholder="Enter country" />
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
                                    <select id="discountType" class="form-control">
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
                <button type="button" id="previewBtn" class="btn btn-info bg-dark">Preview</button>
                <button type="button" class="btn btn-primary bg-dark" data-action="save">Save</button>
                <button type="button" class="btn btn-dark bg-dark" data-action="save_send">Save & Send</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function() {
            const exchangeRate = 1470; // 1 USD = ₦1470
            let index = 1;

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

            // Update when apartment, dates, or currency changes
            $(document).on('change', '.apartment-select, .checkin, .checkout', function() {
                updateRow($(this).closest('.invoice-item-row'));
            });

            // 🧮 Currency switch — recalculate all instantly
            $('#currency').on('change', function() {
                const newCurrency = $(this).val();
                $('.invoice-item-row').each(function() {
                    updateRow($(this)); // recalculates each item
                });
                calculateTotals();
            });

            // Function: Update each row
            function updateRow(row) {
                const apartment = row.find('.apartment-select option:selected');
                const apartmentId = row.find('.apartment-select').val();
                const basePrice = parseFloat(apartment.data('price')) || 0;
                const aptName = apartment.data('name') || '';
                const currency = $('#currency').val();
                const price = currency === '₦' ? basePrice * exchangeRate : basePrice;

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
                    const warning = $('<small class="text-red-500 date-warning block mt-1">⚠️ Check-out date must be greater than check-in date.</small>');
                    row.find('.checkout').after(warning);
                    calculateTotals();
                    return;
                }

                // Check apartment availability
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
                            const warning = $('');
                            alert("Apartment is not available for that date.")
                        }
                    },
                    error: function(xhr) {
                        console.error('Error checking availability:', xhr.responseText);
                    }
                });

                // Calculate nights
                const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
                const total = nights * price;

                row.find('.qty').val(nights);
                row.find('.price').val(price.toFixed(2));
                row.find('.item-total').val(total.toFixed(2));
                row.find('.item-name').val(aptName);

                calculateTotals();
            }

            // 🧾 Totals calculation
            function calculateTotals() {
                const currency = $('#currency').val() || '';
                let subTotal = 0;

                $('.invoice-item-row').each(function() {
                    const total = parseFloat($(this).find('.item-total').val()) || 0;
                    subTotal += total;
                });

                const discountVal = parseFloat($('#discount').val()) || 0;
                const discountType = $('#discountType').val();
                const cautionFee = parseFloat($('#cautionFee').val()) || 0;

                let discountAmount = discountType === 'percent' ? (subTotal * discountVal) / 100 : discountVal;
                let grandTotal = subTotal - discountAmount + cautionFee;

                $('#subTotal').val(currency + subTotal.toFixed(2));
                $('#grandTotal').val(currency + grandTotal.toFixed(2));

                // Hidden fields for backend numeric values
                if (!$('#subTotalNumeric').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'subTotalNumeric',
                        name: 'sub_total'
                    }).appendTo('#invoiceForm');
                }
                if (!$('#grandTotalNumeric').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'grandTotalNumeric',
                        name: 'total'
                    }).appendTo('#invoiceForm');
                }

                $('#subTotalNumeric').val(subTotal.toFixed(2));
                $('#grandTotalNumeric').val(grandTotal.toFixed(2));
            }

            // Preview invoice
            $('#previewBtn').on('click', function() {
                const formData = $('#invoiceForm').serialize();
                const previewUrl = `/admin/invoices/preview?${formData}`;
                window.open(previewUrl, '_blank');
            });


            $('#discount, #discountType, #cautionFee').on('input change', function() {
                calculateTotals();
            });

            // Save buttons (draft/final)
            $('[data-action]').on('click', function() {
                const action = $(this).data('action');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'action',
                    value: action
                }).appendTo('#invoiceForm');
                $('#invoiceForm').submit();
            });
        });
    </script>





</body>

</html>