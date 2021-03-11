<?php
use yii\helpers\Html;
date_default_timezone_set("Asia/Bangkok");

$users_data = Yii::$app->db->createCommand("SELECT * FROM users,unit WHERE users.id = '".$_SESSION['user_id']."' AND users.unit_id = unit.unit_id")->queryOne();

$eform_id = isset($_GET['eform_data']) ?  $_GET['eform_data'] : (isset($_POST['eform_data']) ? $_POST['eform_data'] : '');

if (!empty($eform_id)) {
  $sql = "SELECT * FROM `eform_data` WHERE id = '$eform_id'";
  $query = Yii::$app->db->createCommand($sql)->queryOne();
  $data_json_for_approve = $query['data_json'];
  $data = @json_decode($query['data_json'],TRUE);
  $val_eform = $data[0];
  $id = $query['form_id'];
  $this->params['breadcrumbs'][] = ['label' => 'รายละเอียด', 'url' => ['eform-data/view-person','id'=>$eform_id]];
  $card1 = 'รายละเอียดข้อมูล';
  $card2 = 'เอกสารประกอบ';
  $where = "AND id = '".$query['eform_id']."'";
}else{
  $id = isset($_GET['form_id']) ?  $_GET['form_id'] : (isset($_POST['form_id']) ? $_POST['form_id'] : '');
  $card1 = 'ขั้นตอนที่ 1';
  $card2 = 'ขั้นตอนที่ 2';
  $where = "AND disable = '0'";
}

$unitid = (isset($_GET['unit_id'])) ? "AND unit_id LIKE '%\"".$_GET['unit_id']."\"%'" : "AND unit_id LIKE '%\"".$_SESSION['unit_id']."\"%'";


// $unitid;
$sql = "SELECT * FROM `eform_template` WHERE id = '$id' $where AND type = '6'";
$query = Yii::$app->db->createCommand($sql)->queryOne();
$data = @json_decode($query['form_element'],TRUE);
$data_loop = $data[0]['fieldGroup'];

if (!empty($data_loop)){
  if(count($data_loop)>0){
    sksort($data_loop, "sort", true);
  }else{
    echo "<script>alert('ประเภทรูปแบบฟอร์ม ไม่ตรงกับการเรียกใช้งาน กรุณาตรวจสอบ');window.location='index.php?r=site/pages&view=alert_permission';</script>";
  }
}else{
  echo "<script>alert('ประเภทรูปแบบฟอร์ม ไม่ตรงกับการเรียกใช้งาน กรุณาตรวจสอบ');window.location='index.php?r=site/pages&view=alert_permission';</script>";
}

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

$this->title = $query['detail'];
// $this->params['breadcrumbs'][] = ['label' => $query['detail'], 'url' => ['eform-data/index','form_id'=>$id]];
$this->params['breadcrumbs'][] = $this->title;

if ($_GET['form_id'] == '21') {
  $culor = "bg-red-gradient" ;
} else {
     $culor ='';
}
?>


<style>
#overlay2,#overlay1 {
  position: absolute;
  width: 100%;
  height: auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ffffffcc;
  z-index: 999;
  cursor: not-allowed;
}
#overlay2 {
  display: block;
}
#overlay1 {
  display: none;
}
.list-design{
  overflow-y: scroll;
  overflow-x: hidden;
}
#text{
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 1em;
  color: #113f50 !important;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
  font-weight: bold;
}
.class_radio{
  width: auto !important;
  display: inline-block !important;
}
label{
  font-weight: bold !important;
}
.text-right-align{
  text-align: right !important;
}
@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .text-right-align{
    text-align: left !important;
  }
}
.card-mb-not{
  margin-bottom: 0px !important;
}
.card-mb-not label{
  font-weight: 100 !important;
}
.display-hidden{
  visibility: hidden;
}
.div_scrollbar{
  overflow:auto;max-height:300px !important;
  width: 100%;
}

.rating {
  background: white;
  border-radius: 25px;
  padding: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-around;
  width: 100%;
  /*margin: 30px auto 0;*/
}

.rating input {
  display: none;
}

.rating label {
  font-size: 0;
}

.rating label.stars::before, .rating label.hearts::before {
  content: '';
  display: block;
  width: 20px;
  height: 20px;
  cursor: pointer;
}

/* Hover effect */
.rating.effect input:checked + label ~ label.stars::before, .rating.effect:hover input:hover + label ~ label.stars::before {
  background: url(../../images/icons_rate_star/star-regular.svg) no-repeat center center;
  background-size: 20px;
  opacity: .3;
}

.rating.effect:hover input + label ~ label.stars::before {
  background: url(../../images/icons_rate_star/star-solid.svg) no-repeat center center;
  background-size: 20px;
}

.rating label.stars::before {
  background: url(../../images/icons_rate_star/star-solid.svg) no-repeat center center;
  background-size: 20px;
}

<style>
#tree>svg {
  background-color: rgba(0,0,0,0);
}

.main-group>rect {
  fill: #039BE5;
}

.main-group>text {
  fill: #FCFAF2;
}

.main-group>[control-node-menu-id] line {
  stroke: #FCFAF2;
}

.main-group>g>.ripple {
  fill: #FCFAF2;
}

.focused rect{
  fill: #F57C00;
}

.node.Selected rect {
  fill: #004660;
}
.img-show-img{
  height: 100px;
  width: 100%;
  object-fit: cover;
  object-position: center;
}
</style>

<script src="../../js/orgchart.js"></script>

