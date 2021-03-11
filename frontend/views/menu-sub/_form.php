<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\MenuMain;
use yii\helpers\ArrayHelper;
// use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuSub */
/* @var $form yii\widgets\ActiveForm */

?>
<!-- <script src="../../html-version/selectize/jquery-3.4.1.min.js"></script> -->
<!-- <script src="../../html-version/selectize/selectize.min.js"></script>
<link rel="stylesheet" href="../../html-version/selectize/selectize.bootstrap3.css"/>
-->
<style>
<?php if ($model->isNewRecord) {?>
    #old_data{
        display: none;
    }
<?php } else {?>
    #serialized{
        display: none;
    }
<?php }?>
?>
</style>
<div class="menu-sub-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'submenu_name')->textInput() ?>

            <?= $form->field($model, 'submenu_link')->textInput() ?>

            <?=$form->field($model, 'submenu_active')->dropDownList(['Y' => 'เปิดการใช้งานเมนู', 'N' => 'ปิดการใช้งานเมนู'],['class' => 'form-control','style'=>'height: 34px;']); ?>

            <?= $form->field($model, 's_detail')->textarea(['rows' => 6]) ?>

            <?//= $form->field($model, 'menu_id')->textInput() ?>
            <?php
            $model->isNewRecord==1 ? $model->menu_id=$_GET['id_main']:$model->menu_id;
            $MenuMain = MenuMain::find()->all();
            $menu_id = ArrayHelper::map($MenuMain, 'id', 'm_name');

            $id_main = MenuMain::findOne($model->menu_id)->m_name;


            echo $form->field($model, 'menu_id')->hiddenInput(['value' => $model->menu_id])->label(false);

            echo '<label class="control-label" for="menusub-submenu_link">เมนูหลัก</label><input type="text" class="form-control" value="'.$id_main.'" disabled="">';

            ?>

        </div>

        <div class="col-md-6">
			<label for="">เลือกไอคอนเมนู</label>
			<div id="target"></div>
			<?= $form->field($model, 's_icon')->hiddenInput(['maxlength' => true,'id'=>'showdata'])->label(false); ?>
		</div>
        </div>
<br><div class="row">
        <div class="form-group col-md-12">
            <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
	$(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>

<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css"/>
<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/icon-fonts/map-icons-2.1.0/css/map-icons.min.css"/>
<link rel="stylesheet" href="../../bootstrap-iconpicker-1.10.0/dist/css/bootstrap-iconpicker.css"/>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../bootstrap-iconpicker-1.10.0/dist/js/bootstrap-iconpicker.bundle.min.js"></script>

<script type="text/javascript">

	(function($) {
		$('#target').iconpicker({
			align:'left',
			arrowClass: 'btn-primary',
			arrowPrevIconClass: 'fas fa-angle-left',
			arrowNextIconClass: 'fas fa-angle-right',
			cols: 8,
			footer: true,
			header: true,
			icon: '<?=$model->s_icon;?>',
			iconset: 'fontawesome5',
			labelHeader: '{0} of {1} pages',
			labelFooter: '{0} - {1} of {2} icons',
			placement: 'bottom',
			rows: 6,
			search: true,
			searchText: 'Search',
			selectedClass: 'btn-warning',
			unselectedClass: ''
		}
		).on('change', function(e) {
			$("#showdata").val(e.icon);
		});

	})(jQuery);

</script>


