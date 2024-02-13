<!DOCTYPE html>
<html>

<head>
    <title>QR Code</title>
</head>

<body>
    <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}">
    <p>Scan this QR code to visit: <a href="{{ $url }}">{{ $url }}</a></p>
</body>

</html>