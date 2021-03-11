<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'เพิ่มข้อมูลลูกค้า';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

	<h4><?= Html::encode($this->title) ?></h4>
	<div class="card">
		<div class="card-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
</div>
