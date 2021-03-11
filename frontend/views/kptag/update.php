<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */

$this->title = Yii::t('app', 'Update Kptag: {name}', [
    'name' => $model->idkp_tag,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kptags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idkp_tag, 'url' => ['view', 'id' => $model->idkp_tag]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="kptag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
