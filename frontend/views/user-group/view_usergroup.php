<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroup */

$this->title = $model->name.' - '.$model->description;
$this->params['breadcrumbs'][] = ['label' => 'สิทธิ์การเข้าใช้งาน', 'url' => ['user-role/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this); 
?>
<style>
.aant {
    padding: 2;
    margin-right: 6;
    background-color: #e4c50c;
}
.div-scrollbar{
	height: 400px;
	overflow-y: scroll;
	padding: 0em 1em 1em 1em;
	margin-bottom: 1em;
	font-size: 14px !important;
}
.isDisabled {
	pointer-events: none;
	cursor: default;
	text-decoration: none;
}
</style>

<div class="user-group-view">

    <h4>กลุ่มผู้ใช้งาน : <?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body ribbon">


                    <p>
                        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update_usergroup', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('ลบ', ['delete_usergroup', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'ต้องการยกเลิกกลุ่มผู้ใช้นี้ใช่หรือไม่?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p> 
                    <div class="div-scrollbar">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'name',
                                'description',
                                [
                                    'attribute'=>'allow_access_main',
                                    'format'=>'raw',
                                    'value' => function($model, $key)
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
                                    'value' => function($model, $key)
                                    {
                                        if(!empty($model->allow_access_sub) && strlen($model->allow_access_sub)>2)
                                        {
                                            return getList($model->allow_access_sub,'menu_sub','submenu_id','submenu_name');
                                        }
                                    },
                                ],
                            ],
                        ]) ?>
                    </div><br>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body ribbon">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9">
                        <?php 
                        $web = Yii::$app->db->createCommand("SELECT * FROM `users` WHERE user_group = '".$_GET['id']."' ")->queryAll();    
                        ?>
                            <h6>รายชื่อผู้ใช้งานในกลุ่ม : <?= Html::encode($this->title) ?> </h6>
                        </div>
                       
                        <div class="col-xl-3 col-lg-3 col-md-3">
                        <?php 
                        
                        ?>
                            <a  href="index.php?r=users/create_users_group&usergroupid=<?php echo $_GET['id'];?>&usergroupname=<?=$_GET['name'];?>" class="btn btn-success">+ เพิ่มผู้ใช้งานในกลุ่มนี้</a>
                        </div>
                    </div> <hr>
                    <!-- <input type="text" name="search_box" id="search_box" class="form-control click-page-link" placeholder="ค้นหา (ชื่อผู้ใช้งานในกลุ่ม)" /> -->
                        <div class="div-scrollbar">
                            <div class="row">
                            
                            <?php
                                $i = 1 ;
                                foreach ($web as $w) {   
                            ?>
                                <div class="col-xl-4 col-lg-6 col-md-12">
                                    <?php echo $i;?>.<a href="index.php?r=users/view&id=<?php echo $w['id'];?>" class=""> <b><?php echo $w['name'];?></b> </a>
                                </div>

                                <?php $i++; } ?>
                            </div>   
                        </div>

                          <strong>* คลิ๊กที่ชื่อเพื่อดูข้อมูลเพิ่มเติม </strong>
                </div><br>
            </div>
        </div>
    </div>

</div>


                <script>

                  $(document).on('click', '.click-page-link', function(){
                      var page = $(this).data('page_number');
                      var query = $('#search_box').val();
                      load_data(page, query);
                  });

                  $('#search_box').keyup(function(){
                      var query = $('#search_box').val();
                      load_data(1, query);
                  });

                </script>