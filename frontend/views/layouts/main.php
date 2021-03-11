<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "1fc41a7e-c22d-4c94-9359-dcda7892d553",
    });
  });
  var zoom = 1;
  var width = 100;

  function bigger() {
    zoom = zoom + 0.1;
    width = 100 / zoom;
    document.body.style.transformOrigin = "left top";
    document.body.style.transform = "scale(" + zoom + ")";
    document.body.style.width = width + "%";
  }
  function smaller() {
    zoom = zoom - 0.1;
    width = 100 / zoom;
    document.body.style.transformOrigin = "left top";
    document.body.style.transform = "scale(" + zoom + ")";
    document.body.style.width = width + "%";
  }

</script>
<?php
if(!isset($_SESSION)) 
{ 
  session_start(); 
}
/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use app\models\EformTemplate;
use app\models\Eform;
use app\models\Users;
use app\models\Unit;
use app\models\Setting;

AppAsset::register($this);

if (empty($_SESSION['user_id'])) {
  echo "<script>window.location='index.php?r=site/logout_clear'</script>";
}

// Start :: User Website Usaged
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
$active_url = str_replace("http://45.127.62.51:7000/textx/frontend/web/","",$actual_link);
$users_now = Users::find()->where("id = '".$_SESSION['user_id']."'")->one();
$unit_now = Unit::find()->where("unit_id = '".$users_now['unit_id']."'")->one();
$ip = $_SERVER['REMOTE_ADDR']; 
$log_date = date("Y-m-d H:i:s");
$command = Yii::$app->db->createCommand("INSERT INTO `user_website_usaged`(`user_id`, `user_name`, `unit_id`, `unit_name`, `url_website`, `create_date`,`ip_address`) VALUES ('".$users_now['id']."','".$users_now['name']."','".$unit_now['unit_id']."','".$unit_now['unit_name']."','".$active_url."','".$log_date."','".$ip."')")->execute();
// Stop :: User Website Usaged

$sql_user_role = ($_SESSION['user_role']!='3') ? "SELECT * FROM `user_role` WHERE id = '".$_SESSION['user_role']."'" : "SELECT * FROM `user_group` WHERE id = '".$_SESSION['user_group']."'";
$menu = Yii::$app->db->createCommand($sql_user_role)->queryOne();
$menu_main_role = str_replace('[', '', $menu['allow_access_main']);
$menu_main_role = str_replace(']', '', $menu_main_role);
$menu_main_role = str_replace('"', '\'', $menu_main_role);

if (!empty($menu_main_role)) {
  $where_main_id = "AND id IN (".$menu_main_role.")";

}else{
  $where_main_id = "";
}
$_SESSION['where_main_id'] =  $menu_main_role;

$menu_sub_role = str_replace('[', '', $menu['allow_access_sub']);
$menu_sub_role = str_replace(']', '', $menu_sub_role);
$menu_sub_role = str_replace('"', '\'', $menu_sub_role);

if (!empty($menu_sub_role)) {
  $where_sub_id = "AND submenu_id IN (".$menu_sub_role.")";
}else{
  $where_sub_id = "";
}

$ALL_URL = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$PHP_SELF = explode("/", $ALL_URL);
$rr = array_slice($PHP_SELF,4);
$r_url = implode("/",$rr);

$check_isn_database_main = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `menu_main` WHERE m_link = '".$r_url."' AND m_status = 'Y'")->queryScalar();

$check_isn_database_sub = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `menu_sub` WHERE submenu_link = '".$r_url."' AND submenu_active = 'Y'")->queryScalar();

$check_isn_database = $check_isn_database_sub + $check_isn_database_main;

if ($check_isn_database>0) {
  if (!empty($where_main_id)) {
    $check_url_main = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_link != '' AND m_status = 'Y' $where_main_id")->queryAll();

    $check_main_count = 0;
    foreach ($check_url_main as $url_main) {
      if (strstr( $ALL_URL, $url_main['m_link'] ) ) {
        $check_main_count = $check_main_count + 1;
      } else {
        $check_main_count = $check_main_count + 0;
      }
    }
  }else{
    $check_main_count = 0;
  }


  if (!empty($where_sub_id)) {
    $check_url_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' $where_sub_id")->queryAll();
    $check_sub_count = 0;
    foreach ($check_url_sub as $url_sub) {
      if (strstr( $ALL_URL, $url_sub['submenu_link'] ) ) {
        $check_sub_count = $check_sub_count + 1;
      } else {
        $check_sub_count = $check_sub_count + 0;
      }
    }
  }else{
    $check_sub_count = 0;
  }

  $check_all_count =  $check_main_count+$check_sub_count;


  if ($check_all_count==0) {
    echo "<script>window.location='index.php?r=site/pages&view=alert_permission'</script>";
  }

}


$user_font_size = Yii::$app->db->createCommand("SELECT font_size FROM `users` WHERE id = '".$_SESSION['user_id']."'")->queryone();
?>

<style>
  .btn1 {
    width: 40%;
    font-size: 10px !important;
  }
  .custom-file-upload:hover {
    border: 1px solid #034660 !important;
    background: #034660 !important;
    color: #ffffff;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
  }
  .textx-logo-box{
    background-color: #ffffff;
    width: 100%;
    padding-top: 7px;
    padding-bottom: 7px;
    border-radius: 3px;
    text-align: center;
  }
  .textx-logo{
    width: auto;
    height: 30px;
  }
  .btn-resize-disable-plus{
    pointer-events: none;
  }
  .btn-resize-disable-minus{
    pointer-events: none;
  }
