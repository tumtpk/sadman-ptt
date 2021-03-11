<?php
use yii\helpers\Html;
use app\models\Setting;
date_default_timezone_set("Asia/Bangkok");

$url_node_onesignal =  $Setting = Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value;

if($_SESSION['user_role']!='1'){
	$users_data = Yii::$app->db->createCommand("SELECT * FROM users,unit WHERE users.id = '".$_SESSION['user_id']."' AND users.unit_id = unit.unit_id")->queryOne();
}else{
	$users_data = Yii::$app->db->createCommand("SELECT * FROM users WHERE users.id = '".$_SESSION['user_id']."'")->queryOne();
}


$eform_id = isset($_GET['eform_data']) ?  $_GET['eform_data'] : (isset($_POST['eform_data']) ? $_POST['eform_data'] : '');

if (!empty($eform_id)) {
	$sql = "SELECT * FROM `eform_data` WHERE id = '$eform_id'";
	$query = Yii::$app->db->createCommand($sql)->queryOne();
	$data_json_for_approve = $query['data_json'];
	$data = @json_decode($query['data_json'],TRUE);
	$val_eform = $data[0];
	$id = $query['form_id'];
	$this->params['breadcrumbs'][] = ['label' => 'รายละเอียด', 'url' => ['eform-data/view-process','id'=>$eform_id]];
	$card1 = 'รายละเอียดข้อมูล';
	$card2 = 'เอกสารประกอบ';
	$where = "AND id = '".$query['eform_id']."'";
}else{
	$id = isset($_GET['form_id']) ?  $_GET['form_id'] : (isset($_POST['form_id']) ? $_POST['form_id'] : '');
	$card1 = 'ขั้นตอนที่ 1';
	$card2 = 'ขั้นตอนที่ 2';
	$where = "AND disable = '0'";
}


$unitid = (isset($_GET['unit_id'])) ? "AND unit_id = '".$_GET['unit_id']."'" : "AND unit_id = '".$_SESSION['unit_id']."'";


$sql = "SELECT * FROM `eform_template` WHERE id = '$id' $where";
$query = Yii::$app->db->createCommand($sql)->queryOne();
$data = @json_decode($query['form_element'],TRUE);
$data_loop = $data[0]['fieldGroup'];

if(count($data_loop)>0){
	sksort($data_loop, "sort", true);
}else{
	echo "<script>alert('ไม่พบรูปแบบฟอร์ม กรุณาตรวจสอบ');window.location='index.php?r=eform';</script>";
}

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

// $this->params['breadcrumbs'][] = ['label' => $query['detail'], 'url' => ['eform-data/index','form_id'=>$id]];
$this->title = Yii::t('app', 'สรุปข่าว');
$this->params['breadcrumbs'][] = ['label' => 'ดำเนินกรรมวิธีข่าว', 'url' => ['site/news-process']];
$this->params['breadcrumbs'][] = $this->title;

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
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
</style>


