<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	label{
		font-weight: bold;
	}
</style>
<div class="customer-form">

	<?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'cus_serial_number')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'cus_key')->textInput(['maxlength' => true]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'cus_basic')->textInput(['maxlength' => true]) ?>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>


	<?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>

	
	<?php ActiveForm::end(); ?>

</div>
