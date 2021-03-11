<?php
use app\models\Setting;

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

if (isset($_POST['report_template'])) {
	$report_template = $_POST['report_template'];
	$setting_report = $_POST['setting_report'][0];
}else{
	$id = $_GET['id'];
	$users_report = Yii::$app->db->createCommand("SELECT * FROM users_report WHERE id = '".$id."'")->queryOne();

	$report_template = @json_decode($users_report['data_json'],TRUE);
	$setting_report = array(
		'header' => "".$users_report['header_report']."",
		'footer' => "".$users_report['footer_report']."",
		'logo' => "../../images/logo_users_report/".$users_report['logo_report']."",
		'pos_logo' => "".$users_report['position_logo']."",
	);
}

// var_dump($setting_report);
$data_json_string = @json_encode($report_template,TRUE);
?>


<style>
.img-object{
	object-fit:cover;
	width: 100% !important;
	object-position: 50% 50% !important;
}
thead.report-header {
	display: table-header-group;
}

tfoot.report-footer {
	display:table-footer-group;
}
table.report-container {
	page-break-after: always;
	page-break-inside:auto;
}

tr { page-break-inside:avoid; page-break-after:auto }

body {
	/*background: rgb(204,204,204); */
}
.card-border {
	padding-top: 1em;
	padding-left: 1em;
	padding-right: 1em;
	padding-bottom: 0.7em;
}
page {
	padding: 16mm;
	background: white;
	display: block;
	margin: 0 auto;
	margin-top: 0.5cm;
	margin-bottom: 0.5cm;
	box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
	width: 20cm;
	height: 29.7cm;
	overflow:auto;
}

div.main{
	min-height: 45vh !important;
}

.header-logo{
	width: 80px;
	height: auto;
}

div.pagebr
{
	page-break-inside:always;
}


@media print {
	div.pagebr
	{
		page-break-inside:always;
	}

	body {
		background: rgb(255,255,255); 
		font-size: 2rem !important;
		font-weight: 400 !important;
		line-height: 1.5 !important;
	}
	@page 
	{
		background: white;
		margin: 0 auto;
		mso-title-page:yes;
		mso-page-orientation: portrait;
		mso-header: header;
		mso-footer: footer;
	}
	@page content {margin: 50cm;}
	tbody.report-content {page: content;}
	div.header-info {
		padding: 5em 2.5em 2em 2.5em;
		text-align: justify;
	}
	div.footer-info{
		padding: 1em 2.5em 5em 2.5em;
		text-align: justify;
	}
	div.main{
		/*min-height: 99.5vh !important;*/
		padding: 0em 2.5em 0em 2.5em;
		text-align: justify;
	}
	.page-break-clear { 
		clear: both;
	}
	.page-break {
		page-break-after: always; /* depreciating, use break-after */
		break-after: page;
		height: 0px;
		display: block!important;
	}
	.break-before {
		break-before: page;
	}
}
.show-map{
	page-break-before: auto;
    page-break-after: auto;
    page-break-inside: auto;
}
</style>

<script type="text/javascript" src="../../js/jquery-3.5.1.min.js"></script>

<?php if (isset($_GET['printnow'])): ?>
	<link rel="stylesheet" href="../../html-version/assets/css/style.css"/>
	<link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<script>
		$(document).ready(function() {

			var str = document.getElementById("printarea").innerHTML; 
			var res = str.replace('<page size="A4">', "");
			var res2 = res.replace('</page>', "");
			$("#printarea").html(res2);
			printDiv('printarea');
			function printDiv(divname){
				var printContents = document.getElementById(divname).innerHTML;
				var originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			}


		});
	</script>
<?php endif ?>


<div id="printarea">

	<page size="A4">

		<table class="report-container">
			<thead class="report-header">
				<tr>
					<th>
						<div class="header-info">
							<?php if ($setting_report['pos_logo']=='1'): ?>
								<div class="row">
									<div class="col-md-1">
										<img src="<?php echo $setting_report['logo']; ?>" class="header-logo">
									</div>
									<?php $style_header_record = (isset($_GET['printnow'])) ? 'padding-left: 1.3em;' : 'padding-left: 3em;'; ?>
									<div class="col-md-11" style="<?=$style_header_record;?>">
										<?php echo $setting_report['header']; ?>
									</div>
								</div>
							<?php endif ?>
							<?php if ($setting_report['pos_logo']=='2'): ?>
								<div class="text-center">
									<img src="<?php echo $setting_report['logo']; ?>" class="header-logo">
								</div>
								<?php echo $setting_report['header']; ?>
							<?php endif ?>
							<?php if ($setting_report['pos_logo']=='3'): ?>
								<div class="row">
									<div class="col-md-10">
										<?php echo $setting_report['header']; ?>
									</div>
									<div class="col-md-2">
										<img src="<?php echo $setting_report['logo']; ?>" class="header-logo">
									</div>
								</div>
							<?php endif ?>
							<?php if ($setting_report['pos_logo']=='0'): ?>
								
								<?php echo $setting_report['header']; ?>
							<?php endif ?>
							
							<hr>
						</div>
					</th>
				</tr>
			</thead>
			<tfoot class="report-footer">  
				<tr> 
					<td>
						<div class="footer-info">
							<hr>
							<?php echo $setting_report['footer']; ?>
						</div>
					</td>
				</tr>
			</tfoot>
			<tbody class="report-content"> 
				<tr> 
					<td>
						<div class="main row" id="show-preview22">
						</div>
						
					</td>
				</tr>
			</tbody>
		</table>



	</page>
