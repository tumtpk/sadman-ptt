<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<style>
.div-scrollbar{
	height: 200px;
	overflow-y: scroll;
	padding: 0em 1em 1em 1em;
	margin-bottom: 1em;
	font-size: 14px !important;
}
.isDisabled {
	pointer-events: none;
	cursor: default;
	text-decoration: none;
}
table.detail-view th:first-child, table.detail-view td:first-child {
	width: 180px !important;
	text-align: left;
    height: 250px;
}
a.disabled {
	opacity: 0.6;
	cursor: not-allowed;
}
</style>

<div class="card p-3">
	<h6 class=""><dt>ชื่อหน่วยงาน : <?= Html::encode($model->unit_name) ?></dt></h6>
	<div class="div-scrollbar">
		<?//= Html::encode($model->unit_detail) ?>
		<label for=""><dt>ผู้ดูแลหน่วยงาน</dt></label>
		<small class="d-block text-muted">
			<?php 
			$user = Yii::$app->db->createCommand("SELECT * FROM users WHERE unit_id = '".$model->unit_id."' AND role = '2'")->queryAll();
			$show = '';
			foreach ($user as $value) {
				$show .= '<a href="#" onclick="window.open(\'index.php?r=users/view&id='.$value['id'].'\', \'blank\');">'.$value['name'].'</a>, ';
			}
			$show_all = substr_replace($show, "", -2);

			echo (empty($show_all)) ? 'ไม่มีผู้ดูแลหน่วย' : $show_all;
			?>
		</small>
		
		<div class="row mt-2">
			<div class="col-5 py-1"><strong>ผู้ใช้งานทั้งหมด:</strong></div>
			<div class="col-7 py-1">
				<a onclick="window.open('index.php?r=users/index&unitid=<?=$model->unit_id;?>');" href="#"><?php echo $cusers = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE unit_id = '".$model->unit_id."'")->queryScalar();
				?>
			</a>
			<span class="ml-3">คน</span>
		</div>
		<div class="col-5 py-1"><strong>แบบฟอร์ม:</strong></div>
		<div class="col-7 py-1">
			<small class="d-block text-muted">
				<?php
				$eform_template = Yii::$app->db->createCommand("SELECT * FROM eform_template WHERE unit_id LIKE '%\"".$model->unit_id."\"%' AND disable = '0'")->queryAll();
				$showeform_template = '';
				foreach ($eform_template as $value) {
					$showeform_template .= '- <a href="#" onclick="window.open(\'index.php?r=site/pages&view=eform_template&form_id='.$value['id'].'\', \'blank\');">'.$value['detail'].'</a><br>';
				}
				$show_all_eform = substr_replace($showeform_template, "", -4);

				echo (empty($show_all_eform)) ? 'ไม่มีแบบฟอร์มที่เข้าถึงได้' : $show_all_eform;
				?>
			</small>
		</div>
		<div class="col-5 py-1"><strong>จำนวนข้อมูลที่บันทึกทั้งหมด:</strong></div>
		<div class="col-7 py-1"><strong>
			<?php $eform_data = Yii::$app->db->createCommand("SELECT COUNT(eform_data.id) FROM eform,eform_data WHERE eform.unit_id = '".$model->unit_id."' AND eform.id = eform_data.eform_id")->queryScalar(); 
			echo number_format($eform_data);
			?> <span class="ml-3">รายการ</span>
		</strong></div>

		<div class="col-5 py-1"><strong>จำกัดผู้แลหน่วย:</strong></div>
		<div class="col-7 py-1"><strong><?=$model->admin_limit;?></strong><span class="ml-3">คน</span></div>
		<div class="col-5 py-1"><strong>จำกัดผู้ใช้งานหน่วย:</strong></div>
		<div class="col-7 py-1"><strong><?=$model->user_limit;?></strong> <span class="ml-3">คน</span></div>
		<div class="col-5 py-1"><strong>จำกัดสายข่าวหน่วย:</strong></div>
		<div class="col-7 py-1"><strong><?=$model->undercover_limit;?></strong> <span class="ml-3">คน</span></div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php $checkadmin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE unit_id = '".$model->unit_id."' AND role = '2'")->queryScalar(); ?>
		<?php if ($checkadmin>=$model->admin_limit): ?>
			<a href="#" data-toggle="tooltip" data-placement="top" title="จำนวนผู้ดูแลเต็มแล้ว!" class="disabled"><span class="tag tag-info" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> ผู้ดูแลหน่วย</span></a>
			<?php else: ?>
				<a onclick="window.open('index.php?r=users/create&unitid=<?=$model->unit_id;?>');" href="#"><span class="tag tag-info" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> ผู้ดูแลหน่วย</span></a>
			<?php endif ?>
			<?php $checkusers = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE unit_id = '".$model->unit_id."' AND role = '3'")->queryScalar(); ?>
			<?php if ($checkusers>=$model->user_limit): ?>
				<a href="#" data-toggle="tooltip" data-placement="top" title="จำนวนผู้ใช้งานเต็มแล้ว!" class="disabled"><span class="tag tag-warning text-dark" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> ผู้ใช้งานหน่วย</span></a>
				<?php else: ?>
					<a onclick="window.open('index.php?r=users/create_users&unitid=<?=$model->unit_id;?>&unitname=<?=$model->unit_name;?>');" href="#"><span class="tag tag-warning text-dark" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> ผู้ใช้งานหน่วย</span></a>
				<?php endif ?>
			<?php  if ($checkusers>=$model->undercover_limit): ?>
				<a href="#" data-toggle="tooltip" data-placement="top" title="จำนวนสายข่าวเต็มแล้ว!" class="disabled"><span class="tag tag-secondary" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> สายข่าวหน่วย</span></a>
			<?php  else: ?>
					<a onclick="window.open('index.php?r=undercover/create_undercover&unitid=<?=$model->unit_id;?>&unitname=<?=$model->unit_name;?>');" href="#"><span class="tag tag-secondary" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> สายข่าวหน่วย</span></a>
			<?php  endif ?>
				<a data-toggle="modal" data-target="#manageform" href="#" data-unit_name="<?=$model->unit_name;?>" data-unit_id="<?=$model->unit_id;?>" class="manageform"><span class="tag tag-cyan" style="cursor: pointer;display: inline-block;font-size: 10px;"><i class="fa fa-check-square" aria-hidden="true"></i> จัดการฟอร์ม</span></a>
			</div>
			<div class="ml-auto text-muted col-md-12 text-left mt-2">
				<?php echo Html::a('<i class="fe fe-eye mr-1" data-toggle="tooltip" data-placement="bottom" title="รายละเอียด"></i>',['view', 'id' => $model->unit_id], [
					// 'class' => 'unit-view-link icon',
					'class' => 'icon',
					'title' => 'หน่วยงาน',
					// 'data-toggle' => 'modal',
					// 'data-target' => '#unit-modal',
					// 'data-id' => $model->unit_id,
					// 'data-pjax' => '0',

				]); ?>
				<?php echo Html::a('<i class="fe fe-edit-3 mr-1" data-toggle="tooltip" data-placement="bottom" title="แก้ไขข้อมูล"></i>',['update', 'id' => $model->unit_id], [
				// 'class' => 'unit-update-link icon d-md-inline-block ml-3',
					'class' => 'icon d-md-inline-block ml-3',
					'title' => 'แก้ไขหน่วยงาน',
				// 'data-toggle' => 'modal',
				// 'data-target' => '#unit-modal',
				// 'data-id' => $model->unit_id,
				// 'data-pjax' => '0',

				]); ?>
				<?php echo Html::a('<i class="fe fe-slash mr-1" data-toggle="tooltip" data-placement="bottom" title="ปิดการใช้งาน"></i>', ['disable', 'id' => $model->unit_id], ['class'=>'icon d-md-inline-block ml-3','style'=>'    font-weight: bold;color: #dc3545;','data' => ['confirm' => Yii::t('app', 'ต้องการปิดการใช้งานใช่หรือไม่?'),'method' => 'post','title'=>'ปิดการใช้งาน'],]); ?>
			</div>
		</div>
	</div>


