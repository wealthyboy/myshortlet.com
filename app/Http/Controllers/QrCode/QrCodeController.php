<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeController extends Controller
{
    public function generateQRCode()
    {

        // Create a QR code writer
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode =  $writer->writeFile('https://avenuemontaigne.ng/checkin', 'checkin.png');

        dd($qrCode);

        // Generate QR code
        // $qrCode = $writer->writeString('https://avenuemontaigne.ng/checkin');

        return view('qrcode', compact('qrCode'));
    }
}
