<?php
/* Veja a Documentação da Biblioteca MPDF: https://mpdf.github.io/ */

use Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';

// Create an instance of the class:
$mpdf = new Mpdf();

// Buffer the following html with PHP so we can store it to a variable later
ob_start();

// This is where your script would normally output the HTML using echo or print
echo '<div>Generate your content</div>';

// Now collect the output buffer into a variable
$html = ob_get_contents();
ob_end_clean();

// send the captured HTML from the output buffer to the mPDF class for processing
$mpdf->WriteHTML($html);
$mpdf->Output();
