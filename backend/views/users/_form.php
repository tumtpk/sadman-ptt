<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRole;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->isNewRecord) {
        echo Html::a('Change Password!', '#',['onclick'=>'changePassword()']) . '<br /><br />';
    ?>
        <div id="changePassword">
        <?= $form->field($model, 'auth_key')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password','id'=>'cp','value'=>''])->label('Password') ?>
        <?= $form->field($model, 'password')->hiddenInput(['maxlength' => true])->label(false); ?>
        </div>
    <?php }else{ echo $form->field($model, 'password')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password']); }?>

    <?php //= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'images')->fileInput() ?>
    <div class="row">
      <div class="col-md-2">
        <div class="well text-center">
          <?= Html::img($model->getPhotoViewer(),['style'=>'width:100px;','class'=>'img-rounded','id'=>'imgOld']); ?>
          <img id="person_pic" style="width: 100px;">
        </div>
      </div>
      <div class="col-md-10">
            <?= $form->field($model, 'images')->fileInput(["onchange"=>"document.getElementById('person_pic').src = window.URL.createObjectURL(this.files[0]),document.getElementById('imgOld').style.display ='none'"]) ?>

      </div>
    </div>

    <?php //= $form->field($model, 'status')->textInput() ?>
    <?php

        $role=UserRole::find()->all();
        $listData=ArrayHelper::map($role,'id','role');

        echo $form->field($model, 'role')->dropDownList($listData,['prompt'=>'Select...']);
    ?>

    <?php //= $form->field($model, 'role')->textInput() ?>
    <?=$form->field($model, 'status')->dropDownList([1 => 'enable', 0 => 'disable']); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

 <?php
$script = <<< JS
    $('#users-username').on('beforeSubmit', function(e){
        var form = $(this);
        $.post(
            form.attr("action"),
            form.serialize()
        ).done(function(data){
            form.trigger("reset");
        });
        return false;
    });
JS;
$this->registerJs($script);
?>


<script>
var x = document.getElementById("cp");
var y = document.getElementById("changePassword");
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

</div>
