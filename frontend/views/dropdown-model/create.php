<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DropdownModel */

$this->title = Yii::t('app', 'Create Dropdown Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dropdown Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-model-create">

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
