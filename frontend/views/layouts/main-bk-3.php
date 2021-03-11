<style>
	.button-new {
		color: #FFFFFF;
		background-color: #292D3E;
		border: 1px solid #1D9AF2;
		border-radius: 4px;
		padding: 0 15px;
		cursor: pointer;
		height: 32px;
		font-size: 14px;
		transition: all 0.2s ease-in-out;
	}
	.button-new:hover {
		box-shadow: 1px 1px #53a7ea, 2px 2px #53a7ea, 3px 3px #53a7ea;
		transform: translateX(-3px);
	}

	/*.btn {
		color: #FFFFFF;
		background-color: #292D3E;
		border: 1px solid #1D9AF2;
		border-radius: 4px;
		padding: 0 15px;
		cursor: pointer;
		height: 32px;
		font-size: 14px;
		transition: all 0.2s ease-in-out;
	}
    /*button:hover {*/
	/*.btn:hover {
		box-shadow: 1px 1px #53a7ea, 2px 2px #53a7ea, 3px 3px #53a7ea;
		transform: translateX(-3px);
	}*/
</style>


<?php
 ##  Redis

 //require '../../Credis/Client.php'; 
 //if(!$redis) $redis = new Credis_Client('172.26.0.1',6379);


##  Redis 

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

</style>

<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>" dir="ltr">
<head>

  <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
      OneSignal.init({
        appId: "7cbe1206-fa49-47d0-a177-12ddc5138d58",
      });
    });
</script> -->

<meta charset="<?= Yii::$app->charset; ?>">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<?php $this->registerCsrfMetaTags();?>
<title><?= Html::encode($this->title);?></title>
<?php $this->head();?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../html-version/assets/plugins/multi-select/css/multi-select.css">
<!-- Plugins css -->
<link rel="stylesheet" href="../../html-version/assets/plugins/charts-c3/c3.min.css"/>
<link rel="stylesheet" href="../../html-version/assets/plugins/dropify/css/dropify.min.css">

<!-- Core css -->
<link rel="stylesheet" href="../../html-version/assets/css/main.css"/>
<link rel="stylesheet" href="../../html-version/assets/css/theme1.css"/>
<!-- style by pd -->
<link rel="stylesheet" href="../../html-version/assets/css/style.css"/>

<!-- style table responsive -->
<!-- <link rel="stylesheet" href="../../html-version/assets/css/style_table.css"/> -->

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
		<?
    //$this->title = 'จัดการไฟล์';
    //$this->params['breadcrumbs'][] = $this->title;
		?>
		<div id="header_top" class="header_top">
			<div class="container">
				<div class="hleft">
					<a class="header-brand" href="index.php"><i class="fe fe-home brand-logo"></i></a>
                    <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa  fa-align-left"></i></a>
					<div class="dropdown">
						<a class="nav-link icon" href="index.php?r=site/pages&view=es-dev"  ><i  class="fa fa-code"></i></a>
						<a title="ค้นหา" href="index.php?r=site/search" class="nav-link icon"><i  class="fa fa-search"></i></a>                    
                  <!-- <a title="ปฏิทิน" href="app-calendar.html"  class="nav-link icon app_inbox"><i class="fa fa-calendar"></i></a>
                  	<a href="app-contact.html"  class="nav-link icon xs-hide"><i class="fa fa-id-card-o"></i></a> -->

                  	<a title="จัดการไฟล์" href="index.php?r=site/pages&view=file-manager-all"  class="nav-link icon app_file xs-hide"><i class="fa fa-folder-o"></i></a> 
                        <!-- <a  title="แผนที่" href="index.php?r=site/pages&view=map"  class="nav-link icon xs-hide"><i class="fa fa-map-marker"></i></a>
                        <a target="_blank"  title="แผนที่" href="/html/leaflet-providers/leaflet-providers.html"  class="nav-link icon xs-hide"><i class="fa fa-map-marker"></i></a> 

                        <a title="กราฟสถิติ" href="index.php?r=site/pages&view=app-chart"  class="nav-link icon xs-hide"><i class="fa fa-signal"></i></a>-->
                        <a title="network link" href="index.php?r=site/pages&view=graph"  class="nav-link icon xs-hide"><i class="fa fa-connectdevelop"></i></a>

                        <a title="network link" href="index.php?r=site/pages&view=link-timeline"  class="nav-link icon xs-hide"><i class="fa fa-codepen"></i></a>

