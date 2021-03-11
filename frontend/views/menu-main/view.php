<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\MenuMain */

$this->title = 'จัดการเมนูหลักและเมนูย่อยของ: '.$model->m_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เมนูหลัก'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
#sortable-row { list-style: none;overflow: scroll; }
#sortable-row li { margin-bottom:4px; padding:10px; background-color:#e3e3e3;cursor:move;color: #212121;width: 100%;border-radius: 3px;border:#ccc 1px solid}
#sortable-row li.ui-state-highlight { height: 2.5em; background-color:#F0F0F0;border:#ccc 2px dotted;}
.menu-slot{
    height: 40px;
}
.menu-slot-left{
    float: left;
    display: inline-block;
}
.menu-slot-right{
    float: right;
    display: inline-block;
}
.menu-sub-margin{
    margin-bottom: 10px;
}
</style>
<?php

if(isset($_POST["menu_slot"])) {
    // echo "<script>alert('".$_POST["menu_slot"]."');</script>";
    $id_ary = explode(",",$_POST["menu_slot"]);
    for($i=0;$i<count($id_ary);$i++) {

        $execute_menu_main = Yii::$app->db->createCommand("UPDATE menu_sub SET submenu_sort ='" . $i . "' WHERE submenu_id =". $id_ary[$i])->execute();
    }

    echo "<script>window.location='index.php?r=menu-main/view&id=".$_GET['id']."';</script>";
}
$result = Yii::$app->db->createCommand("SELECT * FROM menu_main WHERE m_status = 'Y' ORDER BY m_sort ASC")->queryAll();

?>

<div class="menu-main-view">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a(Yii::t('app', 'แก้ไข'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php if($model->id!='1'): ?>
                            <?= Html::a(Yii::t('app', 'ลบ'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </p>
                    <h6>ข้อมูลเมนูหลัก</h6>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'm_name',
                            'm_link:ntext',
            // 'm_role',
            // [
            //     'attribute'=>'m_role',
            //     'format'=>'raw',
            //     'value' => function($model, $key)
            //     {
            //         if(!empty($model->m_role) && strlen($model->m_role)>2)
            //         {
            //             return getList($model->m_role,'ms_user_type_group','USER_TYPE_GROUP_CODE','USER_TYPE_GROUP_DESC');
            //         }
            //     },
            // ],
                            [
                                'attribute'=>'m_status',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if($model->m_status=='Y')
                                    {
                                        return 'เปิดการใช้งานเมนู';
                                    }else{
                                        return 'ปิดการใช้งานเมนู';
                                    }
                                },
                            ],

                            [
                                'attribute'=>'m_icon',
                                'format'=>'raw',
                                'value' => function($model, $key)
                                {
                                    if($model->m_icon!='')
                                    {
                                        return '<i class="'.$model->m_icon.'"></i>';
                                    }else{
                                        return '';
                                    }
                                },
                            ],
                            'm_detail',
                        ],
                    ]) ?>

                    <h6>ข้อมูลเมนูย่อย</h6>

                    <div class="row">
                        <div class="col-md-12 menu-sub-margin">
                         <?= Html::a(Yii::t('app', 'เพิ่มเมนูย่อย'), ['menu-sub/create','id_main' => $model->id], ['class' => 'btn btn-success']) ?>
                     </div>
                     <div class="col-md-8">
                        <?php   $form = ActiveForm::begin([
                            'enableClientValidation' => true,
                            'method'=>'post',
                            'options' => [
                                'class' => ''
                            ],
                            'fieldConfig' => [
                                'options' => [
                                    'tag' => false,
                                ],
                            ],
                        ]);?>
                        <div id="manage_sort">
                            <input type="hidden" name="menu_slot" id="menu_slot" />

                            <ul id="sortable-row" class="sortable-all" style="padding: 0;" >
                                <?php $result_sub = Yii::$app->db->createCommand("SELECT * FROM menu_sub WHERE submenu_active = 'Y' AND menu_id = '".$_GET["id"]."' ORDER BY submenu_sort ASC")->queryAll(); 
                                foreach ($result_sub as $row_sub){
                                    if(!empty($row_sub['submenu_role']) && strlen($row_sub['submenu_role'])>2)
                                    {
                                        $show_role = getList($row_sub['submenu_role'],'ms_user_type_group','USER_TYPE_GROUP_CODE','USER_TYPE_GROUP_DESC');
                                    }
                                    ?>
                                    <li class="sub menu-slot" id="<?php echo $row_sub["submenu_id"]; ?>">
                                        <div class="menu-slot-left">
                                           <i class="<?php echo $row_sub["s_icon"]; ?>"></i>
                                            <?php echo $row_sub["submenu_name"]; ?>
                                        </div>
                                        <div class="menu-slot-right">
                                            <a href="index.php?r=menu-sub/view&id=<?php echo $row_sub["submenu_id"]; ?>" title="ดู" aria-label="ดู" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span>
                                            </a>
                                            <a href="index.php?r=menu-sub/update&id=<?php echo $row_sub["submenu_id"]; ?>&id_main=<?php echo $_GET["id"]; ?>" title="ปรับปรุง" aria-label="ปรับปรุง" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <a href="index.php?r=menu-sub%2Fdelete&amp;id=<?php echo $row_sub["submenu_id"]; ?>&amp;menu_id=<?=$model->id;?>" data-confirm=" ต้องยกเลิกเมนูใช่หรือไม่?" data-method="post" data-title="Delete">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>

                                        </div>
                                    </li>
                                    <?php
                                }

                                ?>
                            </ul>

                            <input type="submit" class="btn btn-primary" value="บันทึกการเรียงลำดับ" onClick="saveOrder();" style="margin: 0;"/>
                            <a href="index.php?r=user-role" class="btn btn-primary" style="margin: 0;" >จัดการสิทธิ์การเข้าใช้เมนู</a>
                            
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<script>
    (function($) {
        $(document).ready(function() {
            $( "#sortable-row" ).sortable({
                placeholder: "ui-state-highlight"
            });
        });
    }) (jQuery);


    function saveOrder() {
        var selectedLanguage = new Array();
        $('ul#sortable-row li').each(function() {
            selectedLanguage.push($(this).attr("id"));
        });
        document.getElementById("menu_slot").value = selectedLanguage;
    }
</script>