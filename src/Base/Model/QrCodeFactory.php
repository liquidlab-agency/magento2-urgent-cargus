<?php
/**
 * Created by JetBrains AI Assistant
 * Date: 2025-09-11
 */
declare(strict_types=1);

namespace Urgent\Base\Model;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

/**
 * Factory class for creating QrCode objects compatible with Endroid QrCode v4.x
 */
class QrCodeFactory
{
    /**
     * Create a QrCode instance with SVG writer
     *
     * @param string $data The data to encode in the QR code
     * @param int $size The size of the QR code
     * @param string|null $label Optional label to display below the QR code
     * @return QrCode
     */
    public function create(string $data, int $size = 200, ?string $label = null): QrCode
    {
        // Create QrCode with required data parameter
        $qrCode = new QrCode($data);

        // Set size (this method still exists in v4.x)
        $qrCode->setSize($size);

        // Set other properties with appropriate v4.x methods
        $qrCode->setMargin(10);
        $qrCode->setEncoding(new Encoding('UTF-8'));
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());
        $qrCode->setRoundBlockSizeMode(new RoundBlockSizeModeMargin());
        $qrCode->setForegroundColor(new Color(0, 0, 0));
        $qrCode->setBackgroundColor(new Color(255, 255, 255));

        // Add label if provided
        if ($label !== null) {
            $qrCode->setLabel($label, 16, null, new LabelAlignmentCenter());
        }

        return $qrCode;
    }

    /**
     * Write QR code to string as SVG
     *
     * @param QrCode $qrCode
     * @return string
     */
    public function writeString(QrCode $qrCode): string
    {
        $writer = new SvgWriter();
        return $writer->write($qrCode)->getString();
    }
}