<!-- 
                        <a title="network link" href="index.php?r=site/pages&view=network-link"  class="nav-link icon xs-hide"><i class="fa fa-connectdevelop"></i></a>
                        <a title="network link" href="index.php?r=site/pages&view=network-link-with-images.php"  class="nav-link icon xs-hide"><i class="fa fa-connectdevelop"></i></a>
                        <a title="network link" href="index.php?r=site/pages&view=network-link-square-images.php"  class="nav-link icon xs-hide"><i class="fa fa-connectdevelop"></i></a> 
                    -->


                    <a title="Redis" href="index.php?r=site/pages&view=redis"  class="nav-link icon xs-hide"><i class="fa fa-server"></i></a>

                    <a title="รายการไฟล์ที่อัพโหลด" href="index.php?r=file-upload-list"  class="nav-link icon xs-hide"><i class="fa fa-file"></i></a>
                    <a title="eform-template" href="index.php?r=eform-template/update&id=8"  class="nav-link icon xs-hide"><i class="fa fa-wpforms"></i></a>
                    <!-- <a title="ตั้งค่า" href="index.php?r=setting"  class="nav-link icon xs-hide"><i class="fa fa-cog"></i></a> -->
                    <a title="ตั้งค่า" href="index.php?r=site/pages&view=setting"  class="nav-link icon xs-hide"><i class="fa fa-cog"></i></a>
                    <a title="ออกจากระบบ" href="index.php?r=site/logout_clear"  class="nav-link icon xs-hide"><i class="fa fa-power-off"></i></a>

                </div>
            </div>
            <div class="hright">
            	<div class="dropdown">
                    <!--<a href="javascript:void(0)" class="nav-link icon theme_btn"><i class="fa fa-paint-brush" data-toggle="tooltip" data-placement="right" title="Themes"></i></a> 

                    	<a href="javascript:void(0)" class="nav-link icon settingbar"><i class="fa fa-gear fa-spin" data-toggle="tooltip" data-placement="right" title="Settings"></i></a> -->
                    	<a href="javascript:void(0)" class="nav-link user_btn showuser_data">
                    		<img class="avatar" src="../../frontend/web/uploads/<?php echo $users_now['images']; ?>" alt="" data-toggle="tooltip" data-placement="right" title="User Menu"/>
                    	</a> <!---->
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
        					<p class="text-muted mb-0" style = "font-size: 9px;"><i class="fa fa-envelope-o"></i>_<?php echo $users_now['email']; ?></p>
     <!--<ul class="social-links list-inline mb-0 mt-2">
      <li class="list-inline-item"><a href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="Facebook"><i class="fa fa-envelope-o"></i></a></li>
      <li class=""> <p class="text-muted mb-0"><?php echo $users_now['email']; ?></p></li>
       <li class="list-inline-item"><a href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="1234567890"><i class="fa fa-phone"></i></a></li>
      <li class="list-inline-item"><a href="javascript:void(0)" title="" data-toggle="tooltip" data-original-title="@skypename"><i class="fa fa-skype"></i></a></li> 
  </ul> -->
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
					<label class="mb-0">จำนวนการเข้าใช้งาน</label>
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





    <!-- <div class="form-group">
      <label class="d-block">Total Expenses <span class="float-right">50%</span></label>
      <div class="progress progress-xs">
      <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
    </div>
    </div>
    <div class="form-group mb-0">
      <label class="d-block">Gross Profit <span class="float-right">23%</span></label>
      <div class="progress progress-xs">
      <div class="progress-bar bg-green  bg-blue" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100" style="width: 23%;"></div>
    </div>
</div> -->

</div>
</div>
<a href="index.php?r=users/view&id=<?php echo $_SESSION['user_id'];?>" style="" for="users-images" class="btn btn-success float-right btn1" > แสดงข้อมูลเพิ่มเติม</a>
<!-- <div class="card">
  <div class="card-header">
   <h3 class="card-title">Friends</h3>
   <div class="card-options">
    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>                                
    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
  </div>
</div>
<div class="card-body">                
 <ul class="right_chat list-unstyled">
  <li class="online">
   <a href="javascript:void(0);">
    <div class="media">
     <img class="media-object " src="../../html-version/assets/images/xs/avatar4.jpg" alt="">
     <div class="media-body">
      <span class="name">Donald Gardner</span>
      <span class="message">Designer, Blogger</span>
      <span class="badge badge-outline status"></span>
    </div>
  </div>
</a>                            
</li>
<li class="online">
 <a href="javascript:void(0);">
  <div class="media">
   <img class="media-object " src="../../html-version/assets/images/xs/avatar5.jpg" alt="">
   <div class="media-body">
    <span class="name">Wendy Keen</span>
    <span class="message">Java Developer</span>
    <span class="badge badge-outline status"></span>
  </div>
</div>
</a>                            
</li>
<li class="offline">
 <a href="javascript:void(0);">
  <div class="media">
   <img class="media-object " src="../../html-version/assets/images/xs/avatar2.jpg" alt="">
   <div class="media-body">
    <span class="name">Matt Rosales</span>
    <span class="message">CEO, Epic Theme</span>
    <span class="badge badge-outline status"></span>
  </div>