</style>

<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>" dir="ltr">
<head>

  <meta charset="<?= Yii::$app->charset; ?>">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="../../images/favicon_io/favicon.ico" type="image/x-icon"/>
  <?php $this->registerCsrfMetaTags();?>
  <title><?= Html::encode($this->title);?></title>
  <?php $this->head();?>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
  <!-- Bootstrap Core and vandor -->
  <link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
  <link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../html-version/assets/plugins/multi-select/css/multi-select.css">
  <!-- Plugins css -->
  <link rel="stylesheet" href="../../html-version/assets/plugins/charts-c3/c3.min.css"/>
  <link rel="stylesheet" href="../../html-version/assets/plugins/dropify/css/dropify.min.css">
  <link rel="stylesheet" href="../../html-version/assets/plugins/summernote/dist/summernote.css"/>
  <!-- Core css -->
  <link rel="stylesheet" href="../../html-version/assets/css/main.css"/>
  <link rel="stylesheet" href="../../html-version/assets/css/theme1.css"/>
  <!-- style by pd -->
  <link rel="stylesheet" href="../../html-version/assets/css/style.css"/>

  <script type="text/javascript" src="../../js/jquery-3.5.1.min.js"></script>

</head>
<body class="font-montserrat sidebar_dark">
  <?php $this->beginBody() ?>


  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
    </div>
  </div>

  <div id="main_content">
    <div id="header_top" class="header_top">
      <div class="container">
        <div class="hleft">
          <a class="header-brand" href="index.php"><i class="fe fe-home brand-logo"></i></a>
          <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa  fa-align-left"></i></a>
          <div class="dropdown">
            <a title="ค้นหา" href="index.php?r=site/search" class="nav-link icon"><i  class="fa fa-search"></i></a>                    
            <!-- <a title="จัดการไฟล์" href="index.php?r=site/pages&view=file-manager-all"  class="nav-link icon app_file xs-hide"><i class="fa fa-folder-o"></i></a> 
            <a title="network link" href="index.php?r=site/pages&view=graph"  class="nav-link icon xs-hide"><i class="fa fa-connectdevelop"></i></a> -->
            <a title="ตั้งค่า" href="index.php?r=setting"  class="nav-link icon xs-hide"><i class="fa fa-cog"></i></a>
            <a title="ออกจากระบบ" href="index.php?r=site/logout_clear"  class="nav-link icon xs-hide"><i class="fa fa-power-off"></i></a>

          </div>
        </div>
        <div class="hright">
          <div class="dropdown">

           <a href="javascript:void(0)" class="nav-link user_btn showuser_data">
            <img class="avatar" src="../../frontend/web/uploads/<?php echo $users_now['images']; ?>" alt="" data-toggle="tooltip" data-placement="right" 
            title="<?= \Yii::$app->user->identity->username ?> "/>
          </a>
          <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa  fa-align-left"></i></a>
        </div>            
      </div>
    </div>
  </div>

  <div id="rightsidebar" class="right_sidebar">
    <a href="javascript:void(0)" class="p-3 settingbar float-right"><i class="fa fa-close"></i></a>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Settings" aria-expanded="true">Settings</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#activity" aria-expanded="false">Activity</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane vivify fadeIn active" id="Settings" aria-expanded="true">
        <div class="mb-4">
         <h6 class="font-14 font-weight-bold text-muted">Font Style</h6>
         <div class="custom-controls-stacked font_setting">
          <label class="custom-control custom-radio custom-control-inline">
           <input type="radio" class="custom-control-input" name="font" value="font-opensans">
           <span class="custom-control-label">Open Sans Font</span>
         </label>
         <label class="custom-control custom-radio custom-control-inline">
           <input type="radio" class="custom-control-input" name="font" value="font-montserrat" checked="">
           <span class="custom-control-label">Montserrat Google Font</span>
         </label>
         <label class="custom-control custom-radio custom-control-inline">
           <input type="radio" class="custom-control-input" name="font" value="font-roboto">
           <span class="custom-control-label">Robot Google Font</span>
         </label>
       </div>
     </div>
     <div class="mb-4">
       <h6 class="font-14 font-weight-bold text-muted">Dropdown Menu Icon</h6>
       <div class="custom-controls-stacked arrow_option">
        <label class="custom-control custom-radio custom-control-inline">
         <input type="radio" class="custom-control-input" name="marrow" value="arrow-a">
         <span class="custom-control-label">A</span>
       </label>
       <label class="custom-control custom-radio custom-control-inline">
         <input type="radio" class="custom-control-input" name="marrow" value="arrow-b">
         <span class="custom-control-label">B</span>
       </label>
       <label class="custom-control custom-radio custom-control-inline">
         <input type="radio" class="custom-control-input" name="marrow" value="arrow-c" checked="">
         <span class="custom-control-label">C</span>
       </label>
     </div>
     <h6 class="font-14 font-weight-bold mt-4 text-muted">SubMenu List Icon</h6>
     <div class="custom-controls-stacked list_option">
      <label class="custom-control custom-radio custom-control-inline">
       <input type="radio" class="custom-control-input" name="listicon" value="list-a" checked="">
       <span class="custom-control-label">A</span>
     </label>
     <label class="custom-control custom-radio custom-control-inline">
       <input type="radio" class="custom-control-input" name="listicon" value="list-b">
       <span class="custom-control-label">B</span>
     </label>
     <label class="custom-control custom-radio custom-control-inline">
       <input type="radio" class="custom-control-input" name="listicon" value="list-c">
       <span class="custom-control-label">C</span>
     </label>
   </div>
 </div>
 <div>
   <h6 class="font-14 font-weight-bold mt-4 text-muted">General Settings</h6>
   <ul class="setting-list list-unstyled mt-1 setting_switch">
    <li>
     <label class="custom-switch">
      <span class="custom-switch-description">Night Mode</span>
      <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-darkmode">
      <span class="custom-switch-indicator"></span>
    </label>
  </li>
  <li>
   <label class="custom-switch">
    <span class="custom-switch-description">Fix Navbar top</span>
    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-fixnavbar">
    <span class="custom-switch-indicator"></span>
  </label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Header Dark</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-pageheader">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Min Sidebar Dark</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-min_sidebar">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Sidebar Dark</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-sidebar" checked="">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Icon Color</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-iconcolor">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Gradient Color</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-gradient">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Box Shadow</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-boxshadow">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">RTL Support</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-rtl">
  <span class="custom-switch-indicator"></span>
