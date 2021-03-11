<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsersReport */

$this->title = Yii::t('app', 'ออกแบบรายงานส่วนบุคคล');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลรายงานส่วนบุคคล'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-report-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
