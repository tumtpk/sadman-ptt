<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = 'แก้ไข : ' . $model->setting_name;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->setting_name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="setting-update">

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