</label>
</li>
<li>
 <label class="custom-switch">
  <span class="custom-switch-description">Box Layout</span>
  <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-boxlayout">
  <span class="custom-switch-indicator"></span>
</label>
</li>
</ul>
</div>
<hr>
<div class="form-group">
	<label class="d-block">Storage <span class="float-right">77%</span></label>
	<div class="progress progress-sm">
		<div class="progress-bar" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;"></div>
	</div>
	<button type="button" class="btn btn-primary btn-block mt-3">Upgrade Storage</button>
</div>
</div>
<div role="tabpanel" class="tab-pane vivify fadeIn" id="activity" aria-expanded="false">
  <ul class="new_timeline mt-3">
   <li>
    <div class="bullet pink"></div>
    <div class="time">11:00am</div>
    <div class="desc">
     <h3>Attendance</h3>
     <h4>Computer Class</h4>
   </div>
 </li>
 <li>
  <div class="bullet pink"></div>
  <div class="time">11:30am</div>
  <div class="desc">
   <h3>Added an interest</h3>
   <h4>“Volunteer Activities”</h4>
 </div>
</li>
<li>
  <div class="bullet green"></div>
  <div class="time">12:00pm</div>
  <div class="desc">
   <h3>Developer Team</h3>
   <h4>Hangouts</h4>
   <ul class="list-unstyled team-info margin-0 p-t-5">                                            
    <li><img src="../../html-version/assets/images/xs/avatar1.jpg" alt="Avatar"></li>
    <li><img src="../../html-version/assets/images/xs/avatar2.jpg" alt="Avatar"></li>
    <li><img src="../../html-version/assets/images/xs/avatar3.jpg" alt="Avatar"></li>
    <li><img src="../../html-version/assets/images/xs/avatar4.jpg" alt="Avatar"></li>                                            
  </ul>
</div>
</li>
<li>
  <div class="bullet green"></div>
  <div class="time">2:00pm</div>
  <div class="desc">
   <h3>Responded to need</h3>
   <a href="javascript:void(0)">“In-Kind Opportunity”</a>
 </div>
</li>
<li>
  <div class="bullet orange"></div>
  <div class="time">1:30pm</div>
  <div class="desc">
   <h3>Lunch Break</h3>
 </div>
</li>
<li>
  <div class="bullet green"></div>
  <div class="time">2:38pm</div>
  <div class="desc">
   <h3>Finish</h3>
   <h4>Go to Home</h4>
 </div>
</li>
</ul>
</div>
</div>
</div>

<div class="theme_div">
  <div class="card">
    <div class="card-body">
      <ul class="list-group list-unstyled">
       <li class="list-group-item mb-2">
        <p>Default Theme</p>
        <a href="../main/index.html"><img src="../../html-version/assets/images/themes/default.png" class="img-fluid" /></a>
      </li>
      <li class="list-group-item mb-2">
        <p>Night Mode Theme</p>
        <a href="../dark/index.html"><img src="../../html-version/assets/images/themes/dark.png" class="img-fluid" /></a>
      </li>                    
      <li class="list-group-item mb-2">
        <p>RTL Version</p>
        <a href="../rtl/index.html"><img src="../../html-version/assets/images/themes/rtl.png" class="img-fluid" /></a>
      </li>
      <li class="list-group-item mb-2">
        <p>Theme Version2</p>
        <a href="../theme2/index.html"><img src="../../html-version/assets/images/themes/theme2.png" class="img-fluid" /></a>
      </li>
      <li class="list-group-item mb-2">
        <p>Theme Version3</p>
        <a href="../theme3/index.html"><img src="../../html-version/assets/images/themes/theme3.png" class="img-fluid" /></a>
      </li>
      <li class="list-group-item mb-2">
        <p>Theme Version4</p>
        <a href="../theme4/index.html"><img src="../../html-version/assets/images/themes/theme4.png" class="img-fluid" /></a>
      </li>
      <li class="list-group-item mb-2">
        <p>Horizontal Version</p>
        <a href="../horizontal/index.html"><img src="../../html-version/assets/images/themes/horizontal.png" class="img-fluid" /></a>
      </li>
    </ul>
  </div>