<h4><?= Html::encode($this->title) ?></h4>
<div class="row">
	<div class="col-md-8">
		<div id="show_error"></div>
		<div id="overlay1">
			<div id="text"></div>
		</div>
		<div class="card">
			<div class="card-header bg-secondary text-white">
				<dt><?=$card1;?></dt>
			</div>
			<div class="card-body" id="check-height">
				<form class="needs-validation" novalidate id="eform">
					<div id="select-news-check" class="display-hidden"></div>
					<div id="select-unit-check" class="display-hidden"></div>
					<div class="row">
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
															<textarea class="form-control" id="<?=$col['key'];?>" name="<?=$col['key'];?>" rows="<?=$col['templateOptions']['rows'];?>" <?=$req;?> maxlength="<?=$col['templateOptions']['maxlength'];?>"><?=$val_eform[$col['key']];?></textarea>
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
																					<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
																				</div>
																			</div>
																			<div class="card-body">
																				<link
																				data-require="leaflet@0.7.3"
																				data-semver="0.7.3"
																				rel="stylesheet"
																				href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css"
																				/>
																				<script
																				data-require="leaflet@0.7.3"
																				data-semver="0.7.3"
																				src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"
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
																ตำบล : 
																<?php $nameaddress_tombon = $nameaddress."_tombon"; ?>
															</div>
															<div class="col-md-9 pt-1">
																<input type="text" name="<?=$col['key'];?>_tombon" maxlength="150" id="<?=$col['key'];?>_tombon" class="form-control" placeholder="ตำบล" value="<?=$val_eform[$nameaddress_tombon];?>" <?=$req;?>>
															</div>
															<div class="col-md-2 pt-1 text-right-align">
																อำเภอ : 
																<?php $nameaddress_amphoe = $nameaddress."_amphoe"; ?>
															</div>
															<div class="col-md-9 pt-1">
																<input type="text" name="<?=$col['key'];?>_amphoe" maxlength="150" id="<?=$col['key'];?>_amphoe" class="form-control" placeholder="อำเภอ" value="<?=$val_eform[$nameaddress_amphoe];?>" <?=$req;?>>
															</div>
															<div class="col-md-2 pt-1 text-right-align">
																จังหวัด :
																<?php $nameaddress_province = $nameaddress."_province"; ?>
															</div>
															<div class="col-md-9 pt-1">
																<?php $provine = Yii::$app->db->createCommand("SELECT * FROM `province` ORDER BY ProvinceThai ASC")->queryAll(); 
																?>
																<select name="<?=$col['key'];?>_province" id="<?=$col['key'];?>_province" class="form-control" <?=$req;?>>
																	<option value="">
																		เลือกจังหวัด
																	</option>
																	<?php foreach ($provine as $val_province): 
																		$selected = ($val_eform[$nameaddress_province]==$val_province['ProvinceThai']) ? 'selected' : '';
																		?>
																		<option value="<?=$val_province['ProvinceThai']?>" <?=$selected;?>>
																			<?=$val_province['ProvinceThai']?>
																		</option>
																	<?php endforeach ?>
																</select>
															</div>
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
													<?php else: ?>
														<div id="data_json" style="visibility: hidden;height: 0px;">
															<?=$data_json_for_approve;?>
														</div>

														<?php if (!empty($val_eform['news_value'])): ?>
															<input type="hidden" name="news_value" id="news_value" value="<?=$val_eform['news_value'];?>">
														<?php endif ?>


													<?php endif ?>

													<?php $stay_informed = (!empty($val_eform['stay_informed'])) ? $val_eform['stay_informed'] : '0'; ?>
													<input type="hidden" name="stay_informed" id="stay_informed" value="<?=$stay_informed;?>">

													<?php $evaluate_news = (!empty($val_eform['evaluate_news'])) ? $val_eform['evaluate_news'] : '-'; ?>
													<input type="hidden" name="evaluate_news" id="evaluate_news" value="<?=$evaluate_news;?>">


												</div>

												<?php //if ($_SESSION['user_role']=='3' && $query['unit_id']==$_SESSION['unit_id']): ?>
												<div class="btn-group">
													<button type="submit" class="btn btn-lg btn-primary">ส่งข่าว</button>
													<button type="reset" class="btn btn-lg btn-light">ล้างค่า</button>
												</div>
												<?php //endif ?>

											</form>
										</div>
									</div>

								</div>
								<div class="col-md-4">

									<div class="card">
										<div id="overlay1"></div>
										<div class="card-header bg-secondary text-white">ข่าวที่เกี่ยวข้อง [ คลิ๊กเพื่อค้นหาและเลือกข่าว]</div> 
										<div class="card-body">
											<button type="submit" style="float: right;" class="btn btn-primary  btn-select-news" data-toggle="modal" data-target="#selectNews">
												<i class="fe fe-search"></i>
											</button><br>  
											<div id="count_news"></div>
											<div id="showoutput_news" class="div_scrollbar"></div>
										</div>
									</div>
									<div class="card">
										<div id="overlay1"></div>
										<div class="card-header bg-secondary text-white">กลุ่มที่ต้องการให้รับทราบ [ คลิ๊กเพื่อค้นหาและเลือกกลุ่มผู้ใช้]</div>
										<div class="card-body">
											<button type="submit"  style="float: right;"  class="btn btn-primary  btn-select-unit" data-toggle="modal" data-target="#selectUnit">
												<i class="fe fe-user-plus"></i>
											</button><br>
											<div id="count_unit"></div>
											<div id="showoutput_unit" class="div_scrollbar"></div>
										</div>
									</div>


									<div class="card">
										<div id="overlay2"></div>
										<div class="card-header bg-secondary text-white">
											<dt><?=$card2;?></dt>
										</div>
										<div class="card-body">
											<div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" name="multiple_files" id="multiple_files" multiple="multiple" required="required"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
											<input type="hidden" name="id_sql_eform" id="id_sql_eform" value="<?=$eform_id;?>">
											<div class="show-status text-center"></div>
											<div class="list-design">
												<ul class="list-group list-show-process" id="showfiles">
												</ul>
											</div>
										</div>
									</div>

								</div>

								<div class="col-md-12 text-center" id="insert_success">
								</div>
							</div>
							<!-- Modal -->
							<div class="modal fade" id="selectNews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_news" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">ข่าวที่เกี่ยวข้อง</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body" >
											<div class="row">
												<div class="col-6 col-md-6">
													<input type="text" id="search_news" class="form-control" placeholder="ค้นหาข่าวที่เกี่ยวข้อง">
												</div>
												<div class="col-6 col-md-4">
													<input type="text" id="date_data" class="form-control datepicker_input" placeholder="เลือกวันที่บันทึก" readonly>
													<input type="hidden" class="get_val_datetime">
												</div>
												<div class="col-6 col-md-2">
													<button type="button" class="btn btn-success" id="btn" style="white-space: nowrap;"><i class="fa fa-search"></i> สืบค้น</button>
												</div>
											</div>
											<?php 
											if(!empty($val_eform['news-message'])){
												$att_news = implode(",",$val_eform['news-message']);
												$att_news = str_replace(",","','",$att_news);
											}

											if(!empty($val_eform['unit-send-news'])){
												$att_unit = implode(",",$val_eform['unit-send-news']);
												$att_unit = str_replace(",","','",$att_unit);
											}
											?>
											<div id="shownews"></div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">ยืนยัน</button>
										</div>
									</div>
								</div>
							</div>

							<div class="modal fade" id="selectUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_unit" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">หน่วยที่ต้องการให้รับทราบ</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<input type="text" id="search_unit" class="form-control" placeholder="ค้นหาหน่วย ชื่อ / รายละเอียด">
											<div class="row" id="showunit"></div>
											<br>
											<div class="text-center">
												<div class="btn-group btn-group">
													<input type="hidden" value="1" id="checkpage">
													<button type="button" class="btn btn-primary prev" disabled>ก่อนหน้า</button>
													<button type="button" class="btn btn-primary next">ถัดไป</button>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">ยืนยัน</button>
										</div>
									</div>
								</div>
							</div>

							<?php 
							$show_att_unit = (!empty($att_unit)) ? "'".$att_unit."'": '';
							$show_att_news = (!empty($att_news)) ? "'".$att_news."'": ''; ?>
							<script type="text/javascript">
								$(document).ready(function(){
									checkpage();
									var news_id = [<?php echo $show_att_news; ?>];
									var unit_id = [<?php echo $show_att_unit; ?>];


									show_input_checked(news_id,"select-news-check");
									show_ready(news_id,"showoutput_news");

									show_input_checked_unit(unit_id,"select-unit-check");
									show_ready_unit(unit_id,"showoutput_unit");

									$(document).on('click', '.btn-select-news', function(){
										$.ajax({
											url:"index.php?r=site/json_select_news&auth=<?=$auth?>&type=now",
											method:"GET",
											dataType:"json",
											contentType: "application/json; charset=utf-8",
										})
										.done(function(data){
											show_content(data,'shownews');
										});
									});

									$(document).on('click', '#btn', function(){
										var search_news = $("#search_news").val();
										var date_search = $(".get_val_datetime").val();

										if (date_search!='') {
											$.ajax({
												url:"index.php?r=site/json_select_news&auth=<?=$auth?>&type=search_value",
												method:"GET",
												dataType:"json",
												data:{ date_search: date_search,text_search:search_news},
												contentType: "application/json; charset=utf-8",
											})
											.done(function(data){
												show_content(data,'shownews');
											});

										}else{
											alert('กรุณาเลือกวันที่บันทึก');
										}

									});


									$(document).on('click', 'input[name="select-news"]', function(){
										var detail = $(this).data('topic');
										var topic = detail.split("<br>",3);
										var id = $(this).val();
										if ($(this).is(':checked')) {
											news_id.push(id);
										}else{
											news_id.splice($.inArray(id, news_id),1);
										}

										show_input_checked(news_id,"select-news-check");

									});

									function show_input_checked(data_array,name_div){
										var arraycheckbox = [];
										$.each(data_array, function(i) {arraycheckbox.push(`<input type="checkbox" name="news-message[]" value="${data_array[i]}" checked>`);
									});
										$("#"+name_div).html(arraycheckbox.join(""));
										show_ready(data_array,"showoutput_news");
									}

									function show_content(data_array,name_div){
										var data = data_array;
										var myarray = [];
										for (i = 0; i < data.length; i++) {
											var id = data[i]['id'];
											var topic = data[i]['data'];
											var date = data[i]['date_record'];

											var _news_checked = '';
											if(jQuery.inArray(id, news_id) !== -1){
												_news_checked = 'checked';
											}


											myarray.push(`<div class="card card-mb-not"><div class="card-body"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input getval_check" name="select-news" value="${id}" data-topic="${topic}" ${_news_checked}><span class="custom-control-label"> ${topic} <b>วันที่บันทึก :</b> ${date}</span></label></div></div>`);

										}
										$("#"+name_div).html(myarray.join(""));
									}

									function show_ready(id_array,name_div){
										if (id_array.length>0) {
											$.ajax({
												url:"index.php?r=site/json_select_news&auth=<?=$auth?>&type=showdata",
												method:"GET",
												dataType:"json",
												data:{ id_array: id_array},
												contentType: "application/json; charset=utf-8",
											})
											.done(function(data){
												var myarray = [];
												for (i = 0; i < data.length; i++) {
													var id = data[i]['id'];
													var topic = data[i]['data'];
													var date = data[i]['date_record'];

													myarray.push(`<div class="card card-mb-not"><div class="card-body"> <div style="position:absolute;right: 10;top:10;">
														<a class="btn btn-light btn-sm" onclick="window.open('index.php?r=eform-data/view&id=${id}')" href="#"><i class="fa fa-eye" title="รายละเอียด" target="_blank"></i></a></div> ${topic} </div></div>`);

												}
												$("#count_news").html('<b>จำนวน</b> '+id_array.length+' <b>ข่าว</b>');
												$("#"+name_div).html(myarray.join(""));
											});

										}else{
											$("#"+name_div).html('');
										}
									}

									$(document).on('click', '.btn-select-unit', function(){
										myarray = [];
										$.ajax({
											url:"index.php?r=site/json_select_unit&auth=<?=$auth?>&type=pagi_search",
											method:"GET",
											dataType:"json",
											contentType: "application/json; charset=utf-8",
										}).done(function( data ){
											show_content_unit(data,'showunit');
										});

									});

									function show_content_unit(data_array,name_div){
										var myarray = [];
										var data = data_array;
										for (i = 0; i < data.length; i++) {
											var ids = data[i]['unit_id'];
											var topics = data[i]['unit_name'];
											var des = data[i]['unit_detail'];

											var _unit_checked = '';
											if(jQuery.inArray(ids, unit_id) !== -1){
												_unit_checked = 'checked';
											}

											myarray.push(`<div class="col-md-4"><div class="card card-mb-not"><div class="card-body"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="select-unit" data-title="${topics}" value="${ids}" ${_unit_checked}><span class="custom-control-label"> ${topics}</span></label></div></div></div>`);
										}
										$("#"+name_div).html(myarray.join(""));
									}

									$(document).on('click', '.next', function(){
										var page = $("#checkpage").val();
										var text_search = $("#search_unit").val();
										var page_use = parseInt(page)+1;
										$("#checkpage").val(page_use);
										get_data_pagi_search(text_search,page_use);
										checkpage();
									});

									$(document).on('click', '.prev', function(){
										var page = $("#checkpage").val();
										var text_search = $("#search_unit").val();
										var page_use = parseInt(page)-1;
										$("#checkpage").val(page_use);
										get_data_pagi_search(text_search,page_use);
										checkpage();
									});


									function checkpage(){
										var checkpage = $("#checkpage").val();
										if (checkpage<=1) {
											$('.prev').attr("disabled"); 
											$('.prev').addClass('disabled');
										}else{
											$('.prev').removeAttr("disabled"); 
											$('.prev').removeClass('disabled');
										}
									}

									$(document).on('keyup', '#search_unit', function(){
										$("#checkpage").val(1);
										var text_search = $(this).val();
										var checkpage = 1;
										get_data_pagi_search(text_search,checkpage);

									});

									function get_data_pagi_search(text_search,get_page){
										$.ajax({
											url:"index.php?r=site/json_select_unit&auth=<?=$auth?>&type=pagi_search",
											method:"GET",
											dataType:"json",
											data:{ text_search: text_search,get_page:get_page},
											contentType: "application/json; charset=utf-8",
										}).done(function( data ){
											show_content_unit(data,'showunit');
										});

									}

									$(document).on('click', 'input[name="select-unit"]', function(){

										var checked = $(this).val();
										if ($(this).is(':checked')) {
											unit_id.push(checked);
										}else{
											unit_id.splice($.inArray(checked, unit_id),1);
										}
										console.log(unit_id);
										show_input_checked_unit(unit_id,'select-unit-check')

									});

									function show_input_checked_unit(data_array,name_div){

										var arrayunitsrc = [];
										$.each(data_array, function(i) {arrayunitsrc.push(`<input type="checkbox" name="unit-send-news[]" value="${data_array[i]}" checked>`);
									});
										$("#"+name_div).html(arrayunitsrc.join(""));
										show_ready_unit(data_array,"showoutput_unit");
									}

									function show_ready_unit(id_array,name_div){
										if (id_array.length>0) {
											$.ajax({
												url:"index.php?r=site/json_select_unit&auth=<?=$auth?>&type=showdata_unitid",
												method:"GET",
												dataType:"json",
												data:{ id_array: id_array},
												contentType: "application/json; charset=utf-8",
											})
											.done(function(data){
												var myarray = [];
												for (i = 0; i < data.length; i++) {
													var ids = data[i]['unit_id'];
													var topics = data[i]['unit_name'];
													var des = data[i]['unit_detail'];

													myarray.push(`
														${topics}`);

												}
												$("#count_unit").html('<b>จำนวน</b> '+id_array.length+' <b>หน่วย</b>');
												$("#"+name_div).html(''+myarray.join(", ")+'');
											});

										}else{
											$("#"+name_div).html('');
										}
									}




								});

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
	$('#showfiles').css({height: height_inlist});

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
						showfiles(data[index].file_name,data[index].file_id,data[index].bucket);
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

	function showfiles(file_name,file_id,bucket) {
		$.ajax({
			url:"<?=$url_node['setting_value'];?>/filepathminio?namefile="+file_name+"&bucket="+bucket,
			method:"GET",
			dataType:"json",
			contentType: "application/json; charset=utf-8",
			success:function(data)
			{
				showlist_files.push('<li class="list-group-item d-flex justify-content-between align-items-center"><a href="'+data.url+'" target="_blank">'+file_name+'</a><button class="btn btn-danger badge badge-danger badge-pill deldata" data-file-id="'+file_id+'" data-name-file="'+file_name+'" data-name-bucket="'+bucket+'"><i class="fa fa-trash"></i></button></li>');
				$("#showfiles").html(showlist_files.join(""));
			}


		});

	}

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
		var user_create = $('#user_create').val();
		var form_id = $('#form_id').val();
		var eform_id = $('#eform_id').val();

		var latitude = $('#latitude').val();
		var coor = null;
		var data_json = null;
		var data_object_use = null;

		if (latitude!=null) {
			coor = `
			"coor": {
				"lat": "${$('#latitude').val()}",
				"lon": "${$('#longitude').val()}"
			}
			`;

			var json_de = JSON.stringify(data_object);
			var first = json_de.replace("{", "");
			var end = first.replace("}", "");
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
			address_real += `
			"${nameaddress}": {
				"no": "${$('#'+nameaddress+'_no').val()}",
				"mooban": "${$('#'+nameaddress+'_mooban').val()}",
				"tombon": "${$('#'+nameaddress+'_tombon').val()}",
				"amphoe": "${$('#'+nameaddress+'_amphoe').val()}",
				"provine": "${$('#'+nameaddress+'_province').val()}"
			},
			`
		});
		var res_use = address_real.slice(0, -2);
		if (address_real.length>0) {
			var json_de = JSON.stringify(data_object_use);
			var first = json_de.replace("{", "");
			var end = first.replace("}", "");
			var data_json_use = "{"+end+","+res_use+"}";
			obj_data_json_use = JSON.parse(data_json_use);
			data_json = JSON.stringify(obj_data_json_use);
			data_object_use = obj_data_json_use;
		}

		function send_onesignal (object){
			var i = 0;
			var title = "";
			var detail = "";
			$.each(object, function( index, value ) {
				if(i==2){
					console.log(value);
					 title = value;
				}

				if(i==3){
					console.log(value);
					 detail = value;
				}

				i++;
			});

			var settings = {
				"async": true,
				"crossDomain": true,
				"url": "<?=$url_node_onesignal?>/send_notification",
				"method": "POST",
				"headers": {
					"content-type": "application/json",
				},
				"processData": false,
				"data": "{\"title\":\""+title+"\",\"detail\":\""+detail+"\"}"
			}

			$.ajax(
			{
				async: true,
				crossDomain: true,
				url: "<?=$url_node_onesignal?>/send_notification",
				method: "POST",
				headers: {
					"content-type": "application/json",
				},
				processData: false,
				data: "{\"title\":\""+title+"\",\"detail\":\""+detail+"\"}",
				success: function(data) {

				}
			});

}

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
			$("#text").html('<i class="fas fa-check-circle fa-3x"></i><h6 class="mt-3">บันทึกข้อมูลสำเร็จ</h6><div class="btn-group btn-group-xs"> <a href="index.php?r=site/pages&view=eform_information&form_id=<?=$id;?>" class="btn btn-primary text-white">เพิ่มข้อมูลใหม่</a> <a href="index.php?r=eform-data/view-process&id='+data.id_sql_eform+'" class="btn btn-warning text-dark">รายละเอียด</a></div>');

			send_onesignal(data_object);

		}else{
			$("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
		}
	}
});

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
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	var id_sql_eform = $("#id_sql_eform").val();

	var latitude = $('#latitude').val();
	var coor = null;
	var data_json = null;
	var data_object_use = null;

	var data_json_for_array_other = $("#data_json").html();
	var data_object_for_array_other =  JSON.parse(data_json_for_array_other);


	if (latitude!=null) {
		coor = `
		"coor": {
			"lat": "${$('#latitude').val()}",
			"lon": "${$('#longitude').val()}"
		}
		`;

		var json_de = JSON.stringify(data_object);
		var first = json_de.replace("{", "");
		var end = first.replace("}", "");
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
		address_real += `
		"${nameaddress}": {
			"no": "${$('#'+nameaddress+'_no').val()}",
			"mooban": "${$('#'+nameaddress+'_mooban').val()}",
			"tombon": "${$('#'+nameaddress+'_tombon').val()}",
			"amphoe": "${$('#'+nameaddress+'_amphoe').val()}",
			"provine": "${$('#'+nameaddress+'_province').val()}"
		},
		`
	});
	var res_use = address_real.slice(0, -2);
	if (address_real.length>0) {
		var json_de = JSON.stringify(data_object_use);
		var first = json_de.replace("{", "");
		var end = first.replace("}", "");
		var data_json_use = "{"+end+","+res_use+"}";
		obj_data_json_use = JSON.parse(data_json_use);
		data_json = JSON.stringify(obj_data_json_use);
		data_object_use = obj_data_json_use;
	}
	console.log(data_json);

	var first = data_json.replace("{", "");
	var end = first.replace("}", "");

	if (end.length>0) {
		var approve_use = '{'+end+',"approve":'+JSON.stringify(data_object_for_array_other[0].approve)+'}';
	}

	data_json = approve_use;
	data_object_use = JSON.parse(approve_use);

	if (data_object_for_array_other[0].request_information!=undefined) {
		var first = data_json.slice(1);
		var end = first.slice(0,-1);
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

	var first = obj.replace("[", "");
	var end = first.replace("]", "");
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


// console.log(history_use);

// console.log(data_json);
// console.log(data_object_use);

$.ajax({
	url:"index.php?r=site/insert_file_upload_list&type=update_eform",
	data:{id_sql_eform:id_sql_eform,data_json:data_json,data_object:data_object_use,_csrf : csrfToken},
	type: 'post',
	dataType: 'json',
	success:function(data)
	{
		if (data.status==1) {
			$("#overlay2").css({display: 'none'});
			$("#overlay1").css({display: 'block'});
			$("#text").html('<i class="fas fa-check-circle fa-3x"></i><h6 class="mt-3">แก้ไขข้อมูลสำเร็จ</h6>');
			$("#insert_success").html('<div class="btn-group btn-group-xs"> <a href="index.php?r=site/pages&view=process_news&form_id=<?=$id;?>" class="btn btn-primary text-white">เพิ่มข้อมูลใหม่</a> <a href="index.php?r=eform-data/view-process&id='+id_sql_eform+'" class="btn btn-warning text-dark">รายละเอียด</a></div>');
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

</script>

<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
