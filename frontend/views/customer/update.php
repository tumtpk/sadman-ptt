<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'แก้ไขข้อมูลลูกค้า: ' . $model->cus_id;
$this->params['breadcrumbs'][] = ['label' => 'ลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cus_id, 'url' => ['view', 'id' => $model->cus_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="customer-update">

	<h4><?= Html::encode($this->title) ?></h4>
	<div class="card">
		<div class="card-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>
