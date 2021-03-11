<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRole;
use app\models\UserGroup;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>


<style>
    input[type="file"] {
        display: none;
    }
</style>

<div class="undercover-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="row">
        <div class="col-md-4">
            <label for="">รูปภาพ</label>
            <div class="well">
                <?= Html::img($model->getPhotoViewer(),['style'=>'width:170px;height:170px;object-fit: cover;border-radius:10px;box-shadow: 2px 3px 7px #00000096;','class'=>'img-rounded','id'=>'imgOld',"onerror"=>"this.onerror=null;this.src='img/none.png';"]); ?>
                <img id="person_pic" style="height:170px;object-fit: cover;">
            </div><br>
            <label for="undercover-images" class="custom-file-upload">
                <i class="fe fe-upload"></i> เลือกไฟล์รูปภาพ
            </label>
            <?= $form->field($model, 'images')->fileInput(["onchange"=>"document.getElementById('person_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'","accept"=>"image/*"])->label(false); ?>
            <div id="imgerror"></div>
            <?php if (!$model->isNewRecord): ?>
                <input type="hidden" name="file_name_old" value="<?=$model->images;?>" id="file_name_old">
            <?php endif ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'undercover_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->input('email',['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        

            <?php if ($_SESSION['user_role']=='1' && $_SESSION['user_id']==$model->id): ?>
                <?=$form->field($model, 'unitid')->hiddenInput(['value' => '000'])->label(false); ?>
                <?php else: ?>
                
                    <?php if ($model->isNewRecord): ?>
                    	<?php if (isset($_GET['unit_id'])): ?>
						    <?=$form->field($model, 'unitid')->hiddenInput(['value' => $_GET['unit_id']])->label(false); ?>
                        <?php else: ?>
                            <div class="col-md-4">
                                <label class="control-label" for="undercover-unitid">หน่วยงาน</label>
                                <?php

                                $model->unitid = (isset($_GET['unit_id'])) ? $model->unitid=$_GET['unit_id'] : $model->unitid='';

                                $Unit=Unit::find()->orderBy(['unit_name'=>SORT_ASC])->all();
                                $unit_id=ArrayHelper::map($Unit,'unit_id','unit_name');

                                echo $form->field($model, 'unitid')->dropDownList($unit_id,['prompt'=>'Select...','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
                                ?>
                            </div>
                        <?php endif ?> 
                    <?php else: ?>
                        <?php if (isset($_GET['unit_id'])): ?>
						    <?=$form->field($model, 'unitid')->hiddenInput(['value' => $_GET['unit_id']])->label(false); ?>
                        <?php else: ?>
                            <div class="col-md-4">
                                <label class="control-label" for="undercover-unitid">หน่วยงาน</label>
                                <?php

                                $model->unitid = (isset($_GET['unit_id'])) ? $model->unitid=$_GET['unit_id'] : $model->unitid='';

                                $Unit=Unit::find()->orderBy(['unit_name'=>SORT_ASC])->all();
                                $unit_id=ArrayHelper::map($Unit,'unit_id','unit_name');

                                echo $form->field($model, 'unitid')->dropDownList($unit_id,['prompt'=>'Select...','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
                                ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
        
            <?php endif; ?>
    </div>

        <div class="row">
           <div class="col-md-12">
            <?#= $form->field($model, 'notification')->radioList([0 => 'ปิดการแจ้งเตือน', 1 => 'เปิดการแจ้งเตือน']); ?>
            <!-- <input type="checkbox" checked data-toggle="toggle" data-on="เปิดการแจ้งเตือน" data-off="ปิดการแจ้งเตือน" data-onstyle="success" data-offstyle="danger"> -->
        </div>
        <?php if ($_SESSION['user_role']=='2' && $model->id!=$_SESSION['user_id'] && $model->unitid == $_SESSION['unit_id']): ?>
            <?= $form->field($model, 'status')->radioList([0 => 'ปิด', 1 => 'เปิด'])->label('สิทธิ์การเข้าใช้ระบบงาน'); ?>
        <?php elseif ($_SESSION['user_role']=='1' && $model->id!=$_SESSION['user_id']): ?>
            <?= $form->field($model, 'status')->radioList([0 => 'ปิด', 1 => 'เปิด'])->label('สิทธิ์การเข้าใช้ระบบงาน'); ?>
        <?php else: ?>
            <?=$form->field($model, 'status')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php endif ?>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success checkimg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<script>
    $(document).ready(function(){
        $(".field-undercover-unitid").addClass('multiselect_div');
        $('.multiselect-filter').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
        });
    });

    $(document).on('click', '.checkimg', function(){
        <?php if (!$model->isNewRecord): ?>
            if (!$('#file_name_old').val()) {
                if (!$('#undercover-images').val()) {
                  $("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
                  return false;
              }
          }
          <?php else: ?>
            if (!$('#undercover-images').val()) {
              $("#imgerror").html('<span class="help-block">รูปภาพต้องไม่ว่างเปล่า</span>');
              return false;
          }
      <?php endif; ?>

  });
</script>


<script>
    $(document).ready(function(){
        $('#mytextbox').bind('keyup blur', function () {
            $(this).val($(this).val().replace(/[^A-Za-z0-9_-@ ]/g, ''))
        });

        $('#mytextbox1').bind('keyup blur', function () {
            $(this).val($(this).val().replace(/[^A-Za-z0-9_-@ ]/g, ''))
        });
    });
</script>