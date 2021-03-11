<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DropdownModel */

$this->title = $model->model_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dropdown Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dropdown-model-view">

    <h4><?= Html::encode($this->title) ?></h4>
	<div class="card">
				<div class="card-body ribbon">
    <p>
        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            #'id',
            'model_name',
            'description',
        ],
    ]) ?>

</div>
</div>
</div>