</div>

<script type="text/javascript">
	jQuery(function ($) {
		$(document).ready(function(){
			var data_json = [];
			var col_size = [];
			<?php if (!empty($data_json_string)): ?>
				var date_get = [<?=$data_json_string;?>];
				data_json = date_get[0];
			<?php endif ?>

			console.log(data_json);

			var sort = 0;

			
			<?php if (isset($_GET['printnow'])): ?>
				col_size = [
				{
					col_id:"3",
					height:"220",
				},
				{
					col_id:"4",
					height:"280",
				},
				{
					col_id:"6",
					height:"450",
				},
				{
					col_id:"12",
					height:"470",
				},
				];
				<?php else: ?>
					col_size = [
					{
						col_id:"3",
						height:"150",
					},
					{
						col_id:"4",
						height:"180",
					},
					{
						col_id:"6",
						height:"250",
					},
					{
						col_id:"12",
						height:"300",
					},
					];
				<?php endif; ?>

				show_preview_design();

				function show_preview_design(){
					var showmap = [];
					var data = data_json;
					var show_preview_design = [];
					$.each(data, function(i) {
						var $data_show = ``;
						if (data[i].type==1) {
							var data_news = get_data_news_byid(data[i].id_news);
							$data_show = `
							<div style="break-after:page"></div>
							<div class="col-12" data-sort="${data[i].sort}">
							<div class="card-border"><div data-id_news="${data[i].id_news}" data-sort="${data[i].sort}" data-type="${data[i].type}">${data_news[0].show_all_class}</div>
							</div></div>`;
						}

						if (data[i].type==2) {
							var datatext = data[i].data_textarea.replace(/&amp;/g,'');
							var datatext2 = datatext.replace(/lt;/g,'');
							var datatext3 = datatext2.replace(/gt;/g,'');
							var datatext4 = datatext3.replace(/amp;/g,'');
							var datatext5 = datatext4.replace(/br/g,'<br>');
							// var datatext2 = datatext.replace(/&amp;lt;br&amp;gt;&amp;lt;br&amp;gt;/g,'<br>');
							$data_show = `<div style="break-after:page"></div><div class="col-12" data-sort="${data[i].sort}">
							<div class="card-border">${datatext5}</div>
							</div></div>`;
						}

						if (data[i].type==3) {
							var name_div = data[i].namedivshow+"_show";
							var coor = data[i].coor;
							$data_show = `
							<div class="row show-map">
							
							<div class="col-md-12"><div style="break-after:page"></div></div>
							<div class="col-md-12"><div style="break-after:page"></div>
							
							</div></div>
							<div style="break-after:page"></div>
							<div class="col-12 mt-2">
							<div id="hide_${name_div}">
							<div class="card-border show-map" id="${name_div}" style="width: 100%; height: 400px;">
							</div>
							</div>
							<div class="card-border" id="${name_div}_showimg" style="width: 100%; ">
							</div>
							</div>
							`;

							showmap.push({sort:data[i].sort,name_div:name_div,lat:coor.lat,lon:coor.lon});
						}

						if (data[i].type==4) {

							var urlimage = get_url_images(data[i].namefile);
							var height_use = col_size.find(x => x.col_id === ""+data[i].col_md+"").height;
							$data_show = `
							<div style="break-after:page"></div>
							<div class="col-${data[i].col_md}" data-sort="${data[i].sort}" style="">
							<div>
							<br>
							<a href="${urlimage}" class="">
							<img class="img-object" style="height:${height_use}px !important;" src="${urlimage}" alt="">
							</a>
							</div></div>
							`;
						}

						show_preview_design.push(`
							${$data_show}
							`);
					});
					$("#show-preview22").html(show_preview_design.join(""));
					$("#testtest").html(show_preview_design.join(""));

					loopshowmap(showmap);

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

				function loadmap(divid,idsort,lat,lon){
					var mymap = null;
					var mapElement = document.querySelector("#"+divid);
					if (lat!='' && lon!='') {
						mymap = L.map(divid).setView([lat, lon], 10);
					}else{
						mymap = L.map(divid).setView([13.732564, 100.515000], 5);
					}

					var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
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


					$(divid).css('position', 'inherit');

					tiles.on('load', function() {
						domtoimage.toPng(mapElement, {
							width: mymap.getSize().x,
							height: mymap.getSize().y
						})
						.then(function (dataUrl) {
								// document.getElementById('screenshot').src = dataUrl;
								// console.log(dataUrl);
								// $("#hide_"+divid).css('display', 'none');
								// $("#"+divid+"_showimg").html('<img src="'+dataUrl+'">');
								
							});
					});



				}



			});
});
</script>


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

<script src="https://unpkg.com/dom-to-image"></script>

