<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="card">
				<div class="card-body ribbon">
                    <?php //echo $form->field($model, 'id') ?>
                    <div class="row clearfix">
                    
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <?= $form->field($model, 'page_name') ?>
                        </div>
                            <?php //echo $form->field($model, 'iframe') ?>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <?=$form->field($model, 'status')->dropDownList(['' => 'เลือกสถานะ', '1' => 'เปิดการใช้งาน', '0' => 'ปิดการใช้งาน']); ?>
                        </div>                       
                    </div>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'สืบค้น'), ['class' => 'btn btn-primary']) ?>
                            <?= Html::resetButton(Yii::t('app', 'ล้างค่า'), ['class' => 'btn btn-outline-secondary']) ?>
                        </div>


    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
