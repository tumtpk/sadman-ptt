<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button class="user-role-index-create btn btn-success">Create User Role</button>
        <?//= Html::a(Yii::t('app', 'Create User Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="form_edit"></div>


    <?php //Pjax::begin(); ?>
     <?php Pjax::begin(['id'=>'user_role_index_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'role',
            [
                'attribute'=>'allow_access_main',
                'format'=>'raw',
                'value' => function($model, $key, $index)
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
                'value' => function($model, $key, $index)
                {
                    if(!empty($model->allow_access_sub) && strlen($model->allow_access_sub)>2)
                    {
                        return getList($model->allow_access_sub,'menu_sub','submenu_id','submenu_name');
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                   return false;
               },
               'update' => function ($url, $model, $key) {
                // return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                //     ['ms-user-type-group/update', 'id' => $model->USER_TYPE_GROUP_CODE]

                // );
                
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                        'class' => 'user-role-index-update',
                        'title' => '',
                        // 'data-toggle' => 'modal',
                        // 'data-target' => '#menu-main-type-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',

                    ]);
            },
            // 'delete' => function ($url, $model, $key) {
            //     // return false;
            // },

        ],
        'contentOptions' => ['class' => 'text-center','style' => 'width:50px;'],
        'headerOptions' => ['class' => 'text-center','style' => 'width:50px;'],
    ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>


<?php $this->registerJs('
    function init_click_handlers(){
                    $(".user-role-index-update").click(function(e) {
                        var fID = $(this).closest("tr").data("key");
                        $.get(
                        "index.php?r=user-role/update&id"+fID,
                        {
                            id: fID
                            },
                            function (data)
                            {
                               
                                $(".form_edit").html(data);
                                
                            }
                            );
                            });

                             $(".user-role-index-create").click(function(e) {
                        $.get(
                        "index.php?r=user-role/create",
                            function (data)
                            {
                               
                                $(".form_edit").html(data);
                                
                            }
                            );
                            });

                        }
                        init_click_handlers(); //first run
                        $("#user_role_index_pjax_id").on("pjax:success", function() {
                          init_click_handlers(); //reactivate links in grid after pjax update
                      });');?>



