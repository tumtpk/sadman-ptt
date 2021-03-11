<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserRole;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$us = Yii::$app->db->createCommand("SELECT * FROM users WHERE id = '".$_GET['id']."'")->queryOne();
$unit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$model->unit_id."'")->queryOne();

if ($_SESSION['user_role']=='1' && $_SESSION['user_id']!=$model->id) {
    $this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานทั้งหมด', 'url' => ['index']];
    $role = ($model->role=='2') ? 'ผู้ดูแล' : 'ผู้ใช้งาน';
    $this->title = 'ข้อมูล'.$role.' : '.$us['name'];
}else if ($_SESSION['user_role']=='2' && $_SESSION['user_id']!=$model->id){
    $role = ($model->role=='2') ? 'ผู้ดูแล' : 'ผู้ใช้งาน';
    $this->title = 'ข้อมูล'.$role.' : '.$us['name'];
}else{
    $this->title = 'ข้อมูลส่วนตัว';
}

if ($_SESSION['user_role']=='2' && $_SESSION['user_id']!=$model->id){
    $this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานในหน่วยงาน', 'url' => ['index', 'unitid' => $_SESSION['unit_id']]];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
?>
<style>
  .ribbon .ribbon-box{
    padding: 8px !important;
  }
</style>


<div class="users-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="card">
        <div class="card-body ribbon">
            <div class="row clearfix">
                <div class="col-xl-6 col-lg-6 col-md-6">
            
                    

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'name',
                            'username',
                            //'password',
                            // 'auth_key',
                            // 'password_reset_token',
                            [
                                'label'=>'ประเภทผู้ใช้งาน',
                                'attribute'=>'role',
                                'format'=>'raw',    
                                'value' => function($model)
                                {
                                    if(!empty($model->role))
                                    {
                                        $query = UserRole::find()
                                        ->select('id,role')
                                        ->where("id = ".$model->role)->one();
                                        return $query->role;
                                    }
                                },
                            ],
                            [
                                'attribute'=>'unit_id',
                                'format'=>'raw',    
                                'value' => function($model)
                                {
                                    if(!empty($model->unit_id!='000'))
                                    {
                                        $unit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$model->unit_id."'")->queryOne();
                                        return $unit['unit_name'];
                                    }else{
                                        return '<span class="">-</span>';
                                    }
                                },
                            ],
                            [
                                'attribute'=>'user_group',
                                'format'=>'raw',    
                                'value' => function($model)
                                {
                                    if(!empty($model->user_group!=''))
                                    {
                                        $user_group = Yii::$app->db->createCommand("SELECT * FROM user_group WHERE id = '".$model->user_group."'")->queryOne();
                                        return $user_group['name'];
                                    }else{
                                        return '<span class="">-</span>';
                                    }
                                },
                            ],
                            [
                                'format'=>'raw',
                                'attribute'=>'images',
                                'value' => function($model,$index)
                                {
                                    if(!empty($model->images))
                                    {
                                        return Html::img($model->photoViewer,['class'=>'img-thumbnail','style'=>'width:200px;', "onerror"=>"this.onerror=null;this.src='img/none.png';"]);
                                    }else{
                                        return Html::img('@web/img/none.png',['class'=>'img-thumbnail','style'=>'width:200px;']);
                                    }
                                },
                            ],
                            // [
                            //     'format'=>'raw',
                            //     'attribute'=>'status',
                            //     'value'=> $model->status == 1 ? 'enable' : 'disable',
                            // ],
                            [
                                'attribute'=>'status',
                                'label'=>'สิทธิ์การเข้าใช้งานระบบ',
                                'format'=>'raw',
                                'value' => function($model)
                                {

                                    if ($model->status=='1') {
                                        return 'เปิด';
                                    }else{
                                        return 'ปิด';
                                    }

                                    
                                },
                                'visible' => in_array($_SESSION['user_role'], array("1","2")) ? true : false
                            ],
                            'email:email',
                        ],
                    ]) ?>
                <p>
                        <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php if ($model->role=='1' || $model->role=='2' && $_SESSION['user_id']!=$model->id && $model->id!='1'): ?>
                            <?= Html::a('ลบข้อมูลผู้ใช้นี้', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'คุณต้องการยกเลิกผู้ใช้คนนี้ใช่หรือไม่?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </p>    
              
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6">
                <h5 class=""> <b> สถิติการเข้าใช้งานระบบ</b></h5><hr>
                    <div class="row clearfix">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body ribbon">
                                        <div class="ribbon-box azure">
                                            <i class="icon-users"></i> 
                                        </div>
                                        <a href="javascript:void(0);" class="my_sort_cut text-muted">
                                            <div class="m-0 text-center h1 text-azure counter show_user_ues_all">
                                                
                                            </div>
                                            <span class="h6">เข้าใช้งานทั้งหมด</span>
                                        </a>
                                        <div class="d-flex">
                                            <small class="text-muted">ครั้ง</small>
                                            <div class="ml-auto">
                                                <i class="fa fa-caret-up"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body ribbon">
                                        <div class="ribbon-box orange">
                                            <i class="icon-bar-chart"></i>
                                        </div>
                                            <a href="javascript:void(0);" class="my_sort_cut text-muted">
                                                <div class="m-0 text-center h1  counter show_sadmin">
                                                </div>
                                                <span class="h6">เข้าใช้งานในวันนี้</span>
                                            </a>
                                            <div class="d-flex">
                                                <small class="text-muted">ครั้ง</small>
                                                <div class="ml-auto">
                                                    <i class="fa fa-caret-up"></i> 
                                                    <span class="show_per_sadmin"></span>
                                                </div>
                                            </div>
                                     </div>
                                </div>
                            </div>
                               
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body ribbon">
                                        <div class="ribbon-box cyan">
                                            <i class="icon-calendar"></i></div>
                                            <a href="javascript:void(0);" class="my_sort_cut text-muted">
                                                <div class="m-0 text-center h1  text-cyan counter show_admin">
                                                </div>
                                                <span class="h6">เข้าใช้งานในเดือนนี้</span>
                                            </a>
                                            <div class="d-flex">
                                                <small class="text-muted">ครั้ง</small>
                                                <div class="ml-auto">
                                                    <i class="fa fa-caret-up"></i><span class="show_per_admin"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body ribbon">
                                        <div class="ribbon-box danger">
                                            <i class="icon-user"></i></div>
                                            <a href="javascript:void(0);" class="my_sort_cut text-muted">
                                            <div class="m-0 text-center h1 text-danger counter show_user">
                                            </div>

                                            <span class="h6">เข้าใช้งานในปีนี้</span>
                                        </a>
                                        <div class="d-flex">
                                            <small class="text-muted">ครั้ง</small>
                                            <div class="ml-auto">
                                                <i class="fa fa-caret-up"></i>
                                                <span class="show_per_users"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row clearfix row-deck">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">กราฟแสดงสถิติการเข้าใช้งานระบบ(แยกตามเดือน) ประจำปี <?=(date("Y")+543);?></h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="apex-chart-line-column"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                </div>


            </div>
        </div>
    </div>
</div>




<script>


    var url = "index.php?r=site/json_stat_users&auth=<?=$auth?>&type=graphweek&id=<?= $_GET['id'];?>";

    var json = null;
    var json = $.ajax({
     url: url,
     global: false,
     dataType: "json",
     async:false,
     success: function(msg){
      return msg;
  }
}
).responseJSON;

    var showlog_date = [];
    $.each(json, function(index) {
     showlog_date.push(json[index].log_date);    
 });

    var showsum = [];
    $.each(json, function(index) {
     showsum.push(json[index].sum);    
 });

    $(document).ready(function() {
       var options = {
          chart: {
             height: 300,
             type: 'area',
             toolbar: {
                show: false,
            },
        },
        colors: ['#17A2BC'],
        series: [ {
         name: 'จำนวนการเข้าใช้งาน',
         type: 'area',
         data: showsum
     }],
     stroke: {
       width: [4]
   },        
   labels: showlog_date,

}
var chart = new ApexCharts(
   document.querySelector("#apex-chart-line-column"),
   options
   );

chart.render();
});

    
</script>



<script>
 $(document).ready(function(){

   var url_users = "index.php?r=site/json_stat_users&auth=<?=$auth?>&type=countusers&id=<?= $_GET['id'];?>";

   var json_users = null;
   var json_users = $.ajax({
     url: url_users,
     global: false,
     dataType: "json",
     async:false,
     success: function(msg){
      return msg;
  }
}
).responseJSON;
   $(".show_user_ues_all").html(json_users.useAll);
   $(".show_sadmin").html(json_users.useday);
   $(".show_per_sadmin").html(json_users.per_useday);
   $(".show_admin").html(json_users.usemonths);
   $(".show_per_admin").html(json_users.per_usemonths);
   $(".show_user").html(json_users.useyear);
   $(".show_per_users").html(json_users.per_useyear);


   
 });
// });
</script>