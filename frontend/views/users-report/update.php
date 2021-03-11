<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsersReport */

$this->title = Yii::t('app', 'แก้ไขรายงานส่วนบุคคล');
// $this->title = Yii::t('app', 'แก้ไขรายงานส่วนบุคคล: {name}', [
//     'name' => $model->id,
// ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลรายงานส่วนบุคคล'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียด', 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-report-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
