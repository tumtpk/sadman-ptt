<?php
use yii\helpers\Html;

$eform_id = isset($_GET['eform_data']) ?  $_GET['eform_data'] : (isset($_POST['eform_data']) ? $_POST['eform_data'] : '');

if (!empty($eform_id)) {
$sql = "SELECT * FROM `eform_data` WHERE id = '$eform_id'";
$query = Yii::$app->db->createCommand($sql)->queryOne();
$data = @json_decode($query['data_json'],TRUE);
$val_eform = $data[0];
$id = $query['form_id'];
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียด', 'url' => ['eform-data/view','id'=>$eform_id]];
$card1 = 'รายละเอียดข้อมูล';
$card2 = 'เอกสารประกอบ';
}else{
$id = isset($_GET['form_id']) ?  $_GET['form_id'] : (isset($_POST['form_id']) ? $_POST['form_id'] : '');
$card1 = 'ขั้นตอนที่ 1';
$card2 = 'ขั้นตอนที่ 2';
}

$sql = "SELECT * FROM `eform_template` WHERE id = '$id'";
$query = Yii::$app->db->createCommand($sql)->queryOne();
$data = @json_decode($query['form_element'],TRUE);
$data_loop = $data[0]['fieldGroup'];
sksort($data_loop, "sort", true);

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

$this->title = $query['detail'];
$this->params['breadcrumbs'][] = ['label' => 'Eform Templates', 'url' => ['eform-template/index']];
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดแบบฟอร์ม', 'url' => ['eform-template/view','id'=>$id]];
$this->params['breadcrumbs'][] = ['label' => 'แก้ไขแบบฟอร์ม', 'url' => ['eform-template/update','id'=>$id]];
$this->params['breadcrumbs'][] = $this->title;
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
<div class="row">
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
	$checked = ($val_eform[$col['key']] == $options['value']) ? 'checked' : '';
	?>
	<input type="<?=$col['templateOptions']['type'];?>" class="form-control class_radio" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" value="<?=$options['value'];?>" <?=$req_main;?> <?=$checked;?>> <?=$options['label'];?>&nbsp;&nbsp;
<?php endforeach ?>

<?php elseif($col['templateOptions']['type']=='checkbox'): ?>
	<br>
	<?php
	$ci = 0;
	foreach ($col['templateOptions']['options'] as $options): 
		$checked = ($val_eform[$col['key']][$ci] == $options['value']) ? 'checked' : '';
		?>
		<input type="<?=$col['templateOptions']['type'];?>" placeholder="<?=$col['templateOptions']['placeholder'];?>" id="<?=$col['key'];?>" class="form-control class_radio" name="<?=$col['key'];?>[]" value="<?=$options['value'];?>" <?=$checked;?>> <?=$options['label'];?>&nbsp;&nbsp;
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
	?>
