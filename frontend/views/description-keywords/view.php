<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DescriptionKeywords */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'คำอธิบายการใช้งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
 .img-upload{
        width: 218px;
        border: 0px solid #777777;
        margin-bottom: 10px;
    }
</style>


<div class="description-keywords-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('ลบข้อมูล', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'คุณแน่ใจว่าต้องการจะลบข้อมูลชุดนี้?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    
                    <div class="row">

                        <div class="col-md-6">

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'name',
                                    'detail',
                                  // 'user_create',
                            [
                                'attribute' => 'user_create',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (!empty($model->user_create)) {
                                        $data1 = Yii::$app->db->createCommand("SELECT name FROM users WHERE id ='".$model->user_create."'")->queryOne();
                                            return $data1['name'];
                                        }
                                            },
                            ],
                                ],
                            ]) ?>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <?php
                                    if($model->images!=""){
                                    ?>
                                    <div class="col-xs-12 col-md-12">
                                                                
                                        <div style="background: #ffc107;
                                                padding: 2px 8px;
                                                position: absolute;">ภาพประกอบ</div>
                                        <br><br>
                                                                    
                                        <a class="with-caption" href="../../images_keywords/<?=$model['images'];?>" title="<?=$model['images'];?>">
                                            <img src="../../images_keywords/<?=$model['images'];?>" alt="" class="print-view-box-img img-upload">
                                        </a>
                                        
                                    </div>
                                        
                                <?php } ?>
                                    
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
