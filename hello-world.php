<?php
/* Veja a Documentação da Biblioteca MPDF: https://mpdf.github.io/ */

use Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';

// Create an instance of the class:
$mpdf = new Mpdf();

// Write some HTML code:
$mpdf->WriteHTML("
    <h1>Hello world!</h1>
    <p> It's an example with MPDF
");

// Output a PDF file directly to the browser
$mpdf->Output();