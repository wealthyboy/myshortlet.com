<!DOCTYPE html>
<html>

<head>
    <title>QR Code</title>
</head>

<body>
    <!-- <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}">
    <p>Scan this QR code to visit: <a href="{{ $url }}">{{ $url }}</a></p> -->

    <div class="visible-print text-center">
        {!! QrCode::size(100)->generate(Request::url()); !!}
        <p>Scan me to return to the original page.</p>
    </div>

</body>

</html>