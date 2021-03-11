<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\MenuMain */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="menu-main-form">


	<?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'm_name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'm_link')->textarea(['rows' => 3]) ?>


			<?//= $form->field($model, 'm_status')->textInput(['maxlength' => true]) ?>

			<?=$form->field($model, 'm_status')->dropDownList(['Y' => 'เปิดการใช้งานเมนู', 'N' => 'ปิดการใช้งานเมนู']); ?>
            <?=$form->field($model, 'm_type')->dropDownList(['left_side' => 'แสดงเป็นรายการ', 'center' => 'แสดงเป็นเมนูร่วม']); ?>

			<?php $model->isNewRecord==1 ? $model->m_active=0:$model->m_active;?>
			<?//=$form->field($model, 'm_active')->radioList(array(0=>'ไม่เน้นเมนู',1=>'เน้นเมนู'))->label(false); ?>
			<?= $form->field($model, 'm_active')->hiddenInput(['maxlength' => true])->label(false) ?>
			<?//= $form->field($model, 'm_active')->radio(['label' => 'ไม่เน้นเมนู', 'value' => 0, 'uncheck' => 'checked']) ?>
			<?//= $form->field($model, 'm_active')->radio(['label' => 'เน้นเมนู', 'value' => 1, 'uncheck' => null]) ?>

			<?= $form->field($model, 'm_detail')->textarea(['rows' => 6]) ?>

		</div>

		<div class="col-md-6">
			<label for="">เลือกไอคอนเมนู</label>
			<div id="target"></div>
			<?= $form->field($model, 'm_icon')->hiddenInput(['maxlength' => true,'id'=>'showdata'])->label(false); ?>
		</div>



		<div class="form-group col-md-12 text-center">
			<hr>
			<?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>



<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/> -->
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/> -->

<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css"/>
<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/icon-fonts/map-icons-2.1.0/css/map-icons.min.css"/>
<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/dist/css/bootstrap-iconpicker.css"/>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/bootstrap-iconpicker.bundle.min.js"></script>

<script type="text/javascript">

	(function($) {
		$('#target').iconpicker({
			align:'left',
			arrowClass: 'btn-primary',
			arrowPrevIconClass: 'fas fa-angle-left',
			arrowNextIconClass: 'fas fa-angle-right',
			cols: 8,
			footer: true,
			header: true,
			icon: '<?=$model->m_icon;?>',
			iconset: 'fontawesome5',
			labelHeader: '{0} of {1} pages',
			labelFooter: '{0} - {1} of {2} icons',
			placement: 'bottom',
			rows: 6,
			search: true,
			searchText: 'Search',
			selectedClass: 'btn-warning',
			unselectedClass: ''
		}
		).on('change', function(e) {
			$("#showdata").val(e.icon);
		});

	})(jQuery);

</script>
