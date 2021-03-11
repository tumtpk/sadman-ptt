<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Kptag */

$this->title = 'อัพเดทจุดที่บุกรุก ' . $model->name_kp;
$this->params['breadcrumbs'][] = ['label' => 'จุดที่บุกรุก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="kptag-update">

    <h3><?= Html::encode($this->title) ?></h3>
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