<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WebboardAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webboard Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Webboard Answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'answer_id',
            'answer_detail:ntext',
            'answer_date_create',
            'answer_user_create',
            'topic_id',
            //'status_del',
            //'key_images_or_file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
