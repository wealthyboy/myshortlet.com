<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<head>
    <title>Visitor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="font-family: Arial, sans-serif; background-color: #ccc;">


    <div class="left" style="width: 45%; text-align: left;">
        <img src="https://avenuemontaigne.ng/images/logo/avm_residences.png" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">
    </div>
    <div class="row" style=" page-break-inside: avoid;">


        <div class="left col-md-6" style="">
            <h1>Visitor Details</h1>
            <p><strong>First Name: </strong> {{ $visitor->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $visitor->last_name }}</p>
            <p><strong>Email:</strong> {{ $visitor->email }}</p>
            <p><strong>Phone:</strong> {{ $visitor->phone_number }}</p>
            <p><strong>Apartment:</strong> {{ $reservation->apartment_name }}</p>

            <p><strong>Check-in:</strong> {{-- $reservation->checkin->format('l') --}} {{-- $reservation->checkin->format('d') --}} {{-- $reservation->checkin->format('F')  --}}{{-- $reservation->checkin->isoFormat('Y') --}}</p>
            <p><strong>Check-out:</strong> {{-- $reservation->checkout->format('l') --}} {{-- $reservation->checkout->format('d') --}} {{-- $reservation->checkout->format('F')  --}}{{-- $reservation->checkout->isoFormat('Y') --}}</p>

        </div>

        <div class=" col-md-6" style="">
            <img src="{{ $visitor->image }}" alt="Visitor Image" style="max-width: 300px; max-height: 250px;">
        </div>
    </div>

</body>

</html>