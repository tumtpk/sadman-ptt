<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DescriptionKeywordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'คำอธิบายการใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="description-keywords-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="">
        <div class="">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('สร้างรายการใหม่', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            'name',
                            'detail',
                        // 'images:ntext',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
