<?php

namespace App\Helper;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;

class QRCodeHelper
{
    public static function generateQRCode(string $contents): QrCode
    {
        $qrCode = new QrCode($contents);
        $qrCode->setSize(300);
        $qrCode->setWriterByName('svg');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->writeFile(__DIR__. '/../../public/qr-codes/' . $contents . '.svg');
        return $qrCode;
    }
}
