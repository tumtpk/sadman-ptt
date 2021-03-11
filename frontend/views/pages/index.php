<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Iframe';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pages-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('+เพิ่มข้อมูล Iframe', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                    #  'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            # 'id',
                            'page_name',
                            # 'iframe:text', 
                            [
                                'attribute' => 'iframe',
                                'headerOptions' => ['style' => 'width:40'],
                            ],
                            # 'status',
                            [
                                'attribute'=>'active',
                                'header'=>'status',
                                'filter' => ['1'=>'enable', '0'=>'disable'],
                                'format'=>'raw',    
                                'value' => function($model, $key, $index)
                                {   
                                    if($model->status == '1')
                                    {
                                        return 'เปิดการใช้งาน';
                                    }
                                    else
                                    {   
                                        return 'ปิดการใช้งาน';
                                    }
                                },
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                            
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

