<?php
//use mPDF as Mpdf;
//require_once __DIR__ . '../../vendor/autoload.php';
//echo __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;
require_once '../../vendor/autoload.php';
/* require_once __DIR__ . '/vendor/autoload.php';
*/
//$mpdf = new \Mpdf\Mpdf();
$mpdf = new Mpdf(['debug' => true]);
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output(); 
//$mpdf->Output('filename.pdf', \Mpdf\Output\Destination::FILE);
?>