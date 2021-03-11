<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'หน่วยงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">



<h4>
<?= Html::encode($this->title) ?>
<?php
$desc_modal = Yii::$app->db->createCommand("SELECT * FROM `desc_modal` WHERE `id` = 2")->queryone();
?> 
<a class="btn-question goDoSomething" id="desc-model" data-id-desc="<?=$desc_modal['id'];?>" data-toggle="modal" data-target=".bd-modal-manual"><i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="คู่มือการใช้งาน
"></i></a>
</h4>

<div class="row">
<div class="col-lg-3 col-md-6">
<div class="card">
<div class="card-body w_sparkline">
<div class="details">
<span>หน่วยงานทั้งหมด</span>
<h3 class="mb-0 counter">
<?php echo $unitAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM unit")->queryScalar(); ?>
</h3>
</div>
<div class="w_chart">
<i class="users-box-icon text-orange icon-star"></i>
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="card">
<div class="card-body w_sparkline">
<div class="details">
<span>ผู้ดูแลหน่วยงาน</span>
<h3 class="mb-0 counter">
<?php echo $unit_admin = Yii::$app->db->createCommand("SELECT COUNT(unit.unit_id) FROM unit,users WHERE unit.unit_id = users.unit_id AND users.role = '2'")->queryScalar(); ?>
</h3>
</div>
<div class="w_chart">
<i class="users-box-icon text-green icon-user-following"></i>
</div>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card">
<div class="card-body w_sparkline">
<div class="details">
<span>หน่วยงานที่เปิดใช้งาน</span>
<h3 class="mb-0 counter">
<?php echo $have_active = Yii::$app->db->createCommand("SELECT COUNT(*) FROM unit WHERE have_active = '1'")->queryScalar(); ?>
</h3>
</div>
<div class="w_chart">
<i class="users-box-icon text-red icon-pin"></i>
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="card">
<div class="card-body w_sparkline">
<div class="details">
<span>ผู้ดูแลหน่วยที่เข้าใช้งานวันนี้</span>
<h3 class="mb-0 counter">
<?php $day_now = date('Y-m-d'); ?>
<?=$users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.role = '2' AND  user_log_usaged.create_date = '".$day_now."'")->queryScalar();?>
</h3>
</div>
<div class="w_chart">
<i class="users-box-icon text-black icon-calendar"></i>
</div>
</div>
</div>
</div>
</div>


<div class="row">

<div class="col-lg-6 col-md-6">

<?php Pjax::begin(['id'=>'unit_pjax_id','timeout'=>10000,'enablePushState' => true,'enableReplaceState' => true]); ?>
<div class="row clearfix">
<div class="col-xl-12 col-lg-12 col-md-12">
<div class="card">
<div class="card-body ribbon">
<!-- <button type="button" class="btn btn-success mb-3" id="unit-create" data-toggle="modal" data-target="#unit-modal" data-pjax="0"><dt>เพิ่มหน่วยงาน</dt></button> -->

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?php //var_dump($_GET['UnitSearch']); ?>
<?php 
// $query = array(
// 	"unit_id"=>$_GET['UnitSearch']['unit_detail'],
// 	"unit_name"=>$_GET['UnitSearch']['unit_name'],
// ); 
// var_dump($query);
?>

<?php 
// $columns = array("unit_id","unit_name","(select name form sdfdsf where id = unit_id.ff LIMIT 1)");
// var_dump($columns);
?>
</div>
</div>
</div>
</div>
<?= Html::a('+ เพิ่มหน่วยงาน', ['create'], ['class' => 'btn btn-success mb-3']) ?>
<?php
$columns = 2;
$cl = 12 / $columns;

echo ListView::widget([
'dataProvider' => $dataProvider,
'layout'       => '{items}{pager}',
'itemOptions'  => ['class' => "col-md-$cl"],
'itemView'     => '_listindex',
'options'      => ['class' => 'grid-list-view row' ],
'emptyText' => '<div class="row"><div class="p-3 col-md-12">No results.</div></div>',
'pager' => [
'options' =>[
'class' => 'pagination col-md-12'],
],
]);

?>
<?php Pjax::end(); ?>

</div>
<div class="col-lg-6 col-md-6">


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


