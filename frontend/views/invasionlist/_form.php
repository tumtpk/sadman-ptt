<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Severity;
use common\models\Kptag;
use common\models\Procedure;
// use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Invasionlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invasionlist-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'kp_id')->dropdownList(ArrayHelper::map(Kptag::find()->all(), "idkp_tag", "SP_KP", "name_kp"), ['prompt' => 'เลือก..']) ?>


            <?= $form->field($model, 'severity')->dropdownList(ArrayHelper::map(Severity::find()->all(), "idseverity", "severity_name"), ['prompt' => 'เลือก..']) ?>


            <?= $form->field($model, 'procedure_id')->dropdownList(ArrayHelper::map(Procedure::find()->all(), "idprocedure", "procedureName"), ['prompt' => 'เลือก..']) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'inspection_result_TMM')->textInput(['maxlength' => true]) ?>
        </div>
    </div>




    <?php
    // $form->field($model, 'kp_id')->textInput() 
    ?>
    <?php
    //  $form->field($model, 'severity')->dropdownList($model->getItemEducation(), ['prompt' => 'เลือกการศึกษา..'])
    ?>
    <?php // $form->field($model, 'procedure_id')->textInput() 
    ?>



    <?php
    // $form->field($model, 'date')->widget(
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

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>