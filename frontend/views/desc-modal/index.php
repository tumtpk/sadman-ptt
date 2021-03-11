<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DescModalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'คู่มือการใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desc-modal-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="card">
        <div class="card-body">
            <p>
                <?//= Html::a('เพิ่ม'.$this->title, ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(['id'=>'desc-modal_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'topic',
                    'description',
                    [
                        'attribute'=>'status',
                        'format'=>'raw',
                        'value' => function($model, $key, $index)
                        {
                            if($model->status=='0')
                            {
                                return '<a href="#" data-toggle="tooltip" data-placement="top" title="เปิดการใช้งาน!"><i class="fa fa-circle text_sussess_a6ca16"></i></a>';
                            }else{
                                return '<a href="#" data-toggle="tooltip" data-placement="top" title="ปิดการใช้งาน!"><i class="fa fa-circle text_danger_dc3545"></i></a>';
                            }
                        },
                    ],
                    
                    ['class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                                'class' => 'desc-modal-view-link',
                                'title' => 'คู่มือการใช้งาน',
                                'data-toggle' => 'modal',
                                'data-target' => '#desc-modal-modal',
                                'data-id' => $key,
                                'data-pjax' => '0',

                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                                'class' => 'desc-modal-update-link',
                                'title' => 'แก้ไขคู่มือการใช้งาน',
                                'data-toggle' => 'modal',
                                'data-target' => '#desc-modal-modal',
                                'data-id' => $key,
                                'data-pjax' => '0',

                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return false;
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

<!-- The Modal -->
<div class="modal" id="desc-modal-modal">
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
      $("#desc-modal-create").click(function(e) {
        $.get(
        "index.php?r=desc-modal/create",
        function (data)
        {
            $("#desc-modal-modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("เพิ่มคู่มือการใช้งาน");
            $("#desc-modal-modal").modal("show");
        }
        );
        });

        $(".desc-modal-view-link").click(function(e) {
            var fID = $(this).data("id");
            $.get(
            "index.php?r=desc-modal/view&id="+fID,
            {
                id: fID
                },
                function (data)
                {
                    $("#desc-modal-modal").find(".modal-body").html(data);
                    $(".modal-body").html(data);
                    $(".modal-title").html("คู่มือการใช้งาน");
                    $("#desc-modal-modal").modal("show");
                }
                );
                });


                $(".desc-modal-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                    "index.php?r=desc-modal/update&id"+fID,
                    {
                        id: fID
                        },
                        function (data)
                        {
                            $("#desc-modal-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("แก้ไขคู่มือการใช้งาน");
                            $("#desc-modal-modal").modal("show");
                        }
                        );
                        });
                    }
                    init_click_handlers();
                    $("#desc-modal_pjax_id").on("pjax:success", function() {
                      init_click_handlers(); 
                      });
                      ');


                      ?>



