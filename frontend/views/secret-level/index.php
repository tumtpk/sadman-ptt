<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SecretLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ชั้นความลับ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="secret-level-index">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('app', 'บันทึกข้อมูลชั้นความลับ'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            #'id',
            'level',
            'description',
            #'status',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value' => function($model, $key)
                {
                    if($model->status=='1')
                    {
                        return 'เปิดการใช้งาน';
                    }else{
                        return 'ปิดการใช้งาน';
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
