<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$COUNTUSERS = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '".$model->id."'")->queryScalar();
?>


<div class="card">
	<div class="card-body ribbon">
		<div class="ribbon-box pink"><?php echo number_format($COUNTUSERS); ?></div>
		<h5 class="pl-5"><dt><?= Html::encode($model->role) ?></dt></h5>
		<div class="div-scrollbar">
			<b>สิทธิ์การเข้าถึงเมนูหลัก :</b>
			<small class="text-muted">
				<?php
				if(!empty($model->allow_access_main) && strlen($model->allow_access_main)>2)
				{
					echo getList($model->allow_access_main,'menu_main','id','m_name');
				}
				?>
			</small>
			<label for="" class="mt-2"><dt>การให้สิทธิ์การเข้าถึงเมนูย่อย :</dt></label><br>
			<small class="text-muted">
				<?php
				if(!empty($model->allow_access_sub) && strlen($model->allow_access_sub)>2)
				{
					echo getList($model->allow_access_sub,'menu_sub','submenu_id','submenu_name');
				}
				?>
			</small>
		</div>
		<div class="ml-auto text-muted col-md-12 text-left mt-2">
			<?php echo Html::a('<i class="fe fe-eye mr-1" data-toggle="tooltip" data-placement="bottom" title="รายละเอียด"></i>',['view', 'id' => $model->id], [
					// 'class' => 'unit-view-link icon',
				'class' => 'icon',
				'title' => 'สิทธิ์การเข้าถึงเมนู',
					// 'data-toggle' => 'modal',
					// 'data-target' => '#unit-modal',
					// 'data-id' => $model->unit_id,
					// 'data-pjax' => '0',

			]); ?>
			<?php echo Html::a('<i class="fe fe-edit-3 mr-1" data-toggle="tooltip" data-placement="bottom" title="แก้ไขข้อมูล"></i>',['update', 'id' => $model->id], [
				// 'class' => 'unit-update-link icon d-md-inline-block ml-3',
				'class' => 'icon d-md-inline-block ml-3',
				'title' => 'สิทธิ์การเข้าถึงเมนู',
				// 'data-toggle' => 'modal',
				// 'data-target' => '#unit-modal',
				// 'data-id' => $model->unit_id,
				// 'data-pjax' => '0',

			]); ?>
		</div>
		
	</div>
</div>