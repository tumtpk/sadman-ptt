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
if ($_SESSION['user_role']=='1') {
	if (isset($_GET['unitid'])) {
		$this->title = 'เพิ่มสายข่าวของหน่วยงาน : '.$_GET['unitname'];
		$checkuser = Yii::$app->db->createCommand("SELECT COUNT(*) FROM undercover WHERE unitid = '".$_GET['unitid']."'")->queryScalar();
		$checklimit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$_GET['unitid']."'")->queryOne();
		if($checkuser>=$checklimit['undercover_limit']){
			echo "<script>alert('จำนวนสายข่าวเต็มแล้ว กรุณาตรวจสอบ');window.close();</script>";
		}
	}else{
		$this->title = 'เพิ่มสายข่าวของหน่วยงาน';
	}
}else if ($_SESSION['user_role']=='2'){
	$checkuser = Yii::$app->db->createCommand("SELECT COUNT(*) FROM undercover WHERE unitid = '".$_SESSION['unit_id']."' ")->queryScalar();
	$checklimit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '".$_SESSION['unit_id']."'")->queryOne();
	if($checkuser>=$checklimit['undercover_limit']){
		echo "<script>alert('จำนวนสายข่าวเต็มแล้ว กรุณาตรวจสอบ');window.history.back();</script>";
	}
	$this->title = 'เพิ่มสายข่าวของหน่วยงาน';
}

if ($_SESSION['user_role']!='1') {
	$this->params['breadcrumbs'][] = ['label' => 'สายข่าวในหน่วยงาน', 'url' => ['index', 'unitid' => $_SESSION['unit_id']]];
}
$this->params['breadcrumbs'][] = $this->title;
?>


<style>
    input[type="file"] {
        display: none;
    }
</style>

<div class="undercover-form">
<h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">
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

    <?php if (isset($_GET['unitid'])): ?>
		<?=$form->field($model, 'unitid')->hiddenInput(['value' => $_GET['unitid']])->label(false); ?>
    <?php else: ?>
		<?=$form->field($model, 'unit_id')->hiddenInput(['value' => $_SESSION['unit_id']])->label(false); ?>
	<?php endif ?>

    <?=$form->field($model, 'status')->hiddenInput(['value' => '1'])->label(false); ?>

    

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success checkimg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

                </div>
			</div>
		</div>
	</div>
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