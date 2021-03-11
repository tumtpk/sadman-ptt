<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


?>

<?php
if (isset($_POST['email'])) {
	// echo "<script>alert('".$_POST['email']."');</script>";
	$check_email = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE email = '".$_POST['email']."'")->queryScalar();
	if ($check_email>0) {
		$message_error = "";
		$random = substr(md5(mt_rand()), 0, 8);
		include('../../PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
			$mail->Host = "ssl://smtp.gmail.com:465";
		    $mail->Port = 465;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
		    $mail->isHTML();
			$mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
			$mail->Username = "yii2intelligence@gmail.com"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
			$mail->Password = "Yii2@intelligence"; // ใส่รหัสผ่าน
			$mail->SetFrom = ('no-reply@domaintest.com'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
			$mail->FromName = "Yii2@intelligence"; //ชื่อที่ใช้ในการส่ง
			$mail->Subject = "รหัสผ่านใหม่ (เพื่อเข้าใช้งานระบบ)";  //หัวเรื่อง emal ที่ส่ง
			$mail->Body = "
			
			<div style='font-size:16px;font-weight:bold;'><b>รหัสผ่านใหม่ : </b></div>
			<div style='font-size:30px;background-color:#d93025;color:#FFF;width:200px;text-align:center;'>".$random."</div>
			"; //รายละเอียดที่ส่ง
			$mail->AddAddress($_POST['email']); //อีเมล์และชื่อผู้รับ

				//ตรวจสอบว่าส่งผ่านหรือไม่
			if ($mail->Send()){
				// echo "ส่งสำเร็จ";
				
				$command = Yii::$app->db->createCommand("UPDATE users SET password = '".md5($random)."' WHERE email = '".$_POST['email']."'");
				if($command->execute()){
					echo "<script>window.location='index.php?r=users/forgot_password&send_email=true&email=".$_POST['email']."';</script>";
				}
			}else{
				// echo "no";
				echo $mail->ErrorInfo;

			}

		}else{
			$message_error = "ไม่มีอีเมลนี้อยู่ในระบบ กรุณาตรวจสอบ";
		}
	}

	if (isset($_POST['password'])) {
		$check_password = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE email = '".$_GET['email']."' AND password = '".md5($_POST['password'])."'")->queryScalar();
		if ($check_password>0) {
			$command = Yii::$app->db->createCommand("UPDATE users SET password = '".md5($_POST['new_password'])."' WHERE email = '".$_GET['email']."'");
			if($command->execute()){
				echo "<script>window.location='index.php?r=site/login';</script>";
			}
		}else{
			$message_error = "รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบ";
		}
	}

	?>


	<title>Forgot Password?</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/animate/animate.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/select2/select2.min.css">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../../Login_v15/vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" type="text/css" href="../../Login_v15/css/util.css">
	<link rel="stylesheet" type="text/css" href="../../Login_v15/css/main.css">

	<link rel="stylesheet" type="text/css" href="../../css/checkmark.css">

	<link href="https://fonts.googleapis.com/css?family=Prompt&display=swap" rel="stylesheet">

	<style>
	p,div,button,a,body,span,.alert-validate{
		font-family: 'Prompt', sans-serif !important;
	}

	::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		font-family: 'Prompt', sans-serif !important;
	}

</style>

<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-form-title">
				<img src="../../intelligence/images/logo.png" alt="logo.png">
				<br>
				<span class="login100-form-title-1">
					Forgot Password? 
				</span>
			</div>

			<?php if (isset($_GET['send_email'])) { ?>
				
				<?php   $form = ActiveForm::begin([
					'enableClientValidation' => true,
					'method'=>'post',
					'options' => [
						'class' => 'login100-form validate-form'
					],
					'fieldConfig' => [
						'options' => [
							'tag' => false,
						],
					],
				]);?>

				<!-- <form class="login100-form validate-form" method="POST" action="index.php?r=users/forgot_password"> -->

					<div class="wrap-input100 validate-input m-b-10" data-validate="password is required">
						<span class="label-input100">password</span>
						<input class="input100" type="password" name="password" placeholder="Enter password form email">

						<span class="focus-input100"></span>
					</div>
					<p style="color: red;font-weight: bold;"><?php echo $message_error; ?></p>

					<div class="wrap-input100 validate-input m-b-10" data-validate="new-password is required">
						<span class="label-input100">new password</span>
						<input class="input100" type="password" name="new_password" placeholder="Enter new password" id="new_password">

						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate="confirm-password is required">
						<span class="label-input100">confirm password</span>
						<input class="input100" type="password" name="confirm_password" id="confirm_password"placeholder="Enter confirm password" onkeyup="check();">
						<span class="focus-input100"></span>
					</div>
					<p id='message'></p>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn btn-color-blue">
							เปลี่ยนรหัสผ่าน!
						</button>
					</div>

					<!-- </form> -->
					<?php ActiveForm::end(); ?>

				<?php }else{ ?>

					<?php   $form = ActiveForm::begin([
						'enableClientValidation' => true,
						'method'=>'post',
						'options' => [
							'class' => 'login100-form validate-form'
						],
						'fieldConfig' => [
							'options' => [
								'tag' => false,
							],
						],
					]);?>

					<!-- <form class="login100-form validate-form" method="POST" action="index.php?r=users/forgot_password"> -->

						<div class="wrap-input100 validate-input m-b-10" data-validate="email is required">
							<span class="label-input100">email</span>
							<input class="input100" type="email" name="email" placeholder="Enter email">

							<span class="focus-input100"></span>
						</div>

						<p style="color: red;font-weight: bold;"><?php echo $message_error; ?></p>
						<p><span style="color: red;">*</span> กรุณากรอกอีเมลล์ที่ใช้ลงทะเบียนลงในช่องว่าง เพื่อขอรับรหัสผ่านใหม่ทางอีเมล</p>

						<div class="container-login100-form-btn m-t-20">
							<button class="login100-form-btn btn-color-blue">
								ส่งรหัสผ่านใหม่!
							</button>
						</div>

						<!-- </form> -->
						<?php ActiveForm::end(); ?>

					<?php } //!$_GET['send_email']?>
				</div>
			</div>
		</div>

		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/jquery/jquery-3.2.1.min.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/bootstrap/js/popper.js"></script>
		<script src="../../Login_v15/vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/select2/select2.min.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/daterangepicker/moment.min.js"></script>
		<script src="../../Login_v15/vendor/daterangepicker/daterangepicker.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/vendor/countdowntime/countdowntime.js"></script>
		<!--===============================================================================================-->
		<script src="../../Login_v15/js/main.js"></script>


		<script>
			var np = document.getElementById('new_password');
			var cp = document.getElementById('confirm_password');
			var message = document.getElementById('message');
			var check = function() {
				if (np.value == cp.value) {
					message.style.fontWeight = "900";
					message.innerHTML = '';
				} else {
					message.style.fontWeight = "900";
					message.style.color = 'red';
					message.innerHTML = 'รหัสผ่านไม่ตรงกัน';
				}
			}
		</script>