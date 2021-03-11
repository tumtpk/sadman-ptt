<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WebboardAnswerReplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webboard Answer Replies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-answer-reply-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Webboard Answer Reply', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'answer_reply_id',
            'answer_reply_detail:ntext',
            'answer_reply_date_create',
            'answer_reply_user_create',
            'answer_id',
            //'topic_id',
            //'status_del',
            //'key_images_or_file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