<textarea class="<?=$type_textarea;?>" id="<?=$col['key'];?>" name="<?=$col['key'];?>" rows="<?=$col['templateOptions']['rows'];?>" <?=$req;?> maxlength="<?=$col['templateOptions']['maxlength'];?>"><?=$val_eform[$col['key']];?></textarea>
	<?php elseif($col['type']=='latlong'): 
		$have_map = 1;
		?>
		<br>
		<div class="row" id="showmap">
			<div class="col-md-4">
				<input type="text" name="latitude" maxlength="40" id="latitude" class="form-control" placeholder="กรอกละติจูด" value="<?=$val_eform['latitude'];?>" onkeypress="return validateQty(this,event);" OnChange="JavaScript:chkNum(this)" <?=$req;?>>
			</div>
			<div class="col-md-4">
				<input type="text" name="longitude" maxlength="40" id="longitude" class="form-control" placeholder="กรอกลองติจูด" value="<?=$val_eform['longitude'];?>" onkeypress="return validateQty(this,event);" OnChange="JavaScript:chkNum(this)" <?=$req;?>>
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
							<!-- <link
							data-require="leaflet@0.7.3"
							data-semver="0.7.3"
							rel="stylesheet"
							href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css"
							/>
							<script
							data-require="leaflet@0.7.3"
							data-semver="0.7.3"
							src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"
							></script> -->

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
					$(this).attr('maxlength', 16);
					$(this).val(format_card);
					if ($(this).val() == '' ||
						$(this).val().match(format_card) ||
						$(this).val().length == 0) {
						console.log("invalid");
				} else {
					console.log("valid");
				}
			}else{
				$(this).attr('maxlength', 19);
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
		get_amphures($("#address_province_code").val(),$("#address_amphoe_code").val());
		get_districts($("#address_amphoe_code").val(),$("#address_tombon_code").val());
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

			$sql = "SELECT $id_column,$type_column FROM $table_column";
			$query = Yii::$app->db->createCommand($sql)->queryAll();
			?>
			<select class="form-control" <?=$req;?> id="<?=$col['key'];?>" name="<?=$col['key'];?>">
				<option value="">เลือก<?=$col['templateOptions']['placeholder'];?></option>
				<?php foreach ($query as $val_name): ?>
					<option value="<?=$val_name[$id_column];?>"><?=$val_name[$type_column];?></option>
				<?php endforeach ?>
			</select>
			<?php else: ?>
				<select class="form-control" <?=$req;?> id="<?=$col['key'];?>" name="<?=$col['key'];?>">
					<option value="">เลือก<?=$col['templateOptions']['placeholder'];?></option>
					<?php foreach ($col['templateOptions']['options'] as $options): ?>
						<option value="<?=$options['value'];?>"><?=$options['label'];?></option>
					<?php endforeach ?>
				</select> 
			<?php endif; ?>

			<script>
				$(document).ready(function(){
					$('#<?=$col['key'];?>').val(<?=$val_eform[$col['key']];?>);
				});
			</script>
		<?php endif; ?>


		<div class="valid-feedback"></div>
		<div class="invalid-feedback"><?=$req_text;?> <?=$col['templateOptions']['placeholder'];?>.</div>
	</div>



<?php endforeach ?>

<input type="hidden" name="form_id" id="form_id" value="<?=$id;?>">
<input type="hidden" name="user_create" id="user_create" value="<?=$_SESSION['user_id'];?>">


<?php $stay_informed = (!empty($val_eform['stay_informed'])) ? $val_eform['stay_informed'] : '0'; ?>
<input type="hidden" name="stay_informed" id="stay_informed" value="<?=$stay_informed;?>">

<?php $evaluate_news = (!empty($val_eform['evaluate_news'])) ? $val_eform['evaluate_news'] : '-'; ?>
<input type="hidden" name="evaluate_news" id="evaluate_news" value="<?=$evaluate_news;?>">


</div>

<!-- <div class="btn-group">
<button type="submit" class="btn btn-primary">บันทึก</button>
<button type="reset" class="btn btn-light">ล้างค่า</button>

</div> -->

</form>
</div>
</div>

</div>
<div class="col-md-4">

<!-- <div id="overlay2">
</div>
<div class="card">
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
</div> -->

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
// console.log(obj);
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
url:"index.php?r=site/insert_file_upload_list&type=show&form_id="+id_sql_eform,
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

for (var i = 0; i < files.length; i++) {
var file = files[i];
var name = files[i].name;
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

retrieveNewURL(file_all,namebucket,namefile ,file, (file, url,namebucket,namefile) =>{

uploadFile(namebucket,namefile,file_all,file, url);
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

function retrieveNewURL(file_all,namebucket,namefile, file, cb) {

fetch(`<?=$url_node['setting_value'];?>/uploadminio?name=${file.name}&bucket=${namebucket}&namefile=${namefile}`).then((response) => {
response.text().then((url) => {
cb(file, url,namebucket,namefile);
});
}).catch((e) => {
console.error(e);
});
}

function uploadFile(namebucket,namefile,file_all,file, url) {
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
insertDatabase(namefile,namebucket,count,file_all)
}).catch((e) => {
console.error(e);
});
}

function insertDatabase(namefile,namebucket,count,file_all){
var id_sql_eform = $("#id_sql_eform").val();
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type=insert&namefile="+namefile+"&namebucket="+namebucket+"&form_id="+id_sql_eform,
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
url:"index.php?r=site/insert_file_upload_list&type=delete&file_id="+file_id,
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
var data_json = JSON.stringify(data_object);
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type=insert_eform",
data:{form_id:form_id,user_create:user_create,data_json:data_json,data_object:data_object},
type: 'post',
dataType: 'json',
success:function(data)
{
if (data.status==1) {
$("#id_sql_eform").val(data.id_sql_eform);
$("#overlay2").css({display: 'none'});
$("#overlay1").css({display: 'block'});
$("#text").html('<i class="fas fa-check-circle fa-3x"></i><h6 class="mt-3">บันทึกข้อมูลสำเร็จ</h6>');
$("#insert_success").html('<div class="btn-group btn-group-xs"> <a href="index.php?r=site/pages&view=eform_template&form_id=<?=$id;?>" class="btn btn-primary text-white">เพิ่มข้อมูลใหม่</a> <a href="index.php?r=eform-data/view&id='+data.id_sql_eform+'" class="btn btn-warning text-dark">รายละเอียด</a></div>');
}else{
$("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
}
}
});

}


function update_eform_data(data_object){
var csrfToken = $('meta[name="csrf-token"]').attr("content");
var id_sql_eform = $("#id_sql_eform").val();
var data_json = JSON.stringify(data_object);
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type=update_eform",
data:{id_sql_eform:id_sql_eform,data_json:data_json,data_object:data_object,_csrf : csrfToken},
type: 'post',
dataType: 'json',
success:function(data)
{
if (data.status==1) {
$("#show_error").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle" aria-hidden="true"></i></strong> บันทึกข้อมูลสำเร็จ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
}else{
$("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
}
}
});

}



});


</script>

<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
