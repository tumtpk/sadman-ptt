<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

if ($_SESSION['user_role'] == '1') {
	$this->title = 'เพิ่มผู้ดูแลระบบของหน่วยงาน';
	if (isset($_GET['unitid'])) {
		$checkadmin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE unit_id = '" . $_GET['unitid'] . "' AND role = '2'")->queryScalar();
		$checklimit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '" . $_GET['unitid'] . "'")->queryOne();
		if ($checkadmin >= $checklimit['admin_limit']) {
			echo "<script>alert('จำนวนผู้ดูแลเต็มแล้ว กรุณาตรวจสอบ');window.close();</script>";
		}
	}
} else if ($_SESSION['user_role'] == '2') {
	$this->title = 'เพิ่มผู้ใช้งานในหน่วยงาน';
}

if ($_SESSION['user_role'] != '1') {
	$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานในหน่วยงาน', 'url' => ['index']];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

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