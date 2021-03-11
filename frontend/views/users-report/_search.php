<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

        <?php //echo $form->field($model, 'id'); ?>

        <?php //echo $form->field($model, 'data_json'); ?>

        <div class="col-md-3">
            <label for="">วันที่บันทึก/แก้ไข ระหว่าง - </label>
            <?= $form->field($model, 'data_json')->textInput(['class'=>'form-control datepicker_input_search'])->label(false); ?>
        </div>

        <div class="col-md-3">
            <label for="">ถึงวันที่</label>
            <!-- <input type="text" class="form-control datepicker_input_search" name="end_date"> -->
            <?= $form->field($model, 'date_record')->textInput(['class'=>'form-control datepicker_input_search'])->label(false); ?>
        </div>

        <?php if ($_SESSION['user_role']=='1'): ?>
            <div class="col-md-4">
                <?= $form->field($model, 'user_create') ?>
            </div>
        <?php endif ?>
        
        

        <?php //echo $form->field($model, 'date_record'); ?>

        <div class="form-group col-md-12">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){
        $.fn.datepicker.dates['th'] = {
            days: ["วันอาทิตย์", "วันจันทร์", "วันอังคาร", "วันพุธ", "วันพฤหัสบดี", "วันศุกร์", "วันเสาร์"],
            daysShort: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
            daysMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
            months: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤศภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
            monthsShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
            today: "วันนี้",
            clear: "ล้างค่า",
            format: "yyyy-mm-dd",
            titleFormat: "MM yyyy", 
            weekStart: 0
        };
        $('.datepicker_input_search').datepicker({
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            language: "th",
            thaiyear: true,
            autoclose: true
        }
        );
    });
</script>
