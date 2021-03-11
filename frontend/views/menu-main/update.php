<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MenuMain */

$this->title = Yii::t('app', 'แก้ไขเมนูหลัก: {name}', [
	'name' => $model->m_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เมนูหลัก'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->m_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไขเมนูหลัก');
?>
<div class="menu-main-update">

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
