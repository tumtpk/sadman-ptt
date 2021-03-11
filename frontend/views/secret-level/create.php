<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SecretLevel */

$this->title = Yii::t('app', 'สร้างชั้นความลับ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ชั้นความลับ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="secret-level-create">

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
