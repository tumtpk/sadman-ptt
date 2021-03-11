<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<style>
	/*.show-text {
	-moz-transform: scale(.40, .40); 
	-webkit-transform: scale(.40, .40); 
	-o-transform: scale(.40, .40);
	-ms-transform: scale(.40, .40);
	transform: scale(.40, .40); 
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	transform-origin: top left;*/
}
</style>
<div class="card p-3">
	<div class="show-text" id="show_content_<?=$model->id;?>" data-id="<?=$model->id;?>"></div>
</div>