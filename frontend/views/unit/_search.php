<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-search">

    <?php $form = ActiveForm::begin([
        // 'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

        <?//= $form->field($model, 'unit_id') ?>

        <div class="col-md-6">
            <?= $form->field($model, 'unit_name') ?>
        </div>

        <div class="col-md-6">
            <div class="multiselect_div">
                <label class="control-label" for="unitsearch-unit_detail">ผู้ดูแลระบบของหน่วยงาน</label>
                <?php
                
                $user_admin = Yii::$app->db->createCommand("SELECT * FROM users WHERE role = '2'")->queryAll();
                foreach ($user_admin as $value) {
                    $listuser_admin[$value['unit_id']] = $value['name'];
                }
                ?>

                <select name="selectadmin" id="selectadmin" class="multiselect multiselect-custom multiselect-filter" onchange="getvalue(this);">
                    <option value="">เลือกผู้ดูแลระบบของหน่วยงาน</option>
                    <?php foreach ($user_admin as $value):
                        $selected = ($value['id']==$model->create_by && $value['name']==$model->province) ? 'selected' : '';
                    ?>
                        <option value="<?=$value['id'];?>" <?=$selected;?> data-unitname="<?=$value['name'];?>" data-unitid="<?=$value['unit_id'];?>"><?=$value['name'];?></option>
                    <?php endforeach ?>
                </select>
                <input type="hidden" name="UnitSearch[unit_detail]" id="unitsearch-unit_detail">
                <input type="hidden" name="UnitSearch[province]" id="unitsearch-province">
                <input type="hidden" name="UnitSearch[create_by]" id="unitsearch-create_by">
            </div>
        </div>

        <div class="form-group col-md-12">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary loadmapsearch']) ?>
            <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
   $(document).ready(function(){
    $(".field-unitsearch-unit_detail").addClass('multiselect_div');
    // $('.multiselect-filter').multiselect({
    //     enableFiltering: true,
    //     enableCaseInsensitiveFiltering: true,
    //     maxHeight: 300
    // });
});

   function getvalue(event){
    var unitname = event.options[event.selectedIndex].dataset.unitname; 
    var unitid = event.options[event.selectedIndex].dataset.unitid;
    var selected_value = event.value;
    $('#unitsearch-province').val(unitname);
    $('#unitsearch-unit_detail').val(unitid);
    $('#unitsearch-create_by').val(selected_value);
   }
</script>

