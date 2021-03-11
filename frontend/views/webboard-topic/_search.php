<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\WebboardForum;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\WebboardTopicSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webboard-topic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?//= $form->field($model, 'topic_id') ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'topic_name') ?>
        </div>
        <?//= $form->field($model, 'topic_detail') ?>

        <?//= $form->field($model, 'topic_view') ?>

        <?//= $form->field($model, 'topic_reply') ?>

        <?php // echo $form->field($model, 'topic_date_create') ?>

        <?php // echo $form->field($model, 'topic_user_create') ?>

        <div class="col-md-6">
            <label class="control-label" for="webboardtopicsearch-forum_id">หมวดหมู่</label>
            
            <?php //echo $form->field($model, 'forum_id') ?>
            <?php
            $WebboardForum = WebboardForum::find()->all();
            $forum_id = ArrayHelper::map($WebboardForum, 'forum_id', 'forum_name');
            echo $form->field($model, 'forum_id')->dropDownList($forum_id, ['prompt' => 'เลือกหมวดหมู่','class'=>'multiselect multiselect-custom multiselect-filter'])->label(false);
            ?>
            
        </div>

        <?php // echo $form->field($model, 'status_del') ?>

        <?php // echo $form->field($model, 'key_images_or_file') ?>

        
        <div class="form-group col-md-12">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('ล้างข้อมูล', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
 $(document).ready(function(){
    $(".field-webboardtopicsearch-forum_id").addClass('multiselect_div');
    $('.multiselect-filter').multiselect({
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        maxHeight: 200
    });
});
</script>


