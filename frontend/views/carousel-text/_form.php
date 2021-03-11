<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarouselText */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- <style>
    input[type="file"] {
        display: none;
    }
</style> -->
<div class="carousel-text-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-6">
           <div class="card">
            <div class="card-header">
                <h3 class="card-title">ไฟล์อัปโหลด <small>เลือกไฟล์ที่ต้องการอัปโหลด</small></h3>
            </div>
            <div class="card-body">
                <div class="well">
                    <?= Html::img($model->getPhotoViewer(),['style'=>'width:170px;height:170px;object-fit: cover;border-radius:10px;box-shadow: 2px 3px 7px #00000096;','class'=>'img-rounded','id'=>'imgOld',"onerror"=>"this.onerror=null;this.src='img/none.png';"]); ?>
                    <img id="person_pic" style="height:170px;object-fit: cover;">
                </div><br>
                <?php
                    if ($model->isNewRecord) {
                        $checkImg = "";
                    }else{
                        $checkImg = "/textx/frontend/web/uploads/".$model->images;
                    }
                ?>
                <?= $form->field($model, 'images')->fileInput(["onchange"=>"document.getElementById('person_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'","accept"=>"image/*","class"=>"dropify","data-default-file"=>$checkImg])->label(false); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'detail')->textarea(['maxlength' => true,'rows' => '6']) ?>
    </div>
</div>

<?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>
 <?= $form->field($model, 'slot')->hiddenInput(['maxlength' => true,"value"=>'1'])->label(false); ?>
    <?= $form->field($model, 'create_time')->hiddenInput(['maxlength' => true,"value"=>date("Y-m-d H:i:s")])->label(false); ?>

<div class="form-group">
   
    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
</div>


<?php ActiveForm::end(); ?>

</div>
