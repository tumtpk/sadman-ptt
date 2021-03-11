<?php
use app\models\Setting;
$this->title = 'Timeline Tab';

$url_kibana = $Setting = Setting::find()->where(['setting_name' => 'url_kibana'])->one()->setting_value;
$url_elasticsearch = $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;
$index = $Setting = Setting::find()->where(['setting_name' => 'index'])->one()->setting_value;

?>
<!-- Core css -->
<link rel="stylesheet" href="../../html-version/assets/css/main.css"/>
<link rel="stylesheet" href="../../html-version/assets/css/theme1.css"/>
<!-- style by pd -->
<link rel="stylesheet" href="../../html-version/assets/css/style.css"/>
<script type="text/javascript" src="../../js/jquery-3.5.1.min.js"></script>

<link href="../../link-timeline-tab/timeline.min.css" rel="stylesheet">
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-status"></div>
			<div class="card-header bline">
				<h3 class="card-title">Timeline Tab</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						
						<div id="myTimeline">
							<ul class="timeline-events" id="visualization">

							</ul>
						</div>

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
				<h5 class="modal-title"></h5>
			</div>
			<div class="modal-body">
				<div class="timeline-event-view"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">ปิด</button>
			</div>
		</div>
	</div>
	<div class="modal-backdrop show"></div>
</div> 

<!-- /.modal -->
<!-- tether 1.4.0 (for using bootstrap's tooltip component) -->
<script src="../../link-timeline-tab/tether.min.js" crossorigin="anonymous"></script>
<!-- jQuery Timeline -->
<script src="../../link-timeline-tab/timeline.min.js"></script>
<!-- local scripts -->
<script>
	$(document).ready(function(){

		var showdetail = [];
		var match = { size: 200 };

		var form_data = new FormData();
		form_data.append("query", ""+JSON.stringify(match)+"");

		$.ajax({
			url: "index.php?r=site/elastic-getdata",
			method: "POST",
			processData: false,
			contentType: false,
			mimeType: "multipart/form-data",
			data: form_data,
			global: false,
			dataType: "json",
			async: false,
			crossDomain: true,

		})
		.done(function( msg ) {
			var data = msg.hits.hits;
			console.log(data);
			for (i = 0; i < data.length; i++) {
				var name = JSON.stringify(data[i]._source.name);
				var date_record = JSON.stringify(data[i]._source.date_record);
				var ids = JSON.stringify(data[i]._source.id);

				var rows = JSON.stringify(data[i]._source.form_version);
				var parts = rows.split('.', 2);
				var the_text = parts[0];

				var content = JSON.stringify(data[i]._source.content);
				var content2 = content.replace('"', '');
				var content3 = content2.replace('."', '');
				
				var start = date_record.substr(0,14);
				var start2 = start.replace('"', '');
				var start3 = start2+':00:00';


				var col = start2.split(' ', 2);
				var cols = col[1];

				var end = date_record.substr(0,14);
				var end2 = end.replace('"', '');
				var end3 = end2+':59:00';

				if (cols < '08') {
					var colors = "#89C997";
				}else if (cols < '10') {
					var colors = "#72B7C9";
				}else if (cols < '12'){
					var colors = "#E2C867";
				}else if (cols < '14'){
					var colors = "#EF857D";
				}


				// showdetail.push(`<li data-timeline-node="{start:'${start3}',end:'${end3}',row:4,bdColor:'#942343'}">${name}</li>`);
				showdetail.push(`<li data-timeline-node="{start:'${start3}',end:'${end3}',row:${the_text}
					,bgColor:'${colors}',color:'#ffffff',content:'${content3}'}" >${name}</li>`);
			}
			
			console.log(showdetail);
			$("#visualization").html(showdetail.join());
		});

		$("#myTimeline").timeline({
			//startDatetime   :"currently",
			startDatetime   :"2020-06-25",
			// endDatetime     :"auto",
			// "years" or "months" or "days"
			scale           :"months",

			
		});

		$('.timeline-node').each(function(){
			if ( $(this).data('toggle') === 'popover' ) {
				$(this).attr( 'title', $(this).text() );
				$(this).popover({
					trigger: 'hover'
				});
			}
		});


		$(document).on('click', '.timeline-node', function(){
			var id = $(this).data('id');
			var title = $(this).data('title');
			var content = $(this).data('content');

			console.log(id);

			$("#modal-title-show").html('<dt>'+title+'</dt>');
			$("#relationship_show").html(''+content+'');
			$("#modal-true").css("display", "block");

		});


		$(document).on('click', '.close-modal', function(){
			$("#modal-true").css("display", "none");
			$("#modal-false").css("display", "none");
		});


	});
</script>
