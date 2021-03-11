<?php
use app\models\Setting;
$this->title = 'Timeline';

$url_kibana =  $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
$index =  $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;

?>
<!-- Core css -->
<link rel="stylesheet" href="../../html-version/assets/css/main.css"/>
<link rel="stylesheet" href="../../html-version/assets/css/theme1.css"/>
<!-- style by pd -->
<link rel="stylesheet" href="../../html-version/assets/css/style.css"/>

<script type="text/javascript" src="../../js/jquery-3.5.1.min.js"></script>

<link rel="stylesheet" href="../../html-version/assets/css/style_link_timeline.css"/>
<script src="../../link-timeline/handlebars.min.js"></script>
<script src="../../link-timeline/moment-with-locales.js"></script>
<script id="item-template" type="text/x-handlebars-template">

	<table class="score" data-date="{{datethai}}" data-title="{{title}}" data-detail="{{detail}}"  data-content="{{content}}" onclick="modalDetail(this)">
		<tr>
			<td><img src="{{img}}" class="logo"></td>
			<td>{{title}}</td>
		</tr>
		<tr>
			<td></td>
			<td>{{content}}</td>
		</tr>
		<tr>
			<td></td>
			<td>{{detail}}</td>
		</tr>
	</table>

</script>

<script src="../../link-timeline/vis-timeline-graph2d.min.js"></script>
<link href="../../link-timeline/vis-timeline-graph2d.css" rel="stylesheet" type="text/css"/>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-status"></div>
			<div class="card-header bline">
				<h3 class="card-title">Timeline</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="menu">
							<div class="row">
								<div class="col-md-3">
									<select id="yearVis" name="yearVis" class="form-control inline-block">
										<option selected value=''>-- เลือกปีของข้อมูล --</option>
										<?php 
										$firstYear = (int)date('Y');
										$lastYear = $firstYear - 10;
										for($i=$firstYear;$i>=$lastYear;$i--){
											?>
											<option value="<?=$i;?>"><?=$i;?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<button class="btn btn-secondary" id="moveLeft" value="<?=date('Y');?>">ปีก่อนหน้า</button>
									<button class="btn btn-secondary" id="moveRight" value="<?=date('Y');?>">ปีถัดไป</button>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div id="visualization"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<div class="modal fade show" id="modal-true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="z-index: inherit;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-show"></h5>
				<button type="button" id="close-modal" class="close close-modal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="relationship_show"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">ปิด</button>
			</div>
		</div>
	</div>
	<div class="modal-backdrop show"></div>
</div> 

<script>
	$(document).ready(function(){
		var showdetail = [];
		var match = { size: 30 };

		function time_str(val){
			var res = val.substr(0,14);
			var res2 = res+':00:00';
			return res2;
		}

		function img_str(val){
			var imgs = val.slice(1,-1);
			return imgs;
		}

		function txt_str(val){
			var text = val.slice(1,-1);
			return text;
		}


		var form_data = new FormData();
		form_data.append("query", ""+JSON.stringify(match)+"");
		var id = <?php echo $_GET['id']; ?> ;
		$.ajax({
			url: "index.php?r=site/json-timeline&id="+id,
			method: "GET",
			dataType: "json",
			async: false,
		})
		.done(function(data
			) {
			for (i = 0; i < data.length; i++) {
				var name = JSON.stringify(data[i].unit_name);
				var date_record = JSON.stringify(data[i].date_time);
				var type = JSON.stringify(data[i].action);
				var user_name = JSON.stringify(data[i].user_view);
				var img = JSON.stringify(data[i].img_user);
				var datethai = JSON.stringify(data[i].date_thai);


				showdetail.push({
					title: txt_str(type),
					detail: txt_str(name),
					content: txt_str(user_name),
					img: img_str(img),
					start: time_str(date_record),
					datethai: txt_str(datethai),
				});

			}

			timelinedata(showdetail);
			//console.log(showdetail);
			
		});

	});


	function timelinedata(showdetail) {
	  	// create a handlebars template
	  	var source   = document.getElementById('item-template').innerHTML;
	  	var template = Handlebars.compile(document.getElementById('item-template').innerHTML);
		// DOM element where the Timeline will be attached
		var container = document.getElementById('visualization');

		var data_set = showdetail;
		// console.log(data_set);
		var items = new vis.DataSet(data_set);
	  	// specify a template for the items
	  	var options = {
	  		template: template,
	  		locale: 'th'
	  	};
		// Create a Timeline
		var timeline = new vis.Timeline(container, items, options);

		var currentDate = new Date();
		timeline.moveTo(currentDate);
		
		$("#yearVis").change(function()
		{
			var id = $(this).val();
			var dataString = id+'-01-01 00:00:00';
			console.log(dataString);
			timeline.moveTo(dataString);		
		});

		$(document).on('click', '#moveLeft', function(){
			var range = timeline.getWindow();
			var interval = range.end - range.start;
			timeline.setWindow({
				start: range.start.valueOf() - interval * 1,
				end:   range.end.valueOf()   - interval * 1
			});
		});

		$(document).on('click', '#moveRight', function(){
			var range = timeline.getWindow();
			var interval = range.end - range.start;
			timeline.setWindow({
				start: range.start.valueOf() - interval * -1,
				end:   range.end.valueOf()   - interval * -1
			});	
		});


		// $('button').click(function(){
		// 	var id = $('.selectYear').attr('data-id');
		// 	var dataString = id+'-01-01 00:00:00';
		// 	console.log(id);
		// 	timeline.moveTo(dataString);	
		// });
	}

	function modalDetail(identifier){
		var date = $(identifier).data('date');
		var title = $(identifier).data('title');
		var detail = $(identifier).data('detail');
		var content = $(identifier).data('content');

		$("#modal-title-show").html('<dt>ประเภทการดำเนินการ : '+title+'</dt>');
		$("#relationship_show").html('หน่วย : <b>'+detail+'</b><br>ชื่อผู้ใช้งาน : '+content+'<br>เวลาที่ดำเนินการ : '+date);
		$("#modal-true").css("display", "block");

	}

	$(document).on('click', '.close-modal', function(){
		$("#modal-true").css("display", "none");
		$("#modal-false").css("display", "none");
	});

</script>




