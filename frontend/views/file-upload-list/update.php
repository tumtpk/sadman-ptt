<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FileUploadList */

$this->title = 'Update File Upload List: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'File Upload Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-upload-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
