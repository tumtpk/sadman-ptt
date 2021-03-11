<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroup */

$this->title = 'แก้ไขกลุ่มผู้ใช้งาน';
$this->params['breadcrumbs'][] = ['label' => 'สิทธิ์การเข้าใช้งาน', 'url' => ['user-role/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view_usergroup', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-create">

    <h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">
					<?= $this->render('_form_manage_menu', [
						'model' => $model,
					]) ?>
				</div>
			</div>
		</div>
	</div>

</div>
