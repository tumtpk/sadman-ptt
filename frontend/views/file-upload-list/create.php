<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FileUploadList */

$this->title = 'Create File Upload List';
$this->params['breadcrumbs'][] = ['label' => 'File Upload Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-upload-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
