<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<head>
    <title>Visitor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="font-family: Arial, sans-serif;">

    <page backtop="10mm" backbottom="10mm" style="font-size: 14pt">

        <div align="center">
            <img src="https://avenuemontaigne.ng/images/logo/avnmont-white-04.png" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">
            <br />
        </div>
    </page>

    <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 10px; page-break-inside: avoid;">
        <img src="https://avenuemontaigne.ng/images/logo/avnmont-white-04.png" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">

        <div class="left" style="width: 45%; text-align: left;">
            <h1>Visitor Details</h1>
            <p><strong>First Name: </strong>{{ $visitor->first_name }}</p>
            <p><strong>Last Name:</strong>{{ $visitor->last_name }}</p>
            <p><strong>Email:</strong>{{ $visitor->email }}</p>
            <p><strong>Phone:</strong>{{ $visitor->phone_number }}</p>
            <p><strong>Apartment:</strong>{{ $visitor->apartment_id }}</p>

            <p><strong>Check-in:</strong> {{ $reservation->checkin->format('l') }} {{ $reservation->checkin->format('d') }} {{ $reservation->checkin->format('F')  }}{{ $reservation->checkin->isoFormat('Y') }}</p>
            <p><strong>Check-out:</strong> {{ $reservation->checkout->format('l') }} {{ $reservation->checkout->format('d') }} {{ $reservation->checkout->format('F')  }}{{ $reservation->checkout->isoFormat('Y') }}</p>

        </div>

        <div class="right" style="width: 45%; text-align: right;">
            <img src="{{ $visitor->image }}" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">
        </div>
    </div>

</body>

</html>