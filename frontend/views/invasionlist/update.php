<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Invasionlist */

$this->title = 'อัพเดทรายการบุกรุก ' . $model->detail;
$this->params['breadcrumbs'][] = ['label' => 'รายการบุกรุก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .card-header {
        padding: 20px 20px 10px 20px !important;
    }
</style>
<div class="invasionlist-update">

    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="card-body ribbon">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>