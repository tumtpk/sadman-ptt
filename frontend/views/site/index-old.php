<?php
use app\models\Setting;
use app\models\FileUploadList;
use frontend\models\MenuMain;
use frontend\models\MenuSub;

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");

//$this->title = 'วันนี้คุณต้องการทำอะไร?';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

/* @var $this yii\web\View */

$this->title = 'TextX';
?>
<div class="row clearfix"> 
  <div class="col-lg-12">
    <div class="mb-4">
      <h4>Welcome # <?=$_SESSION['user_name']?> วันนี้คุณต้องการทำอะไร</h4>
      <!-- <small>หน้าเพจหลักแสดงข้อมูล <a href="#">Learn More</a></small> -->
    </div>                        
  </div>
</div>

<!--<iframe src="http://45.127.62.51:5601/goto/6a0055bfaa2b46aba6bb07ab6c4b3e25" height="1600" width="100%"  style="border:0;"></iframe> 
-->


<style>
  .iconall{
    content: "\e001";
    background-color: #dab90a;
    padding: 16px;
    border: -32;
    border-radius: 50px;
    color: #fff;
    text-align: center !important;
    font-size: 49;
    
  }
  .bbt{
    border-radius: 30px;
    margin-top: 20;
  }
  .top{
    margin-top: 10;
    margin-bottom: 20;
  }
  .ribbon .ribbon-box{
    padding: 8px !important;
  }
</style>

<!-- <button class="button-new">ข้อมูลเพิ่มเติม</button > -->


<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="row clearfix">
                    
                    <!-- start div -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                                    <h4 class="mb-1"><span class="couterfileall">12</span></h4>
                                    <div>เข้าใช้งานวันนี้</div>
                                    <div class="mt-4">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div> 
                    <!-- end div -->
                    <!-- start div -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                                    <h4 class="mb-1"><span class="couterfileall">120</span></h4>
                                    <div>เข้าใช้งานเดือนนี้</div>
                                    <div class="mt-4">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div> 
                    <!-- end div -->
                    <!-- start div -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                                    <h4 class="mb-1"><span class="couterfileall">120</span></h4>
                                    <div>เข้าใช้งานปีนี้</div>
                                    <div class="mt-4">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div> 
                    <!-- end div -->
                    <!-- start div -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                                    <h4 class="mb-1"><span class="couterfileall">120</span></h4>
                                    <div>เข้าใช้งานทั้งหมด</div>
                                    <div class="mt-4">
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div> 
                    <!-- end div -->

                    <!--  -->
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">
                                        <strong>ข้อมูลประจำวัน</strong>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    </div>
                                </div>
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">
                                    <strong>สถิติการเข้าใช้งาน</strong>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                      เข้าใช้งานวันนี้ : xxx ครั้ง <br>
                                      เข้าใช้งานเดือนนี้ : xxx ครั้ง <br>
                                      เข้าใช้งานปีนี้ : xxx ครั้ง <br>

                                      

                                    </div>
                                    <div class="row"><br>
                                    <a href="#user" class="btn btn-secondary"><i class="fa fa-signal"></i></a>
                                    </div>
                                </div>
                        </div>
                    </div> 
                    <!--  -->

                </div>
            </div>
        </div>
    </div>
</div>


 


<div class="row">
<!-- Card -->


<? //=$_SESSION['user_role']?>
 