</div>
</a>                            
</li>                      
</ul>
</div>
</div> -->
<!-- <div class="card b-none">
  <ul class="list-group">
   <li class="list-group-item d-flex">
    <div class="box-icon sm rounded bg-blue"><i class="fa fa-credit-card"></i> </div>
    <div class="ml-3">
      <div>+$29 New sale</div>
      <a href="javascript:void(0)">Admin Template</a>
      <div class="text-muted font-12">5 min ago</div>
    </div>
 </li>
 <li class="list-group-item d-flex">
  <div class="box-icon sm rounded bg-pink"><i class="fa fa-upload"></i> </div>
  <div class="ml-3">
   <div>Project Update</div>
   <a href="javascript:void(0)">New HTML page</a>
   <div class="text-muted font-12">10 min ago</div>
 </div>
</li>
<li class="list-group-item d-flex">
  <div class="box-icon sm rounded bg-teal"><i class="fa fa-file-word-o"></i> </div>
  <div class="ml-3">
   <div>You edited the file</div>
   <a href="javascript:void(0)">reposrt.doc</a>
   <div class="text-muted font-12">11 min ago</div>
 </div>
</li>
<li class="list-group-item d-flex">
  <div class="box-icon sm rounded bg-cyan"><i class="fa fa-user"></i> </div>
  <div class="ml-3">
   <div>New user</div>
   <a href="javascript:void(0)">Puffin web - view</a>
   <div class="text-muted font-12">17 min ago</div>
 </div>
</li>
</ul>
</div> -->
</div>

<div id="left-sidebar" class="sidebar ">
	<h5 class="brand-name">Text X <a href="javascript:void(0)" class="menu_option float-right"><i class="icon-grid font-16" data-toggle="tooltip" data-placement="left" title="Grid & List Toggle"></i></a></h5>
	<nav id="left-sidebar-nav" class="sidebar-nav">
		<ul class="metismenu">
			<!-- <li class="g_heading"><?php echo $_SESSION['user_id']; ?></li> -->
			<!--  <li class="g_heading">Directories</li> -->
<!-- <li class="active">
<a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-rocket"></i><span>HRMS</span></a>
<ul>

    <li class="active"><a href="index.html"><span>Dashboard</span></a></li>
    <li><a href="hr-users.html"><span>Users</span></a></li>
    <li><a href="hr-departments.html"><span>Departments</span></a></li>
    <li><a href="hr-employee.html"><span>Employee</span></a></li>
    <li><a href="hr-activities.html"><span>Activities</span></a></li>
    <li><a href="hr-holidays.html"><span>Holidays</span></a></li>
    <li><a href="hr-events.html"><span>Events</span></a></li>
    <li><a href="hr-payroll.html"><span>Payroll</span></a></li>
    <li><a href="hr-accounts.html"><span>Accounts</span></a></li>
    <li><a href="hr-report.html"><span>Report</span></a></li>
</ul>
</li> -->
<!-- <?php /*
$array_menu_main = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_status = 'Y' ORDER BY m_sort ASC")->queryAll();
foreach ($array_menu_main as $val_menu_main){


?>
<li>
<a href="javascript:void(0)" class="has-arrow arrow-c"><i class="<?=$val_menu_main['m_icon'];?>"></i><span><?=$val_menu_main['m_name'];?></span></a>
<ul>
    <?php  $array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' AND menu_id = '".$val_menu_main['id']."' ORDER BY submenu_sort ASC")->queryAll();
    foreach ($array_menu_sub as $val_menu_sub){
        ?>
        <li><a href="index.html"><span><?=$val_menu_sub['submenu_name'];?></span></a></li>
    <?php } ?>
</ul>
</li>

<?php } */ ?> -->

<?php if ($_SESSION['user_role']=='3'): ?>
	<li><a href=""><i class="fab fa-wpforms"></i><span>แบบฟอร์ม</span></a>
		<ul aria-expanded="true" class="collapse in">
			<?php
			$eform =  Eform::find()->where("active = '1' AND unit_id ='".$_SESSION['unit_id']."'")->orderBy(['detail' => SORT_ASC])->all();
			foreach($eform as $ef){
				?>
				<li><a href="index.php?r=eform-data/index&form_id=<?=$ef->form_id?>"><span><?=$ef->detail?></span></a>
				<? } ?>
			</ul>
		</li>
	<?php endif ?>

	<?php if (in_array($_SESSION['user_role'], array("2","3"))): ?>
 <!--  <li><a href=""><i class="fa fa-file"></i><span>จัดการไฟล์</span></a>
 	<ul aria-expanded="true" class="collapse in"> -->
 		<?php
         // if($_SESSION['user_role']=='2'){
         //  $sql = "SELECT * FROM `eform_template` WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable ='0' ORDER BY id ASC";
         // }else{
 		$sql = "SELECT form_id as id, detail FROM `eform` WHERE unit_id = '".$_SESSION['unit_id']."' AND active = '1' GROUP BY form_id ORDER BY detail ASC";
         // }

 		$eform_template = Yii::$app->db->createCommand($sql)->queryAll();
 		?>
 		<?php
 		foreach($eform_template as $ef){
 			?>
 			<!--   <li><a href="index.php?r=site/pages&view=file-manager-type&form_id=<?=$ef['id']?>"><span><?=$ef['detail']?></span></a> -->
 			<? } ?>
   <!--  </ul>
   </li> -->
