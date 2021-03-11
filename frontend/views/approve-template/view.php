<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ApproveTemplate */

$this->title = $model->approve_name;
$this->params['breadcrumbs'][] = ['label' => 'การอนุมัติข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="approve-template-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="card">

        <div class="card-body">
            <p>
                <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
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
                    'id',
                    'approve_name',
                    // 'step:ntext',
                    [
                        'attribute'=>'step',
                        'format'=>'raw',
                        'value' => function($model)
                        {
                            $data_step = @json_decode($model->step,TRUE);
                            $show_step = '';
                            foreach ($data_step[0] as $k => $v) {
                                $show_step .= "<b>$k :</b> $v<br>";
                            }
                            return $show_step;
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
