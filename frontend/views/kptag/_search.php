<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Kptag;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\models\KptagSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kptag-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?php // $form->field($model, 'idkp_tag') 
            ?>
            <?= $form->field($model, 'SP_KP') ?>
            <?php // $form->field($model, 'SP_KP')->dropdownList(ArrayHelper::map(Kptag::find()->all(), "SP_KP", "SP_KP"), ['prompt' => 'เลือก..']) 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name_kp') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'UTM_Indian_N') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'UTM_Indian_E') ?>
        </div>
    </div>
    <?php // echo $form->field($model, 'UTM_WGS84_N') 
    ?>

    <?php // echo $form->field($model, 'UTM_WGS84_E') 
    ?>

    <?php // echo $form->field($model, 'GEO_WGS84_Lat') 
    ?>

    <?php // echo $form->field($model, 'GEO_WGS84_Long') 
    ?>

    <?php // echo $form->field($model, 'GEO_WGS84_2_Lat') 
    ?>

    <?php // echo $form->field($model, 'GEO_WGS84_2_Long') 
    ?>

    <?php // echo $form->field($model, 'remark') 
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'สืบค้น'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'ล้างค่า'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>