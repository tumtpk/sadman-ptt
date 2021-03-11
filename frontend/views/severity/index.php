<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SeveritySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Severities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="severity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Severity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idseverity',
            'severity_name',
            'severity_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
