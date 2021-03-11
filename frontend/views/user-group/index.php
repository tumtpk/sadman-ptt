<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'กลุ่มผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">

                    <p>
                        <button type="button" class="btn btn-success btn-sm" id="user-group-create" data-toggle="modal" data-target="#user-group-modal" data-pjax="0">เพิ่มกลุ่มผู้ใช้งาน</button>
                    </p>

                    <?php Pjax::begin(['id'=>'user_group_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'name',
                            'description',

                            ['class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                                        'class' => 'user-group-view-link',
                                        'title' => 'กลุ่มผู้ใช้งาน',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#user-group-modal',
                                        'data-id' => $key,
                                        'data-pjax' => '0',

                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                                        'class' => 'user-group-update-link',
                                        'title' => 'แก้ไขกลุ่มผู้ใช้งาน',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#user-group-modal',
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
<div class="modal" id="user-group-modal">
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
      $("#user-group-create").click(function(e) {
        $.get(
        "index.php?r=user-group/create",
        function (data)
        {
            $("#user-group-modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("เพิ่มกลุ่มผู้ใช้งาน");
            $("#user-group-modal").modal("show");
        }
        );
        });

        $(".user-group-view-link").click(function(e) {
            var fID = $(this).data("id");
            $.get(
            "index.php?r=user-group/view&id="+fID,
            {
                id: fID
                },
                function (data)
                {
                    $("#user-group-modal").find(".modal-body").html(data);
                    $(".modal-body").html(data);
                    $(".modal-title").html("กลุ่มผู้ใช้งาน");
                    $("#user-group-modal").modal("show");
                }
                );
                });


                $(".user-group-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                    "index.php?r=user-group/update&id"+fID,
                    {
                        id: fID
                        },
                        function (data)
                        {
                            $("#user-group-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("แก้ไขกลุ่มผู้ใช้งาน");
                            $("#user-group-modal").modal("show");
                        }
                        );
                        });
                    }
                    init_click_handlers();
                    $("#user_group_pjax_id").on("pjax:success", function() {
                      init_click_handlers(); 
                      });
                      ');


                      ?>