<div id="mapshow" style="border-radius: 5px;
width: 100%;
height: 924px;
margin-top: 11px;"></div>    
<script>

$(document).ready(function(){

var map = null;

var url_json_map = "index.php?r=unit/map_marker&type=all";

var json_map = null;
var json_map = $.ajax({
url: url_json_map,
global: false,
dataType: "json",
async:false,
success: function(msg){
return msg;
}
}
).responseJSON;

loadmap(json_map);

function loadmap(data){

map = L.map('mapshow').setView([data[0].lat, data[0].lon], 6);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
maxZoom: 18,
minZoom: 5,
attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
id: 'mapbox/streets-v11',
tileSize: 512,
zoomOffset: -1
}).addTo(map);

for(i in data) {
L.marker([data[i].lat, data[i].lon],{
	icon: new L.Icon({
		iconAnchor: [12, 26],
		iconUrl: '../../upload_file/marker/icon_marker.png',
	})
}).addTo(map)
.bindPopup(`
	<a href="index.php?r=unit/view&id=${data[i].unit_id}"><b>หน่วย : ${data[i].unit_name}</b></a>
	<br>
	ที่ตั้ง : ${data[i].address}<br>จังหวัด : ${data[i].province}<br>
	<b>พิกัด (${data[i].lat}, ${data[i].lon})</b>`);
}
var popup = L.popup();
}


$(document).on('click', '.loadmapsearch', function(){
var unitname = $("#unitsearch-unit_name").val();
var vv = unitname.replace(/ /g, '_');
var unitid = $("#unitsearch-unit_detail").val();
map.remove();
$("#mapshow").html("");
$("#preMap").empty();
$( "<div id=\"mapshow\" style=\"height: 500px;\"></div>" ).appendTo("#preMap");
loaddata_search(vv,unitid);

function loaddata_search(name,id){
var url_json = "index.php?r=unit/map_marker&type=search&unitname="+name+"&unitid="+id;

var json_map = null;
var json_map = $.ajax({
	url: url_json,
	global: false,
	dataType: "json",
	async:false,
	success: function(msg){
		return msg;
	}
}
).responseJSON;
loadmap(json_map);
}
});


});
</script>
</div>


</div>

</div>


<!-- The Modal -->
<div class="modal" id="unit-modal">
<div class="modal-dialog">
<div class="modal-content">

<!-- Modal Header -->
<div class="modal-header">
<h5 class="modal-title"></h5>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>



<!-- Modal body -->
<div class="modal-body">

</div>

<!-- Modal footer -->
<!--   <div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
</div> -->

</div>
</div>
</div>


<?php 