<h4><?= Html::encode($this->title) ?></h4>
<div class="row">
  <div class="col-md-6">
    <div id="show_error"></div>
    <div id="overlay1">
      <div id="text"></div>
    </div>
    <div class="card ">
      <div class="card-header <?php echo $culor;?> text-white">
        <dt><?=$card1;?></dt>
      </div>
      <div class="card-body" id="check-height">
        <form class="needs-validation" novalidate id="eform">

          <div id="org-data">
            <input type="hidden" name="data_org[]" class="org_id" value="<?=$val_eform['data_org'][0];?>">
            <input type="hidden" name="data_org[]" class="main_id" value="<?=$val_eform['data_org'][1];?>">
            <input type="hidden" name="data_org[]" class="pid_id" value="<?=$val_eform['data_org'][2];?>">
            <input type="hidden" name="data_org[]" class="position_id" value="<?=$val_eform['data_org'][3];?>">
            <input type="hidden" name="data_org[]" class="rate_id" value="<?=$val_eform['data_org'][4];?>">
            <input type="hidden" name="data_org[]" class="img-person" value="<?=$val_eform['data_org'][5];?>">
          </div>
          <div class="row">
            <?php if (!empty($data_loop)): ?>
              <?php if (count($data_loop)>0): ?>
                <?php foreach ($data_loop as $col) : ?>

                  <?php
                  $typeinput = array("select");
                  $typeinput_rc = array("radio","checkbox");
                  if (in_array($col['type'], $typeinput)) {
                    $req_text = 'เลือก';
                  }else {
                    if (in_array($col['templateOptions']['type'], $typeinput_rc)) {
                      $req_text = 'เลือก';
                    }else{
                      $req_text = 'กรอก';
                    }

                  }

                  if ($col['templateOptions']['required']==true) {
                    $req = 'required oninvalid="this.setCustomValidity(\''.$req_text.$col['templateOptions']['placeholder'].'\')" oninput="setCustomValidity(\'\')"';
                  }else{
                    $req = "";
                  }

                  ?>
                  <div class="<?=$col['className'];?> mb-3">
                    <label for="<?=$col['key'];?>"><?=$col['templateOptions']['label'];?> :</label>
                    <?php if ($col['type']=='input'): ?>
                      <?php if ($col['templateOptions']['type']!=null): ?>
                        <?php if ($col['templateOptions']['type']=='date'): ?>
                          <input type="text" readonly="" class="form-control datepicker_input" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" <?=$req;?> value="<?=$val_eform[$col['key']];?>">
                          <?php elseif($col['templateOptions']['type']=='radio'): ?>
                            <br>
                            <?php foreach ($col['templateOptions']['options'] as $key => $options): ?>
                              <?php  $req_main = ($key == 0) ? 'required' : '';
                              $checked = ($val_eform[$col['key']] == $options['label']) ? 'checked' : '';
                              ?>
                              <input type="<?=$col['templateOptions']['type'];?>" class="form-control class_radio" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" value="<?=$options['label'];?>" <?=$req_main;?> <?=$checked;?>> <?=$options['label'];?>&nbsp;&nbsp;
                            <?php endforeach ?>

                            <?php elseif($col['templateOptions']['type']=='checkbox'): ?>
                              <br>
                              <?php
                              $ci = 0;
                              foreach ($col['templateOptions']['options'] as $options): 
                                $checked = ($val_eform[$col['key']][$ci] == $options['label']) ? 'checked' : '';
                                ?>
                                <input type="<?=$col['templateOptions']['type'];?>" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" class="form-control class_radio" name="<?=$col['key'];?>[]" value="<?=$options['label'];?>" <?=$checked;?>> <?=$options['label'];?>&nbsp;&nbsp;
                                <?php
                                $ci++;
                              endforeach ?>
                              <?php else: ?>  
                                <input type="number" class="form-control" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" <?=$req;?> value="<?=$val_eform[$col['key']];?>" min="<?=$col['templateOptions']['min'];?>" max="<?=$col['templateOptions']['max'];?>">
                              <?php endif ?>
                              <?php else: ?>
                                <input type="text" class="form-control" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" <?=$req;?> value="<?=$val_eform[$col['key']];?>" maxlength="<?=$col['templateOptions']['maxlength'];?>">
                              <?php endif ?>

                              <?php elseif($col['type']=='textarea'): ?>
                                <?php $type_textarea = ($col['templateOptions']['type_textarea']>0) ? 'summernote' : 'form-control';
                                $val_textarea = str_replace("-/-/-","'",$val_eform[$col['key']]);
                                $val_textarea2 = str_replace("*/*/*","'",$val_textarea);
                                ?>
                                <textarea class="<?=$type_textarea;?> type_textarea" data-id="<?=$col['key'];?>" rows="<?=$col['templateOptions']['rows'];?>" <?=$req;?> maxlength="<?=$col['templateOptions']['maxlength'];?>"><?=$val_textarea2;?></textarea>
                                <!-- name="<?=$col['key'];?>" -->
                              <?php elseif($col['type']=='latlong'): 
                                $have_map = 1;
                                ?>
                                <br>
                                <div class="row" id="showmap">
                                  <div class="col-md-4">
                                    <input type="text" name="latitude" maxlength="40" id="latitude" class="form-control" placeholder="กรอกละติจูด" value="<?=$val_eform['latitude'];?>" onkeypress="return validateQty(this,event);" <?=$req;?>>
                                  </div>
                                  <div class="col-md-4">
                                    <input type="text" name="longitude" maxlength="40" id="longitude" class="form-control" placeholder="กรอกลองติจูด" value="<?=$val_eform['longitude'];?>" onkeypress="return validateQty(this,event);" <?=$req;?>>
                                    <input type="hidden" value="<?=$col['templateOptions']['urlmarker'];?>" name="urlmarker" id="urlmarker">
                                  </div>
                                  <?php if ($have_map>0): ?>
                                    <div class="col-xl-12 col-lg-12">
                                      <div class="card card-collapsed remove_collapsed">
                                        <div class="card-header">
                                          <h3 class="card-title"><dt><i class="fa fa-map-marker" style="color: #dc3545 !important;"></i> เลือกพิกัดจากแผนที่ (ละติจูด , ลองจิจูด)</dt></h3>
                                          <div class="card-options">
                                            <div class="show-hide">
                                              <a href="#showmap" class="card-options-collapse open_map"><i class="fe fe-chevron-up"></i></a>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card-body">
                                          <link
                                          data-require="leaflet@0.7.3"
                                          data-semver="0.7.3"
                                          rel="stylesheet"
                                          href="../../leaflet-0.7.3/leaflet.css"
                                          />
                                          <script
                                          data-require="leaflet@0.7.3"
                                          data-semver="0.7.3"
                                          src="../../leaflet-0.7.3/leaflet.js"
                                          ></script>


                                          <div id="mapid" style="width: 100%; height: 500px;"></div>    
                                          <script>
                                            $(document).ready(function(){

                                              var mymap = null;

                                              $(document).on('click', '.open_map', function(){
                                                $(".show-hide").html(`
                                                  <a href="#showmap" class="card-options-collapse close_mep"><i class="fa fa-angle-up"></i></a>
                                                  `);

                                                $(".remove_collapsed").removeClass("card-collapsed");
                                                if (mymap==null) {loadmap();}else{
                                                }
                                              });


                                              $(document).on('focusin', '#latitude', function(){
                                                $(".show-hide").html(`
                                                  <a href="#showmap" class="card-options-collapse close_mep"><i class="fa fa-angle-up"></i></a>
                                                  `);

                                                $(".remove_collapsed").removeClass("card-collapsed");
                                                if (mymap==null) {loadmap();}else{
                                                }
                                              });

                                              $(document).on('focusin', '#longitude', function(){
                                                $(".show-hide").html(`
                                                  <a href="#showmap" class="card-options-collapse close_mep"><i class="fa fa-angle-up"></i></a>
                                                  `);

                                                $(".remove_collapsed").removeClass("card-collapsed");
                                                if (mymap==null) {loadmap();}else{
                                                }
                                              });

                                              $(document).on('click', '.close_mep', function(){
                                                $(".show-hide").html(`
                                                  <a href="#showmap" class="card-options-collapse open_map"><i class="fe fe-chevron-up"></i></a>
                                                  `);

                                                $(".remove_collapsed").addClass("card-collapsed");
                                              });

                                              function loadmap(){
                                                mymap = L.map('mapid').setView([13.732564, 100.515000], 5);

                                                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                                                  maxZoom: 19,
                                                  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                                  '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                                  'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                                  id: 'mapbox/streets-v11',
                                                  tileSize: 512,
                                                  zoomOffset: -1
                                                }).addTo(mymap);



                                                var popup = L.popup();

                                                function onMapClick(e) {
                                                  popup
                                                  .setLatLng(e.latlng)
                                                  .setContent("ตำแหน่งที่ตั้ง " + e.latlng.toString())
                                                  .openOn(mymap);
                                                  var latlng = e.latlng.toString().replace('LatLng(', "");
                                                  latlng = latlng.toString().replace(')', "");
                                                  latlng = latlng.toString().split(",");
                                                  document.getElementById('latitude').value = latlng[0];
                                                  document.getElementById('longitude').value = latlng[1];
                                                }

                                                mymap.on('click', onMapClick);

                                              }



                                            });

                                          </script>
                                        </div>
                                      </div>
                                    </div>
                                  <?php endif ?>
                                </div>
                              <?php elseif($col['type']=='idcard'):
                                ?>
                                <input type="text" class="form-control card_number" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" <?=$req;?> value="<?=$val_eform[$col['key']];?>" onkeypress="return isNumber(event)">

                                <script>
                                  function isNumber(evt) {
                                    evt = (evt) ? evt : window.event;
                                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                      return false;
                                    }
                                    return true;
                                  }
                                  function cardFormat() {
                                    if ($(this).val().length > 4 && $(this).val().indexOf('-') === -1) {
                                      var format_card = $(this).val().replace(/(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})/, "$1-$2-$3-$4-$5");
                                      $(this).attr('maxlength', 17);
                                      $(this).val(format_card);
                                      if ($(this).val() == '' ||
                                        $(this).val().match(format_card) ||
                                        $(this).val().length == 0) {
                                        console.log("invalid");
                                    } else {
                                      console.log("valid");
                                    }
                                  }else{
                                    $(this).attr('maxlength', 17);
                                  }
                                }

                                $(".card_number").on('input blur', cardFormat);

                              </script>

                            <?php elseif($col['type']=='address'): 
                              $nameaddress = $col["key"];
                              ?>
                              <div class="row" style="font-weight: 100 !important;">
                                <input type="hidden" value="<?=$col['key'];?>" class="nameaddress">
                                <div class="col-md-2 text-right-align">
                                  เลขที่ : 
                                  <?php $nameaddress_no = $nameaddress."_no"; ?>
                                </div>
                                <div class="col-md-9">
                                  <input type="text" name="<?=$col['key'];?>_no" maxlength="50" id="<?=$col['key'];?>_no" class="form-control" placeholder="เลขที่" value="<?=$val_eform[$nameaddress_no];?>" <?=$req;?>>
                                </div>
                                <div class="col-md-2 pt-1 text-right-align">
                                  หมู่บ้าน : 
                                  <?php $nameaddress_mooban = $nameaddress."_mooban"; ?>
                                </div>
                                <div class="col-md-9 pt-1">
                                  <input type="text" name="<?=$col['key'];?>_mooban" maxlength="150" id="<?=$col['key'];?>_mooban" class="form-control" placeholder="หมู่บ้าน" value="<?=$val_eform[$nameaddress_mooban];?>" <?=$req;?>>
                                </div>
                                <div class="col-md-2 pt-1 text-right-align">
                                  จังหวัด :
                                  <?php $nameaddress_province = $nameaddress."_province";
                                  $nameaddress_province_code = $nameaddress."_province_code";
                                  ?>
                                </div>
                                <div class="col-md-9 pt-1">
                                  <input type="hidden" name="<?=$col['key'];?>_province_code" id="<?=$col['key'];?>_province_code" class="form-control" value="<?=$val_eform[$nameaddress_province_code];?>">
                                  <?php $provine = Yii::$app->db->createCommand("SELECT id,code,name_th FROM `provinces` ORDER BY name_th ASC")->queryAll(); 
                                  ?>
                                  <select name="<?=$col['key'];?>_province" id="<?=$col['key'];?>_province" class="form-control select__province" <?=$req;?>>
                                    <option value="">
                                      เลือกจังหวัด
                                    </option>
                                    <?php foreach ($provine as $val_province): 
                                      $selected = ($val_eform[$nameaddress_province]==$val_province['name_th']) ? 'selected' : '';
                                      ?>
                                      <option value="<?=$val_province['name_th']?>" <?=$selected;?> data-id="<?=$val_province['id']?>"  data-code="<?=$val_province['code']?>">
                                        <?=$val_province['name_th']?>
                                      </option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                                <div class="col-md-2 pt-1 text-right-align">
                                  อำเภอ : 
                                  <?php 
                                  $nameaddress_amphoe = $nameaddress."_amphoe";
                                  $nameaddress_amphoe_code = $nameaddress."_amphoe_code";
                                  ?>
                                </div>
                                <div class="col-md-9 pt-1">
                                  <input type="hidden" name="<?=$col['key'];?>_amphoe_code" id="<?=$col['key'];?>_amphoe_code" class="form-control" value="<?=$val_eform[$nameaddress_amphoe_code];?>">
                                  <select name="<?=$col['key'];?>_amphoe" id="<?=$col['key'];?>_amphoe" class="form-control select__amphoe" <?=$req;?>>
                                    <?php if ($val_eform[$nameaddress_amphoe]!=''): ?>
                                      <option value="<?=$val_eform[$nameaddress_amphoe];?>">
                                        <?=$val_eform[$nameaddress_amphoe];?>
                                      </option>
                                      <?php else: ?>
                                        <option value="">
                                          เลือกอำเภอ
                                        </option>
                                      <?php endif ?>
                                    </select>
                                  </div>
                                  <div class="col-md-2 pt-1 text-right-align">
                                    ตำบล : 
                                    <?php $nameaddress_tombon = $nameaddress."_tombon"; 
                                    $nameaddress_tombon_code = $nameaddress."_tombon_code";
                                    ?>
                                  </div>
                                  <div class="col-md-9 pt-1">
                                    <input type="hidden" name="<?=$col['key'];?>_tombon_code" id="<?=$col['key'];?>_tombon_code" class="form-control" value="<?=$val_eform[$nameaddress_tombon_code];?>">
                                    <select name="<?=$col['key'];?>_tombon" id="<?=$col['key'];?>_tombon" class="form-control select__tombon" <?=$req;?>>
                                      <?php if ($val_eform[$nameaddress_tombon]!=''): ?>
                                        <option value="<?=$val_eform[$nameaddress_tombon];?>">
                                          <?=$val_eform[$nameaddress_tombon];?>
                                        </option>
                                        <?php else: ?>
                                          <option value="">
                                            เลือกตำบล
                                          </option>
                                        <?php endif ?>
                                      </select>
                                    </div>

                                    <script>
                                      $(document).ready(function(){

                                        <?php if (isset($_GET['eform_data'])): ?>
                                          get_amphures($("#address_province_code").val(),$("#address_amphoe_code").val());
                                          get_districts($("#address_amphoe_code").val(),$("#address_tombon_code").val());
                                        <?php endif ?>

                                        $(document).on('change', '.select__province', function(){
                                          var id = $(this).find(':selected').data('id');
                                          var code = $(this).find(':selected').data('code');
                                          var name_id = $(this).attr('id');
                                          $("#"+name_id+"_code").val(id);
                                          if (id!=undefined) {
                                            get_amphures(id,'');
                                          }
                                        });

                                        $(document).on('click', '.select__amphoe', function(){
                                          var id = $(this).find(':selected').data('id');
                                          var code = $(this).find(':selected').data('code');
                                          var name_id = $(this).attr('id');
                                          $("#"+name_id+"_code").val(id);
                                          if (id!=undefined) {
                                            get_districts(id,'');
                                          }
                                        });

                                        function get_amphures(id,idselect){
                                          $.ajax({
                                            url:"index.php?r=site/json_dynamic_select&type=get_amphures&province_id="+id+"&idselect="+idselect,
                                            method:"GET",
                                            success:function(data)
                                            {
                                              $(".select__amphoe").html(data);
                                            }
                                          });
                                        }

                                        function get_districts(id,idselect){
                                          $.ajax({
                                            url:"index.php?r=site/json_dynamic_select&type=get_districts&amphure_id="+id+"&idselect="+idselect,
                                            method:"GET",
                                            success:function(data)
                                            {
                                              $(".select__tombon").html(data);
                                            }
                                          });
                                        }

                                        $(document).on('click', '.select__tombon', function(){
                                          var id = $(this).find(':selected').data('id');
                                          var code = $(this).find(':selected').data('code');
                                          var name_id = $(this).attr('id');
                                          $("#"+name_id+"_code").val(id);
                                        });

                                      });
                                    </script>

                                  </div>
                                <?php elseif($col['type']=='birthday'):
                                  ?>
                                  <input type="text" readonly="" class="form-control datepicker_input birthday" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" <?=$req;?> value="<?=$val_eform[$col['key']];?>">
                                  <input type="hidden" class="get_val_datetime">
                                  <div class="show_age"></div>


                                  <script>
                                    $(document).on('change', '.birthday', function(){
                                      var birthday = $('.get_val_datetime').val();
                                      var d1 = new Date();
                                      var d2 = new Date(birthday)
                                      var d3 = yearsDiff(d2, d1);
                                      if (!isNaN(d3)) {
                                        $('.show_age').html('อายุปัจจุบัน '+d3+' ปี');
                                      }else{
                                        $('.show_age').html('');
                                      }

                                      function yearsDiff(d1, d2) {
                                        let date1 = new Date(d1);
                                        let date2 = new Date(d2);
                                        let yearsDiff =  date2.getFullYear() - date1.getFullYear();
                                        return yearsDiff;
                                      }

                                    });
                                  </script>
                                  <?php else: ?>

                                    <?php if ($col['templateOptions']['model']!=null): ?>
                                      <?php
                                      $id_column = $col['templateOptions']['model']['id'];
                                      $type_column = $col['templateOptions']['model']['type_name'];
                                      $table_column = $col['templateOptions']['model']['table'];
                                      $sql_select = "SELECT $id_column,$type_column FROM $table_column";
                                      $query_select = Yii::$app->db->createCommand($sql_select)->queryAll();
                                      ?>
                                      <select class="form-control" <?=$req;?> id="<?=$col['key'];?>" name="<?=$col['key'];?>">
                                        <option value="">เลือก<?=$col['templateOptions']['placeholder'];?></option>
                                        <?php foreach ($query_select as $val_name): 
                                          $selected = ($val_eform[$col['key']]==$val_name[$type_column]) ? 'selected' : '';
                                          ?>
                                          <option value="<?=$val_name[$type_column];?>" <?=$selected;?>><?=$val_name[$type_column];?></option>
                                          <!-- <?=$val_name[$id_column];?> -->
                                        <?php endforeach ?>
                                      </select>
                                      <?php else: ?>
                                        <select class="form-control" <?=$req;?> id="<?=$col['key'];?>" name="<?=$col['key'];?>">
                                          <option value="">เลือก<?=$col['templateOptions']['placeholder'];?></option>
                                          <?php foreach ($col['templateOptions']['options'] as $options): 
                                            $selected = ($val_eform[$col['key']]==$options['label']) ? 'selected' : '';
                                            ?>
                                            <option value="<?=$options['label'];?>" <?=$selected;?>><?=$options['label'];?></option>
                                          <?php endforeach ?>
                                        </select> 
                                      <?php endif; ?>


                                    <?php endif; ?>


                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"><?=$req_text;?> <?=$col['templateOptions']['placeholder'];?>.</div>
                                  </div>



                                <?php endforeach ?>
                              <?php endif ?>
                            <?php endif ?>

                            <input type="hidden" name="form_id" id="form_id" value="<?=$id;?>">

                            <input type="hidden" name="eform_id" id="eform_id" value="<?=$query['id'];?>">

                            <input type="hidden" name="eform_version" id="eform_version" value="<?=$query['version'];?>">

                            <?php $user_detail = Yii::$app->db->createCommand("SELECT * FROM `users` WHERE id = '".$_SESSION['user_id']."'")->queryOne();  
                            $unit_detail = Yii::$app->db->createCommand("SELECT * FROM `unit` WHERE unit_id = '".$_SESSION['unit_id']."'")->queryOne();
                            ?>

                            <?php $user_create_id = (!isset($_GET['eform_data'])) ? $_SESSION['user_id'] : $val_eform['user_create_id']; ?>
                            <input type="hidden" name="user_create_id" id="user_create_id" value="<?=$user_create_id;?>">

                            <?php $user_create_name = (!isset($_GET['eform_data'])) ? $user_detail['name'] : $val_eform['user_create_name']; ?>
                            <input type="hidden" name="user_create_name" id="user_create_name" value="<?=$user_create_name;?>">

                            <?php $unit_id = (!isset($_GET['eform_data'])) ? $_SESSION['unit_id'] : $val_eform['unit_id']; ?>
                            <input type="hidden" name="unit_id" id="unit_id" value="<?=$unit_id;?>">

                            <?php $unit_name = (!isset($_GET['eform_data'])) ? $unit_detail['unit_name'] : $val_eform['unit_name']; ?>
                            <input type="hidden" name="unit_name" id="unit_name" value="<?=$unit_name;?>">

                            <?php $date_record_create = (!isset($_GET['eform_data'])) ? date("Y-m-d H:i:s") : $val_eform['date_record']; ?>
                            <input type="hidden" name="date_record" id="date_record" value="<?=$date_record_create;?>">

                            <?php if (!isset($_GET['eform_data'])): ?>
                              <input type="hidden" name="approve" id="approve" value="">
                              <!-- <input type="hidden" name="status_request_information" id="status_request_information" value="0"> -->
                              <?php else: ?>
                                <?php //var_dump($val_eform['request_information']); ?>
                                <?php //var_dump($val_eform['approve']); ?>

                                <?php if (!empty($val_eform['news_value'])): ?>
                                  <input type="hidden" name="news_value" id="news_value" value="<?=$val_eform['news_value'];?>">
                                <?php endif ?>


                              <?php endif ?>



                            </div>

                            <?php //if ($_SESSION['user_role']=='3'): ?>
                            <div class="btn-group">
                              <button type="submit" class="btn btn-primary">บันทึก</button>
                              <button type="reset" class="btn btn-light">ล้างค่า</button>
                            </div>
                            <?php //endif ?>

                          </form>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-6">

                      <div class="card">
                        <div id="overlay1"></div>
                        <div class="card-header <?php echo $culor;?> text-white">ข้อมูลองค์กร</div> 
                        <div class="card-body">
                          <?php

                          $organization = Yii::$app->db->createCommand("SELECT * FROM organization")->queryAll();

                          ?>
                          <div class="multiselect_div">
                            <label for="organization_id"></label>
                            <select class="form-control multiselect multiselect-custom" id="organization_id" name="organization_id" onchange="getdata_organization(this.value);">
                              <option value="">เลือกองค์กร</option>
                              <?php foreach ($organization as $org): 
                                $selected_org = ($org['id']==$val_eform['data_org'][0]) ? 'selected' : '';
                                ?>
                                <option value="<?=$org['id'];?>" <?=$selected_org;?>><?=$org['name']?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                          <div style="width:100%;" id="tree"> </div>
                          <div id="box_show_level"></div>
                          <div id="box_show_position"></div>
                          <div id="box_show_rate"></div>
                        </div>
                      </div>


                      <div class="card ">
                        <div id="overlay2">
                        </div>
                        <div class="card-header <?php echo $culor;?> text-white">
                          <dt><?=$card2;?></dt>
                        </div>
                        <div class="card-body">
                          <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" name="multiple_files" id="multiple_files" multiple="multiple" required="required"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                          <input type="hidden" name="id_sql_eform" id="id_sql_eform" value="<?=$eform_id;?>">
                          <div class="show-status text-center"></div>
                          <div class="list-design">
                            <div class="row row-cards list-show-process" id="showfiles">
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-12 text-center" id="insert_success">
                    </div>




                  </div>


                  <script>


                    function convertDate(date){
                      var date_auth =
                      date.getFullYear() + "" +
                      ("00" + (date.getMonth() + 1)).slice(-2) + "" +
                      ("00" + (date.getDate()+ 1)).slice(-2) + "" +
                      ("00" + date.getHours()).slice(-2) + "" +
                      ("00" + date.getMinutes()).slice(-2) + "" +
                      ("00" + date.getSeconds()).slice(-2);

                      return date_auth;
                    }

                    var monthShortNames = ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];


                    function dateFormat(d) {
                      var t = new Date(d);
                      return t.getDate() + ' ' + monthShortNames[t.getMonth()] + ' ' +(t.getFullYear()+543)+' / '+t.getHours()+':'+t.getMinutes()+':'+t.getSeconds()+' น.';
                    }

                    $(document).ready(function(){

                      [].forEach.call(document.getElementsByTagName("textarea"), function(textarea) {
                        textarea.addEventListener("input", function() {
                          textarea.value = textarea.value.replace(/\n/g, "<br>").replace(/ /g, " ");
                        });
                      });

                      $(document).ready(function(){

                        window.addEventListener('load', function() {

                          var forms = document.getElementsByClassName('needs-validation');

                          var validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                              if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                              }else{
                                event.preventDefault();
                                const f = Array.from(new FormData(event.target));
                                const obj = f.reduce((o, [k, v]) => {
                                  let a = v,
                                  b, i,
                                  m = k.split('['),
                                  n = m[0],
                                  l = m.length;
                                  if (l > 1) {
                                    a = b = o[n] || [];
                                    for (i = 1; i < l; i++) {
                                      m[i] = (m[i].split(']')[0] || b.length) * 1;
                                      b = b[m[i]] = ((i + 1) == l) ? v : b[m[i]] || [];
                                    }
                                  }
                                  return { ...o, [n]: a };
                                }, {});

                                <?php if (empty($eform_id)): ?>
                                  insert_eform_data(obj);
                                  <?php else: ?>
                                    update_eform_data(obj)
                                  <?php endif ?>
                                }
                                form.classList.add('was-validated');
                              }, false);
                          });



                        }, false);
                      });

                      checkid_file();
                      function checkid_file(){
                        var id_sql_eform = $("#id_sql_eform").val();
                        if (id_sql_eform!='') {
                          $("#overlay2").css({display: 'none'});
                          load_data_files();
                        }
                      }

                      var clientHeight = document.getElementById('check-height').clientHeight;
                      var height_inlist = parseInt(clientHeight-239.66);
                      $('#showfiles').css({height: (height_inlist-120)});

                      var showlist_files = [];

                      function load_data_files(){
                        var id_sql_eform = $("#id_sql_eform").val();
                        $.ajax({
                          url:"index.php?r=site/insert_file_upload_list_type&type=showlistdata&eform_data_id="+id_sql_eform,
                          method:"GET",
                          dataType:"json",
                          contentType: "application/json; charset=utf-8",
                          success:function(data)
                          {
                            if (data.length>0) {
                              $.each(data, function(index) {
                                showfiles(data[index].file_name,data[index].file_id,data[index].bucket,data[index].origin_file_name);
                              });
                            }else{
                              $("#showfiles").html("");
                            }
                          }
                        });
                      }

                      var count = 0;
                      $(document).on('change', '#multiple_files', function(){
                        upload();
                        count = 0;
                      });

                      function upload() {
                        showlist_files = [];
                        var files = document.querySelector("#multiple_files").files;
                        var file_all = files.length;
                        var namebucket = '';
                        var nameold = '';
                        for (var i = 0; i < files.length; i++) {
                          var file = files[i];
                          var name = files[i].name;
                          nameold = name;
                          var ext = name.split('.').pop().toLowerCase();
                          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) != -1) 
                          {
                            namebucket = 'image';
                          }else if(jQuery.inArray(ext, ['doc','docx','xls','xlsx','ppt','pptx']) != -1) {
                            namebucket = 'office';
                          }else if(jQuery.inArray(ext, ['pdf']) != -1) {
                            namebucket = 'pdf';
                          }else if(jQuery.inArray(ext, ['csv']) != -1) {
                            namebucket = 'csv';
                          }else{
                            namebucket = 'other';
                          }
                          var namefile = convertDate(new Date()) +'-' +Date.now()+ '.'+ext;


                          retrieveNewURL(file_all,namebucket,namefile,nameold,file, (file, url,namebucket,namefile,nameold) =>{

                            uploadFile(nameold,namebucket,namefile,file_all,file, url);
                            $('.show-status').html(`
                              <div class="alert alert-secondary alert-dismissible">
                              <div class="spinner-grow text-dark" style="width: 3rem; height: 3rem;" role="status">
                              <span class="sr-only">Loading...</span>
                              </div>
                              <h6 class="mt-3"><dt>กำลังอัพโหลดไฟล์ ${count}/${file_all}</dt></h6>
                              </div>
                              `);
                          });

                        }

                      }

                      function retrieveNewURL(file_all,namebucket,namefile,nameold, file, cb) {

                        fetch(`<?=$url_node['setting_value'];?>/uploadminio?name=${file.name}&bucket=${namebucket}&namefile=${namefile}`).then((response) => {
                          response.text().then((url) => {
                            cb(file, url,namebucket,namefile,nameold);
                          });
                        }).catch((e) => {
                          console.error(e);
                        });
                      }

                      function uploadFile(namefileold,namebucket,namefile,file_all,file, url) {
                        fetch(url, {
                          method: 'PUT',
                          body: file
                        }).then(() => {
                          count = count+1;
                          if (count==file_all) {
                            $('.show-status').html(`
                              <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert"></button>
                              <h6 class="mt-1"><dt><i class="fas fa-check-circle fa-1x"></i> อัพโหลดไฟล์สำเร็จ</dt></h6>
                              </div>
                              `);
                          }else{
                            $('.show-status').html(`
                              <div class="alert alert-secondary alert-dismissible">
                              <div class="spinner-grow text-dark" style="width: 3rem; height: 3rem;" role="status">
                              <span class="sr-only">Loading...</span>
                              </div>
                              <h6 class="mt-3"><dt>กำลังอัพโหลดไฟล์ ${count}/${file_all}</dt></h6>
                              </div>
                              `);
                          }
                          insertDatabase(namefile,namebucket,count,file_all,namefileold)
                        }).catch((e) => {
                          console.error(e);
                        });
                      }

                      function insertDatabase(namefile,namebucket,count,file_all,namefileold){
                        var id_sql_eform = $("#id_sql_eform").val();
                        var form_id = $("#form_id").val();
                        $.ajax({
                          url:"index.php?r=site/insert_file_upload_list_type&type=insert&namefile="+namefile+"&namebucket="+namebucket+"&form_id="+form_id+"&eform_data_id="+id_sql_eform+"&unitid=<?=$_SESSION['unit_id'];?>&usercreate=<?=$_SESSION['user_id'];?>&status_upload=1&namefileold="+namefileold,
                          method:"GET",
                          dataType:"json",
                          contentType: "application/json; charset=utf-8",
                          success:function(data)
                          {
                            if (count==file_all) {
                              load_data_files();
                            }
                          }
                        });
                      }

                      function showfiles(file_name,file_id,bucket,origin_file_name) {
                        $.ajax({
                          url:"<?=$url_node['setting_value'];?>/filepathminio?namefile="+file_name+"&bucket="+bucket,
                          method:"GET",
                          dataType:"json",
                          contentType: "application/json; charset=utf-8",
                          success:function(data)
                          {
                            var showdata = '';
                            var btnset = '';
                            var checkmain = '';

                            if ($(".img-person").val()==file_name) {
                              checkmain = '<div style="background: #ffc107;padding: 2px 8px;position: absolute;">ภาพหลัก</div>';
                            }
                            if (bucket=='image') {
                              showdata = '<img src="'+data.url+'" alt="'+origin_file_name+'" class="rounded img-show-img">';
                              btnset = '<a href="javascript:void(0)" class="icon setmain" style="color: #007bff !important;" data-file-id="'+file_id+'" data-name-file="'+file_name+'" data-name-bucket="'+bucket+'" title="ตั้งเป็นภาพหลักแสดงในองค์กร"><i class="fa fa-thumb-tack mr-1"></i></a>';
                            }else{
                              showdata = '<img src="../../images/document.png" alt="'+origin_file_name+'" class="rounded img-show-img"><small>'+origin_file_name+'</small>';
                              btnset = '';
                            }
                            showlist_files.push('<div class="col-sm-6 col-lg-3 pt-3">'+checkmain+'<a href="'+data.url+'" target="_blank">'+showdata+'</a><div class="ml-auto text-muted mt-2">'+btnset+'<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3 deldata text-danger" style="color: #dc3545 !important;" data-file-id="'+file_id+'" data-name-file="'+file_name+'" data-name-bucket="'+bucket+'"><i class="fa fa-trash mr-1"></i></a></div></div>');
                            $("#showfiles").html(showlist_files.join(""));
                          }


                        });

                      }

                      $(document).on('click', '.setmain', function(){
                        var file_id = $(this).data("file-id");
                        var namefile = $(this).data("name-file");
                        var bucket = $(this).data("name-bucket");
                        
                        if(confirm("ต้องการตั้งเป็นภาพหลักแสดงในองค์กรใช่หรือไม่?"))
                        {
                          showlist_files = [];
                          $('.img-person').val(namefile);
                          load_data_files();
                          alert('กรุณาบันทึกข้อมูลใหม่อีกครั้ง');
                        }
                      });

                      $(document).on('click', '.deldata', function(){
                        var file_id = $(this).data("file-id");
                        var namefile = $(this).data("name-file");
                        var bucket = $(this).data("name-bucket");
                        showlist_files = [];
                        if(confirm("ต้องการลบไฟล์ใช่หรือไม่?"))
                        {
                          $.ajax({
                            url:"<?=$url_node['setting_value'];?>/removefileminio?namefile="+namefile+"&bucket="+bucket,
                            method:"GET",
                            dataType:"json",
                            contentType: "application/json; charset=utf-8",
                            success:function(data)
                            {
                              deleteDatabase(file_id);
                            }
                          });
                        }
                      });

                      function deleteDatabase(file_id){
                        $.ajax({
                          url:"index.php?r=site/insert_file_upload_list_type&type=delete&file_id="+file_id,
                          method:"GET",
                          success:function(data)
                          {
                            load_data_files();
                            alert('ลบไฟล์สำเร็จ');
                          }
                        });
                      }


                      function insert_eform_data(data_object){
                        var org_id = $(".org_id").val();
                        var level_id = $(".pid_id").val();
                        var position_id = $(".position_id").val();
                        var rate_id = $(".rate_id").val();
                        
                        // if (org_id!="" && level_id!="" && position_id!="" && rate_id!="") {


                          data_object['files'] = "";
                          var user_create = $('#user_create').val();
                          var form_id = $('#form_id').val();
                          var eform_id = $('#eform_id').val();

                          var latitude = $('#latitude').val();
                          var coor = null;
                          var data_json = null;
                          var data_object_use = null;

                          if (latitude!=null) {
                            coor = `"coor": {"lat": "${$('#latitude').val()}","lon": "${$('#longitude').val()}"}`;

                            var json_de = JSON.stringify(data_object);
                            var first = json_de.substring(1);
                            var end = first.slice(0, -1);
                            var data_json_use = "{"+end+","+coor+"}";
                            obj_data_json_use = JSON.parse(data_json_use);
                            data_json = JSON.stringify(obj_data_json_use);
                            data_object_use = obj_data_json_use;

                          }else{

                            data_json = JSON.stringify(data_object);
                            data_object_use = data_object;

                          }

                          var address_real = '';
                          $(".nameaddress").each(function() {
                            var nameaddress = $(this).val();
                            address_real += `"${nameaddress}": {"no": "${$('#'+nameaddress+'_no').val()}","mooban": "${$('#'+nameaddress+'_mooban').val()}","tombon": "${$('#'+nameaddress+'_tombon').val()}","tombon_code": "${$('#'+nameaddress+'_tombon_code').val()}","amphoe": "${$('#'+nameaddress+'_amphoe').val()}","amphoe_code": "${$('#'+nameaddress+'_amphoe_code').val()}","provine": "${$('#'+nameaddress+'_province').val()}","provine_code": "${$('#'+nameaddress+'_province_code').val()}"},`;
                          });
                          var res_use = address_real.slice(0, -1);
                          if (address_real.length>0) {
                            var json_de = JSON.stringify(data_object_use);
                            var first = json_de.substring(1);
                            var end = first.slice(0, -1);
                            var data_json_use = "{"+end+","+res_use+"}";
                            obj_data_json_use = JSON.parse(data_json_use);
                            data_json = JSON.stringify(obj_data_json_use);
                            data_object_use = obj_data_json_use;
                          }


                          var textarea_all = '';
                          $(".type_textarea").each(function( index ) {
                            var val_textarea = $(this).val();
                            var key = $(this).attr('data-id');
                            var res = val_textarea.replace(/\"/g,'-/-/-');
                            var res2 = res.replace(/'/g,'*/*/*');
                            var str = res2.replace(/\n/g, "<br>").replace(/ /g, " ");
                            textarea_all += `"${key}": "${str}",`
                          });

                          var textarea_all_use = textarea_all.slice(0, -1);
                          if (textarea_all_use.length>0) {
                            var json_de = JSON.stringify(data_object_use);
                            var first = json_de.substring(1);
                            var end = first.slice(0, -1);
                            var data_json_use = "{"+end+","+textarea_all_use+"}";
                            obj_data_json_use = JSON.parse(data_json_use);
                            data_json = JSON.stringify(obj_data_json_use);
                            data_object_use = obj_data_json_use;
                          }

                          console.log(data_object_use);

                          $.ajax({
                            url:"index.php?r=site/insert_file_upload_list&type=insert_eform",
                            data:{form_id:form_id,eform_id:eform_id,user_create:user_create,data_json:data_json,data_object:data_object_use},
                            type: 'post',
                            dataType: 'json',
                            success:function(data)
                            {
                              if (data.status==1) {
                                $("#id_sql_eform").val(data.id_sql_eform);
                                $("#overlay2").css({display: 'none'});
                                $("#overlay1").css({display: 'block'});
                                $("#text").html('<i class="fas fa-check-circle fa-3x"></i><h6 class="mt-3">บันทึกข้อมูลสำเร็จ</h6><div class="btn-group btn-group-xs"> <a href="index.php?r=site/pages&view=eform_dataperson&form_id=<?=$id;?>" class="btn btn-primary text-white">เพิ่มข้อมูลใหม่</a> <a href="index.php?r=eform-data/view-person&id='+data.id_sql_eform+'" class="btn btn-warning text-dark">รายละเอียด</a></div>');

                              }else{
                                $("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
                              }
                            }
                          });


                        // }else{
                        //   $("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ต้องกรอกข้อมูลเกี่ยวกับองค์กรให้ครบถ้วน <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
                        // }

                      }



                      function convertDateView(date){
                        var date_auth =
                        date.getFullYear() + "-" +
                        ("00" + (date.getMonth() + 1)).slice(-2) + "-" +
                        ("00" + (date.getDate()+ 1)).slice(-2) + " " +
                        ("00" + date.getHours()).slice(-2) + ":" +
                        ("00" + date.getMinutes()).slice(-2) + ":" +
                        ("00" + date.getSeconds()).slice(-2);

                        return date_auth;
                      }


                      function update_eform_data(data_object){
                        console.log(data_object);
                        data_object['files'] = "";
                        var csrfToken = $('meta[name="csrf-token"]').attr("content");
                        var id_sql_eform = $("#id_sql_eform").val();

                        var latitude = $('#latitude').val();
                        var coor = null;
                        var data_json = null;
                        var data_object_use = null;
                        var obj_data_json_use = null;

                        var data_json_for_array_other = '<?=$data_json_for_approve;?>';
                        var data_object_for_array_other =  JSON.parse(data_json_for_array_other);


                        if (latitude!=null) {
                          coor = `
                          "coor": {
                            "lat": "${$('#latitude').val()}",
                            "lon": "${$('#longitude').val()}"
                          }
                          `;

                          var json_de = JSON.stringify(data_object);
                          var first = json_de.substring(1);
                          var end = first.slice(0, -1);
                          var data_json_use = "{"+end+","+coor+"}";
                          obj_data_json_use = JSON.parse(data_json_use);
                          data_json = JSON.stringify(obj_data_json_use);
                          data_object_use = obj_data_json_use;

                        }else{

                          data_json = JSON.stringify(data_object);
                          data_object_use = data_object;

                        }

                        var address_real = '';
                        $(".nameaddress").each(function() {
                          var nameaddress = $(this).val();
                          address_real += `"${nameaddress}": {"no": "${$('#'+nameaddress+'_no').val()}","mooban": "${$('#'+nameaddress+'_mooban').val()}","tombon": "${$('#'+nameaddress+'_tombon').val()}","tombon_code": "${$('#'+nameaddress+'_tombon_code').val()}","amphoe": "${$('#'+nameaddress+'_amphoe').val()}","amphoe_code": "${$('#'+nameaddress+'_amphoe_code').val()}","provine": "${$('#'+nameaddress+'_province').val()}","provine_code": "${$('#'+nameaddress+'_province_code').val()}"},`;
                        });
                        var res_use = address_real.slice(0, -1);
                        if (address_real.length>0) {
                          var json_de = JSON.stringify(data_object_use);
                          var first = json_de.substring(1);
                          var end = first.slice(0, -1);

                          var data_json_use = "{"+end+","+res_use+"}";
                          console.log(data_json_use);
                          obj_data_json_use = JSON.parse(data_json_use);
                          data_json = JSON.stringify(obj_data_json_use);
                          data_object_use = obj_data_json_use;
                        }


                        var first = data_json.substring(1);
                        var end = first.slice(0, -1);

                        if (data_object_for_array_other[0].approve!=undefined) {
                          if (data_object_for_array_other[0].approve.length>0) {
                            if (end.length>0) {
                              var approve_use = '{'+end+',"approve":'+JSON.stringify(data_object_for_array_other[0].approve)+'}';
                              data_json = approve_use;
                              data_object_use = JSON.parse(approve_use);
                            }
                          }
                        }else{
                          if (end.length>0) {
                            var approve_use = '{'+end+',"approve":""}';
                            data_json = approve_use;
                            data_object_use = JSON.parse(approve_use);
                          }
                        }


                        if (data_object_for_array_other[0].request_information!=undefined) {
                          var first = data_json.substring(1);
                          var end = first.slice(0, -1);
                          var request_use = '{'+end+',"request_information":'+JSON.stringify(data_object_for_array_other[0].request_information)+'}';
                          data_json = request_use;
                          data_object_use = JSON.parse(data_json);
                        }


                        var obj = '';
                        if (data_object_for_array_other[0].history!=undefined) {
                          if (data_object_for_array_other[0].history.length>0) {
                            obj = JSON.stringify(data_object_for_array_other[0].history);
                          } else {
                            obj = '[]';
                          }
                        }else{
                          obj = '[]';
                        }

                        var date_view = convertDateView(new Date());

                        var first = obj.substring(1);
                        var end = first.slice(0, -1);

                        var history_use = '';
                        var res_use = `{"date_time":"${date_view}" , "user_view":"<?=$users_data['name'];?>","unit_name":"<?=$users_data['unit_name'];?>","action":"แก้ไข"}`;
                        if (end.length>0) {
                          history_use = "["+end+","+res_use+"]";
                        }else{
                          history_use = "["+res_use+"]";
                        }

                        if (data_object_for_array_other[0].history!=undefined) {
                          var first = data_json.slice(1);
                          var end = first.slice(0,-1);
                          var history = '{'+end+',"history":'+history_use+'}';
                          data_json = history;
                          data_object_use = JSON.parse(data_json);
                        }


                        var textarea_all = '';
                        $(".type_textarea").each(function(index) {
                          var val_textarea = $(this).val();
                          var key = $(this).attr('data-id');
                          var res = val_textarea.replace(/\"/g,'-/-/-');
                          var res2 = res.replace(/'/g,'*/*/*');
                          var str = res2.replace(/\n/g, "<br>").replace(/ /g, " ");
                          textarea_all += `"${key}": "${str}",`;
                        });

                        var textarea_all_use = textarea_all.slice(0, -1);
                        if (textarea_all_use.length>0) {
                          var json_de = JSON.stringify(data_object_use);
                          var first = json_de.substring(1);
                          var end = first.slice(0, -1);
                          var data_json_use = "{"+end+","+textarea_all_use+"}";
                          obj_data_json_use = JSON.parse(data_json_use);
                          data_json = JSON.stringify(obj_data_json_use);
                          data_object_use = obj_data_json_use;
                        }


                        $.ajax({
                          url:"index.php?r=site/insert_file_upload_list&type=update_eform",
                          data:{id_sql_eform:id_sql_eform,data_json:data_json,data_object:data_object_use,_csrf : csrfToken},
                          type: 'post',
                          dataType: 'json',
                          success:function(data)
                          {
                            if (data.status==1) {

                              $("#id_sql_eform").val(id_sql_eform);
                              $("#overlay2").css({display: 'none'});
                              $("#overlay1").css({display: 'block'});
                              $("#text").html('<i class="fas fa-check-circle fa-3x"></i><h6 class="mt-3">แก้ไขข้อมูลสำเร็จ</h6><div class="btn-group btn-group-xs"> <a href="index.php?r=site/pages&view=eform_information&form_id=<?=$id;?>" class="btn btn-primary text-white">เพิ่มข้อมูลใหม่</a> <a href="index.php?r=eform-data/view-person&id='+id_sql_eform+'" class="btn btn-warning text-dark">รายละเอียด</a></div>');

                            }else{
                              $("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
                            }
                          }
                        });

                      }

                    });

$(document).on('change','textarea', function () {
  if (this.value.match(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g, '');
  }
});



var data_org = [];
var data_array;
var level = [];
var position = [];

<?php if(isset($_GET['eform_data'])):?>
  getdata_organization(<?=$val_eform['data_org'][0];?>);
  showrate();
<?php endif;?>


function remove_duplicates(objectsArray) {
  var arr = [], collection = []; 
  $.each(objectsArray, function (index, value) {
    if (value.id !=0 && value.rate!=undefined) {
      if ($.inArray(value.id, arr) == -1) { 
        arr.push(value.id);
        collection.push(value);
      }
    }
  });
  return collection;
}

function getdata_organization(val){
  level = [];
  $(".org_id").val(val);
  var organization_id = val;

  if (organization_id!='') {
    var _data;
    _data = $.ajax({
      url:"index.php?r=site/insert_file_upload_list_type&type=getdata_org",
      data:{org_id:organization_id},
      type: 'post',
      dataType: 'json',
      global: false,
      async: false,
      success: function(response){
        return response;
      }
    }).responseJSON;


    var org_person_array = null;
    var org_person_array = $.ajax({
      url:"index.php?r=organization/json_getdata",
      method:"GET",
      dataType:"json",
      data:{ type: "showdata_person",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",org_id:organization_id},
      contentType: "application/json; charset=utf-8",
      global: false,
      dataType: "json",
      async:false,
      success: function(msg){
        return msg;
      }
    }
    ).responseJSON;

    console.log(org_person_array);

    data_array = JSON.parse(_data.data_json);


    var org_person = [];
    $.each(org_person_array, function(i) {
     var objIndex = data_array.map(x => x.id).indexOf(parseInt(org_person_array[i].main_id));


     if (objIndex!=-1) {
       data_array[objIndex].name = ""+org_person_array[i].data_person+"";

       data_array[objIndex].rate = ""+org_person_array[i].rate+"";

       data_array[objIndex].link = "index.php?r=eform-data/view-person&id="+org_person_array[i].id_person;
     }

   });




    data_array = data_array.sort( function( left, right ) {
      return left.id - right.id;
    });


    <?php if(isset($_GET['eform_data'])):?>
      for (var i = 0; i < data_array.length; i++) {
        var node = data_array[i];
        if (node.id==<?=$val_eform['data_org'][1];?> && node.pid==""+<?=$val_eform['data_org'][2];?>+"") {
          node.tags = ["Selected"];
        }
      }
    <?php endif;?>

    use_chart(data_array);

  }
}

function use_chart(nodes){

  console.log(nodes);

  OrgChart.templates.group.field_0 = '<text width="230" style="font-size: 18px;" fill="#000000" x="{cw}" y="55" text-anchor="middle">{val}</text>';
  OrgChart.templates.ana.field_0 = 
  '<text class="field_0" style="font-size: 14px;" x="{cw}" y="45" fill="#c9d1d8" text-anchor="middle">{val}</text>';
  OrgChart.templates.ana.field_1 = 
  '<text class="field_0" style="font-size: 16px;" x="{cw}" y="75" fill="#FFFFFF" text-anchor="middle">{val}</text>';

  OrgChart.templates.ana.field_2 = 
  '{val}';

  function stars(count) {
    count = parseInt(count);
    var stargroup = '<g transform="matrix(0.2,0,0,0.2,110,15)">';

    for (var i = 0; i < count; i++) {
      stargroup += '<g transform="matrix(1,0,0,1,' + (110 - i * 80) + ',0)">';
      stargroup += '<path fill="#ffcc33" d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757 c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042 c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685 c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528 c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956 C22.602,0.567,25.338,0.567,26.285,2.486z"/>'
      stargroup += '</g>';
    }
    stargroup += '</g>';
    return stargroup;
  }

  function binder(sender, node) {
    var data = sender.get(node.id);
    var field = '';
    return field + stars(data.rate);
  }

  var chart = new OrgChart(document.getElementById("tree"), {
    template: "ana",
    enableDragDrop: false,
    toolbar: {
      fullScreen: true,
      zoom: true,
      fit: true,
      expandAll: true
    },

    nodeBinding: {
      field_0: "name",
      field_1: "title",
      field_2: binder,
    },
    tags: {
      "group": {
        template: "group",
      },
      "main-group": {
      },
      "Selected": {
      },
    }
  });

  chart.on('click', function(sender, args){
    if (args.node.tags.indexOf("group") != -1) {
      return false;
    }else{

      var data = nodes.find(x => x.id === args.node.id);

      if(args.node.tags.length>0){
        $(".main_id").val(data.id);
        $(".pid_id").val(data.pid);
        $(".position_id").val(data.position_id);
      }else{

       if (data.name=="") {
         var focusedElements = document.querySelectorAll('.focused');
         for(var i = 0; i < focusedElements.length; i++){
          focusedElements[i].classList.remove('focused');
        }
        var nodeElement = sender.getNodeElement(args.node.id);
        nodeElement.classList.add('focused');

        $(".main_id").val(data.id);
        $(".pid_id").val(data.pid);
        $(".position_id").val(data.position_id);
        showrate();

      }else{
        alert("ไม่สามารถเลือกตำแหน่งที่ไม่ว่างได้");
      }
    }



    return false;
  }
});

  chart.load(nodes);

}



function showrate(){
  var array_star = ["star_one","star_two","star_three","star_four","star_five"];
  var show_rate = ``;
  for (var i = 1; i < 6; i++) {
    var activeTab = '';
    <?php if(isset($_GET['eform_data'])):?>
      if ((i)==<?=$val_eform['data_org'][3];?>) {
        activeTab = "checked";
      }
    <?php endif;?>
    show_rate += `<input type="radio" name="rating_stars" value="${(i)}" id="${array_star[i]}" ${activeTab}/>
    <label for="${array_star[i]}" class="stars"></label>`;
  }
  $("#box_show_rate").html(`
    <br>
    <lebel class="mt-5"><dt>ระดับความสำคัญภายในองค์กร</dt></lebel>
    <div class="rating effect">
    ${show_rate}
    </div>

    `);

}


$(document).ready(function(){
  $(document).on('click', 'input[name="select_level"]', function(){
    var le_id = $(this).val();
    var level_id = $(this).attr('data-level_id');
    $(".level_id").val(level_id);
    getdata_position(le_id);
  });

  $(document).on('click', 'input[name="select_position"]', function(){
    var position_id = $(this).attr('data-position_id');
    $(".position_id").val(position_id);
    showrate();
  });

  $(document).on('click', 'input[name="rating_stars"]', function(){
    var rate = $(this).val();
    $(".rate_id").val(rate);
  });



});

</script>

<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

