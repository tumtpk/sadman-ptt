<?php
$mainid = (isset($_GET['mainid'])) ? "AND id = '".$_GET['mainid']."'" : '';

$array_menu_main = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_status = 'Y' $mainid ORDER BY m_sort ASC")->queryOne();

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

$menu_sub_role = str_replace('[', '', $menu['allow_access_sub']);
$menu_sub_role = str_replace(']', '', $menu_sub_role);
$menu_sub_role = str_replace('"', '\'', $menu_sub_role);

if (!empty($menu_sub_role)) {
  $where_sub_id = "AND submenu_id IN (".$menu_sub_role.")";
}else{
  $where_sub_id = "";
}

$this->title=$array_menu_main['m_name'];
?>

<style>
.iconall{
    content: "\e001";
    background-color: #dab90a;
    padding: 22 20 22 20;
    border: -32;
    border-radius: 75px;
    color: #fff;
    text-align: center !important;
    font-size: 32;
   
}
.bbt{
  border-radius: 30px;
  margin-top: 20;
}
.top{
  margin-top: 0;
    margin-bottom: 10;
}
.div-scrollbar{
	height: 100px;
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
.card{
    height: 300px;
}
a.disabled {
	opacity: 0.6;
	cursor: not-allowed;
}
</style>

<ul class="breadcrumb"><li><a href="index.php">หน้าหลัก</a></li>
  <li class="active"><?=$this->title;?></li>
</ul>


<div class="row">

  <?php $array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' $where_sub_id AND menu_id = '".$array_menu_main['id']."' ORDER BY submenu_sort ASC")->queryAll(); ?>

  <?php foreach ($array_menu_sub as $value): ?>

  <div class="col-12 col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="row ">
          <div class="col-sm-9 col-9">
            <h3 class=""><b><?=$value['submenu_name']?></b></h3>
          </div>

          <div class="col-sm-3 col-3">
            <div class=" text-right top">
              <?php if (!empty($value['s_icon'])): ?>
                <i class="<?=$value['s_icon']?> iconall"></i>
              <?php else: ?>
                 <i class="fa fa-ICON_NAME iconall"></i>
              <?php endif ?>
            
            </div>
          </div><hr>

          <div class="col-sm-12 col-12 top">
            <div class="div-scrollbar">
              <h5>รายละเอียดเมนู</h5>
              <p class="card-text">  <?=$value['s_detail']?></p>
            </div>
          </div>

          <div class="col-sm-12 col-12">
            <a href="<?=$value['submenu_link'];?>" class="btn btn-primary bbt"><i class="fa fa-external-link" data-toggle="tooltip" title="" data-original-title="fa fa-external-link"></i> ไปยังหน้านี้</a>
          </div>

        </div>
      </div>
    </div>
  </div>

   

  <?php endforeach ?>  
  
  <!-- <div class="col-6 col-md-3">
    <div class="alert alert-dark" role="alert">
      <h4 class="alert-heading">ค้นหาระบุระยะห่างและ</h4>
      <p>Aww yeah</p>
      <hr>
      <p class="mb-0">ค้นหา ทั้งคำและระยะห่าง</p>

      <a href="index.php?r=site/pages&view=es-js" class="btn btn-secondary">es-js.php</a>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="alert alert-dark" role="alert">
      <h4 class="alert-heading">ค้นหา Apissara</h4>
      <p>Aww yeah</p>
      <hr>
      <p class="mb-0">ค้นหา ทั้งคำและระยะห่าง</p>

      <a href="/es/es-search3.php" class="btn btn-secondary">es-js.php</a>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="alert alert-dark" role="alert">
      <h4 class="alert-heading">Mockaroo</h4>
      <p>Aww yeah</p>
      <hr>
      <p class="mb-0">Send mockaroo to ES</p>

      <a href="index.php?r=site/pages&view=es-mockaroo" class="btn btn-secondary">es-mockaroo.php</a>
    </div>
  </div> -->


</div>

<!-- <div id="topBar">
    <a href ="#" id="load_home"> HOME </a>
</div>
<div id ="content">        
</div>

<script>
$(document).ready( function() {
   
        $("#content").load("http://45.127.62.51:7000/textx/frontend/web/index.php?r=site/pages&view=es-dev");
    
});
</script> -->

<!-- <div class="row">
  <div class="col-8">col-8</div>
  <div class="col-4">col-4</div>
</div> -->





