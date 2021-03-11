<?php

use yii\helpers\Html;

use frontend\models\MenuMain;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuSub */

$MenuMain = MenuMain::find()->all();
$menu_id = ArrayHelper::map($MenuMain, 'id', 'm_name');

$id_main = MenuMain::findOne($model->menu_id)->m_name;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuSub */

$this->title = Yii::t('app', 'แก้ไขเมนูย่อย: {name}', [
	'name' => $model->submenu_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เมนูหลัก'), 'url' => ['menu-main/view', 'id' => $model->menu_id]];
// $this->params['breadcrumbs'][] = ['label' => $model->submenu_name, 'url' => ['view', 'id' => $model->submenu_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไขเมนูย่อย');
?>
<div class="menu-sub-update">

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
