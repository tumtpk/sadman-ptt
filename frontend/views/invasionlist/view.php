<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Invasionlist */

$this->title = $model->detail;
$this->params['breadcrumbs'][] = ['label' => 'Invasionlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .card-header {
        padding: 20px 20px 10px 20px !important;
    }
</style>
<div class="invasionlist-view">

    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="card-body ribbon">
                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    // 'idinvasionlist',
                                    'detail',
                                    'kp_id',
                                    'severity',
                                    'procedure_id',
                                    'inspection_result_TMM',
                                    'date',
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-3">
                            <img src="https://www.spu.ac.th/uploads/webfac/f000000/contents/20180312145944OSQuw1m.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>