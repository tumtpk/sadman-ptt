<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\MenuMain;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuSub */

$this->title = $model->submenu_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เมนูย่อย'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-sub-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->submenu_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->submenu_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'submenu_id',
                            'submenu_name:ntext',
            // 'submenu_role',
            // 'submenu_link:ntext',
            // 'submenu_active:ntext',
            // [
            //     'attribute'=>'submenu_role',
            //     'format'=>'raw',
            //     'value' => function($model, $key)
            //     {
            //         if(!empty($model->submenu_role) && strlen($model->submenu_role)>2)
            //         {
            //             return getList($model->submenu_role,'ms_user_type_group','USER_TYPE_GROUP_CODE','USER_TYPE_GROUP_DESC');
            //         }
            //     },
            // ],           
                            
                            'submenu_link:ntext',
                            [
                                'attribute'=>'submenu_active',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if($model->submenu_active=='Y')
                                    {
                                        return 'เปิดการใช้งานเมนู';
                                    }else{
                                        return 'ปิดการใช้งานเมนู';
                                    }
                                },
                            ],
            // 'menu_id',
                            // 'menu_id',
                            [
                                'attribute'=>'menu_id',
                                'format'=>'raw',    
                                'value' => function($model, $key)
                                        {
                                            if(!empty($model->menu_id))
                                            {
                                                $query = MenuMain::find()
                                                ->select('id,m_name')
                                                ->where("id = ".$model->menu_id)->one();
                                // return '<h5><span class="label label-default">'.$query->role.'</span></h5>';
                                                return $query->m_name;
                                            }
                                        },
                            ],
                            [
                                'attribute'=>'s_icon',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if($model->s_icon!='')
                                    {
                                        return '<i class="'.$model->s_icon.'"></i>';
                                    }else{
                                        return '';
                                    }
                                },
                            ],
                            's_detail',
                        ],
                   
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
