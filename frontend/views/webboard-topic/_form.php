<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\WebboardForum;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\WebboardTopic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-topic-form">
 <div class="row clearfix">
  <!-- <div class="col-xl-12 col-lg-12 col-md-12"> -->
    <div class="card">
      <div class="card-body ribbon row">
        <div class="col-md-6">
          <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'topic_detail')->textarea(['rows' => 14,'class' => 'summernote']) ?>

          <?= $form->field($model, 'topic_date_create')->hiddenInput(['maxlength' => true,'value'=>date("Y-m-d H:i:s")])->label(false); ?>

          <?= $form->field($model, 'topic_user_create')->hiddenInput(['maxlength' => true,'value'=>$_SESSION['user_id']])->label(false); ?>

          <?php if (isset($_GET['type_forum'])): ?>
           <?= $form->field($model, 'forum_id')->hiddenInput(['maxlength' => true,'value'=>$_GET['type_forum']])->label(false); ?>
           <?php else: ?>
            <label class="control-label" for="webboardtopic-forum_id">หมวดหมู่</label>
            <?php
            $WebboardForum = WebboardForum::find()->all();
            $forum_id = ArrayHelper::map($WebboardForum, 'forum_id', 'forum_name');
            echo $form->field($model, 'forum_id')->dropDownList($forum_id, ['prompt' => 'เลือกหมวดหมู่'])->label(false);
            ?>
          <?php endif ?>

          <?php if ($_SESSION['user_role']=='1'): ?>
            <?php $model->isNewRecord==1 ? $model->status_del=1:$model->status_del;?>
            <?=$form->field($model, 'status_del')->radioList(array(1=>'ใช้งาน',0=>'ยกเลิก',)); ?>
            <?php else: ?>
              <?php $model->isNewRecord==1 ? $model->status_del=1:$model->status_del;?>
              <?=$form->field($model, 'status_del')->hiddenInput(['maxlength' => true, 'value'=>$model->status_del])->label(false); ?>
            <?php endif ?>

            <?php $model->isNewRecord==1 ? $model->key_images_or_file=date("Y-m-d_His"):$model->key_images_or_file;?>
            <?=$form->field($model, 'key_images_or_file')->hiddenInput(['maxlength' => true])->label(false); ?>

            <div class="form-group text-center">
              <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
          </div>

          <div class="col-md-6">

            <?php
            $key_images = $model->key_images_or_file;
            include '../../upload_file/upload_files.php';
            ?>
          </div>


        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>



  <link rel="stylesheet" href="../../html-version/assets/plugins/summernote/dist/summernote.css"/>
  <script src="../../html-version/assets/bundles/summernote.bundle.js"></script>
  <script src="../../html-version/main/assets/js/page/summernote.js"></script>