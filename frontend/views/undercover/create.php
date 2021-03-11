<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Undercover */

// $this->title = 'เพิ่มสายข่าวของหน่วยงาน';
// $this->params['breadcrumbs'][] = ['label' => 'สายข่าว', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
if ($_SESSION['user_role']=='1') {
	$this->title = 'เพิ่มสายข่าวในหน่วยงาน';
	if(isset($_GET['unitid'])){
		$checkadmin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM undercover WHERE unitid = '".$_GET['unitid']."'")->queryScalar();
		$checklimit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$_GET['unitid']."'")->queryOne();
		if($checkadmin>=$checklimit['undercover_limit']){
			echo "<script>alert('จำนวนสายข่าวเต็มแล้ว กรุณาตรวจสอบ');window.close();</script>";
		}
	}
}else if ($_SESSION['user_role']=='2'){
	$this->title = 'เพิ่มสายข่าวในหน่วยงาน';
}

if ($_SESSION['user_role']!='1') {
	$this->params['breadcrumbs'][] = ['label' => 'สายข่าวในหน่วยงาน', 'url' => ['index']];
}
?>
<div class="undercover-create">


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