</div>
</div>



<div class="user_div">
  <h5 class="brand-name mb-4">Text X<a href="javascript:void(0)" class="user_btn"><i class="icon-logout"></i></a></h5>
  <div class="card">
    <div class="card-body">
      <div class="media">
       <img class="avatar avatar-xl mr-3" src="../../frontend/web/uploads/<?php echo $users_now['images']; ?>" alt="avatar">
       <div class="media-body">
        <h5 class="m-0"><?php echo $users_now['name'];?></h5>

        <p class="text-muted mb-0"><?php echo $unit_name = ($unit_now['unit_id']=='') ? 'Super Admin' : $unit_now['unit_name'];?></p>
        <p class="text-muted mb-0" style="font-size: 9px;"><i class="fa fa-envelope-o"></i>_<?php echo $users_now['email']; ?></p>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">ข้อมูลส่วนตัว</h3>
    <div class="card-options">
      <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
      <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
    </div>
  </div>
  <div class="card-body">
    <div class="text-center">
      <div class="row">
        <div class="col-12 pb-3">
          <label class="mb-0">ประวัติการเข้าใช้งาน</label>
          <h4 class="font-30 font-weight-bold show_users1"> </h4>
        </div>
      </div>
    </div>

    <hr><h3 class="card-title"><B>เว็บไซต์ที่เข้าใช้งานล่าสุด</B></h3>
    <div class="show_users">
    </div>
    <script>
      $(document).on('click', '.showuser_data', function(){

        $.ajax({
          url:"index.php?r=site/checkuser_users&type=2",
          method:"GET",
          dataType:"json",
          contentType: "application/json; charset=utf-8",
          success:function(data)
          {

           $(".show_users1").html(data.sum);
         }

       });

        var show_users = [];
        $.ajax({
          url:"index.php?r=site/checkuser_users&type=1",
          method:"GET",
          dataType:"json",
          contentType: "application/json; charset=utf-8",
          success:function(data)
          {
           $.each(data, function(index) {
            show_users.push(`
             <div class="form-group">
             <label class="d-block" style="font-size: 14px;" >${data[index].url_website}<span class="float-right"></span></label>
             <label ><span class="float-right d-block" style="font-size: 10px;" >${data[index].create_date}</span></label>
             <div class="progress progress-xs">
             <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 100%;height: 1px;"></div>
             </div>
             </div>

             `);
          });
           $(".show_users").html(show_users.join(""));
         }

       });


      });
    </script>


  </div>
</div>
<a href="index.php?r=users/view&id=<?php echo $_SESSION['user_id'];?>" for="users-images" class="btn btn-success float-right btn1"> แสดงข้อมูลเพิ่มเติม</a>
</div>

<!-- sidebar -->
<div id="left-sidebar" class="sidebar ">
  <div class="textx-logo-box">
    <!-- <img src="../../images/TextX_Logo.png" class="textx-logo"> -->  
    PTT
  </div>
  <nav id="left-sidebar-nav" class="sidebar-nav">
    <ul class="metismenu">

      <?php if ($_SESSION['user_role']=='3'): ?>
        <!-- from 1 -->
        <li><a href=""><i class="fab fa-wpforms"></i><span>แบบฟอร์ม</span></a>
          <ul aria-expanded="true" class="collapse in">
            <?php
            $eform = Yii::$app->db->createCommand("SELECT * FROM `eform_template` WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0' ORDER BY detail ASC")->queryAll();
            foreach($eform as $ef){
              ?>
              <!-- from 2 -->
              <li><a href="index.php?r=eform-data/index&form_id=<?=$ef['id']?>"><span><?=$ef['detail']?></span></a>
              <? } ?>
            </ul>
          </li>
        <?php endif ?>

        <?php if (in_array($_SESSION['user_role'], array("2","3"))): ?>

          <?php
          $sql = "SELECT form_id as id, detail FROM `eform` WHERE unit_id = '".$_SESSION['unit_id']."' AND active = '1' GROUP BY form_id ORDER BY detail ASC";

          $eform_template = Yii::$app->db->createCommand($sql)->queryAll();
          ?>
          <?php
          foreach($eform_template as $ef){
            ?>
          <? } ?>
        <?php endif ?>


        <?php if(!empty($menu_main_role)):
          $mainmenusql = "SELECT * FROM `menu_main` WHERE m_status = 'Y' $where_main_id ORDER BY m_sort ASC";
          $array_menu_main = Yii::$app->db->createCommand($mainmenusql)->queryAll();
          foreach ($array_menu_main as $val_menu_main):
            if ($val_menu_main['m_active']=='1') {
              $class_active = 'active';
            }else{
              $class_active = '';
            }

            ?>

            <?php if($val_menu_main['m_link']!='' || strlen($val_menu_main['m_link'])>1): ?>
  
              <li><a href="<?=$val_menu_main['m_link']?>"><i class="<?=$val_menu_main['m_icon'];?>"></i><span><?=$val_menu_main['m_name'];?></span></a></li>
              <?php else: ?>

                <?php if ($val_menu_main['m_type']!='left_side'): ?>
    
                  <li><a href="index.php?r=site/pages&view=menu-center&mainid=<?=$val_menu_main['id'];?>"><i class="<?=$val_menu_main['m_icon'];?>"></i><span><?=$val_menu_main['m_name'];?></span></a></li>
                  <?php else: ?>


                   <?php if($val_menu_main['id']=='1'): ?>
                   <?php endif; ?>
                   <?php
                   $server = $_SERVER['REQUEST_URI'];
                   $server = str_replace("/textx/frontend/web/",'',$server);
                   $activeMenu = Yii::$app->db->createCommand("SELECT * FROM `menu_sub`,`menu_main` WHERE menu_sub.menu_id = menu_main.id AND menu_sub.submenu_link = '".$server."'")->queryOne();

                   if ($server == $activeMenu['submenu_link']) {
                    $act = "active";
                  }
                  ?>
                  <li class="<?php if($val_menu_main['id'] == $activeMenu['id']){echo 'active'; }else { echo ''; } ?>">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="<?=$val_menu_main['m_icon'];?>"></i><span><?=$val_menu_main['m_name'];?></span></a>
                    <ul aria-expanded="true" class="collapse in">
                     <?php  $array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' $where_sub_id AND menu_id = '".$val_menu_main['id']."' ORDER BY submenu_sort ASC")->queryAll();
                     foreach ($array_menu_sub as $val_menu_sub){
                      ?>  
                      <li class="<?php if($val_menu_sub['submenu_id'] == $activeMenu['submenu_id']){echo 'active-sub'; }else { echo ''; } ?>">
                       <a href="<?=$val_menu_sub['submenu_link'];?>">
                        <span><?=$val_menu_sub['submenu_name'];?></span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php endif ?>
          <?php endif; ?>

        <?php endforeach; ?>
      <?php endif; ?>

    </ul>
  </nav>        
</div>

<?php 
$unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$_SESSION['unit_id']."'")->queryOne();
$unit_name = (!empty($unit['unit_name'])) ? '(<strong>หน่วย'.$unit['unit_name'].'</strong>)' : '';
$usergroup = Yii::$app->db->createCommand("SELECT * FROM `user_group` WHERE id = '".$_SESSION['user_group']."'")->queryOne();
$user_group = (!empty($usergroup['name'])) ? 'กลุ่มผู้ใช้ : '.$usergroup['name'].'' : '';
?>


