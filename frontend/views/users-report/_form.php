<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersReport */
/* @var $form yii\widgets\ActiveForm */

$model->user_create = ($model->isNewRecord) ? $_SESSION['user_id'] : $model->user_create;

?>

<style>
input[type="file"] {
	display: none;
}
#sortable-row { 
	list-style: none;
	overflow: scroll;
}

#show-preview{
	overflow: scroll;
}
#show-preview div { 
	cursor:pointer;
	color: #212121;
	/*width: 100%;*/
	border-radius: 3px;
}
#show-preview div.ui-state-highlight { 
	/*height: 2.6em !important; */
	background-color:#F0F0F0;
	border:#ccc 2px dotted;
	margin-bottom: 1em;
}

.text_data:hover {
	background-color: #007bff61 !important;
	font-weight: bold;
}

.card-report{
	height: auto;
	margin-top: 0px !important;
	padding: 10px;
}
.card-move{
	cursor: move;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.clickmodal{
	cursor: pointer !important;
}
.btn_upload{
	font-size: 14px !important;
	color: #fff !important;
	background-color: #343a40 !important;
	border-color: #343a40 !important;
	border: 1px solid transparent !important;
	padding: 0.5em !important;
	line-height: 1 !important;
	border-radius: .25rem !important;
	cursor: pointer;
	margin-bottom: 0px;
	vertical-align: -2;
}
.btn_upload:hover{
	background-color: #000000 !important;
	border-color: #000000 !important;
}
.img-object{
	object-fit:cover;
	width: 100% !important;
	object-position: 50% 50% !important;
}
#show-media-vimeo{
	display: none;
}
iframe {
	-moz-transform: scale(1, 1); 
	-webkit-transform: scale(1, 1); 
	-o-transform: scale(1, 1);
	-ms-transform: scale(1, 1);
	transform: scale(1, 1); 
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	transform-origin: top left;
}
#IDNAME {
	-moz-transform: scale(1, 1); 
	-moz-transform-origin: top left;
}
.overflow-450{
	max-height: 450px !important;
	overflow: auto;
}
</style>

<div class="users-report-form">

	<script src="../../js-sortable/jquery-1.10.2.js"></script>
	<script src="../../js-sortable/jquery-ui-1.11.2.js"></script>

	<?php $form = ActiveForm::begin(); ?>
	<div class="row clearfix">
		<div class="col-lg-8 col-md-12">
			<div class="card">
				<div class="card-header bg-secondary text-white">
					<h3 class="card-title">[3] ผลลัพธ์รายงาน</h3>
				</div>
				<div class="card-body" style="min-height: 410px;">
					<div class="row" id="show-preview">
					</div>
				</div>
			</div>
			<div class="card" id="show-media-vimeo">
				<div class="card-header bg-secondary text-white">
					<h3 class="card-title">ตัวอย่างรายงาน</h3>
					<div class="card-options">
						<a href="#" class="card-options-collapse text-white" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
					</div>
				</div>
				<div class="card-body">
					<!-- <div id="media-vimeo">
						<iframe src="" frameborder="0" id="IDNAME" style="height: 31cm; width: 100%;"></iframe>
					</div> -->
					<div id="result"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-12">
			<div class="card">
				<div class="card-header bg-secondary text-white">
					<h3 class="card-title">[1] ข่าวที่ต้องการแสดง</h3>
				</div>
				<div class="card-body">
					<ul class="list-group" style="overflow:auto;height:370px;" id="show_eform_templete">
					</ul>
				</div>
			</div>
			<div class="card c_grid c_yellow">
				<div class="card-header bg-secondary text-white">
					<h3 class="card-title">[2] Widget</h3>
				</div>
				<div class="card-body text-center">
					<button class="btn btn-dark btn-sm add_textarea_detail" type="button">กรอกรายละเอียดข้อมูล</button>
					<button class="btn btn-dark btn-sm add_showleftmap" type="button">แผนที่</button>
					<label for="upload-images" class="btn_upload btn-sm btn btn-dark">
						<i class="fe fe-upload"></i> รูปภาพ
					</label>
					<input type="file" id="upload-images" accept="image/*" multiple="multiple">
				</div>
			</div>
			<div class="show-status text-center">
			</div>

			<div class="card c_grid c_yellow">
				<div class="card-header bg-secondary text-white">
					<h3 class="card-title">[3] ตั้งค่าโลโก้, หัวข้อรายงาน , ท้ายรายงาน</h3>
				</div>
				<div class="card-body">
					<div class="text-center">
						<?= Html::img($model->getPhotoViewer(),['style'=>'width:40%;','class'=>'img-rounded','id'=>'imgOld']); ?>

						<div class="button-wrapper text-center">
							<img id="logo_pic" class="img-new-upload">
							<br>
							<label for="upload-logo" class="btn_upload btn-sm btn btn-dark mt-2">
								<i class="fe fe-upload"></i> เลือกไฟล์รูปภาพ
							</label>
							
							<?= $form->field($model, 'logo_report')->fileInput(["onchange"=>"document.getElementById('logo_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'","accept"=>"image/*",'id'=>'upload-logo'])->label(false); ?>
							<?php if (!$model->isNewRecord): ?>
								<input type="hidden" name="file_name_old" value="<?=$model->logo_report;?>" id="file_name_old">
							<?php endif ?>
						</div>

					</div>


					<?php $model->position_logo = (!$model->isNewRecord) ? $model->position_logo : 0; ?>
					<label for=""><dt>ตำแหน่งการแสดงโลโก้</dt></label>
					<?= $form->field($model, 'position_logo')->radioList([1 => 'แสดงด้านซ้าย' , 2 => 'แสดงตรงกลาง', 3 => 'แสดงด้านขวา',0 => 'ไม่แสดงรูปภาพ'])->label(false); ?>
					<div id="header_footer">
					<?= $form->field($model, 'header_report')->textArea(['maxlength' => true, 'class' => 'summernote', 'rows'=>'10'])->label();
					?>
					<?= $form->field($model, 'footer_report')->textArea(['maxlength' => true, 'class' => 'summernote', 'rows'=>'10',])->label();
					?>
					</div>

				</div>
			</div>
		</div>
		<div class="col-md-12">


			<?= $form->field($model, 'data_json')->textArea(['maxlength' => true,'rows'=>'1','style'=>'visibility: hidden;height: 0px !important;'])->label(false);
			?>

			<?= $form->field($model, 'user_create')->hiddenInput(['maxlength' => true])->label(false) ?>

			<div class="form-group">
				<button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
				<button type="reset" class="btn btn-sm btn-danger clear_data">ยกเลิก</button>
			</div>

		</div>
	</div>
	<?php ActiveForm::end(); ?>


	<div class="modal shownew">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-6 col-md-6">
							<input type="hidden" id="form_id_check">
							<input type="text" id="search_news" class="form-control" placeholder="ค้นหาข่าว">
						</div>
						<div class="col-6 col-md-4">
							<input type="text" id="date_data" class="form-control datepicker_input" placeholder="เลือกวันที่บันทึก" value="<?=date("Y-m-d");?>" readonly>
							<input type="hidden" class="get_val_datetime" value="<?=date("Y-m-d");?>">
						</div>
						<div class="col-6 col-md-2">
							<button type="button" class="btn btn-success" id="btn_search" style="white-space: nowrap;"><i class="fa fa-search"></i> สืบค้น</button>
						</div>
					</div>
					<div id="shownews" class="overflow-450"></div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">ยืนยัน</button>
				</div>

			</div>
		</div>
	</div>



	<?php include 'js-report-design-many-sources.php'; ?>


</div>
