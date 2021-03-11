<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarouselText */

$this->title = 'แก้ไขสไลด์ข่าวหน้าเข้าสู่ระบบ : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'สไลด์ข่าวหน้าเข้าสู่ระบบ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="carousel-text-update">

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
