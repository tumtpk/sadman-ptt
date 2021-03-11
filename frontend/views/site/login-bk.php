<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\mongodb\Query;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php // To get from db2
// $rows = Yii::$app->hosxpDb->createCommand('SELECT * FROM ms_bank')->queryAll();
// foreach ($rows as $row) {
//   echo $row['BANK_NAME'].", ";
// }

// echo "<br>";

// $values = MsBank::find()->select('*')->all();

// foreach ($values as $val) {
//   echo $val['BANK_NAME'].", ";
// }

// $query = new Query();
// // compose the query
// $query->select(['admin_name', 'admin_permission'])
//     ->from('ds_admin')
//     ->limit(10);
// // execute the query
// $rows = $query->all();

// foreach ($rows as $row) {
//    echo $row['admin_name'].'<br>';
// }
// $rows = Yii::$app->mongodb->createCommand(['admin_name', 'admin_permission'])->query('ds_admin');
// foreach ($rows as $row) {
//    echo $row['admin_name'].'<br>';
// }
?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
