<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WebboardForumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'หมวดหมู่';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-forum-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">

                    <p>
                        <button type="button" class="btn btn-success btn-sm" id="webboard-forum-create" data-toggle="modal" data-target="#webboard-forum-modal" data-pjax="0">เพิ่มหมวดหมู่</button>
                    </p>

                    

                    <?php //Pjax::begin(); ?>
                    <?php Pjax::begin(['id'=>'webboard_forum_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'forum_name',
                            [
                                'attribute'=>'forum_date_create',
                                'format'=>'raw',
                                'value' => function($model, $key, $index)
                                {
                                    if(!empty($model->forum_date_create))
                                    {
                                        return DateThaiTime($model->forum_date_create);
                                    }
                                },
                            ],
                            [
                                'attribute'=>'forum_user_create',
                                'format'=>'raw',
                                'value' => function($model, $key, $index)
                                {
                                    if(!empty($model->forum_user_create))
                                    {
                                     $query = Users::find()
                                     ->select('id,name')
                                     ->where("id = " . $model->forum_user_create)->one();
                                     return $query->name;
                                 }
                             },
                         ],

                         ['class' => 'yii\grid\ActionColumn',
                         'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                                    'class' => 'webboard-forum-view-link',
                                    'title' => 'หมวดหมู่',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#webboard-forum-modal',
                                    'data-id' => $key,
                                    'data-pjax' => '0',

                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                                    'class' => 'webboard-forum-update-link',
                                    'title' => 'แก้ไขหมวดหมู่',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#webboard-forum-modal',
                                    'data-id' => $key,
                                    'data-pjax' => '0',

                                ]);
                            },

                        ],
                        'contentOptions' => ['class' => 'text-center','style' => 'width:50px;'],
                        'headerOptions' => ['class' => 'text-center','style' => 'width:50px;'],
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
</div>

</div>

<!-- The Modal -->
<div class="modal" id="webboard-forum-modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      </div>

      <!-- Modal footer -->
      <!--   <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
      </div> -->

  </div>
</div>
</div>

<?php 

$this->registerJs('
    function init_click_handlers(){
      $("#webboard-forum-create").click(function(e) {
        $.get(
        "index.php?r=webboard-forum/create",
        function (data)
        {
            $("#webboard-forum-modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("เพิ่มหมวดหมู่");
            $("#webboard-forum-modal").modal("show");
        }
        );
        });

        $(".webboard-forum-view-link").click(function(e) {
            var fID = $(this).data("id");
            $.get(
            "index.php?r=webboard-forum/view&id="+fID,
            {
                id: fID
                },
                function (data)
                {
                    $("#webboard-forum-modal").find(".modal-body").html(data);
                    $(".modal-body").html(data);
                    $(".modal-title").html("หมวดหมู่");
                    $("#webboard-forum-modal").modal("show");
                }
                );
                });


                $(".webboard-forum-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                    "index.php?r=webboard-forum/update&id"+fID,
                    {
                        id: fID
                        },
                        function (data)
                        {
                            $("#webboard-forum-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("แก้ไขหมวดหมู่");
                            $("#webboard-forum-modal").modal("show");
                        }
                        );
                        });
                    }
                    init_click_handlers();
                    $("#webboard_forum_pjax_id").on("pjax:success", function() {
                      init_click_handlers(); 
                      });
                      ');


                      ?>


