<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsValuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ค่าของข่าว';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-values-index">

   <h4><?= Html::encode($this->title) ?></h4>
   <div class="row clearfix">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body ribbon">

                <p>
                    <button type="button" class="btn btn-success btn-sm" id="news-values-create" data-toggle="modal" data-target="#news-values-modal" data-pjax="0">เพิ่มค่าของข่าว</button>
                </p>

                <?php Pjax::begin(['id'=>'news-values_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'news_val_name',
                        'news_val_detail',
                        // 'user_create_update',
                        [
                                'attribute'=>'user_create_update',
                                'format'=>'raw',
                                'value' => function($model, $key, $index)
                                {
                                    if(!empty($model->user_create_update))
                                    {
                                     $query = Users::find()
                                     ->select('id,name')
                                     ->where("id = " . $model->user_create_update)->one();
                                     return $query->name;
                                 }
                             },
                         ],

                        ['class' => 'yii\grid\ActionColumn',
                         'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                                    'class' => 'news-values-view-link',
                                    'title' => 'ค่าของข่าว',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#news-values-modal',
                                    'data-id' => $key,
                                    'data-pjax' => '0',

                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                                    'class' => 'news-values-update-link',
                                    'title' => 'แก้ไขค่าของข่าว',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#news-values-modal',
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
<div class="modal" id="news-values-modal">
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
      $("#news-values-create").click(function(e) {
        $.get(
        "index.php?r=news-values/create",
        function (data)
        {
            $("#news-values-modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("เพิ่มค่าของข่าว");
            $("#news-values-modal").modal("show");
        }
        );
        });

        $(".news-values-view-link").click(function(e) {
            var fID = $(this).data("id");
            $.get(
            "index.php?r=news-values/view&id="+fID,
            {
                id: fID
                },
                function (data)
                {
                    $("#news-values-modal").find(".modal-body").html(data);
                    $(".modal-body").html(data);
                    $(".modal-title").html("ค่าของข่าว");
                    $("#news-values-modal").modal("show");
                }
                );
                });


                $(".news-values-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                    "index.php?r=news-values/update&id"+fID,
                    {
                        id: fID
                        },
                        function (data)
                        {
                            $("#news-values-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("แก้ไขค่าของข่าว");
                            $("#news-values-modal").modal("show");
                        }
                        );
                        });
                    }
                    init_click_handlers();
                    $("#news-values_pjax_id").on("pjax:success", function() {
                      init_click_handlers(); 
                      });
                      ');


                      ?>



