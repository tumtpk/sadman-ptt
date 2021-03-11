<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserRole;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
if ($_SESSION['user_role']==1) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
}

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($_SESSION['user_role']==1) { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'username',
            // 'password',
            // 'auth_key',
            // 'password_reset_token',
            // 'role',
            [
                'format'=>'raw',
                'attribute'=>'role',
                'value' => function($model,$index)
                {
                    if(!empty($model->role))
                    {
                        $query = UserRole::find()
                                ->select('id,role')
                                ->where("id = ".$model->role)->one();
                        // return '<h5><span class="label label-default">'.$query->role.'</span></h5>';
                        return $query->role;
                    }
                },
            ],
            // 'images:ntext',
            [
                'format'=>'raw',
                'attribute'=>'images',
                'value' => function($model,$index)
                {
                    if(!empty($model->images))
                    {
                        return Html::img($model->photoViewer,['class'=>'img-thumbnail','style'=>'width:200px;']);
                    }else{
                        return Html::img('@web/img/none.png',['class'=>'img-thumbnail','style'=>'width:200px;']);
                    }
                },
            ],
            // 'status',
            [
                'format'=>'raw',
                'attribute'=>'status',
                'value'=> $model->status == 1 ? 'enable' : 'disable',
            ],
        ],
    ]) ?>

</div>
