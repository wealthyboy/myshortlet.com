<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>
</head>

<style>
    .flex {
        display: flex;
        flex-wrap: nowrap;
    }

    .justify-between {
        justify-content: space-between;
    }

    .items-center {
        align-items: center;
    }
</style>


<body>

    <img src="https://avenuemontaigne.ng/images/logo/avnmont-white-04.png" alt="Visitor Image">
    <div class="flex justify-between  items-center">
        <div class="visitor-content">
            <h1>Visitor Details</h1>
            <p><strong>First Name: </strong>{{ $visitor->first_name }}</p>
            <p><strong>Last Name:</strong>{{ $visitor->last_name }}</p>
            <p><strong>Email:</strong>{{ $visitor->email }}</p>
            <p><strong>Phone:</strong>{{ $visitor->phone_number }}</p>
            <p><strong>Check-in:</strong> {{ $reservation->checkin->format('l') }} {{ $reservation->checkin->format('d') }} {{ $reservation->checkin->format('F')  }}{{ $reservation->checkin->isoFormat('Y') }}</p>
            <p><strong>Check-out:</strong> {{ $reservation->checkout->format('l') }} {{ $reservation->checkout->format('d') }} {{ $reservation->checkout->format('F')  }}{{ $reservation->checkout->isoFormat('Y') }}</p>

        </div>

        <img src="{{ $visitor->image }}" alt="Visitor Image">
    </div>

</body>

</html>