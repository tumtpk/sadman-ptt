<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Users */

$this->title = 'เปลี่ยนรหัสผ่าน';
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="users-update">

	<h4><?=Html::encode($this->title)?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="users-form">


								<?=Html::beginForm(['changepass'], 'post');?>

								<div class="row">
									<div class="col-md-4">
										<?=Html::label('<i class="fa fa-user" aria-hidden="true"></i> ชื่อผู้ใช้งานระบบ');?>
										<?=Html::textInput('username', $model->username, ['class' => 'form-control', 'readonly' => true]);?>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-4">
										<?=Html::label('<i class="fa fa-key" aria-hidden="true"></i> รหัสผ่านใหม่');?>
										<?=Html::passwordInput('auth_key', '', ['class' => 'form-control']);?>
									</div>
									<div class="col-md-4">
										<?=Html::hiddenInput('password', $model->password, ['class' => 'form-control']);?>
									</div>
								</div>

								<br>
								<div class="row">
									<div class="col-md-12">
										<?=Html::hiddenInput('id', $model->id, ['class' => 'form-control']);?>
										<?=Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success btn-md']);?>
									</div>
								</div>



								<?=Html::endForm();?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>




</div>