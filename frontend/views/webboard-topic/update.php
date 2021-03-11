<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardTopic */

$this->title = 'แก้ไขกระดานข่าว : ' . $model->topic_name;
$this->params['breadcrumbs'][] = ['label' => 'กระดานข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->topic_name, 'url' => ['view', 'id' => $model->topic_id]];
$this->params['breadcrumbs'][] = 'แก้ไขกระดานข่าว';
?>
<div class="webboard-topic-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
