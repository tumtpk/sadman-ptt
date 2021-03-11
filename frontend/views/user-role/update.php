<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */

$this->title = Yii::t('app', 'แก้ไขข้อมูลสิทธิ์การเข้าถึง: {name}', [
	'name' => $model->role,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สิทธิ์การเข้าใช้งาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไขข้อมูล');
?>
<div class="user-role-update">

	<h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">
					<?= $this->render('_form', [
						'model' => $model,
					]) ?>
				</div>
			</div>
		</div>
	</div>
</div>
