<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\QuestionAndAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'คำถามที่พบบ่อย';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-and-answer-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('เพิ่มคำถามที่พบบ่อย', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'qa_id',
                            'qa_questions:ntext',
                            'qa_answer:ntext',
                            'qa_date_create',
                            //'qa_status',
                            [
                                'attribute'=>'active',
                                'header'=>'qa_status',
                                'filter' => ['1'=>'enable', '0'=>'disable'],
                                'format'=>'raw',    
                                'value' => function($model, $key, $index)
                                {   
                                    if($model->qa_status == '1')
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

