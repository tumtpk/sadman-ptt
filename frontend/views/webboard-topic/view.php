<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\WebboardForum;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\WebboardTopic */

$this->title = $model->topic_name;
$this->params['breadcrumbs'][] = ['label' => 'กระดานข่าว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<link rel="stylesheet" href="../../html-version/assets/css/style_table.css"/>
<div class="webboard-topic-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="row clearfix">
        <div class="col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body ribbon">
                   <?php if($model->topic_user_create==$_SESSION['user_id'] || $_SESSION['user_role']=='1'): ?>
                    <p>

                        <?= Html::a('แก้ไข', ['update', 'id' => $model->topic_id], ['class' => 'btn btn-primary']) ?>
                        <?php if ($_SESSION['user_role']=='1'): ?>
                            <?= Html::a('ลบ', ['delete', 'id' => $model->topic_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'ต้องการยกเลิกกระดานข่าวใช่หรือไม่?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?php else: ?>
                                <?= Html::a('ลบ', ['update_status_del', 'id' => $model->topic_id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'ต้องการยกเลิกกระดานข่าวใช่หรือไม่?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif ?>
                            
                        </p>
                    <?php endif; ?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                        // 'topic_id',
                            'topic_name',
                            'topic_detail:ntext',
                        // 'topic_date_create',
                            [
                                'attribute'=>'topic_date_create',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if(!empty($model->topic_date_create))
                                    {
                                        return DateThaiTime($model->topic_date_create);
                                    }
                                },
                            ],
                            [
                                'attribute' => 'topic_user_create',
                                'format' => 'raw',
                                'value' => function ($model, $key) {
                                    if (!empty($model->topic_user_create)) {
                                        $query = Users::find()
                                        ->select('id,name')
                                        ->where("id = " . $model->topic_user_create)->one();
                                        return $query->name;
                                    }
                                },
                            ],
                        // 'status_del',
                            [
                                'label' => 'หมวดหมู่',
                                'attribute' => 'forum_id',
                                'format' => 'raw',
                                'value' => function ($model, $key) {
                                    if (!empty($model->forum_id)) {
                                        $query = WebboardForum::find()
                                        ->select('forum_id,forum_name')
                                        ->where("forum_id = " . $model->forum_id)->one();
                                        return $query->forum_name;
                                    }
                                },
                            ],
                            'topic_view',
                            'topic_reply',

                        // 'key_images_or_file',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body ribbon">
                    455445645
                </div>
            </div>
        </div>
    </div>

</div>
