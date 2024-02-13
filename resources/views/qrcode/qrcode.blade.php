<!DOCTYPE html>
<html>

<head>
    <title>QR Code</title>
</head>

<body>


    <div class="visible-print text-center">
        {!! QrCode::size(100)->generate(Request::url()); !!}
        <p>Scan me to return to the original page.</p>
    </div>

</body>

</html>