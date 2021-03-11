<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการสิทธิ์การเข้าใช้งาน');
$this->params['breadcrumbs'][] = ['label' => 'จัดการ Template', 'url' => ['eform-template/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.div-scrollbar{
    height: 250px;
    overflow-y: scroll;
    padding: 0em 1em 1em 1em;
    margin-bottom: 1em;
}

.div-scrollbar2{
    height: 80px;
    overflow-y: scroll;
    padding: 0em 1em 1em 1em;
    margin-bottom: 1em;
    line-height: 13px;
}
.isDisabled {
    pointer-events: none;
    cursor: default;
    text-decoration: none;
}
</style>
<div class="user-role-index">

	<div class="row clearfix">
		<div class="col-xl-4 col-lg-4 col-md-4">
            <h4><?= Html::encode($this->title) ?></h4>

            <?php Pjax::begin(['id'=>'user_role_index_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
            <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php //= 
                //     GridView::widget([
                //     	'dataProvider' => $dataProvider,

                //     	'columns' => [
                //     		['class' => 'yii\grid\SerialColumn'],


                //     		'role',
                //     		[
                //     			'attribute'=>'allow_access_main',
                //     			'format'=>'raw',
                //     			'value' => function($model, $key, $index)
                //     			{
                //     				if(!empty($model->allow_access_main) && strlen($model->allow_access_main)>2)
                //     				{
                //     					return getList($model->allow_access_main,'menu_main','id','m_name');
                //     				}
                //     			},
                //     		],

                //     		[
                //     			'attribute'=>'allow_access_sub',
                //     			'format'=>'raw',
                //     			'value' => function($model, $key, $index)
                //     			{
                //     				if(!empty($model->allow_access_sub) && strlen($model->allow_access_sub)>2)
                //     				{
                //     					return getList($model->allow_access_sub,'menu_sub','submenu_id','submenu_name');
                //     				}
                //     			},

                //     		],

                //     		['class' => 'yii\grid\ActionColumn',
                //     		'buttons' => [
                //     			'delete' => function ($url, $model, $key) {
                //     				return false;
                //     			},
                //     		]
                //     	]

                //     ],
                // ]);

                    ?>
                    <?php
                    $columns = 1;
                    $cl = 12 / $columns;

                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout'       => '{items}{pager}',
                        'itemOptions'  => ['class' => "col-md-$cl"],
                        'itemView'     => '_listuser_role',
                        'options'      => ['class' => 'grid-list-view row' ],
                        'emptyText' => '<div class="row"><div class="p-3 col-md-12">No results.</div></div>',
                        'pager' => [
                            'options' =>[
                                'class' => 'pagination col-md-12'],
                            ],
                        ]);

                        ?>

                        <?php Pjax::end(); ?>

                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-8">
                        <?php $count_user_group = Yii::$app->db->createCommand("SELECT COUNT(*) FROM user_group")->queryScalar(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h5><dt>กลุ่มผู้ใช้งาน <small>(<?=number_format($count_user_group);?> รายการ)</small></dt></h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-success" href="index.php?r=user-group%2Fcreate_usergroup">เพิ่มกลุ่มผู้ใช้งาน</a>
                            </div>
                        </div>
                        
                        
                        <hr>
                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="ค้นหา (ชื่อกลุ่มผู้ใช้งาน , รายละเอียด)" />

                        <div id="dynamic_content">

                        </div>
                        
                    </div>
                </div>



                <script>
                  $(document).ready(function(){

                    load_data(1);

                    function load_data(page, query = '')
                    {
                      $.ajax({
                        url:"index.php?r=user-role/fetch_users_group",
                        method:"POST",
                        data:{page:page, query:query},
                        success:function(data)
                        {
                          $('#dynamic_content').html(data);
                      }
                  });
                  }

                  $(document).on('click', '.click-page-link', function(){
                      var page = $(this).data('page_number');
                      var query = $('#search_box').val();
                      load_data(page, query);
                  });

                  $('#search_box').keyup(function(){
                      var query = $('#search_box').val();
                      load_data(1, query);
                  });

              });
          </script>