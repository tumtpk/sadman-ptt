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
<script src="../../link-timeline/moment-with-locales.js"></script>
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
		var data = [{"id":1,"topic":"Macaque, bonnet","content":"Shuangwang","date_time":"2020-09-03 07:47:04","detail":"leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio"},{"id":2,"topic":"Deer, savannah","content":"Lianhua","date_time":"2020-11-05 06:01:48","detail":"praesent id massa id nisl venenatis lacinia aenean sit amet justo morbi ut odio cras mi pede malesuada in imperdiet"},{"id":3,"topic":"Beisa oryx","content":"Milići","date_time":"2020-07-07 09:19:09","detail":"nunc donec quis orci eget orci vehicula condimentum curabitur in libero ut massa volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus sit amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula"},{"id":4,"topic":"Snake, buttermilk","content":"Miyazu","date_time":"2020-07-20 02:53:16","detail":"convallis duis consequat dui nec nisi volutpat eleifend donec ut dolor morbi vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum sit amet cursus id turpis integer aliquet massa id lobortis convallis tortor risus dapibus augue vel accumsan tellus nisi eu orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi a ipsum integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi quis tortor id"},{"id":5,"topic":"Red-headed woodpecker","content":"Sangzhou","date_time":"2020-08-07 11:30:10","detail":"nulla suspendisse potenti cras in purus eu magna vulputate luctus cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia aenean sit amet justo morbi ut odio cras mi pede malesuada in imperdiet et commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus"},{"id":6,"topic":"White-nosed coatimundi","content":"Batutulis","date_time":"2020-07-07 16:49:20","detail":"ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia"}];


		
		for (i = 0; i < data.length; i++) {
			var id = data[i]['id'];
			var topic = data[i]['topic'];
			var content = data[i]['content'];
			var date_time = data[i]['date_time'];
			var detail = data[i]['detail'];

			var start = date_time.substr(0,14);
			var start2 = start.replace('"', '');
			var start3 = start2+':00:00';

			var col = start2.split(' ', 2);
			var cols = col[1];

			var end = date_time.substr(0,14);
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

			if (cols < '08') {
				var rows = "1";
			}else if (cols < '10') {
				var rows = "2";
			}else if (cols < '12'){
				var rows = "3";
			}else if (cols < '14'){
				var rows = "4";
			}

			showdetail.push(`<li data-timeline-node="{start:'${start3}',end:'${end3}',row:${rows},bgColor:'${colors}',color:'#ffffff',content:'${detail}'}" >${topic}</li>`);

			// showdetail.push(`<li data-timeline-node="{start:'${start3}',end:'${end3}',row:1,bgColor:'${colors}',color:'#ffffff',content:'${content}'}" >${topic}</li>`);
		}

		console.log(showdetail);
		$("#visualization").html(showdetail.join());



		$("#myTimeline").timeline({
			//startDatetime   :"currently",
			startDatetime   :"2020-07-15",
			endDatetime     :"auto",
			// "years" or "months" or "days"
			scale           :"months",

			// displays footer
			headline          : {
				display     : true,
				content     : "",
				range       : false,
				locale      : "fr",
				format      : { hour12: false }
			},

			
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