<?  if($_SESSION['user_role'] == "1"){ // <h1>supper_admin</h1> <br>  ?>
        

<? } ?>
<?  if($_SESSION['user_role'] == "2"){ // <h1>admin</h1><br> ?>
    

<? } ?>    
<?  if($_SESSION['user_role'] == "3"){ // <h1>user_general</h1> ?>
    
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-9"> 
            <h2><b>แบบฟอร์มบันทึกข้อมูล</b></h2>
          </div>
          <div class="col-sm-3">
            <div class="ribbon-box azure text-right top">
              <i class="icon-briefcase iconall"></i> 
            </div>
          </div><hr>
          <div class="col-sm-12 top">    
                <p class="card-text">
                    เลือกแบบฟอร์มด้านขวาเพื่อป้อนข้อมูล
                </p>
                <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
          
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-9"> 
            <h2><b>แบบฟอร์มบันทึกข้อมูล</b></h2>
          </div>
          <div class="col-sm-3">
            <div class="ribbon-box azure text-right top">
              <i class="icon-briefcase iconall"></i> 
            </div>
          </div><hr>
          <div class="col-sm-12 top">
          <p>เลือกแบบฟอร์มด้านขวาเพื่อป้อนข้อมูล</p>
          <?php
        $sql = "SELECT form_id as id, detail FROM `eform` WHERE unit_id = '".$_SESSION['unit_id']."' AND active = '1' GROUP BY form_id ORDER BY detail ASC";
        // }
        
            $eform_template = Yii::$app->db->createCommand($sql)->queryAll();
            ?>
            <?php
            foreach($eform_template as $ef){
              ?>
               <div class="card">
                <div class="card-body">
                  <div class="row">
                  <div class="col-sm-9"> 
                    <h4><b><?=$ef['detail']?></b></h4>
                  </div>
                  <div class="col-sm-3">
                    <div class="">
                    <a href="index.php?r=site/pages&view=eform_information&form_id=<?=$ef['id']?>"><i class="icon-briefcase">ไปยังฟอร์มนี้</i></a> 
                    </div>
                  </div>
                <!-- <li><a href="index.php?r=site/pages&view=eform_information&form_id=<?=$ef['id']?>"><span><?=$ef['detail']?></span></a> -->
                
                    
                  </div>
                </div>
              </div> 
              <? } ?>
            <!-- <a href="#" class="btn btn-primary bbt">Go somewhere</a> -->
          </div>
          
          </div>
        </div>
      </div>


    </div> 
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-9">
              <h2><b>สถิติการเข้าใช้งาน</b></h2>
            </div>
            <div class="col-sm-3">
              <div class="text-right">
                <i class="fa fa-list-ul iconall"></i> 
              </div>
            </div><hr>
            <div class="col-sm-12 top">
                          <div class="row clearfix">          
                            <div class="col-md-4">
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
                               
                            <div class="col-md-4">
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
                                <div class="col-md-4">
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
          <!-- <a href="#" class="btn btn-primary bbt">Go somewhere</a> -->
          
        </div>
      </div>
    </div>
    
  </div>
</div>




<div class="row clearfix">
  <div class="col-lg-4 col-md-12">
    <div class="card google w_social">
      <div id="w_social1" class="carousel slide" data-ride="carousel" data-interval="2000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <i class="fa fa-google-plus fa-2x"></i>
            <p>18th Feb</p>
            <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form WrapTheme</i></div>
          </div>
          <div class="carousel-item">
            <i class="fa fa-google-plus fa-2x"></i>
            <p>28th Mar</p>
            <h4>Now Get <span>50% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form Epic Theme</i></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="card twitter w_social">
      <div id="w_social2" class="carousel vert slide" data-ride="carousel" data-interval="2000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <i class="fa fa-twitter fa-2x"></i>
            <p>23th Feb</p>
            <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form Epic Theme</i></div>
          </div>
          <div class="carousel-item">
            <i class="fa fa-twitter fa-2x"></i>
            <p>25th Jan</p>
            <h4>Now Get <span>50% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form WrapTheme</i></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="card facebook w_social">
      <div id="w_social2" class="carousel vert slide" data-ride="carousel" data-interval="2000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <i class="fa fa-facebook fa-2x"></i>
            <p>20th Jan</p>
            <h4>Now Get <span>50% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form Theme</i></div>
          </div>
          <div class="carousel-item">
            <i class="fa fa-facebook fa-2x"></i>
            <p>23th Feb</p>
            <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
            <div class="mt-20"><i>- post form Theme</i></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<? } ?>




<script>
 $(document).ready(function(){

   var url_users = "index.php?r=site/json_stst_index_user&auth=<?=$auth?>&type=countusers&id=<?= $_GET['id'];?>";

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


