<?php

use yii\helpers\Html;
use frontend\models\MenuMain;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuSub */

$model->menu_id=$_GET['id_main'];
$MenuMain = MenuMain::find()->all();
$menu_id = ArrayHelper::map($MenuMain, 'id', 'm_name');

$id_main = MenuMain::findOne($model->menu_id)->m_name;

$this->title = Yii::t('app', 'เพิ่มเมนูย่อย');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เมนูหลัก'), 'url' => ['menu-main/view', 'id' => $model->menu_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-sub-create">

	<h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">

					<?= $this->render('_form', [
						'model' => $model,
					]) ?>

				</div>
			</div>
		</div>
	</div>
</div>