<?php endif ?>


<?php if(!empty($menu_main_role)):
     $mainmenusql = "SELECT * FROM `menu_main` WHERE m_status = 'Y' $where_main_id ORDER BY m_sort ASC";
     //echo $mainmenusql;
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
							<!-- <h3 class="menu-title">จัดการระบบ</h3> -->
						<?php endif; ?>
						<?php
						$server = $_SERVER['REQUEST_URI'];
						$server = str_replace("/textx/frontend/web/",'',$server);
						$activeMenu = Yii::$app->db->createCommand("SELECT * FROM `menu_sub`,`menu_main` WHERE menu_sub.menu_id = menu_main.id AND menu_sub.submenu_link = '".$server."'")->queryOne();

						if ($server == $activeMenu['submenu_link']) {
							$act = "active";
            // echo $activeMenu['id'];
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
                                        <!-- <i class="<?=$val_menu_sub['s_icon'];?>"></i> -->
                                        
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


<!-- <li>
    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-rocket"></i><span>HRMS</span></a>
    <ul>

        <li class="active"><a href="index.html"><span>Dashboard</span></a></li>
        <li><a href="hr-users.html"><span>Users</span></a></li>
        <li><a href="hr-departments.html"><span>Departments</span></a></li>
        <li><a href="hr-employee.html"><span>Employee</span></a></li>
        <li><a href="hr-activities.html"><span>Activities</span></a></li>
        <li><a href="hr-holidays.html"><span>Holidays</span></a></li>
        <li><a href="hr-events.html"><span>Events</span></a></li>
        <li><a href="hr-payroll.html"><span>Payroll</span></a></li>
        <li><a href="hr-accounts.html"><span>Accounts</span></a></li>
        <li><a href="hr-report.html"><span>Report</span></a></li>
    </ul>
</li> 
<li>
    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-cup"></i><span>Project</span></a>
    <ul>
        <li><a href="project-index.html">Dashboard</a></li>                        
        <li><a href="project-list.html">Project list</a></li>
        <li><a href="project-taskboard.html">Taskboard</a></li>
        <li><a href="project-ticket.html">Ticket List</a></li>
        <li><a href="project-ticket-details.html">Ticket Details</a></li>
        <li><a href="project-clients.html">Clients</a></li>
        <li><a href="project-todo.html">Todo List</a></li>
    </ul>
</li>
<li>
    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-briefcase"></i><span>Job Portal</span></a>
    <ul>
        <li><a href="job-index.html"><span>Job Dashboard</span></a></li>
        <li><a href="job-positions.html"><span>Positions</span></a></li>                    
        <li><a href="job-applicants.html"><span>Applicants</span></a></li>
        <li><a href="job-resumes.html"><span>Resumes</span></a></li>
        <li><a href="job-settings.html"><span>Settings</span></a></li>
    </ul>
</li>
<li>
    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-lock"></i><span>Authentication</span></a>
    <ul>
        <li><a href="login.html">Login</a></li>
        <li><a href="register.html">Register</a></li>
        <li><a href="forgot-password.html">Forgot password</a></li>
        <li><a href="404.html">404 error</a></li>
        <li><a href="500.html">500 error</a></li>   
    </ul>
</li> -->
<!-- <li class="g_heading">UI Elements</li>
<li>
    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-lock"></i><span>Layouts</span></a>
    <ul>
        <li><a href="../layouts/layout-menu.html">Menu with Tab</a></li>
        <li><a href="../layouts/layout-menu-dark.html">Dark Menu</a></li>
        <li><a href="../layouts/layout-menu-grid.html">Menu with Grid</a></li>
        <li><a href="../layouts/layout-menu-mini-dark.html">Mini Dark Menu</a></li>
        <li><a href="../layouts/layout-menu-collapse.html">Menu Collapse</a></li>
        <li><a href="../layouts/layout-menu-rtl.html">RTL Version</a></li>
        <li><a href="../layouts/layout-menu-rtl-collapse.html">RTL Menu Collapse</a></li>
        <li><a href="../layouts/layout-page-hedaer-drak.html">Header Dark</a></li>
        <li><a href="../layouts/layout-page-hedaer-fix.html">Header Top Fix</a></li>
        <li><a href="../layouts/layout-dark.html">Full Dark</a></li>
        <li><a href="../layouts/layout-dark-sidebar-color.html">Dark Sidebar Color</a></li>
    </ul>
</li>
<li><a href="icons-fontawesome.html"><i class="icon-tag"></i><span>Icons</span></a></li>
<li><a href="charts-apex.html"><i class="icon-bar-chart"></i><span>Charts</span></a></li>
<li><a href="form-elements.html"><i class="icon-layers"></i><span>Forms</span></a></li>
<li><a href="table-normal.html"><i class="icon-tag"></i><span>Tables</span></a></li>                
<li><a href="widgets.html"><i class="icon-puzzle"></i><span>Widgets</span></a></li>                
<li><a href="page-maps.html"><i class="icon-map"></i><span>Maps</span></a></li>
<li><a href="page-gallery.html"><i class="icon-picture"></i><span>Gallery</span></a></li> -->
<!-- <li>
    <a href="index.php?r=site/logout_clear"> <i class="fa fa-power-off"></i><span>ออกจากระบบ </span></a>
</li> -->
</ul>
</nav>        
</div>

<?php $unit = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$_SESSION['unit_id']."'")->queryOne();
$unit_name = (!empty($unit['unit_name'])) ? '<small>(<b>หน่วย'.$unit['unit_name'].'<b>)</small>' : '';
$usergroup = Yii::$app->db->createCommand("SELECT * FROM `user_group` WHERE id = '".$_SESSION['user_group']."'")->queryOne();
$user_group = (!empty($usergroup['name'])) ? '<br><small class="text-muted">กลุ่มผู้ใช้ : '.$usergroup['name'].'</small>' : '';
?>

