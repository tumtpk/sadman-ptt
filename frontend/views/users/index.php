<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\UserRole;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (isset($_GET['unitid'])) {
    $UnitName = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '" . $_GET['unitid'] . "'")->queryOne();
    $this->title = 'ข้อมูลผู้ใช้งานระบบในหน่วยงาน : ' . $UnitName['unit_name'];
} else {
    if ($_SESSION['user_role'] == '2') {
        echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
    }
    $this->title = 'ข้อมูลผู้ใช้งานระบบ';
}


$this->params['breadcrumbs'][] = $this->title;
$day_now = date('Y-m-d');
?>
<div class="users-index">


    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body w_sparkline">
                    <div class="details">
                        <span class="text-nowrap">ผู้ใช้งานทั้งหมด</span>
                        <h3 class="mb-0 counter"><?php
                                                    if (isset($_GET['unitid'])) {
                                                        echo $userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE unit_id = '" . $_GET['unitid'] . "' AND  role IN ('1','2','3')")->queryScalar();
                                                    } else {
                                                        echo $userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role IN ('1','2','3') ")->queryScalar();
                                                    }
                                                    ?>

                        </h3>
                        <br>
                    </div>
                    <div class="w_chart">
                        <i class="users-box-icon text-green icon-users"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="card">
                <div class="card-body w_sparkline">
                    <div class="details">
                        <?php if (isset($_GET['unitid'])) : ?>
                            <span class="text-nowrap">ผู้ดูแลหน่วยงาน</span>
                            <h3 class="mb-0 counter"><?= $admin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '2' AND unit_id = '" . $_GET['unitid'] . "'")->queryScalar(); ?></h3>
                        <?php else : ?>
                            <span class="text-nowrap">ผู้ดูแลระบบ</span>
                            <h3 class="mb-0 counter"><?= $admin = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '1'")->queryScalar(); ?></h3>
                        <?php endif ?>
                        <br>
                    </div>
                    <div class="w_chart">
                        <i class="users-box-icon text-orange icon-user-following"></i>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!isset($_GET['unitid'])) : ?>

            <div class="col">
                <div class="card">
                    <div class="card-body w_sparkline">
                        <div class="details">
                            <span class="text-nowrap">ผู้ดูแลหน่วยงาน</span>
                            <h3 class="mb-0 counter"><?php
                                                        echo $userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '2'")->queryScalar();
                                                        ?>
                            </h3>
                            <br>
                        </div>
                        <div class="w_chart">
                            <i class="users-box-icon text-blue icon-user-follow"></i>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif ?>

        <div class="col">
            <div class="card">
                <div class="card-body w_sparkline">
                    <div class="details">
                        <span class="text-nowrap">ผู้ใช้งานทั่วไป</span>
                        <h3 class="mb-0 counter">
                            <?php if (isset($_GET['unitid'])) : ?>
                                <?= $users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '3' AND unit_id = '" . $_GET['unitid'] . "'")->queryScalar(); ?>
                            <?php else : ?>
                                <?= $users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '3'")->queryScalar(); ?>
                            <?php endif ?>
                        </h3>
                        <br>
                    </div>
                    <div class="w_chart">
                        <i class="users-box-icon text-indigo icon-user"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body w_sparkline">
                    <div class="details">
                        <span>จำนวนการใช้งานวันนี้</span>

                        <?php if (isset($_GET['unitid'])) : ?>
                            <h3 class="mb-0 counter">
                                <?= $users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '" . $_GET['unitid'] . "' AND  user_log_usaged.create_date = '" . $day_now . "'")->queryScalar(); ?>
                            </h3><br>
                        <?php else : ?>
                            <h3 class="mb-0 counter">
                                <?= $users = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `user_log_usaged` WHERE `create_date` = '" . $day_now . "'")->queryScalar(); ?>
                            </h3>
                        <?php endif ?>

                    </div>
                    <div class="w_chart">
                        <i class="users-box-icon text-pink icon-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!isset($_GET['unitid'])) : ?>

            <div class="col">
                <a href="index.php?r=site/pages&view=stat_users" style="color: inherit !important;">
                    <div class="card">
                        <div class="card-body w_sparkline">
                            <div class="details">
                                <br>
                                <!-- <span class="text-nowrap">รายงานสถิติการเข้าใช้งาน</span> -->
                                <h6 class="mb-3">
                                    <?php
                                    //echo $userAll = Yii::$app->db->createCommand("SELECT COUNT(*) FROM users WHERE role = '2'")->queryScalar();
                                    ?>
                                    รายงานสถิติการเข้าใช้งาน
                                </h6>

                            </div>
                            <div class="w_chart">
                                <i class="users-box-icon text-blue icon-graph"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif ?>
    </div>

    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?php if (isset($_GET['unitid'])) : ?>
                            <?php if ($_SESSION['user_role'] == 1) : ?>
                                <?= Html::a('เพิ่มผู้ใช้งานในหน่วย', ['create_users', 'unitid' => $_GET['unitid'], 'unitname' => $UnitName['unit_name']], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('เพิ่มสายข่าวในหน่วย', ['undercover/create_undercover', 'unitid' => $_GET['unitid'], 'unitname' => $UnitName['unit_name']], ['class' => 'btn btn-success']) ?>
                            <?php else : ?>
                                <?= Html::a('เพิ่มผู้ใช้งานในหน่วย', ['create_users'], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('เพิ่มสายข่าวในหน่วย', ['undercover/create_undercover'], ['class' => 'btn btn-success']) ?>
                            <?php endif ?>
                        <?php else : ?>
                            <?= Html::a('เพิ่มผู้ใช้งานระบบ', ['create'], ['class' => 'btn btn-success']) ?>
                        <?php endif ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,

                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            'username',
                            [
                                'attribute' => 'role',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index) {
                                    if (!empty($model->role)) {
                                        $query = UserRole::find()
                                            ->select('id,role')
                                            ->where("id = " . $model->role)->one();
                                        // return '<h5><span class="label label-default">'.$query->role.'</span></h5>';
                                        return $query->role;
                                    }
                                },
                            ],
                            [
                                'attribute' => 'unit_id',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index) {
                                    if (!empty($model->unit_id)) {
                                        $unit = Yii::$app->db->createCommand("SELECT * FROM unit WHERE unit_id = '" . $model->unit_id . "'")->queryOne();
                                        return $unit['unit_name'];
                                    }
                                },
                            ],
                            [
                                'attribute' => 'user_group',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index) {
                                    if (!empty($model->user_group)) {
                                        $user_group = Yii::$app->db->createCommand("SELECT * FROM user_group WHERE id = '" . $model->user_group . "'")->queryOne();
                                        return $user_group['name'];
                                    }
                                },
                            ],
                            //'user_group',
                            //'images:ntext',
                            //'status',
                            'email',

                            // ['class' => 'yii\grid\ActionColumn'],
                            [
                                'attribute' => 'status',
                                'label' => 'สิทธิ์การเข้าใช้งานระบบ',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index) {

                                    if ($model->status == '1') {
                                        return 'เปิด';
                                    } else {
                                        return 'ปิด';
                                    }
                                },
                                // 'visible' => $_SESSION['user_role']=='1' ? true : false
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="fas fa-eye"></i>',
                                            ['users/view', 'id' => $model->id],
                                            ['title' => 'View', 'class' => 'btn btn-light']
                                        );
                                    },
                                    'update' => function ($url, $model, $key) {

                                        return Html::a(
                                            '<i class="fas fa-pencil-alt"></i>',
                                            ['users/update', 'id' => $model->id],
                                            ['title' => 'Update', 'class' => 'btn btn-light']
                                            // ['target'=>'_blank', 'title' => 'Update']
                                        );
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        if ($_SESSION['user_role'] == '2' && $model->role == '2') {
                                            return false;
                                        } else if ($model->role == '1') {
                                            return false;
                                        } else {
                                            return  Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app', 'ต้องการยกเลิกผู้ใช้งานใช่หรือไม่?'), 'method' => 'post', 'title' => 'Delete'], 'class' => 'btn btn-light']);
                                        }
                                    },

                                ],
                                'options' => ['style' => 'width:20%;'],
                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>