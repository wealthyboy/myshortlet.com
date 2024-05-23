<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<head>
    <title>Visitor Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            page-break-inside: avoid;
            /* Prevent page breaks inside the row */
        }

        .left {
            width: 50%;
            text-align: left;
        }

        .right {
            width: 50%;
            text-align: right;
        }

        img {
            max-width: 300px;
            max-height: 250px;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; background-color: #ccc;">


    <div class="left" style="width: 45%; text-align: left;">
        <img src="https://avenuemontaigne.ng/images/logo/avem-logo.png" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">
    </div>
    <div class="row " style=" page-break-inside: avoid; padding: 20px;">


        <div style="float:left; font-size: 20px; font-weight: bold" class="left">
            <h1>Visitor Details</h1>
            <p><strong>First Name: </strong> {{ $g->name }}</p>
            <p><strong>Last Name:</strong> {{ $g->last_name }}</p>
            <p><strong>Email:</strong> {{ $g->email }}</p>
            <p><strong>Phone:</strong> {{ $g->phone_number }}</p>
            <p><strong>Apartment:</strong> {{ optional($apartment->attribute)->name }}</p>
            <p><strong>Check-in:</strong> {{ $reservation->checkin->format('l') }} {{ $reservation->checkin->format('d') }} {{ $reservation->checkin->format('F')  }} {{ $reservation->checkin->isoFormat('Y') }}</p>
            <p><strong>Check-out:</strong> {{ $reservation->checkout->format('l') }} {{ $reservation->checkout->format('d') }} {{ $reservation->checkout->format('F')  }} {{ $reservation->checkout->isoFormat('Y') }}</p>

        </div>

        <div style="float:right; font-size: 20px; font-weight: bold" class=" col-md-6">
            <img src="{{ $g->image }}" alt="Visitor Image" style="max-width: 350px; max-height: 350px;">
        </div>

    </div>

</body>

</html>