<div class="page">
	<div id="page_top" class="section-body ">
		<div class="container-fluid">
			<div class="page-header">
				<div class="left">
					<h1 class="page-title">
						<?=$_SESSION['user_name']." ".$unit_name." ".$user_group;?></h1>
                    <!-- <select class="custom-select">
                        <option>Year</option>
                        <option>Month</option>
                        <option>Week</option>
                    </select>
                    <div class="input-group xs-hide">
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>  -->              
                </div>
                <div class="right">
                	<ul class="nav nav-pills">

    <!--<li class="nav-item dropdown">

    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ภาษา</a>
                         <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><img class="w20 mr-2" src="../../html-version/assets/images/flags/us.svg">English</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><img class="w20 mr-2" src="../../html-version/assets/images/flags/th.svg">Thai</a>
         <a class="dropdown-item" href="#"><img class="w20 mr-2" src="../../html-version/assets/images/flags/jp.svg">japanese</a>
            <a class="dropdown-item" href="#"><img class="w20 mr-2" src="../../html-version/assets/images/flags/bl.svg">France</a> 
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">รายงาน</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#"><i class="dropdown-icon fa fa-file-excel-o"></i> MS Excel</a>
            <a class="dropdown-item" href="#"><i class="dropdown-icon fa fa-file-word-o"></i> MS Word</a>
            <a class="dropdown-item" href="#"><i class="dropdown-icon fa fa-file-pdf-o"></i> PDF</a>
        </div>
    </li>-->

    <li class="nav-item dropdown">
    	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">นำเข้าข้อมูล</a>
    	<div class="dropdown-menu">
    		<a class="dropdown-item" href="#">แบบฟอร์ม</a>                                    
    		<a class="dropdown-item" href="#">อัพโหลดไฟล์</a>
    		<a class="dropdown-item" href="#">พูดเพื่อป้อนข้อมูล</a>
    		<!-- <a class="dropdown-item" href="#">iOs App Development</a>
    		<div class="dropdown-divider"></div>
    		<a class="dropdown-item" href="#">Home Development</a>
    		<a class="dropdown-item" href="#">New Blog post</a> -->
    	</div>
    </li>
    <li class="nav-item dropdown">
    	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ช่วยเหลือ</a>
    	<div class="dropdown-menu">
    		<a class="dropdown-item" href="#">คู่มือ</a>                                    
    		<a class="dropdown-item" href="#">Profile</a>
    		<a class="dropdown-item" href="#">คำถามที่พบบ่อย</a>
    		<a class="dropdown-item" href="#">ติดต่อผู้ดูแลระบบ</a>
    		<div class="dropdown-divider"></div>
    		<a class="dropdown-item" href="#">Home Development</a>
    		<a class="dropdown-item" href="#">New Blog post</a>
    	</div>
    </li>

