<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use frontend\models\MenuSub;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการเมนูระบบ');
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="../../js-sortable/jquery-1.10.2.js"></script>
<script src="../../js-sortable/jquery-ui-1.11.2.js"></script>
<style>
    #sortable-row { 
        list-style: none;
        overflow: scroll;
    }
    #sortable-row li { 
        margin-bottom:4px; 
        padding:10px; 
        background-color:#e3e3e3;
        cursor:move;
        color: #212121;
        width: 100%;
        border-radius: 3px;
        border:#ccc 1px solid
    }
    #sortable-row li.ui-state-highlight { 
        height: 2.5em; 
        background-color:#F0F0F0;
        border:#ccc 2px dotted;
    }
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
</style>

<?php

if(isset($_POST["menu_slot"])) {
    // echo "<script>alert('".$_POST["menu_slot"]."');</script>";
    $id_ary = explode(",",$_POST["menu_slot"]);
    for($i=0;$i<count($id_ary);$i++) {

        $execute_menu_main = Yii::$app->db->createCommand("UPDATE menu_main SET m_sort ='" . $i . "' WHERE id=". $id_ary[$i])->execute();
    }

    echo "<script>window.location='index.php?r=menu-main';</script>";
}
$result = Yii::$app->db->createCommand("SELECT * FROM menu_main WHERE m_status = 'Y' ORDER BY m_sort ASC")->queryAll();

?>
<div class="menu-main-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a(Yii::t('app', '+ เพิ่มเมนูหลัก'), ['create'], ['class' => 'btn btn-success']) ?>
                        <?= Html::a(Yii::t('app', 'จัดการสิทธิ์การเข้าถึงเมนู'), ['user-role/index'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <h4><b>จัดการเมนูหลัก</b></h4>
                            <p>สามารถเพิ่ม ลบ แก้ไขเมนูย่อย และเรียงลำดับของเมนูหลักโดยการลากวาง</p>
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
                                <ul id="sortable-row" style="padding: 0;">
                                    <?php
                                    foreach ($result as $row){
                                        ?>
                                        <li id="<?php echo $row["id"]; ?>" class="menu-slot">
                                            <div class="menu-slot-left">
                                                <i class="<?php echo $row["m_icon"]; ?>"></i>
                                                <strong><?php echo $row["m_name"]; ?></strong>  -

                                                [<?=$count = MenuSub::find()
                                                    ->where(['menu_id' => $row["id"]])
                                                    ->count();?> เมนู]

                                                </div>
                                                <div class="menu-slot-right">
                                                    <a href="index.php?r=menu-main%2Fview&amp;id=<?php echo $row["id"]; ?>">

                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                    </a> 
                                                    <a href="index.php?r=menu-main%2Fupdate&amp;id=<?php echo $row["id"]; ?>">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a> 
                                                    <a href="index.php?r=menu-main%2Fdelete&amp;id=<?php echo $row["id"]; ?>" data-confirm=" ต้องยกเลิกเมนูใช่หรือไม่?" data-method="post" data-title="Delete">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                </div>
                                            </li>
                                            <?php 
                                        }

                                        ?>  
                                    </ul>
                                    <input type="submit" class="btn btn-primary" value="บันทึกการเปลี่ยนแปลง" onClick="saveOrder();" style="margin: 0;"/>


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
        })(jQuery);


        function saveOrder() {
            var selectedLanguage = new Array();
            $('ul#sortable-row li').each(function() {
                selectedLanguage.push($(this).attr("id"));
            });
            document.getElementById("menu_slot").value = selectedLanguage;
        }
    </script>