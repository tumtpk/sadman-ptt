<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">

	<?php $form = ActiveForm::begin(); ?>

	<div class="row">

		<div class="col-md-4">

			<?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'have_active')->hiddenInput(['maxlength' => true, 'value'=>'1'])->label(false) ?>

			<?= $form->field($model, 'unit_detail')->textArea(['maxlength' => true,'rows'=>'4']) ?>

			<?php if ($model->isNewRecord): ?>
				<?= $form->field($model, 'create_by')->hiddenInput(['maxlength' => true, 'value'=>$_SESSION['user_id']])->label(false) ?>
			<?php endif ?>

			<?= $form->field($model, 'address')->textArea(['maxlength' => true,'rows'=>'3']) ?>

			<label class="control-label" for="unit-province">จังหวัด</label>
			<?php
			$provinceall=Yii::$app->db->createCommand("SELECT * FROM province ORDER BY ProvinceThai")->queryAll();
			$province=ArrayHelper::map($provinceall,'ProvinceThai','ProvinceThai');

			echo $form->field($model, 'province')->dropDownList($province,['prompt'=>'เลือกจังหวัด','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
			?>

			<div class="row">
				<div class="col-md-6">
					<?php
					$admin_limit = ($model->isNewRecord) ? 0 : $model->admin_limit;
					echo $form->field($model, 'admin_limit')->input('number',['maxlength' => true,'min'=>'1','max'=>'1000', 'value'=>$admin_limit]) ?>
				</div>
				<div class="col-md-6">
					<?php
					$user_limit = ($model->isNewRecord) ? 0 : $model->user_limit;
					echo $form->field($model, 'user_limit')->input('number',['maxlength' => true,'min'=>'1','max'=>'1000','value'=>$user_limit]) ?>
				</div>
				<div class="col-md-6">
					<?php
					$undercover_limit = ($model->isNewRecord) ? 0 : $model->undercover_limit;
					echo $form->field($model, 'undercover_limit')->input('number',['maxlength' => true,'min'=>'1','max'=>'1000','value'=>$undercover_limit]) ?>
				</div>
			</div>
		</div>
        
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'lat')->textInput(['maxlength' => true, "onkeypress"=>"return validateQty(this,event);","OnChange"=>"JavaScript:chkNum(this)"]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'lon')->textInput(['maxlength' => true, "onkeypress"=>"return validateQty(this,event);","OnChange"=>"JavaScript:chkNum(this)"]) ?>
				</div>
			</div>

			<link
            data-require="leaflet@0.7.3"
            data-semver="0.7.3"
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css"
            />
            <script
            data-require="leaflet@0.7.3"
            data-semver="0.7.3"
            src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"
            ></script>

            * คลิ๊กบนแผนที่เพื่อเลือกพิกัด
            <div id="mapid" style="width: 100%; height: 410px; border-color: black"></div>    
            <script>
               
                    var mymap = L.map('mapid').setView([13.732564, 100.515000], 5);

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                        maxZoom: 19,
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
                    }).addTo(mymap);



                    var popup = L.popup();

                    function onMapClick(e) {
                        popup
                        .setLatLng(e.latlng)
                        .setContent("ตำแหน่งที่ตั้ง " + e.latlng.toString())
                        .openOn(mymap);
                        var latlng = e.latlng.toString().replace('LatLng(', "");
                        latlng = latlng.toString().replace(')', "");
                        latlng = latlng.toString().split(",");
                        document.getElementById('unit-lat').value = latlng[0];
                        document.getElementById('unit-lon').value = latlng[1];
                    }

                    mymap.on('click', onMapClick);
              
            </script>

		</div>

		<div class="form-group col-md-12 mt-4">
			<div id="show_error"></div>
			<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success savesort']) ?>
			<?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-light']) ?>
		</div>

	</div>

	<?php ActiveForm::end(); ?>

</div>

<script>
	$(document).ready(function(){
		$(".field-unit-province").addClass('multiselect_div');
		$('.multiselect-filter').multiselect({
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			maxHeight: 400
		});
	});
</script>
