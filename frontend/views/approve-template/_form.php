<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApproveTemplate */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
#sortable-row { list-style: none; }
#sortable-row li { margin-bottom:4px; padding:10px; background-color:#e3e3e3;cursor:pointer;color: #212121;width: 100%;border-radius: 3px;border:#ccc 1px solid}
#sortable-row li.ui-state-highlight { height: 2.5em; background-color:#F0F0F0;border:#ccc 2px dotted;}
#clickshow{ display: none; }
.menu-slot{
	height: 40px;
}
.menu-slot-left{
	float: left;
	display: inline-block;
}
.menu-slot-right{
	float: right;
	display: inline-block;
}
pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
.string { color: green; }
.number { color: blue; }
.boolean { color: firebrick; }
.null { color: magenta; }
.key { color: #292b30;font-weight: bold; }
.saveupdate{
	display: none;
}
.filemarker_latlong{
	display: none;
}
.output{
	visibility: hidden;
	width: 0px;
	height: 0px;
}
label{
	font-weight: bold;
}
.form_add_step{
	display: none;
}
</style>

<div class="approve-template-form">

	<?php $form = ActiveForm::begin(); ?>

	<div class="row">

		
		<div class="col-md-6">

			<?= $form->field($model, 'approve_name')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6"></div>


		<div class="col-md-6">
			<?= $form->field($model, 'step')->textArea(['maxlength' => true,'rows'=>'1','style'=>'visibility: hidden;height: 0px !important;'])->label(false); ?>
			<div class="row">
				<div class="col-3">
					<button type="button" class="btn btn-primary show_form_add_step mb-4 btn-block" >เพิ่มขั้นตอนใหม่</button>
				</div>
				<div class="col-6">
					<input type="text" class="form-control form_add_step" placeholder="กรอกคำอธิบายขั้นตอน" id="detail_step">
				</div>
				<div class="col-3">
					<button type="button" class="btn btn-success mb-4 btn-block form_add_step add_step">บันทึก</button>
				</div>
			</div>
			<div id="approve_step"></div>
		</div>
		<div class="col-md-6"></div>

		<div class="form-group col-md-12">
			<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success savesort']) ?>
			<?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-light']) ?>
		</div>

	</div>

	<?php ActiveForm::end(); ?>

</div>


<script>
	(function($) {
		$(document).ready(function(){
			var approve_step = $("#approvetemplate-step").val();
			var obj = '';
			if (approve_step!='') {
				obj = JSON.parse(approve_step);
			}else{
				var obj_data = [{}];
				obj = obj_data;
			}
			
			loadData(obj)
			
			function loadData(objdata){

				var i = 0;
				
				var text = '<ul id="sortable-row" class="sortable-all" style="padding: 0;">';

				jQuery.each(objdata[0], function(obj, values) {
					
					text += '<li id="'+i+'" class="menu-slot sub" data-sort=""><div class="menu-slot-left show_data" id="'+i+'"><b>'+obj+' :</b> '+values+'</div>';

					if (i === Object.keys(objdata[0]).length - 1) {
						text += '<div class="menu-slot-right"><a class="remove_approve_step" data-sort="'+obj+'"><i class="fa fa-times"></i></a></div>';
					}
					text += '</li>';

					i++;
				});

				text += '</ul>';

				$("#approve_step").html(text);
				$("#approvetemplate-step").val(JSON.stringify(objdata
					));
				
			}

			$(document).on('click', '.show_form_add_step', function(){
				$(".form_add_step").css('display', 'block');
			});

			$(document).on('click', '.remove_approve_step', function(){
				if(confirm('ต้องการยกเลิกขั้นตอนนี้ใช่หรือไม่')){
					var new_length = Object.keys(obj[0]).length-1;
					var new_obj = [];
					for (var key in obj[0]) {
						if (new_length>0) {
							new_obj.push(`
								"${key}": "${obj[0][key]}"
								`);
						}
						new_length--;
					}

					var res = new_obj.join(",");
					var res_use = res.slice(0, -1);
					var n_obj = JSON.parse('[{'+res_use+'}]');
					
					obj = n_obj;
					loadData(obj);

				}
			});


			$(document).on('click', '.add_step', function(){
				var detail_step = $("#detail_step").val();
				if (detail_step!="") {
					var new_step = Object.keys(obj[0]).length+1;
					var objstring = JSON.stringify(obj[0]);
					var res = objstring.replace(/[]?{?}?/gi,"");
					var new_obj = '';
					if (res!='') {
						new_obj = res+',"step'+new_step+'":"'+detail_step+'"';
					}else{
						new_obj = '"step'+new_step+'":"'+detail_step+'"';
					}
					var n_obj = JSON.parse('[{'+new_obj+'}]');
					obj = n_obj;
					loadData(obj);
					$("#detail_step").val('');
				}else{
					alert('กรุณากรอกคำอธิบายขั้นตอน');
				}
			});


		});
	}) (jQuery);
</script>
