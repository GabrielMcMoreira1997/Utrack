<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');
        $qrCode = QrCode::size(300)->generate($url);

        return response()->json([
            'qr' => (string) $qrCode // força ser string
        ]);
    }

}