</ul>
<div class="notification d-flex">
	<div class="dropdown d-flex">
		<a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1 showuser_online" data-toggle="dropdown"><i class="fa fa-users" data-toggle="tooltip" data-placement="bottom" title="<?php include 'CheckUserOnline.php';?>"></i><span class="badge badge-success nav-unread" style="background-color: #21ba45 !important;"></span></a>
		<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
			<ul class="right_chat list-unstyled w250 p-0 show_useronline" style="height:350px; overflow: auto;">
			</ul>
            <!-- <div class="dropdown-divider"></div>
            	<a href="javascript:void(0)" class="dropdown-item text-center text-muted-dark readall">Mark all as read</a> -->
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

        <!-- <div class="dropdown d-flex">
        	<a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge badge-success nav-unread"></span></a>
        	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        		<ul class="right_chat list-unstyled w250 p-0">
        			<li class="online">
        				<a href="javascript:void(0);">
        					<div class="media">
        						<img class="media-object " src="../../html-version/assets/images/xs/avatar4.jpg" alt="">
        						<div class="media-body">
        							<span class="name">Donald Gardner</span>
        							<span class="message">Designer, Blogger</span>
        							<span class="badge badge-outline status"></span>
        						</div>
        					</div>
        				</a>                            
        			</li>
        			<li class="online">
        				<a href="javascript:void(0);">
        					<div class="media">
        						<img class="media-object " src="../../html-version/assets/images/xs/avatar5.jpg" alt="">
        						<div class="media-body">
        							<span class="name">Wendy Keen</span>
        							<span class="message">Java Developer</span>
        							<span class="badge badge-outline status"></span>
        						</div>
        					</div>
        				</a>                            
        			</li>
        			<li class="offline">
        				<a href="javascript:void(0);">
        					<div class="media">
        						<img class="media-object " src="../../html-version/assets/images/xs/avatar2.jpg" alt="">
        						<div class="media-body">
        							<span class="name">Matt Rosales</span>
        							<span class="message">CEO, Epic Theme</span>
        							<span class="badge badge-outline status"></span>
        						</div>
        					</div>
        				</a>                            
        			</li>
        			<li class="online">
        				<a href="javascript:void(0);">
        					<div class="media">
        						<img class="media-object " src="../../html-version/assets/images/xs/avatar3.jpg" alt="">
        						<div class="media-body">
        							<span class="name">Phillip Smith</span>
        							<span class="message">Writter, Mag Editor</span>
        							<span class="badge badge-outline status"></span>
        						</div>
        					</div>
        				</a>                            
        			</li>                        
        		</ul>
        		<div class="dropdown-divider"></div>
        		<a href="javascript:void(0)" class="dropdown-item text-center text-muted-dark readall">Mark all as read</a>
        	</div>
        </div> -->
        <?php if ($_SESSION['user_role']=='1'): ?>
        	<div class="dropdown d-flex">
        		<a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fab fa-wpforms"></i><span class="badge badge-danger nav-unread check_alert"></span></a>
        		<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow list-alert">
        			<ul class="list-unstyled feeds_widget show_alert_eform">
        			</ul>
        		</div>

        		<script>
        			$(document).ready(function(){
        				$('.check_alert').css('display', 'none');
        				var show_alert_eform = [];
        				var alert_eform_total = 0;
        				$.ajax({
        					url:"index.php?r=site/insert_file_upload_list&type=check_status_stay_informed",
        					method:"GET",
        					dataType:"json",
        					contentType: "application/json; charset=utf-8",
        					success:function(data)
        					{
        						if (data.length>0) {
        							$.each(data, function(index) {
        								alert_eform_total = parseInt(alert_eform_total)+parseInt(data[index].total_stay_informed)
        								var icon = '';
        								var num_alert = '';
        								var text_color = '';
        								var alert_eform_news = '';
        								var alert_eform_informed = '';

        								if (data[index].total_stay_informed==0) {
        									alert_eform_informed = 'alert_eform_light';
        									num_alert = '';
        								}else{
        									alert_eform_informed = 'alert_eform_danger';
        									num_alert = 'badge-danger badge-pill text-white';
        								}

        								if (data[index].total_stay_informed==0) {
        									icon = 'fa-circle';
        									text_color = 'text_sussess_a6ca16';
        								}else{
        									icon = 'fa-circle';
        									text_color= 'text_warning_f0b144';
        								}

        								show_alert_eform.push(`
        									<a href="index.php?r=eform-data/index&form_id=${data[index].form_id}&stay_informed=0"><li>
        									<div class="feeds-left"><i class="fa ${icon} ${text_color}"></i></div>
        									<div class="feeds-body">
        									<h6 class="title text-danger"><small class="float-right text-muted ${num_alert}">${data[index].total_stay_informed}</small></h6>
        									<small>${data[index].detail}</small>
        									</div>
        									</li></a>
        									`);
        							});
        							$(".show_alert_eform").html(show_alert_eform.join(""));

        							if (alert_eform_total==0) {
        								$('.check_alert').css('display', 'none');
        							}else{
        								$('.check_alert').css('display', 'block');
        							}
        						}else{

        						}
        					}
        				});
        			});
        		</script>
        	</div>
        <?php endif ?>
        <div class="dropdown d-flex">
        	<a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-primary nav-unread"></span></a>
        	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        		<ul class="list-unstyled feeds_widget">
        			<li>
        				<div class="feeds-left"><i class="fa fa-check"></i></div>
        				<div class="feeds-body">
                        <a href="index.php?r=site/pages&view=dashboard-approve">
        					<h4 class="title text-danger">ข้อมูลรออนุมัติ <small class="float-right text-muted">11:05</small></h4>
        					<!-- <small>WE have fix all Design bug with Responsive</small> -->
                        </a>    
        				</div>
        			</li>
                    <li>
        				<div class="feeds-left"><i class="fa fa-check"></i></div>
        				<div class="feeds-body">
                        <a href="index.php?r=site/pages&view=dashboard-approve">
        					<h4 class="title text-danger">ข่าวแจ้งเตือน <small class="float-right text-muted">11:05</small></h4>
        					<!-- <small>WE have fix all Design bug with Responsive</small> -->
                        </a>    
        				</div>
        			</li>
        			 <li>
        				<div class="feeds-left"><i class="fa fa-user"></i></div>
        				<div class="feeds-body">
        					<h4 class="title">New User <small class="float-right text-muted">10:45</small></h4>
        					<small>I feel great! Thanks team</small>
        				</div>
        			</li>
        			<!--<li>
        				<div class="feeds-left"><i class="fa fa-thumbs-o-up"></i></div>
        				<div class="feeds-body">
        					<h4 class="title">7 New Feedback <small class="float-right text-muted">Today</small></h4>
        					<small>It will give a smart finishing to your site</small>
        				</div>
        			</li>
        			<li>
        				<div class="feeds-left"><i class="fa fa-question-circle"></i></div>
        				<div class="feeds-body">
        					<h4 class="title text-warning">Server Warning <small class="float-right text-muted">10:50</small></h4>
        					<small>Your connection is not private</small>
        				</div>
        			</li>
        			<li>
        				<div class="feeds-left"><i class="fa fa-shopping-cart"></i></div>
        				<div class="feeds-body">
        					<h4 class="title">7 New Orders <small class="float-right text-muted">11:35</small></h4>
        					<small>You received a new oder from Tina.</small>
        				</div>
        			</li>    -->                                
        		</ul>
        		<div class="dropdown-divider"></div>
        		<a href="javascript:void(0)" class="dropdown-item text-center text-muted-dark readall">Mark all as read</a>
        	</div>
        </div>
        
        <div class="dropdown d-flex">
        	<a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-user"></i></a>
        	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        		<a class="dropdown-item" href="index.php?r=users/update&id=<?php echo $_SESSION['user_id'];?>
        		"><i class="dropdown-icon fe fe-user"></i> ข้อมูลส่วนตัว</a>
        		<a class="dropdown-item" href="index.php?r=users/change_password&id=<?php echo $_SESSION['user_id'];?>"><i class="dropdown-icon fe fe-unlock"></i> เปลี่ยนรหัสผ่าน</a>
        		<div class="dropdown-divider"></div>
        		<a class="dropdown-item" href="index.php?r=user-role"><i class="dropdown-icon fe fe-sliders"></i> จัดการสิทธิ์การเข้าใช้งาน</a>
        		<a class="dropdown-item" href="app-setting.html"><i class="dropdown-icon fe fe-settings"></i> ตั้งค่าการใช้งาน</a>
        		<!-- <a class="dropdown-item" href="index.php?r=site/pages&view=stat_users"><i class="dropdown-icon fe fe-users"></i> สถิติการเข้าใช้งาน</a> -->
        		<!-- <a class="dropdown-item" href="index.php?r=site/pages&view=stat_use_me"><i class="dropdown-icon fe fe-users"></i> สถิตการเข้าใช้งานของฉัน</a> -->
        		<?php if ($_SESSION['user_role']=='2'): ?>
        			<a class="dropdown-item" href="index.php?r=site/pages&view=stat_users_department"><i class="dropdown-icon fe fe-server"></i> สถิตการเข้าใช้งานหน่วยงาน</a>
        		<?php endif ?>
        		<div class="dropdown-divider"></div>
        		<a class="dropdown-item" href="javascript:void(0)"><span class="float-right"><span class="badge badge-primary">6</span></span><i class="dropdown-icon fe fe-mail"></i> Inbox</a>
        		<a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-send"></i> Message</a>
        		<a class="dropdown-item" href="index.php?r=site/pages&view=questionAndAnswer"><i class="dropdown-icon fe fe-file"></i> Q&A</a>
        		<div class="dropdown-divider"></div>
        		<a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-help-circle"></i> ต้องการความช่วยเหลือ?</a>
        		<a class="dropdown-item" href="index.php?r=site/logout_clear"><i class="dropdown-icon fe fe-log-out"></i> Sign out</a>
        	</div>
        	<?php
        	// $urlNow = $_SERVER['REQUEST_URI'];
        	// $urlView = 'view';
        	// $pos = strpos($urlNow, $urlView);
        	// if ($pos !== false) {
        		?>
        		<!-- <div class="nav-item">
        			<form id="TheForm" method="post" action="index.php?r=site/print-pdf" target="_blank">
        				<textarea name="msg" id="msg" style="display:none;"></textarea>
        				<button type="submit" class="btn-export-pdf"><i class="fas fa-file-pdf"></i> Export pdf</button>
        			</form>
        		</div> -->
        	<?php //} ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="section-body mt-3">
	<div class="container-fluid">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>

        <? /*<div class="alert alert-danger">
        (Witthaya DEBUG) <br>    
        Redis - Dashboard  <br>
            <?
                require '../../Credis/Client.php';
                if(!$redis) $redis = new Credis_Client($_SERVER['REMOTE_ADDR'],6379);
                
                if($redis->EXISTS('name')==0) $redis->set('name', 'วิทยา พันดวง');
                echo  $redis->get('name');

                if($redis->EXISTS('url_minio')==0) $redis->set('url_minio', Setting::find()->where(['setting_name' => 'url_minio'])->one()->setting_value);

                if($redis->EXISTS('url_node')==0) $redis->set('url_node', Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value);

                echo '<br>['.$redis->get('url_node').'|'.$redis->get('url_minio').']' ;


            ?><br>
        (Witthaya DEBUG)    
        </div> */ ?>
        <!-- <a href="#!" class="btn btn-primary">Try it for free</a> -->



        <div id="set-data-to-pdf">
        	<?= $content ?>
        </div>
        
    </div>
