<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>
</head>

<body>
    <h1>Visitor Details</h1>
    <p>First Name: {{ $visitor->first_name }}</p>
    <p>Last Name: {{ $visitor->last_name }}</p>
    <p>Email: {{ $visitor->email }}</p>
    <p>Phone: {{ $visitor->phone_number }}</p>
    <p>Check-in: {{ $visitor->checkin }}</p>
    <p>Check-out: {{ $visitor->checkout }}</p>
    <!-- Display image if needed -->
    <img src="{{ $visitor->image }}" alt="Visitor Image">
</body>

</html>