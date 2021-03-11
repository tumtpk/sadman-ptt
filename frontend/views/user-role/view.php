<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */

$this->title = $model->role;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สิทธิ์การเข้าใช้งาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-role-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php
                        // = Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->id], [
                        //     'class' => 'btn btn-danger',
                        //     'data' => [
                        //         'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        //         'method' => 'post',
                        //     ],
                        // ]) 
                        ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'role',
                            [
                                'attribute'=>'allow_access_main',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if(!empty($model->allow_access_main) && strlen($model->allow_access_main)>2)
                                    {
                                        return getList($model->allow_access_main,'menu_main','id','m_name');
                                    }
                                },
                            ],

                            [
                                'attribute'=>'allow_access_sub',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if(!empty($model->allow_access_sub) && strlen($model->allow_access_sub)>2)
                                    {
                                        return getList($model->allow_access_sub,'menu_sub','submenu_id','submenu_name');
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
