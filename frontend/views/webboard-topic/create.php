<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WebboardTopic */

$this->title = 'เพิ่มกระดานข่าว';
$this->params['breadcrumbs'][] = ['label' => 'กระดานข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-topic-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
