<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsersReport */

$this->title = "วันที่บันทึกแก้ไข :".DateThaiTime($model->date_record);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ข้อมูลรายงานส่วนบุคคล'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$data_json_string = @json_encode($model->data_json,TRUE);
?>
<div class="users-report-view">

 <h4><?= Html::encode($this->title) ?></h4>
 <div class="row clearfix">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body ribbon">
                <p>
                    <?= Html::a('พิมพ์รายงาน', ['report-design-many-sources-pdf','id'=> $model->id, 'printnow'=>true], ['class' => 'btn btn-dark btn-sm','target'=>'_blank']) ?>
                    <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'ยกเลิก'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'ต้องการยกเลิกรูปแบบรายงานนี้ใช่หรือไม่?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <dt>รูปแบบรายงานส่วนบุคคล</dt>
                <div class="show-data_json"></div>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [

                        [
                            'attribute'=>'user_create',
                            'format'=>'raw',    
                            'value' => function($model)
                            {
                                if(!empty($model->user_create))
                                {
                                    $user_create = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$model->user_create."'")->queryOne();
                                    return $user_create['name'];
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

<script type="text/javascript">
    jQuery(function ($) {
        $(document).ready(function(){

            var date_get = [<?=$data_json_string;?>];
            var data_json = date_get[0];

            $.ajax({
                url:"index.php?r=users-report/report-design-many-sources-pdf",
                method:"GET",
                data:{id:"<?=$model->id;?>"},
                global: false,
                async:false,
                success: function(msg){
                    $(".show-data_json").html(msg);
                }
            });


        });
    });
</script>