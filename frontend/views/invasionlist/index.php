<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Severity;
use common\models\Kptag;
use common\models\Procedure;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InvasionlistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการบุกรุก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invasionlist-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">

                    <p>
                        <?= Html::a('เพิ่มรายการบุกรุก', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php
                    echo $this->render('_search', ['model' => $searchModel]);
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'idinvasionlist',
                            'detail',
                            // 'kp_id',
                            [
                                'label' => 'ระยะ KP',
                                'attribute' => 'kp_id',
                                'value' => function ($model) {
                                    $kp = Kptag::find()->where(['idkp_tag' => $model->kp_id])->one();
                                    return $kp->SP_KP;
                                }
                            ],
                            [
                                'label' => 'ชื่อ',
                                'attribute' => 'kp_id',
                                'value' => function ($model) {
                                    $kp = Kptag::find()->where(['idkp_tag' => $model->kp_id])->one();
                                    return $kp->name_kp;
                                }
                            ],
                            // 'severity',
                            [
                                'label' => 'ความรุนแรง',
                                'attribute' => 'severity',
                                'value' => function ($model) {
                                    $severity = Severity::find()->where(['idseverity' => $model->severity])->one();
                                    return $severity->severity_name;
                                }
                            ],
                            // 'procedure_id',
                            [
                                'label' => 'ขั้นตอน',
                                'attribute' => 'procedure_id',
                                'value' => function ($model) {
                                    $severity = Procedure::find()->where(['idprocedure' => $model->procedure_id])->one();
                                    return $severity->procedureName;
                                }
                            ],
                            //'inspection_result_TMM',
                            //'date',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>



</div>