<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DescriptionKeywords */
/* @var $form yii\widgets\ActiveForm */
?>


<style>
     .help-block{
        color: #dc3545;
        font-weight: 600;
    }
    .img-rounded{
        border: 1px solid #777777;
        padding: 10px;
        margin-bottom: 10px;
    }
    .img-new-upload{
        width: 218px;
        border: 0px solid #777777;
        margin-bottom: 10px;
    }
    .button-wrapper {
        position: relative;
        width: 150px;
        text-align: center;
    }
    .button-wrapper span.label {
        position: relative;
        z-index: 0;
        display: inline-block;
        width: 218px;
        background: #00bfff;
        cursor: pointer;
        color: #fff;
        padding: 10px 0;
        text-transform:uppercase;
        font-size:16px;
    }
    #upload {
        display: inline-block;
        position: absolute;
        z-index: 1;
        width: 100%;
        height: 50px;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    .btn-purchase-payment{
        margin-left: 10px;
        margin-top: 20px;
    }
</style>


<div class="description-keywords-form">
    <div class="row">
        <div class="col-md-6">

            <?php $form = ActiveForm::begin(); ?>

            <?php $model->name = (isset($_GET['key'])) ? $_GET['key'] : $model->name; ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_create')->hiddenInput(['value' => $_SESSION['user_id'] ])->label(false); ?>
        </div> 

        <?php // echo= $form->field($model, 'images')->textarea(['rows' => 6]) ?>
        <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for=""><dt>ภาพประกอบ</dt></label>
                    </div>

                    <div class="col-md-12 mt-2">
                        <?= Html::img($model->getPhotoViewer(),['style'=>'width:30%;','class'=>'img-rounded','id'=>'imgOld']); ?>
                        <div class="button-wrapper">
                            <img id="person_pic" class="img-new-upload">
                            <label for="users-images" class="custom-file-upload">
                                <i class="fe fe-upload"></i> เลือกไฟล์รูปภาพ
                            </label>
                            <?= $form->field($model, 'images')->fileInput(["onchange"=>"document.getElementById('person_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'","accept"=>"image/*",'id'=>'upload','class'=>'upload-box'])->label(false); ?>
                            <div id="imgerror"></div>
                                <?php if (!$model->isNewRecord): ?>
                                    <input type="hidden" name="file_name_old" value="<?=$model->images;?>" id="file_name_old">
                                <?php endif ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<script>
    $(document).ready(function(){
        $(".field-users-unit_id").addClass('multiselect_div');
        $('.multiselect-filter').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
        });
    });

    $(document).on('click', '.checkimg', function(){
        <?php if (!$model->isNewRecord): ?>
            if (!$('#file_name_old').val()) {
                if (!$('#users-images').val()) {
                  $("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
                  return false;
              }
          }
          <?php else: ?>
            if (!$('#users-images').val()) {
              $("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
              return false;
          }
      <?php endif; ?>

  });
</script>
