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
    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'kp_id')->dropdownList(ArrayHelper::map(Kptag::find()->all(), "idkp_tag", "SP_KP", "name_kp"), ['prompt' => 'เลือก..']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'severity')->dropdownList(ArrayHelper::map(Severity::find()->all(), "idseverity", "severity_name"), ['prompt' => 'เลือก..']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'procedure_id')->dropdownList(ArrayHelper::map(Procedure::find()->select(["idprocedure", "concat(idprocedure,' ',procedureName) as procedureName"])->all(), "idprocedure", "procedureName"), ['prompt' => 'เลือก..']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'inspection_result_TMM')->textarea(['rows' => '3']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <label>ภาพประกอบ</label>
                    <form action="/file-upload" class="dropzone">
                        <div class="form-group fallback">
                            <input name="file" type="file" id="zoneId" class="form-control" />
                        </div>
                    </form>
                </div>
            </div>
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


</div>

<?php
$this->registerJsFile('@web/dropzone/dropzone.js', ['depends' => [yii\web\JqueryAsset::className()]]);

$script = <<< JS
    $(document).ready(function() {
        $("div#zoneId").dropzone({ url: "/file/post" });
    });

JS;
$this->registerJs($script);
?>