<div class="page">
  <div id="page_top" class="section-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="left">
          <h3 class="page-title">


           <?php $unit_name_user_group = (!empty($unit_name)) ? "หน่วยงาน :".$unit_name." ".$user_group : ""; ?>
           [ ผู้ใช้ : <?= \Yii::$app->user->identity->username ?> <?=$unit_name_user_group;?>]

         </h3>      
       </div>
       <div class="right">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <div class="btn-group btn-group-sm" role="group">
              <button class="btn btn-default" id="resize-font-orig">A</button>
              <button class="btn btn-default" id="resize-font-plus">A+</button>
            </div>

          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">นำเข้าข้อมูล</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">แบบฟอร์ม</a>                                    
              <a class="dropdown-item" href="#">อัพโหลดไฟล์</a>
              <a class="dropdown-item" href="#">พูดเพื่อป้อนข้อมูล</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ช่วยเหลือ</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">คู่มือ</a>                                    
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">คำถามที่พบบ่อย</a>
              <a class="dropdown-item" href="#">ติดต่อผู้ดูแลระบบ</a>
            </div>
          </li>

        </ul>
        <div class="notification d-flex">
          <div class="dropdown d-flex">
            <a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1 showuser_online" data-toggle="dropdown"><i class="fa fa-users" data-toggle="tooltip" data-placement="bottom" title="<?php include 'CheckUserOnline.php';?>"></i><span class="badge badge-success nav-unread" style="background-color: #21ba45 !important;"></span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <ul class="right_chat list-unstyled w250 p-0 show_useronline" style="height:350px; overflow: auto;">
              </ul>

            </div>
          </div>

          <script>
            $(document).on('click', '.showuser_online', function(){
              var show_useronline = [];
              $.ajax({
                url:"index.php?r=site/checkuser_online",
                method:"GET",
                dataType:"json",
                contentType: "application/json; charset=utf-8",
                success:function(data)
                {
                 if (data.length>0) {
                  $.each(data, function(index) {
                   var type_user = '';
                   if (data[index].role=='1') {
                    type_user = 'offline';
                  }else{
                    type_user = 'online';
                  }

                  show_useronline.push(`
                    <li class="${type_user}">
                    <a href="javascript:void(0);">
                    <div class="media">
                    <img class="media-object" src="../../frontend/web/uploads/${data[index].images}" alt="" style="object-fit: cover;">
                    <div class="media-body">
                    <span class="name">${data[index].name}</span>
                    <span class="message">${data[index].unit_name} , ${data[index].unit_group}</span>
                    <span class="badge badge-outline status"></span>
                    </div>
                    </div>
                    </a>
                    </li>
                    `);
                });
                  $(".show_useronline").html(show_useronline.join(""));

                }else{

                }
              }
            });
            });
          </script>
          
          <div class="dropdown d-flex">
            <a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-primary nav-unread changebadge"></span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <ul class="list-unstyled feeds_widget">
                <li>
                 <div class="feeds-left"><i class="fa fa-check"></i></div>
                 <div class="feeds-body">
                  <a href="#">
                    <h4 class="title text-danger">ข่าวแจ้งเตือน <small class="float-right text-muted">11:05</small></h4>
                  </a>    
                </div>
              </li>
              <?php if ($_SESSION['user_group']=='1'): ?>
                <li class="check_countdatanotapprove">
                 <div class="feeds-left"><i class="fe fe-alert-circle"></i></div>
                 <div class="feeds-body">
                  <a href="index.php?r=site/pages&view=dashboard-approve">
                    <h4 class="title text-danger" style="color: #e89300 !important;">ข้อมูลรออนุมัติ</h4>
                  </a>    
                </div>
              </li>
            <?php endif; ?>
            <?php if ($_SESSION['user_role']=='3'): ?>
              <li class="check_request_information" data-toggle="modal" data-target="#show_request_information" style="cursor: pointer;">
                <div class="feeds-left"><i class="fa fa-question-circle-o"></i></div>
                <div class="feeds-body">
                  <h4 class="title text-danger" style="color: #dc3545!important"><b>ต้องการข้อมูลเพิ่มเติม</b></h4>
                </div>
              </li>
            <?php endif ?>
            <?php if ($_SESSION['user_role']=='3'): ?>
              <li class="check_news_procees" data-toggle="modal" data-target="#show_check_news_procees" style="cursor: pointer;">
               <div class="feeds-left"><i class="fa fa-newspaper-o"></i></div>
               <div class="feeds-body">
                <h4 class="title" style="color: #FF6A70 !important;"> แจ้งเตือนข่าวดำเนินวิธีการ
                </div>
              </li>
            <?php endif ?>

          </ul>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0)" class="dropdown-item text-center text-muted-dark readall">Mark all as read</a>
        </div>
      </div>

      <div class="modal" id="show_request_information">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"><dt>ข้อมูลที่ต้องการเพิ่มเติม</dt></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body show_data_request_information">
            </div>

          </div>
        </div>
      </div>

      <div class="modal" id="show_check_news_procees">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title"><dt>แจ้งเตือนข้อมูลดำเนินวิธีการ</dt></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body showPushNews">
            </div>

          </div>
        </div>
      </div>
      <?php 
      $token = "asdasdqe2ewsdtRFDWRQKFLmf36ddasdasdasdas";
      $auth = "Authenticator=>".$token."".date("Ymd");
      ?>
      <script>
        $(document).ready(function(){
          var showPushNews = [];
          $.ajax({
            url:"index.php?r=site/json_check_news_process&auth=<?=$auth;?>",
            method:"GET",
            dataType:"json",
            contentType: "application/json; charset=utf-8",
            success:function(data)
            {
             if (data.length>0) {
               $('.check_request_information').css('display', 'flex');
               $('.changebadge').removeClass('badge-primary');
               $('.changebadge').addClass('badge-danger');
             }else{
              $('.check_request_information').css('display', 'none');
              $('.changebadge').addClass('badge-primary');
              $('.changebadge').removeClass('badge-danger');
            }
            if (data.length>0) {
              $.each(data, function(i) {
               showPushNews.push(`<li class="list-group-item" style="font-weight:100 !important;">
                <a href="index.php?r=eform-data/view-process&id=${data[i].id}">${data[i].name}</a>
                </li>`);
             });
              //console.log(showPushNews);
              $(".showPushNews").html('<ul class="list-group">'+showPushNews.join("")+'</ul>');
            }
          }
        });
        });
      </script>

      <script>
        $(document).ready(function(){
          $('.check_request_information').css('display', 'none');
          $('.check_countdatanotapprove').css('display', 'none');
          var show_alert_eform = [];
          var alert_eform_total = 0;
          $.ajax({
            url:"index.php?r=site/json_check_request_information_eformdata&userid=<?=$_SESSION['user_id']?>&type=checkdata&auth=Authenticator=%3Easdasdqe2ewsdtRFDWRQKFLmf36ddasdasdasdas<?=date('Ymd');?>",
            method:"GET",
            dataType:"json",
            contentType: "application/json; charset=utf-8",
            success:function(data)
            {
            // console.log(data.length);
            if (data.length>0) {
             $('.check_request_information').css('display', 'flex');
             $('.changebadge').removeClass('badge-primary');
             $('.changebadge').addClass('badge-danger');
           }else{
            $('.check_request_information').css('display', 'none');
            $('.changebadge').addClass('badge-primary');
            $('.changebadge').removeClass('badge-danger');
          }
        }
      });

          <?php if ($_SESSION['user_group']=='1'): ?>
            $.ajax({
              url:"index.php?r=site/json_dashboard_approve&auth=Authenticator=%3E2ffa459adcc37176dbf93a82addf61dc<?=date('Ymd');?>&type=countdatanotapprove",
              method:"GET",
              dataType:"json",
              contentType: "application/json; charset=utf-8",
              success:function(data)
              {
                console.log(data.coutertype);
                if (data.coutertype>0) {
                 $('.check_countdatanotapprove').css('display', 'flex');
                 $('.changebadge').removeClass('badge-primary');
                 $('.changebadge').addClass('badge-danger');
               }else{
                $('.check_countdatanotapprove').css('display', 'none');
                $('.changebadge').addClass('badge-primary');
                $('.changebadge').removeClass('badge-danger');
              }
            }
          });
          <?php endif; ?>

          $(document).on('click', '.check_request_information', function(){
            var show_data_request_information = [];
            $.ajax({
              url:"index.php?r=site/json_check_request_information_eformdata&userid=<?=$_SESSION['user_id']?>&type=checkdata&auth=Authenticator=%3Easdasdqe2ewsdtRFDWRQKFLmf36ddasdasdasdas<?=date('Ymd');?>",
              method:"GET",
              dataType:"json",
              contentType: "application/json; charset=utf-8",
              success:function(data)
              {
                if (data.length>0) {
                  $.each(data, function(i) {
                    show_data_request_information.push(`<li class="list-group-item" style="font-weight:100 !important;">
                      <div style="position:absolute;right: 10;top:10;">
                      <a class="btn btn-warning btn-sm" href="index.php?r=site/pages&view=eform_information&eform_data=${data[i].id}"><i class="fas fa-pencil-alt"></i> แก้ไข</a></div>

                      <b style="position:absolute;left: 10;top:10;">${data[i].data_type}</b>
                      <div style="margin-top: 2rem!important;">
                      - ${data[i].request_information} <br><span class="badge badge-dark">ผู้บันทึก</span> ${data[i].user_request} (${data[i].unit_name}) / ${data[i].date_time_request}<br></div>
                      </li>
                      `);
                  });

                  $(".show_data_request_information").html('<ul class="list-group">'+show_data_request_information.join("")+'</ul>');
                }else{
                  $(".show_data_request_information").html('');
                }     
              }
            });

          });
        });
      </script>

      <div class="dropdown d-flex">
        <a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-user"></i></a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
          <a class="dropdown-item" href="index.php?r=users/update&id=<?php echo $_SESSION['user_id'];?>
          "><i class="dropdown-icon fe fe-user"></i> ข้อมูลส่วนตัว</a>
          <a class="dropdown-item" href="index.php?r=users/change_password&id=<?php echo $_SESSION['user_id'];?>"><i class="dropdown-icon fe fe-unlock"></i> เปลี่ยนรหัสผ่าน</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="index.php?r=user-role"><i class="dropdown-icon fe fe-sliders"></i> จัดการสิทธิ์การเข้าใช้งาน</a>
          <?php if ($_SESSION['user_role']=='2'): ?>
            <a class="dropdown-item" href="index.php?r=site/pages&view=stat_users_department"><i class="dropdown-icon fe fe-server"></i> สถิตการเข้าใช้งานหน่วยงาน</a>
          <?php endif ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:void(0)"><span class="float-right"><span class="badge badge-primary">6</span></span><i class="dropdown-icon fe fe-mail"></i> Inbox</a>
          <a class="dropdown-item" href="index.php?r=site/pages&view=questionAndAnswer"><i class="dropdown-icon fe fe-file"></i> Q&A</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-help-circle"></i> ต้องการความช่วยเหลือ?</a>
          <a class="dropdown-item" href="index.php?r=site/logout_clear"><i class="dropdown-icon fe fe-log-out"></i> Sign out</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div class="section-body">
  <div class="">
    <?= Breadcrumbs::widget([
      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div id="resize-font">
      <?= $content ?>
    </div>
  </div>
</div>    
<div class="section-body">
  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-sm-12 text-md-right">
          <ul class="list-inline mb-0">
           <li class="list-inline-item"><a href="../doc/index.html">Documentation</a></li>
           <li class="list-inline-item"><a href="javascript:void(0)">FAQ</a></li>
         </ul>
       </div>
     </div>
   </div>
 </footer>
</div>
</div>    
</div>

<script type="text/javascript">
  $(document).on('click', '.goDoSomething', function(){
    var dataId = $(this).data("id-desc");
    var id = $(this).data("id-desc");

    $.ajax({
      url:"index.php?r=site/desc-model",
      method:"POST",
      data: {id: id},
      "dataType": "json",
      success:function(data)
      {
        $(".desc-model-title").html(data.topic);
        $(".desc-model-detail").html(data.description);
      }
    });

  });
</script>

<div class="modal fade bd-modal-manual" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title desc-model-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body desc-model-detail">
      </div>
    </div>
  </div>
</div>

<script src="../../html-version/assets/bundles/lib.vendor.bundle.js"></script>
<script src="../../html-version/assets/bundles/apexcharts.bundle.js"></script>
<script src="../../html-version/assets/bundles/echarts.bundle.js"></script>
<script src="../../html-version/assets/bundles/counterup.bundle.js"></script>
<script src="../../html-version/assets/bundles/knobjs.bundle.js"></script>
<script src="../../html-version/assets/bundles/c3.bundle.js"></script>

<script src="../../html-version/assets/js/core.js"></script>
<script src="../../html-version/assets/plugins/dropify/js/dropify.min.js"></script>
<script src="../../html-version/main/assets/js/page/w-statistics.js"></script>

<script src="../../html-version/main/assets/js/page/index.js"></script>
<script src="../../html-version/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../html-version/assets/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../html-version/assets/plugins/multi-select/js/jquery.multi-select.js"></script>
<script src="../../html-version/assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../html-version/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
<script src="../../html-version/assets/bundles/summernote.bundle.js"></script>
<!-- <script src="../../html-version/theme2/assets/js/page/summernote.js"></script> -->
<script>

  function validateQty(el, evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45 && charCode != 8 && (charCode != 46) && (charCode < 48 || charCode > 57))
      return false;
    if (charCode == 46) {
      if ((el.value) && (el.value.indexOf('.') >= 0))
        return false;
      else
        return true;
    }
    if (charCode == 45) {
      if ((el.value) && (el.value.indexOf('-') != -2))
        return false;
      else
        return true;
    }
    return true;
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = evt.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  };

  function validateQty_NO(el, evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45 && charCode != 8 && (charCode != 46) && (charCode < 48 || charCode > 57))
      return false;
    if (charCode == 46) {
      if ((el.value) && (el.value.indexOf('/') >= 0))
        return false;
      else
        return true;
    }
    if (charCode == 45) {
      if ((el.value) && (el.value.indexOf('/') != -2))
        return false;
      else
        return true;
    }
    return true;
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = evt.value.split('/');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  };

  jQuery(document).ready(function($){
    $('.summernote').summernote({
      height: 280,
      focus: true,
      onpaste: function() {
        alert('You have pasted something to the editor');
      }
    });
  });
  

   jQuery(document).ready(function($){
      $('.multiselect').multiselect({
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        maxHeight: 200,
      });

    });


  $(document).ready(function(){

    $.fn.datepicker.dates['th'] = {
      days: ["วันอาทิตย์", "วันจันทร์", "วันอังคาร", "วันพุธ", "วันพฤหัสบดี", "วันศุกร์", "วันเสาร์"],
      daysShort: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
      daysMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
      months: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤศภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
      monthsShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
      today: "วันนี้",
      clear: "ล้างค่า",
      format: "yyyy-mm-dd",
      titleFormat: "MM yyyy", 
      weekStart: 0
    };
    $('.datepicker_input').datepicker({
      todayHighlight: true,
      format: 'yyyy-mm-dd',
      language: "th",
      thaiyear: true,
      autoclose: true
    }
    );

    $(".datepicker_input").datepicker().on('changeDate', function (e) {
      let date_ob = new Date(e.date);
// adjust 0 before single digit date
let date = ("0" + date_ob.getDate()).slice(-2);
// current month
let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
// current year
let year = date_ob.getFullYear();
$(this).attr("data-value", year + "-" + month + "-" + date);
$(".get_val_datetime").val(year + "-" + month + "-" + date);
});

    var contents = $('#set-data-to-pdf').html();
    $('#msg').val(contents);
  });
  

  // change font size 
  $( document ).ready(function() {
    <?php 
    if (empty($user_font_size['font_size'])) { 
      $font_user = 10;
    } else {
     $font_user = $user_font_size['font_size'];
   }
   ?>

   var font_orig = <?php echo $font_user; ?>; 
   var resize_plus = 10;
   document.getElementById("resize-font-plus").setAttribute("data-size",font_orig);

   $('#resize-font').css('font-size',""+font_orig+"0%");
   $('.card').css('font-size',""+font_orig+"0%");
   $('.card-header').css('font-size',""+font_orig+"0%");
   $('.card-body').css('font-size',""+font_orig+"0%");
   $('.text-muted, label, dt, small, b, p, .text-muted').css('font-size',""+font_orig+"0%");
   $('.table td, .table th').css('font-size',""+font_orig+"0%");

   $(document).on('click', '#resize-font-orig', function(){
    $('#resize-font').css('font-size','100%');
    $('.card').css('font-size','100%');
    $('.card-header').css('font-size','100%');
    $('.card-body').css('font-size','100%');
    $('.text-muted, label, dt, small, b, p, b').css('font-size','100%');
    $('.table td, .table th').css('font-size','100%');
    document.getElementById("resize-font-plus").setAttribute("data-size",10);
    $('#resize-font-plus').removeClass('btn-resize-disable-plus');

    var user_id = <?php echo $_SESSION['user_id'];?>;
    var size = 10;

    $.ajax({
      url:"index.php?r=site/json_change_font_size",
      method:"GET",
      data: {user_id: user_id, size: size},
      "dataType": "json",
      success:function(data)
      {
        location.reload();
          //console.log(data);
        }
      });

  });

   $(document).on('click', '#resize-font-plus', function(){
    $('#resize-font').css('font-size',''+font_orig+'0%');
    $('.card').css('font-size',''+font_orig+'0%');
    $('.card-header').css('font-size',''+font_orig+'0%');
    $('.card-body').css('font-size',''+font_orig+'0%');
    $('.text-muted, label, dt, small, b, p').css('font-size',''+font_orig+'0%');
    $('.table, td, .table, th').css('font-size',''+font_orig+'0%');
    document.getElementById("resize-font-plus").setAttribute("data-size",font_orig);

    if (font_orig == 11) {
      document.getElementById("resize-font-plus").setAttribute("data-size",font_orig);
      $('#resize-font-plus').addClass('btn-resize-disable-plus');
    }
    font_orig++;

    var user_id = <?php echo $_SESSION['user_id'];?>;
    var size = font_orig;
    $.ajax({
      url:"index.php?r=site/json_change_font_size",
      method:"GET",
      data: {user_id: user_id, size: size},
      "dataType": "json",
      success:function(data)
      {
        //console.log(data);
        location.reload();
          //document.getElementById("resize-font-plus").setAttribute("data-size",data);
        }
      });

  });


 });

</script>

<?php $this->endBody() ?>
</body>
</html>
<script>
  $.noConflict();
</script>

<?php $this->endPage() ?>
