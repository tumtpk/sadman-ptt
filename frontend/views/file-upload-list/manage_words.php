<?php
use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\DetailView;


$eform_template = "SELECT detail as dt FROM `eform` WHERE form_id = '".$model->form_id."' AND active = '1' AND unit_id = '".$_SESSION['unit_id']."'";
$eft = Yii::$app->db->createCommand($eform_template)->queryOne();

$this->title = $model->origin_file_name;
$this->params['breadcrumbs'][] = ['label' => 'ไฟล์จากแฟ้มข้อมูล'.$eft['dt'], 'url' => ['site/pages','view'=>'file-manager-type','form_id'=>$model->form_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

?>

<style>
.sub{
	cursor: move;
}
.sub-in-main {
	width: max-content;
	padding: 5px;
	border-radius: 5px;
	cursor: pointer;
	background-color: #E9ECEF;
	margin-bottom: 5px;
	display: inline-block;
}
.sub-in-main i {
	color: crimson;
}
</style>

<link rel="stylesheet" href="../../draggable/kendo.default-v2.min.css"/>
<script src="../../draggable/jquery-1.12.4.min.js"></script>
<script src="../../draggable/kendo.all.min.js"></script>


<div class="row clearfix">

	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h2 class="card-title"><dt>บริหารจัดการ - คำ / ประโยค</dt></h2>
				<div class="card-options">

					<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<em>Tooltip</em> <u>with</u> <b>HTML</b> เราทราบกันดีว่าระบบสาธารณสุขในไทยค่อนข้างมีปัญหา ไม่ว่าจะเรื่องการขาดแคลนบุคลากร การขาดแคลนอุปกรณ์ทางการแพทย์ ทำให้เกิดความเหลื่อมล้ำของคุณภาพการบริการ ผู้ป่วยก็มากระจุกกันอยู่ที่โรงพยาบาลขนาดใหญ่ในกรุงเทพฯ นำมาสู่ปัญหาความแออัดในโรงพยาบาล แพทย์และพยาบาลทำงานหนักอีกต่อหนึ่ง">
						?
					</button>

				</div>
			</div>
			<div class="card-body ribbon" >
				<div class="show-text">
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h2 class="card-title"><dt>ลากคำมาวางเพื่อจัดการ</dt></h2>
				<div class="card-options">

					<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="<em>Tooltip</em> <u>with</u> <b>HTML</b> เราทราบกันดีว่าระบบสาธารณสุขในไทยค่อนข้างมีปัญหา ไม่ว่าจะเรื่องการขาดแคลนบุคลากร การขาดแคลนอุปกรณ์ทางการแพทย์ ทำให้เกิดความเหลื่อมล้ำของคุณภาพการบริการ ผู้ป่วยก็มากระจุกกันอยู่ที่โรงพยาบาลขนาดใหญ่ในกรุงเทพฯ นำมาสู่ปัญหาความแออัดในโรงพยาบาล แพทย์และพยาบาลทำงานหนักอีกต่อหนึ่ง">
						?
					</button>

				</div>
			</div>
			<div class="card-body ribbon" id="mainArea" style="min-height: 100px;">
				<div id="drop-list"></div>
			</div>
		</div>

		<div class="text-center">
			<div class="btn-group btn-group-sm">
				<button type="button" class="btn btn-primary sum_word">รวมคำ</button>
				<button type="button" class="btn btn-secondary clear_title_all">ล้างค่า</button>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h2 class="card-title"><dt>แก้ไขคำ</dt></h2>
			</div>
			<div class="card-body ribbon">
				<textarea rows="3" class="form-control textedit"></textarea>
			</div>
		</div>

	</div>

</div>

<script>

$(document).ready(function() {

        function getTagText(txt) {
            alert(txt);
            $('.show-tag').html(''+txt);
        }    
        getTagText('<?=$model->text_extract;?>');
})        


	jQuery.noConflict();
	(function ($) {

		function switchColor(val) {
			var text = '';
			switch(val) {
				case 1:
				text = "display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #79bb0e !important;padding: 3px 5px;border-radius: 4px;";
				break;
				case 2:
				text = "display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #9aa0ac !important;padding: 3px 5px;border-radius: 4px;";
				break;
			}
			return text;
		}
		<?php
		$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;    
		?>
		var text = '<?=$model->text_extract;?>';

		if (text!='null') {
			var res2 = text.replace(/-/g, ' ');
			var res3 = res2.replace(/,/g, ' ');
			var res4 = res3.replace(/"/g, ' ');
			var res5 = res4.replace(/\"/g, ' ');
			var res = res5.replace(/[&!@,'"^$*+?()[{\|/#\":;]/g, ' ');
			var settings = {
				"async": false,
				"crossDomain": true,
				"url": "<?=$url_elasticsearch?>/_analyze",
				"method": "POST",
				"headers": {
					"Authorization": "Basic " + btoa("elastic:changeme"),
					"content-type": "application/json",
				},
				"data": "{\r\n  \"tokenizer\": \"thai\",\r\n  \"text\": \""+res+"\"\r\n}",
				"global": false,
				"dataType": "json",
			}
			var all_token = $.ajax(settings).done(function (response) {
				return response;
			}).responseJSON;

		}

		var data = all_token.tokens;
		var showdata = [];
		for (i = 0; i < data.length ; i++) {
			var b = (i%2 == 0)? 1 : 2;
			showdata.push(`
				<span class="sub editword" data-id="${i}" data-title="${data[i].token}" data-style="${switchColor(b)}" style="${switchColor(b)}">${data[i].token}</span>
				`
				);
		}

		$('.show-text').html(showdata.join(""));


		var arraymain = [];
		$(".sub").kendoDraggable({
			group: "subGroup",
			hint: function(element) {
				data_title = $(element).attr("data-title");
				data_id = $(element).attr("data-id");
				data_style = $(element).attr("data-style");
				return element.clone();
			}
		});

		$("#mainArea").kendoDropTarget({ 
			group: "subGroup",
			drop : function( event, ui ){
				Drop(data_title,data_id,data_style);
			}
		});

		function Drop(data_title) {
			var objIndex = arraymain.findIndex((obj => obj.title == data_title));

			if (objIndex == -1) {
				arraymain.push({id:data_id,title:data_title,style:data_style});
				loaddrophere();
			}
			
		}

		function loaddrophere(){
			myarray = [];
			myarrayword = [];

			$.each(arraymain, function(i) {
				myarray.push(`<span class="sub-in-main">${arraymain[i].title} <i class="fe fe-x del-sub" data-title="${arraymain[i].title}" data-id="${arraymain[i].id}"></i></span>`);
				myarrayword.push(arraymain[i].title);

			});
			// console.log(myarray);
			$("#drop-list").html(myarray.join(" "));
            //$("#drop-list-word").html(myarrayword.join(" "));
        }


        $(document).on('click', '.editword', function(){
        	var text = $(this).data('title');
        	$(".textedit").val(text);
        });

        $(document).on('click', '.sum_word', function(){
        	console.log(myarrayword);
        	console.log(myarrayword.join(''));
        	$("#drop-list").html(`<span class="sub-in-main">${myarrayword.join('')} <i class="fe fe-x del-sub" data-title="${myarrayword.join('')}" data-id="1"></i></span>`);
        });

        

        $(document).on('click', '.del-sub', function(){
        	myarray = [];
        	var id = $(this).data('id');
        	$.each(arraymain, function(i, el){
        		if (this.id == id){
        			arraymain.splice(i, 1);
        		}
        	});

        	loaddrophere();

        });

        $(document).on('click', '.clear_title_all', function(){
        	arraymain = [];
        	loaddrophere();
        });


    })(jQuery);



	// function showfiles(file_name,file_id,bucket) {
	// 	$.ajax({
	// 		url:"<?=$url_node['setting_value'];?>/filepathminio?namefile="+file_name+"&bucket="+bucket,
	// 		method:"GET",
	// 		dataType:"json",
	// 		contentType: "application/json; charset=utf-8",
	// 		success:function(data)
	// 		{
	// 			window.open(data.url, "_blank");
	// 		}
	// 	});
	// }

</script>  
