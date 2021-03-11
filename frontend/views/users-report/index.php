<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ข้อมูลรายงานส่วนบุคคล');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-report-index">


    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">


                    <p>
                        <?= Html::a(Yii::t('app', 'ออกแบบรายงานส่วนบุคคล'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // 'data_json:ntext',
                            // [
                            //     'attribute'=>'data_json',
                            //     'format'=>'raw',
                            //     'value' => function($model, $key, $index)
                            //     {
                            //         if(!empty($model->data_json))
                            //         {
                            //             return "<div class='show-text' id='show_content_".$model->id."' data-id='".$model->id."'></div>";
                            //         }
                            //     },
                            // ],
                            
                            [
                                'attribute'=>'date_record',
                                'format'=>'raw',    
                                'value' => function($model, $key, $index)
                                {
                                    if(!empty($model->date_record))
                                    {
                                        return DateThaiTime($model->date_record);
                                    }
                                },
                            ],
                            [
                                'attribute'=>'user_create',
                                'format'=>'raw',
                                'value' => function($model, $key, $index)
                                {
                                    if(!empty($model->user_create))
                                    {
                                        $user_create = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$model->user_create."'")->queryOne();
                                        return $user_create['name'];
                                    }
                                },
                                'visible' => $_SESSION['user_role']=='1' ? true : false
                            ],

                            ['class' => 'yii\grid\ActionColumn']
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    jQuery(function ($) {
        $(document).ready(function(){

          $(".show-text").each(function( index ) {
              var id = $(this).data('id');
              // var data_json_text = $(this).data('content');
              // var data_json = data_json_text;

              $.ajax({
                url:"index.php?r=users-report/report-design-many-sources-pdf",
                method:"GET",
                data:{id:id},
                global: false,
                async:false,
                success: function(msg){
                    $("#show_content_"+id).html(msg);
                }
            });
          });
            // var date_get = [<?=$data_json_string;?>];
            // var data_json = date_get[0];

            // $.ajax({
            //     url:"index.php?r=users-report/report-design-many-sources-pdf",
            //     method:"GET",
            //     data:{id:"<?=$model->id;?>"},
            //     global: false,
            //     async:false,
            //     success: function(msg){
            //         $(".show-data_json").html(msg);
            //     }
            // });


        });
    });
</script>