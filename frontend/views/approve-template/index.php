<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApproveTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'การอนุมัติข่าว';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="approve-template-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="card">

        <div class="card-body">
            <p>
                <?= Html::a('เพิ่ม'.$this->title, ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'approve_name',
                    // 'step:ntext',
                    [
                        'attribute'=>'step',
                        'format'=>'raw',
                        'value' => function($model, $key, $index)
                        {
                            $data_step = @json_decode($model->step,TRUE);
                            $show_step = '';
                            foreach ($data_step[0] as $k => $v) {
                                $show_step .= "<b>$k :</b> $v<br>";
                            }
                            return $show_step;
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>
