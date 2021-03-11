<?php
ob_clean();
require_once '../../vendor/autoload.php';
//custom font
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$detail = $_POST['msg'];
$mpdf = new \Mpdf\Mpdf([
	'tempDir' => __DIR__ . '/tmp',
	'fontDir' => array_merge($fontDirs, ['../../pdf-fonts/',
	]),
	'fontdata' => $fontData + [
		'sarabun' => [
			'R' => 'THSarabunNew.ttf',
			'I' => 'THSarabunNew Italic.ttf',
			'B' =>  'THSarabunNew Bold.ttf',
		]
	],
]);


$text = $detail;

$content = '
<style>
.container{
    font-family: "sarabun";
    font-size: 12pt;
}
table ,th ,tr ,td{
	font-family: "sarabun";
	border: 1px solid #999999;
	border-collapse: collapse;
}
p{
    text-align: justify;
}
h1{
    text-align: center;
}
.btn{
	display:none;
}
</style>
<div class="container" style="width: 100%">
'.$text.'
</div>
';

$mpdf->SetWatermarkText('textx');
$mpdf->showWatermarkText = true;
$mpdf->WriteHTML($content);
$mpdf->Output();
ob_end_flush();

?>