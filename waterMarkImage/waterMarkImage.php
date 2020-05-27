<?php

/* https://mpdf.github.io/reference/mpdf-variables/showwatermarkimage.html */

use Mpdf\Mpdf;
require_once '../vendor/autoload.php';

$mpdf = new Mpdf();

$mpdf->SetWatermarkImage('php-1.svg');
$mpdf->showWatermarkImage = true;

$mpdf->WriteHTML("
    <h1>Hello Page 1</h1>
    <p> It's the 1st page, with a watermark image!</p>

    <a href='https://mpdf.github.io/reference/mpdf-variables/showwatermarkimage.html' target='_blank'>
        See the Documentation
    </a>
");
// As showWatermark is true when the first page is finished, a watermark is added
$mpdf->AddPage();

// When the second page is finished the watermark will not appear.
$mpdf->showWatermarkImage = false;

$mpdf->WriteHTML("
    <h1>Hello Page 2</h1>
    <p> It's the 2nd page, uhuu!</p>
");

$mpdf->Output();