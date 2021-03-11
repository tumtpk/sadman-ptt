<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\QuestionAndAnswer */

$this->title = $model->qa_questions;
$this->params['breadcrumbs'][] = ['label' => 'Question And Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-and-answer-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('แก้ไข', ['update', 'id' => $model->qa_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('ลบ', ['delete', 'id' => $model->qa_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'qa_id',
                            'qa_questions:ntext',
                            'qa_answer:ntext',
                            'qa_date_create',
                            // 'qa_status',
                            [
                                'attribute'=>'qa_status',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if($model->qa_status=='1')
                                    {
                                        return 'เปิดการใช้งานเมนู';
                                    }else{
                                        return 'ปิดการใช้งานเมนู';
                                    }
                                },
                            ],
                            // 'qa_slot',
                             // 'user_create',
                             [
                                'attribute' => 'user_create',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (!empty($model->user_create)) {
                                        $data1 = Yii::$app->db->createCommand("SELECT name FROM users WHERE id ='".$model->user_create."'")->queryOne();
                                            return $data1['name'];
                                        }
                                            },
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
