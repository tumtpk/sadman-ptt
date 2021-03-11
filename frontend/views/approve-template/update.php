<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApproveTemplate */

$this->title = 'แก้ไขการอนุมัติข่าว : ' . $model->approve_name;
$this->params['breadcrumbs'][] = ['label' => 'การอนุมัติข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->approve_name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="approve-template-update">

    <h4><?= Html::encode($this->title) ?></h4>

	<div class="card">
		
		<div class="card-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
	</div>

</div>
