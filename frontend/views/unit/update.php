<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = 'แก้ไขข้อมูลหน่วย : ' . $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลหน่วยงาน', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->unit_id, 'url' => ['view', 'id' => $model->unit_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<div class="unit-update">

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