$this->registerJs('
function init_click_handlers(){
$("#unit-create").click(function(e) {
$.get(
"index.php?r=unit/create",
function (data)
{
$("#unit-modal").find(".modal-body").html(data);
$(".modal-body").html(data);
$(".modal-dialog").addClass("modal-lg");
$(".modal-dialog").removeClass("modal-md");
$(".modal-title").html("เพิ่มหน่วยงาน");
$("#unit-modal").modal("show");
}
);
});

$(".unit-view-link").click(function(e) {
var fID = $(this).data("id");
$.get(
"index.php?r=unit/view&id="+fID,
{
id: fID
},
function (data)
{
$("#unit-modal").find(".modal-body").html(data);
$(".modal-dialog").removeClass("modal-lg");
$(".modal-dialog").addClass("modal-md");
$(".modal-body").html(data);
$(".modal-title").html("หน่วยงาน");
$("#unit-modal").modal("show");
}
);
});


$(".unit-update-link").click(function(e) {
var fID = $(this).data("id");
$.get(
"index.php?r=unit/update&id"+fID,
{
id: fID
},
function (data)
{
$("#unit-modal").find(".modal-body").html(data);
$(".modal-dialog").removeClass("modal-md");
$(".modal-dialog").addClass("modal-lg");
$(".modal-body").html(data);
$(".modal-title").html("แก้ไขหน่วยงาน");
$("#unit-modal").modal("show");
}
);
});
}
init_click_handlers();
$("#unit_pjax_id").on("pjax:success", function() {
init_click_handlers(); 
});

');

// $(".save_eform_unit").click(function() {
//     $.pjax.reload({container: "#unit_pjax_id"});
// });
?>


<div class="modal" id="manageform">
<div class="modal-dialog">
	<div class="modal-content">

		<form id="frmValues">
			<div class="modal-header">
				<h5 class="modal-title"><dt>จัดการแบบฟอร์มหน่วยงาน <span id="show_unitname"></span></dt></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div id="show_error"></div>
			<div class="modal-body show_data_eform">
			</div>

			<div class="text-center p-3">
				<hr>
				<button type="button" class="btn btn-success save_eform_unit">บันทึก</button>

			</div>
		</form>
	</div>
</div>
</div>

<script>
function convertDate(date){
	var date_auth =
	date.getFullYear() + "" +
	("00" + (date.getMonth() + 1)).slice(-2) + "" +
	("00" + (date.getDate())).slice(-2) + "-" +
	("00" + date.getHours()).slice(-2) + "" +

	("00" + date.getMinutes()).slice(-2);
	return date_auth;
}

$(document).ready(function(){
	$(document).on('click', '.manageform', function(){
		var show_data_eform = '';
		var show_eform_template = [];
		var unitname = $(this).data('unit_name');
		var unitid = $(this).data('unit_id');
		$("#show_unitname").html(": "+unitname);
		$.ajax({
			url:"index.php?r=unit/manage_eform&type=show&auth=Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>&unitid="+unitid,
			method:"GET",
			dataType:"json",
			contentType: "application/json; charset=utf-8",
			success:function(data)
			{
				show_data_eform += `

				<input class="form-control" id="TableSearch" type="text" placeholder="ค้นหา..">
				<div class="custom-controls-stacked" style="padding: .7rem!important;" id="hideselectall">
				<label class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="select-all">
				<span class="custom-control-label"><b>เลือกทั้งหมด</b></span>
				</label>
				</div>
				<div style="height:300px; overflow: auto;">
				<table class="table mb-0" id="TableEtemplate">
				<tbody>
				`;
				if (data.length>0) {
					$.each(data, function(index) {
						show_eform_template.push(`
							<tr>
							<td scope="row">
							<div class="custom-controls-stacked">
							<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input checkbox_eform" name="checkbox_eform[]" value="${data[index].id}" ${data[index].checked}>
							<span class="custom-control-label">${data[index].detail}</span>
							</label>
							</div>
							<input type="hidden" name="eform_id_check[]" id="eform_id_check" value="${data[index].id}">
							<textarea name="unit_id[${data[index].id}]" style="display:none;height:0px;">${data[index].unit_id}</textarea>
							</td>
							</tr>
							`);
					});

					show_data_eform += show_eform_template.join("");
					show_data_eform += `</tbody>
					</table></div>`;

					show_data_eform += `<input type="hidden" name="unit_id_check" id="unit_id_check" value="${unitid}">`;

					$(".show_data_eform").html(show_data_eform);
				}
			},
		});
	});

	$(document).on('click', '#select-all', function(){
		$('input[type="checkbox"].checkbox_eform').prop('checked', this.checked);
	});

	$(document).on('keyup', '#TableSearch', function(){
		var value = $(this).val().toLowerCase();
		if (value.length>0) {
			$("#hideselectall").css('display', 'none');
		}else{
			$("#hideselectall").css('display', 'block');
		}
		$("#TableEtemplate tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$(document).on('click', '.save_eform_unit', function(){
		var frmValues = $('#frmValues').serialize();
		var unitid = $("#unit_id_check").val();
		$.ajax({
			url:"index.php?r=unit/manage_eform&type=update_data&auth=Authenticator=>2ffa459adcc37176dbf93a82addf61dc"+convertDate(new Date())+"&unitid="+unitid,
			data: frmValues,
			type: 'post',
			dataType: 'json',
			// processData: false,
			// 		contentType: false,
			// 		mimeType: "multipart/form-data",
			// 		global: false,
			// 		async: false,
			// 		crossDomain: true,
			success:function(data)
			{
				console.log(data);
				// if (data.output==1) {
					$("#show_error").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle" aria-hidden="true"></i></strong> บันทึกข้อมูลสำเร็จ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
// $("#manageform").modal("hide");
// $.pjax.reload({container: "#unit_pjax_id", async: false});
setTimeout(function(){ location.reload(); }, 2000);
// }else{
// $("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
// }
}
});
	});

});


</script>