</div>    
<div class="section-body">
	<footer class="footer">
		<div class="container-fluid">
			<div class="row">
                <!-- <div class="col-md-6 col-sm-12">
                    Copyright © 2019 <a href="http://www.pd-it-solution.com/">PD IT SOLUTION</a>.
                </div> -->
                <div class="col-md-6 col-sm-12 text-md-right">
                	<ul class="list-inline mb-0">
                		<li class="list-inline-item"><a href="../doc/index.html">Documentation</a></li>
                		<li class="list-inline-item"><a href="javascript:void(0)">FAQ</a></li>
                		<!--  <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-outline-primary btn-sm">Buy Now</a></li> -->
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
<script src="../../html-version/assets/bundles/summernote.bundle.js"></script>
<script src="../../html-version/assets/js/core.js"></script>
<script src="../../html-version/assets/plugins/dropify/js/dropify.min.js"></script>

<script src="../../html-version/main/assets/js/page/index.js"></script>
<!-- <script src="../../html-version/main/assets/js/form/form-advanced.js"></script> -->
<script src="../../html-version/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../html-version/assets/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../../html-version/assets/plugins/multi-select/js/jquery.multi-select.js"></script>
<script src="../../html-version/assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../../html-version/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

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

    // function chkNum(ele)
    // {

    //     var res = ele.value.replace(/\,/g, "");
    //     var num = parseFloat(res);
    //     ele.value = addCommas(num.toFixed(2));
    // }
    
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

    	var contents = $('#set-data-to-pdf').html();
    	$('#msg').val(contents);
     //console.log(contents);
    // timelinedata(contents);
});

    // function timelinedata(contents) {
    // 	var datapages = contents;
    // 	//console.log(datapages);
    // 	$(document).on('click', '#export-pdf', function(){
    // 		$.ajax({
    // 			url: "index.php?r=site/print-pdf",
    // 			method: "POST",
    // 			data : {datapages:datapages},
    // 			success: function(data){
    // 				window.open('index.php?r=site/print-pdf','_blank'); 
    // 			},
    // 		});
    // 	});
    // }

</script>

<?php $this->endBody() ?>
</body>
</html>
<script>
	$.noConflict();
</script>
<?php
// $this->registerJsFile('../../html-version/assets/bundles/lib.vendor.bundle.js');
?>

<?php $this->endPage() ?>
