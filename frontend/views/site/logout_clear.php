<?php
// $session = Yii::$app->session;
// $session->remove('user_id');

// //OR
// unset($session['user_id']);
// //OR
// unset($_SESSION['user_id']);
Yii::$app->user->logout();

session_start();

session_destroy();

Yii::$app->session->destroy();

echo "";
// header('Location: index.php?r=site/login');

echo "<script>window.location='index.php?r=site/login'</script>";

?>