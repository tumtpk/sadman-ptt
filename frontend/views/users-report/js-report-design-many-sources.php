<?php
use app\models\Setting;


$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

$logo_pic = (!empty($model->logo_report)) ? "../../images/logo_users_report/".$model->logo_report : "../../images/logo_users_report/none.png";

?>


<script type="text/javascript">
	jQuery(function ($) {
		$(document).ready(function(){
			
			var data_json_old = $("#usersreport-data_json").html();
			var setting_report = [{
				header:'<?=$model->header_report;?>',
				footer:'<?=$model->footer_report;?>',
				logo:'<?=$logo_pic;?>',
				pos_logo:'<?=$model->position_logo;?>',
			}];

			$(document).on('focusout', '#header_footer', function(){
				show_preview_design();
			});

			$(document).on('click', 'input[name="UsersReport[position_logo]"]', function(){
				var pos_logo = $(this).val();
				setting_report[0].pos_logo = pos_logo;
				show_preview_design();
			});


			$(document).on('change', '#upload-logo', function(){
				var src_img = $("#logo_pic").attr("src");
				setting_report[0].logo = src_img;
				show_preview_design();
			});

			var data_json = [];
			var sort = 0;

			<?php if (!empty($model->data_json)): ?>
				data_json = JSON.parse(data_json_old);
				var lastsort = Object.keys(data_json).length-1;
				sort = data_json[lastsort].sort;
			<?php endif ?>

			show_preview_design();

			var col_size = [
			{
				col_id:3,
				height:150,
			},
			{
				col_id:4,
				height:180,
			},
			{
				col_id:6,
				height:220,
			},
			{
				col_id:12,
				height:300,
			},
			];

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

			var count = 0;
			$('#upload-images').change(function(){
				upload();
				count = 0;
			});

			function upload() {
				var files = document.querySelector("#upload-images").files;
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

					retrieveNewURL(file_all,namebucket,namefile, nameold, file, (file, url,namebucket,namefile,nameold) =>{

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

				fetch(`<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/uploadminio?name=${file.name}&bucket=${namebucket}&namefile=${namefile}`).then((response) => {
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
					body: file,
				}).then(() => {
					count = count+1;
					if (count==file_all) {
						$('.show-status').html(`
							<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"></button>
							<i class="fas fa-check-circle fa-3x"></i>
							<h6 class="mt-3"><dt>อัพโหลดไฟล์สำเร็จ</dt></h6>
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

					insertDatabase(namefile,namebucket,namefileold)
				}).catch((e) => {
					console.error(e);
				});
			}

			function insertDatabase(namefile,namebucket,namefileold){
				$.ajax({
					url:"index.php?r=users-report/json_report_design_many_sources",
					method:"GET",
					data:{ type: "insert_images_user_report",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",namefile:namefile,namebucket:namebucket,namefileold:namefileold,userid:<?=$_SESSION['user_id']?>},
					dataType:"json",
					contentType: "application/json; charset=utf-8",
					success:function(data)
					{
						var arrayimages = [{
							idfile_sql:data.status,
							namefile:namefile,
							namefileold:namefileold,
						}]
						pushon_data_json(arrayimages);
					}
				});
			}

			function pushon_data_json(arrayimages){
				$.each(arrayimages, function(i) {
					sort = sort + 1;
					data_json.push({
						sort:sort,
						idfile_sql:arrayimages[i].idfile_sql,
						namefile:arrayimages[i].namefile,
						namefileold:arrayimages[i].namefileold,
						type:4,
						col_md:3,
						height:150
					});
				});
				show_preview_design();
			}


			load_data_eform_template();
			function load_data_eform_template(){
				var show_data_eform_template = [];
				$.ajax({
					url:"index.php?r=users-report/json_report_design_many_sources",
					method:"GET",
					dataType:"json",
					data:{ type: "show_eform_templete",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>"},
					contentType: "application/json; charset=utf-8",
					success:function(data){
						$.each(data, function(i) {
							show_data_eform_template.push(`<li class="list-group-item clickmodal" data-toggle="modal" data-target=".shownew" data-form_id="${data[i].form_id}" data-form_name="${data[i].form_name}">
								${data[i].form_name}
								<div class="float-right">
								<b>(${data[i].count})</b>
								</div>
								</li>`);
						});
						$('#show_eform_templete').html(show_data_eform_template.join(""));
					}
				});
			}

			$(document).on('click', '.clickmodal', function(){
				var form_id = $(this).data('form_id');
				var form_name = $(this).data('form_name');
				$("#form_id_check").val(form_id);
				$(".modal-title").html(form_name);
				show_eform_data_today(form_id);
			});

			$(document).on('click', '#btn_search', function(){
				var search_news = $("#search_news").val();
				var date_search = $(".get_val_datetime").val();
				var form_id = $("#form_id_check").val();

				if (date_search!='') {
					$.ajax({
						url:"index.php?r=users-report/json_report_design_many_sources",
						method:"GET",
						dataType:"json",
						data:{ type: "search_value",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",form_id:form_id,date_search: date_search,text_search:search_news},
						contentType: "application/json; charset=utf-8",
					})
					.done(function(data){
						if(data.length>0){
							show_content(data,'shownews');
						}else{
							$("#shownews").html('<div class="text-center mt-4"><b>ไม่พบข้อมูล</b></div>');
						}
					});

				}else{
					alert('กรุณาเลือกวันที่บันทึก');
				}

			});


			function show_eform_data_today(form_id){
				$.ajax({
					url:"index.php?r=users-report/json_report_design_many_sources",
					method:"GET",
					dataType:"json",
					data:{ type: "today",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",form_id:form_id},
					contentType: "application/json; charset=utf-8",
					success:function (data) {
						if(data.length>0){
							show_content(data,'shownews');
						}else{
							$("#shownews").html('<div class="text-center mt-4"><b>ไม่มีข้อมูลของวันนี้</b></div>');
						}
					}
				})
			}


			$(document).on('click', 'input[name="select-news"]', function(){
				var id = $(this).val();
				var name = $(this).data("name");
				var key = $(this).data("key");
				sort = sort+1;
				if ($(this).is(':checked')) {
					$("#modal-true").css("display", "block");
					data_json.push({
						sort:sort,
						id_news:id,
						type:1,
					});
				}else{
					var index = data_json.map(x => {
						return x.id_news;
					}).indexOf(id);
					if (index!=-1) {
						data_json.splice(index, 1);
					}
				}

				show_preview_design();

			});

			function show_preview_design(){
				console.log(data_json);
				var showmap = [];
				var data = data_json;
				var show_preview_design = [];
				$.each(data, function(i) {
					var $data_show = ``;
					if (data[i].type==1) {
						var data_news = get_data_news_byid(data[i].id_news);
						$data_show = `<div class="text_body ui-state-default col-md-12" data-sort="${data[i].sort}">
						<div class="text_data card-move card card-report"><button type="button" class="btn btn-danger remove_eform btn-sm" style="position: absolute;z-index: 1;right: 8px;" data-sort="${data[i].sort}" data-type="${data[i].type}"><i class="fa fa-trash" aria-hidden="true"></i></button><div class="col-md-12" data-id_news="${data[i].id_news}" data-sort="${data[i].sort}" data-type="${data[i].type}">${data_news[0].show_all_class}</div>
						</div></div>`;
					}

					if (data[i].type==2) {
						$data_show = `<div class="text_body ui-state-default col-md-12" data-sort="${data[i].sort}">
						<div class="text_data card-move card card-report"><button type="button" class="btn btn-danger remove_eform btn-sm" style="position: absolute;z-index: 1;right: 8px;" data-sort="${data[i].sort}" data-type="${data[i].type}"><i class="fa fa-trash" aria-hidden="true"></i></button><div class="focusin_save_data col-md-12" data-sort="${data[i].sort}"><textarea class="form-control" id="textarea_${data[i].sort}" rows="7" data-type="${data[i].type}" data-sort="${data[i].sort}">${data[i].data_textarea}</textarea></div>
						</div></div>`;
					}

					if (data[i].type==3) {
						var name_div = data[i].namedivshow;
						var coor = data[i].coor;
						$data_show = `
						<div class="text_body ui-state-default col-md-12" data-sort="${data[i].sort}">
						<div class="text_data card-move card card-report"><button type="button" class="btn btn-danger remove_eform btn-sm" style="position: absolute;z-index: 1;right: 8px;" data-sort="${data[i].sort}" data-type="${data[i].type}"><i class="fa fa-trash" aria-hidden="true"></i></button>
						<div class="col-md-12">
						<h3 class="card-title"><dt><i class="fa fa-map-marker" style="color: #dc3545 !important;"></i> เลือกพิกัดจากแผนที่ (ละติจูด , ลองจิจูด)</dt></h3>
						<div class="row">
						<div class="col-md-6">
						<input type="text" class="form-control latcheck" placeholder="กรอกละติจูด" id="${name_div}_lat" onkeypress="return validateQty(this,event);" value="${coor.lat}" data-sort="${data[i].sort}">
						</div>
						<div class="col-md-6">
						<input type="text" class="form-control loncheck" placeholder="กรอกลองจิจูด" id="${name_div}_lon" onkeypress="return validateQty(this,event);" value="${coor.lon}" data-sort="${data[i].sort}">
						</div>
						<div class="col-md-12 pt-2">
						<div id="${name_div}" style="width: 100%; height: 400px;"></div>
						</div>
						
						<button type="button" class="btn btn-success save_lat_lon btn-sm" style="position: absolute;z-index: 10000;right: 8px;bottom:0;" data-sort="${data[i].sort}" data-name_div="${name_div}" data-type="${data[i].type}">บันทึกข้อมูลแผนที่</button>
						
						</div>
						</div>
						</div></div>
						`;

						showmap.push({sort:data[i].sort,name_div:name_div,lat:coor.lat,lon:coor.lon});
					}

					if (data[i].type==4) {
						var urlimage = get_url_images(data[i].namefile);
						$data_show = `
						<div class="text_body ui-state-default col-lg-${data[i].col_md} col-md-4 col-6" data-sort="${data[i].sort}">
						<div class="text_data card-move"><button type="button" class="btn btn-danger remove_eform btn-sm" style="position: absolute;z-index: 1;right: 8px;" data-sort="${data[i].sort}" data-type="${data[i].type}" data-nameimg="${data[i].namefile}" data-idimg="${data[i].idfile_sql}"><i class="fa fa-trash" aria-hidden="true"></i></button>
						<div class="btn-group">
						<button type="button" class="btn btn-light imgplus" data-sort="${data[i].sort}" data-col_md="${data[i].col_md}" data-height="${data[i].height}" title="เพิ่มขนาด"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-light imgminus" data-sort="${data[i].sort}" data-col_md="${data[i].col_md}" data-height="${data[i].height}" title="ลดขนาด"><i class="fa fa-minus"></i></button>
						</div>
						<a href="#" class="d-block mb-4 h-100">
						<img class="img-fluid img-thumbnail img-object" style="height:${data[i].height}px !important;" src="${urlimage}" alt="">
						</a>
						</div></div>
						`;
					}

					show_preview_design.push(`
						${$data_show}
						`);
				});
$("#show-preview").html(show_preview_design.join(""));
loopshowmap(showmap);

$("#usersreport-data_json").val(JSON.stringify(data_json))

if (data_json.length>0) {
	var arr = {report_template : data_json};
	$("#show-media-vimeo").css('display', 'block');
	// $("#media-vimeo iframe").attr("src", "index.php?r=users-report/report-design-many-sources-pdf&"+$.param(arr));
	
	var $hf = 0;
	$(".note-editable").each(function() {
		if ($hf==0) {
			var header = $(this).html();
			setting_report[0].header = header;
		}
		if ($hf==1) {
			var footer = $(this).html();
			setting_report[0].footer = footer;
		}
		$hf++;
	});

	if (setting_report[0].logo=="") {
		var src_img = $("#imgOld").attr("src");
		setting_report[0].logo = src_img;
	}

	$.ajax({
		url:"index.php?r=users-report/report-design-many-sources-pdf",
		method:"POST",
		data:{report_template : data_json,setting_report:setting_report},
		global: false,
		async:false,
		success: function(msg){
			$("#result").html(msg);
		}
	});
}else{
	$("#show-media-vimeo").css('display', 'none');
}

}

function loopshowmap(arraydiv){
	$.each(arraydiv, function(i) {
		loadmap(arraydiv[i].name_div,arraydiv[i].sort,arraydiv[i].lat,arraydiv[i].lon);
	});
}


function show_content(data_array,name_div){
	var data = data_array;
	var myarray = [];
	for (i = 0; i < data.length; i++) {
		var id = data[i]['id'];
		var topic = data[i]['data'];
		var date = data[i]['date_record'];

		var _news_checked = '';
		if(data_json.find(x => x.id_news === id)){
			_news_checked = 'checked';
		}

		myarray.push(`<div class="card card-mb-not"><div class="card-body"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input getval_check" name="select-news" value="${id}" data-topic="${topic}" ${_news_checked}><span class="custom-control-label"> ${topic} <b>วันที่บันทึก :</b> ${date}</span></label></div></div>`);

	}
	$("#"+name_div).html(myarray.join(""));
}

function get_data_news_byid(id){
	var data = null;
	var data = $.ajax({
		url:"index.php?r=users-report/json_report_design_many_sources",
		method:"GET",
		data:{ type: "byid",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",id_news:id},
		contentType: "application/json; charset=utf-8",
		global: false,
		dataType: "json",
		async:false,
		success: function(msg){
			return msg.data;
		}
	}
	).responseJSON;

	return data;
}


function get_url_images(file_name){
	var data = null;
	var data = $.ajax({
		url:"<?=$url_node['setting_value'];?>/filepathminio?namefile="+file_name+"&bucket=image",
		method:"GET",
		dataType:"json",
		contentType: "application/json; charset=utf-8",
		global: false,
		dataType: "json",
		async:false,
		success: function(msg){
			return msg;
		}
	}
	).responseJSON;

	return data.url;
}

var text_bodydivst = $('#show-preview');
$('#show-preview').sortable({
	placeholder: "ui-state-highlight",
	handle: '.text_data', 
	update: function() {
		$('.text_body', text_bodydivst).each(function(index, elem) {
			var $divstItem = $(elem),
			newIndex = $divstItem.index();
		});
		savesort();
	},
	start: function (event, ui) {
		$(".ui-state-highlight")
		.css('width', $(ui.item).css('width'));
		$(".ui-state-highlight")
		.css('height', $(ui.item).css('height'));
	},

});


function savesort(){
	var index_sort = new Array();
	$('div#show-preview div.text_body').each(function() {
		var old_sort = $(this).data("sort");
		var objIndex = data_json.map(x => x.sort).indexOf(old_sort);

		index_sort.push(objIndex);
	});

	change_sort(index_sort);
}

function change_sort(index_sort){
	for (var i = 0; i < index_sort.length; i++) {
		console.log((i+1));
		var index_key = index_sort[i];
		data_json[index_key].sort = (i+1);
	}
	var objdata = data_json.sort( function( left, right ) {
		return left.sort - right.sort;
	});
	data_json = objdata;
	show_preview_design();
}

$(document).on('click', '.remove_eform', function(){
	if(confirm('ต้องการยกเลิกข้อมูลรายการนี้ใช่หรือไม่')){
		var id_sort = $(this).data("sort");
		var type = $(this).data("type");
		if (type==4) {
			var namefile = $(this).data("nameimg");
			var file_id = $(this).data("idimg");
			$.ajax({
				url:"<?=$url_node['setting_value'];?>/removefileminio?namefile="+namefile+"&bucket=image",
				method:"GET",
				dataType:"json",
				contentType: "application/json; charset=utf-8",
				success:function(data)
				{
					deleteDatabase(file_id);
				}
			});
		}
		$.each(data_json, function(i, el){
			if (this.sort == id_sort){
				data_json.splice(i, 1);
			}
		});


		data_json = data_json;
		show_preview_design();
	}
});

function deleteDatabase(file_id){
	$.ajax({
		url:"index.php?r=users-report/json_report_design_many_sources",
		method:"GET",
		data:{ type: "deleteimg",auth:"Authenticator=>2ffa459adcc37176dbf93a82addf61dc<?=date("Ymd");?>",file_id:file_id},
		success:function(data)
		{

		}
	});
}

$(document).on('click', '.add_textarea_detail', function(){
	sort = sort + 1;
	data_json.push({
		sort:sort,
		data_textarea:"",
		type:2,
	});
	show_preview_design();
});

$(document).on('focusin', '.focusin_save_data', function(){
	var sort = $(this).data("sort");
	var keyword = `<div class="btn-group" style="width: 100%;">
	<button type="button" class="btn btn-light save_data_textarea" data-sort="${sort}"><i class="fa fa-check text-success" aria-hidden="true"></i> <b class="text-success"> บันทึกรายละเอียด</b></button>
	<button type="button" class="btn btn-light clear_data_textarea" data-sort="${sort}"><i class="fa fa-times" style="color: #dc3545 !important;" aria-hidden="true"></i> <b style="color: #dc3545 !important;"> ล้างค่า</b></button>
	</div>`;
	var html_div = $(this).html();
	var pattern = new RegExp(keyword, 'gi');
	if(!html_div.match(pattern)){
		$(this).html(html_div+keyword);
	}
});


$(document).on('click', '.clear_data_textarea', function(){
	var sort = $(this).data("sort");
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	$("#textarea_"+sort).val('');
	data_json[objIndex].data_textarea = "";
	show_preview_design();
});

$(document).on('click', '.clear_data', function(){
	data_json = [];
	show_preview_design();
	$('#show-preview').html('');
});

$(document).on('click', '.save_data_textarea', function(){
	var sort = $(this).data("sort");
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	var val_text = $("#textarea_"+sort).val();
	data_json[objIndex].data_textarea = val_text;
	show_preview_design();
});

$(document).on('change','textarea', function () {
	if (this.value.match(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g)) {
					// this.value = this.value.replace(/[^a-zA-Z0-9 ก-๏ +-/ ()@#$%&<>]/g, '');
					this.value = this.value.replace(/\"/g, "").replace(/ /g, " ");
					this.value = this.value.replace(/\'/g, "").replace(/ /g, " ");
					this.value = this.value.replace(/\n/g, "<br>").replace(/ /g, " ");
				}
			});



function loadmap(divid,idsort,lat,lon){
	var mymap = null;

	if (lat!='' && lon!='') {
		mymap = L.map(divid).setView([lat, lon], 10);
	}else{
		mymap = L.map(divid).setView([13.732564, 100.515000], 5);
	}

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '',

	}).addTo(mymap);

	if (lat!='' && lon!='') {
		L.marker([lat, lon],{
			icon: new L.Icon({
				iconSize: [30, 30],
				iconAnchor: [25, 45],
				shadowAnchor: [4, 62],
				iconUrl: '../../leaflet-0.7.3/images/marker-icon.png',
			})
		}).addTo(mymap);
	}

	var popup = L.popup();

	function onMapClick(e) {
		popup
		.setLatLng(e.latlng)
		.setContent("ตำแหน่งที่ตั้ง " + e.latlng.toString())
		.openOn(mymap);
		var latlng = e.latlng.toString().replace('LatLng(', "");
		latlng = latlng.toString().replace(')', "");
		latlng = latlng.toString().split(",");

		document.getElementById(divid+"_lat").value = latlng[0];
		document.getElementById(divid+"_lon").value = latlng[1];
		updatedatamap(idsort,latlng[0],latlng[1]);
	}

	mymap.on('click', onMapClick);

}

function updatedatamap(idsort,lat,lng){
	var sort = idsort;
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	data_json[objIndex].coor.lat = lat;
	data_json[objIndex].coor.lon = lng;
	// show_preview_design();
}

$(document).on('click','.save_lat_lon', function () {
	var sort = $(this).data("sort");
	var name_div = $(this).data("name_div");
	var lat = $("#"+name_div+"_lat").val();
	var lon = $("#"+name_div+"_lon").val();
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	data_json[objIndex].coor.lat = lat;
	data_json[objIndex].coor.lon = lon;
	show_preview_design();
});

$(document).on('focusout','.latcheck', function () {
	var sort = $(this).data("sort");
	var lat = $(this).val();
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	data_json[objIndex].coor.lat = lat;
});

$(document).on('focusout','.loncheck', function () {
	var sort = $(this).data("sort");
	var lon = $(this).val();
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	data_json[objIndex].coor.lon = lon;
});

$(document).on('click', '.add_showleftmap', function(){
	console.log(sort);
	sort = sort + 1;
	data_json.push({
		sort:sort,
		namedivshow:"mapshow_"+sort+"",
		coor:
		{
			lat:"",lon:""
		},
		type:3,
	});
	show_preview_design();
});

$(document).on('click', '.imgplus', function(){
	var sort = $(this).data("sort");
	var col_md = $(this).data("col_md");
	var height_old = $(this).data("height");
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	var height = 0;
	if (col_md==3) {
		height = col_size.find(x => x.col_id === 4).height;
		data_json[objIndex].col_md = 4;
	}else if(col_md==4){
		height = col_size.find(x => x.col_id === 6).height;
		data_json[objIndex].col_md = 6;
	}else if(col_md==6){
		height = col_size.find(x => x.col_id === 12).height;
		data_json[objIndex].col_md = 12;
	}else{
		height = height_old;
	}
	data_json[objIndex].height = height;

	show_preview_design();
});

$(document).on('click', '.imgminus', function(){
	var sort = $(this).data("sort");
	var col_md = $(this).data("col_md");
	var height_old = $(this).data("height");
	var objIndex = data_json.map(x => x.sort).indexOf(sort);
	var height = 0;
	if (col_md==12) {
		height = col_size.find(x => x.col_id === 6).height;
		data_json[objIndex].col_md = 6;
	}else if(col_md==6){
		height = col_size.find(x => x.col_id === 4).height;
		data_json[objIndex].col_md = 4;
	}else if(col_md==4){
		height = col_size.find(x => x.col_id === 3).height;
		data_json[objIndex].col_md = 3;
	}else{
		height = height_old;
	}
	data_json[objIndex].height = height;

	show_preview_design();
});


});
});
</script>

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


<script src="../../html-version/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
