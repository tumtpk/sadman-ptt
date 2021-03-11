<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\mongodb\Query;

?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="icon" href="../../images/favicon_io/favicon.ico" type="image/x-icon"/>

	<title>:: TextX :: Login</title>

	<!-- Bootstrap Core and vandor -->
	<link rel="stylesheet" href="../../html-version/assets/plugins/bootstrap/css/bootstrap.min.css" />

	<!-- Core css -->
	<link rel="stylesheet" href="../../html-version/assets/css/main.css"/>
	<link rel="stylesheet" href="../../html-version/assets/css/theme1.css"/>

	<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@300&display=swap" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<link href="../../../captcha/simple-php-captcha.php"/>

	<style>
	body, input, textarea, select, li, table, tr, td, div, font{font-family:'Bai Jamjuree', sans-serif !important; }

	a, dd, p, pre,h1, h2, h3, h4, h5, h6, div, text, li, button, b, label {font-family:'Bai Jamjuree', sans-serif !important;}
	table > tr > td{font-family:'Bai Jamjuree', sans-serif !important; }
	table tbody tr {font-family:'Bai Jamjuree', sans-serif !important; }

</style>
</head>

<style>

.btn-warning {
	color: #212529;
	background-color: #ffc107;
	border-color: #ffc107;
	margin-bottom: 8px !important;
}
.help-block{
	color: #dc3545 !important;
	font-weight: 600 !important;
}
.textx-logo{
    width: auto;
    height: 50px;
  }
</style>

<body class="font-montserrat sidebar_dark" onload="Captcha();">

	<div class="auth">
		<div class="auth_left">
			<div class="card">
				<div class="text-center">
					<div class="header-brand">
                        <img src="../../images/TextX_Logo.png" class="textx-logo">
                    </div>
				</div>
				<?php $form = ActiveForm::begin([
					'id' => 'login-form',
					'fieldConfig' => [
						'options' => [
							'tag' => false,
						],
					],
				]); 
				?>
				<div class="card-body">
					<div class="card-title"><center><dt>TextX - Login</dt></center></div>
                    <div class="form-group">
                    	<label class="form-label">ชื่อผู้ใช้งาน</label>
                    	<?=$form->field($model, 'username')->textInput(['maxlength' => 30,'aria-describedby' => 'emailHelp', 'class' => 'form-control user_val check_users_status','placeholder' => 'กรุณากรอกชื่อผู้ใช้งาน','id'=>'exampleInputEmail1'])->label(false);?>
                    </div>
                    <div class="form-group">
                    	<label class="form-label">รหัสผ่าน<a href="index.php?r=site/forgot_password" class="float-right small">ลืมรหัสผ่าน</a></label>
                    	<?=$form->field($model, 'password')->passwordInput(['maxlength' => 30,'class' => 'form-control pass_val check_users_status','placeholder' => 'กรุณากรอกรหัสผ่าน','id'=>'exampleInputPassword1'])->label(false);?>
                    </div>

                    <div class="form-group">
                    	<style>
                    	.canvas {
                    		border: 1px var(--main-text-color) solid;
                    	}

                    	#textCanvas {
                    		display: none;
                    	}
                    </style>

                </div>

                <div class="form-group">
                		<?= $form->field($model, 'rememberMe',['options' => ['class' =>'custom-control-input']])->checkbox(); ?>
                	</div>
                	<div class="form-footer">
                		<input type="hidden" name="check_users_status" id="check_users_status">
                		<?=Html::submitButton('เข้าสู่ระบบ', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button','id'=>'verifyButton'])?>
                	</div>
                </div>
                <?php ActiveForm::end();?>
            </div>        
        </div>
        <div class="auth_right">
        	<div class="carousel slide" data-ride="carousel" data-interval="3000">
        		<div class="carousel-inner">
        			<?php
        			$sql = Yii::$app->db->createCommand("SELECT * FROM `carousel_text` ORDER BY slot ASC")->queryAll();
        			$i=1;
        			foreach ($sql as $row){

        				if ($i==1) {
        					$activeClass = "active";
        				}else{
        					$activeClass = "";
        				}

        				?>
        				<div class="carousel-item <?=$activeClass;?>">
        					<img src="<?='/textx/frontend/web/uploads/'.$row['images'];?>" class="img-fluid" alt="login page"/>
        					<div class="px-4 mt-4">
        						<h4><?=$row['name'];?></h4>
        						<p><?=$row['detail'];?></p>
        					</div>
        				</div>
        				<?php $i++; } ?>


        			</div>
        		</div>
        	</div>
        </div>

        <script src="../../html-version/assets/bundles/lib.vendor.bundle.js"></script>
        <script src="../../html-version/assets/js/core.js"></script>
        <script src="../../captcha/rand_captcha.js"></script>
    </body>
    </html>