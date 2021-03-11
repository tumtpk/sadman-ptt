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

<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->

    <style>
    input[type="file"] {
        display: none;
    }
</style>
<div class="users-form">

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
            <label for="users-images" class="custom-file-upload">
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
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->input('email',['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php
            if ($_SESSION['user_role']=='3') {
                echo $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true, 'id' => 'mytextbox1']);
            }else{
                echo $form->field($model, 'username')->textInput(['maxlength' => true, 'id' => 'mytextbox1']);
            }
            ?>
        </div>
        <div class="col-md-4">
            <?//= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?php if(!$model->isNewRecord) {
                if($_SESSION['user_role']=='1' || $_SESSION['user_role']=='2' && $_SESSION['unit_id']==$model->unit_id){
                    echo Html::a('Change Password!', '#changePassword',['onclick'=>'changePassword()','id'=>'buttonchangePassword']) . '<br />';
                }
                ?>
                <div id="changePassword">
                    <?= $form->field($model, 'auth_key')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password','id'=>'cp','value'=>'','placeholder'=>'เปลี่ยนรหัสผ่าน (Password)','style'=>'margin-top: 0.5em;'])->label(false) ?>
                    <?= $form->field($model, 'password')->hiddenInput(['maxlength' => true, 'id' => 'mytextbox'])->label(false); ?>
                </div>
            <?php }else{ echo $form->field($model, 'password')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password', 'id' => 'mytextbox']); }?>


        </div>
    </div>

    <div class="row">
        <?php if($_SESSION['user_role']=='1'): ?>

            <?php if ($_SESSION['user_role']=='1' && $_SESSION['user_id']==$model->id): ?>
                <?php echo $form->field($model, 'role')->hiddenInput(['maxlength' => true,'value'=>'1'])->label(false); ?>
                <?=$form->field($model, 'unit_id')->hiddenInput(['value' => '000'])->label(false); ?>
                <?php else: ?>
                    <?php echo $form->field($model, 'role')->hiddenInput(['maxlength' => true,'value'=>'2'])->label(false); ?>
                    <?php if ($model->isNewRecord): ?>
                        <div class="col-md-4">
                            <label class="control-label" for="users-unit_id">หน่วยงาน</label>
                            <?php

                            $model->unit_id = (isset($_GET['unitid'])) ? $model->unit_id=$_GET['unitid'] : $model->unit_id='';

                            $Unit=Unit::find()->orderBy(['unit_name'=>SORT_ASC])->all();
                            $unit_id=ArrayHelper::map($Unit,'unit_id','unit_name');

                            echo $form->field($model, 'unit_id')->dropDownList($unit_id,['prompt'=>'Select...','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
                            ?>
                        </div>
                    <?php endif ?>

                    <?php if (!$model->isNewRecord): ?>
                        <div class="col-md-4">
                          <label class="control-label" for="users-unit_id">หน่วยงาน</label>
                          <?php
                          $Unit=Unit::find()->orderBy(['unit_name'=>SORT_ASC])->all();
                          $unit_id=ArrayHelper::map($Unit,'unit_id','unit_name');

                          echo $form->field($model, 'unit_id')->dropDownList($unit_id,['prompt'=>'Select...','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
                          ?>
                      </div>
                  <?php endif ?>
                  <div class="col-md-4">
                    <?//=$form->field($model, 'user_group')->textInput(['maxlength' => true]) ?>
                    <?php
                    $group=UserGroup::find()->all();
                    $data=ArrayHelper::map($group,'id','name');

                    echo $form->field($model, 'user_group')->dropDownList($data,['prompt'=>'Select...']);
                    ?>
                </div>

            <?php endif ?>
            <?php else: ?>
                <?php if($_SESSION['user_role']=='1'): ?>
                    <div class="col-md-3">
                        <?php
                        $role=UserRole::find()->all();
                        $listData=ArrayHelper::map($role,'id','role');

                        echo $form->field($model, 'role')->dropDownList($listData,['prompt'=>'Select...']);
                        ?>
                    </div>

                <?php endif; ?>

                <?php if($_SESSION['user_role']=='2'): ?>
                <div class="col-md-4">
                    <?php
                    $group=UserGroup::find()->all();
                    $data=ArrayHelper::map($group,'id','name');

                    echo $form->field($model, 'user_group')->dropDownList($data,['prompt'=>'Select...']);
                    ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="row">
           <div class="col-md-4">
            <?= $form->field($model, 'notification')->radioList([0 => 'ปิดการแจ้งเตือน', 1 => 'เปิดการแจ้งเตือน']); ?>
            <!-- <input type="checkbox" checked data-toggle="toggle" data-on="เปิดการแจ้งเตือน" data-off="ปิดการแจ้งเตือน" data-onstyle="success" data-offstyle="danger"> -->
        </div>
        <?php if ($_SESSION['user_role']=='2' && $model->id!=$_SESSION['user_id'] && $model->unit_id == $_SESSION['unit_id']): ?>
            <?= $form->field($model, 'status')->radioList([0 => 'ปิด', 1 => 'เปิด'])->label('สิทธิ์การเข้าใช้ระบบงาน'); ?>
        <?php elseif ($_SESSION['user_role']=='1' && $model->id!=$_SESSION['user_id']): ?>
            <?= $form->field($model, 'status')->radioList([0 => 'ปิด', 1 => 'เปิด'])->label('สิทธิ์การเข้าใช้ระบบงาน'); ?>
        <?php else: ?>
            <?=$form->field($model, 'status')->hiddenInput(['value' => '1'])->label(false); ?>
        <?php endif ?>
    </div>

    <?//=$form->field($model, 'status')->dropDownList([1 => 'enable', 0 => 'disable']); ?>
    

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success checkimg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var x = document.getElementById("cp");
    var y = document.getElementById("changePassword");
    var b = document.getElementById("buttonchangePassword");
    x.style.display = "none";
    y.style.display = "none";
    function changePassword() {

        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display = "block";
        } else {
            x.style.display = "none";
            y.style.display = "none";
        }
    }
</script>


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