<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
if(!in_array($_SESSION['user_role'], array('1','2'))){
	if($_SESSION['user_id']!=$model->id){
		echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
	}
}

if ($_SESSION['user_role']=='2') {
	if($_SESSION['unit_id']!=$model->unit_id){
		echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
	}
}

if ($_SESSION['user_role']=='3') {
	if($_SESSION['user_id']!=$model->id){
		echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
	}
}

$this->title = 'แก้ไขข้อมูล : ' . $model->name;
if ($_SESSION['user_role']=='2' && $_SESSION['user_id']!=$model->id){
	$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานในหน่วยงาน', 'url' => ['index', 'unitid' => $_SESSION['unit_id']]];
}
if ($_SESSION['user_id']!=$model->id){
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
}
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';


?>
<div class="users-update">

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
