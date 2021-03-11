<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRole;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'เพิ่มผู้ใช้งานระบบในกลุ่ม : '.$_GET['usergroupname'];

$this->params['breadcrumbs'][] = $this->title;
?>
<style>
input[type="file"] {
	display: none;
}
</style>
<div class="users-create">
	<h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">
					<?php $form = ActiveForm::begin([
						'options' => ['enctype' => 'multipart/form-data']
					]); ?>


					<div class="row">
						<div class="col-md-4">
							<label for="">รูปภาพ</label>
							<div class="well">
								<?= Html::img($model->getPhotoViewer(),['style'=>'width:170px;height:170px;object-fit: cover;border-radius:10px;box-shadow: 2px 3px 7px #00000096;','class'=>'img-rounded','id'=>'imgOld',"onerror"=>"this.onerror=null;this.src='img/none.png';"]); ?>
								<img id="person_pic" style="height:170px;object-fit: cover;">
							</div>
							<br>
							<label for="users-images" class="custom-file-upload">
								<i class="fe fe-upload"></i> เลือกไฟล์รูปภาพ
							</label>
							<?= $form->field($model, 'images')->fileInput(["onchange"=>"document.getElementById('person_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'","accept"=>"image/*"])->label(false); ?>
							<div id="imgerror"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-4">
							<?= $form->field($model, 'email')->input('email',['maxlength' => true]) ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<?php
							if ($_SESSION['user_role']=='3') {
								echo $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true, 'id' => 'mytextbox1']);
							}else{
								echo $form->field($model, 'username')->textInput(['maxlength' => true, 'id' => 'mytextbox1']);
							}
							?>
						</div>
						<div class="col-md-4">
							<?//= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
							<?php if(!$model->isNewRecord) {
								echo Html::a('Change Password!', '#',['onclick'=>'changePassword()','id'=>'buttonchangePassword']) . '<br />';
								?>
								<div id="changePassword">
									<?= $form->field($model, 'auth_key')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password','id'=>'cp','value'=>'','placeholder'=>'เปลี่ยนรหัสผ่าน (Password)','style'=>'margin-top: 0.5em;'])->label(false) ?>
									<?= $form->field($model, 'password')->hiddenInput(['maxlength' => true, 'id' => 'mytextbox'])->label(false); ?>
								</div>
							<?php }else{ echo $form->field($model, 'password')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password', 'id' => 'mytextbox']); }?>


						</div>

					</div>

					
					<?=$form->field($model, 'user_group')->hiddenInput(['value' => $_GET['usergroupid']])->label(false); ?>
					<div class="row">
						<div class="col-md-4">
							<label class="control-label" for="users-unit_id">หน่วยงาน</label>
							<?php
							$group=Unit::find()->all();
							$data=ArrayHelper::map($group,'unit_id','unit_name');

							echo $form->field($model, 'unit_id')->dropDownList($data,['prompt'=>'เลือกหน่วยงาน','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
							?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<?= $form->field($model, 'notification')->radioList([0 => 'ปิดการแจ้งเตือน', 1 => 'เปิดการแจ้งเตือน']); ?>
						</div>
					</div>

					<?=$form->field($model, 'status')->hiddenInput(['value' => '1'])->label(false); ?>
					<?=$form->field($model, 'role')->hiddenInput(['value' => '3'])->label(false); ?>



					<div class="form-group">
						<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success checkimg']) ?>
					</div>

					<?php ActiveForm::end(); ?>

				</div>
			</div>
		</div>
	</div>
</div>



<script>
	$(document).on('click', '.checkimg', function(){
		<?php if (!$model->isNewRecord): ?>
			if (!$('#file_name_old').val()) {
				if (!$('#users-images').val()) {
					$("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
					return false;
				}
			}
			<?php else: ?>
				if (!$('#users-images').val()) {
					$("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
					return false;
				}
			<?php endif; ?>

		});
	</script>


	<script>
		$(document).ready(function(){

			$(".field-users-unit_id").addClass('multiselect_div');
			$('.multiselect-filter').multiselect({
				enableFiltering: true,
				enableCaseInsensitiveFiltering: true,
				maxHeight: 200,
			});
	

		$('#mytextbox').bind('keyup blur', function () {
			$(this).val($(this).val().replace(/[^A-Za-z0-9_-@ ]/g, ''))
		});

		$('#mytextbox1').bind('keyup blur', function () {
			$(this).val($(this).val().replace(/[^A-Za-z0-9_-@ ]/g, ''))
		});
	});
</script>


