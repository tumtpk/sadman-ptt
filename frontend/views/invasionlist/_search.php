<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Severity;
use common\models\Kptag;
// use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\InvasionlistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invasionlist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'detail') ?>
            <?= $form->field($model, 'inspection_result_TMM') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'kp_id')->dropdownList(ArrayHelper::map(Kptag::find()->all(), "idkp_tag", "SP_KP", "name_kp"), ['prompt' => 'เลือก..']) ?>
            <?= $form->field($model, 'severity')->dropdownList(ArrayHelper::map(Severity::find()->all(), "idseverity", "severity_name"), ['prompt' => 'เลือก..']) ?>
        </div>
    </div>
    <?php //$form->field($model, 'idinvasionlist') 
    ?>



    <?php
    // $form->field($model, 'kp_id') 
    ?>

    <?php
    //  $form->field($model, 'severity') 
    ?>



    <?php
    //  $form->field($model, 'procedure_id')
    ?>
    <?php
    //  $form->field($model, 'date')->widget(
    //     DatePicker::className(),
    //     [
    //         'inline' => false,
    //         'clientOptions' => [
    //             'autoclose' => true,
    //             'format' => 'yyyy-mm-dd'
    //         ]
    //     ]
    // ); 
    ?>



    <?php // echo $form->field($model, 'date') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('สืบค้น', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>