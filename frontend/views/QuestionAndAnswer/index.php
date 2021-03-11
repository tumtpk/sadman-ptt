<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionAndAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Question And Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-and-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Question And Answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'question',
            'answer',
            'date_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
