<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionAndAnswer */

$this->title = 'แก้ไขคำถาม : ' . $model->qa_questions;
$this->params['breadcrumbs'][] = ['label' => 'คำถามที่พบบ่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qa_id, 'url' => ['view', 'id' => $model->qa_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-and-answer-update">

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
