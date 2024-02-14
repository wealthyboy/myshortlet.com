<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QrCodeController extends Controller
{
    public function generateQRCode()
    {

        // Create a QR code writer

        // $image = QrCode::size(200)->generate('https://avenuemontaigne.ng/checkin', public_path('qrcodes/checkin.png'));
        // $image = QrCode::format('png')
        //     ->size(200)->errorCorrection('H')
        //     ->generate('https://avenuemontaigne.ng/checkin');
        // $output_file = time() . '.png';
        // Storage::disk('local')->put($output_file, $image);

        // dd($image);
        // dd($writer);

        // Generate QR code
        // $qrCode = $writer->writeString('https://avenuemontaigne.ng/checkin');

        return view('qrcode.qrcode');
    }
}
