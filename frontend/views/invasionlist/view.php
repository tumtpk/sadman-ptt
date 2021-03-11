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
<div class="invasionlist-view">

    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
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
                        <div class="col-md-6">
                            <img src="https://www.w3schools.com/images/w3schools_green.jpg" alt="" class="img-view">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>