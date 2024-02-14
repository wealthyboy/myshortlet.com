<!DOCTYPE html>
<html>

<head>
    <title>QR Code</title>
</head>

<body>


    <div class="visible-print text-center">
        {!! QrCode::size(200)->generate('https://avenuemontaigne.ng/checkin'); !!}
    </div>


    <div style="margin-top: 100px;" class="visible-print text-center ">
        {!! QrCode::size(200)->generate('https://avenuemontaigne.ng'); !!}
    </div>

</body>

</html>