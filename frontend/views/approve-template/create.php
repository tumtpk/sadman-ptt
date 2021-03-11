<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApproveTemplate */

$this->title = 'เพิ่มการอนุมัติข่าว';
$this->params['breadcrumbs'][] = ['label' => 'การอนุมัติข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approve-template-create">

	<h4><?= Html::encode($this->title) ?></h4>

	<div class="card">
		
		<div class="card-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>
	

</div>
