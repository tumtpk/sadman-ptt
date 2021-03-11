<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarouselTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สไลด์ข่าวหน้าเข้าสู่ระบบ';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
    #sortable-row { list-style: none; }
    #sortable-row li { margin-bottom:4px; padding:10px; background-color:#e3e3e3;cursor:move;color: #212121;width: 100%;border-radius: 3px;border:#ccc 1px solid}
    #sortable-row li.ui-state-highlight { height: 2.5em; background-color:#F0F0F0;border:#ccc 2px dotted;}
    /*#manage_sort{ display: none; }*/
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
if(isset($_POST["carousel_slot"])) {
    // echo "<script>alert('".$_POST["menu_slot"]."');</script>";
    $id_ary = explode(",",$_POST["carousel_slot"]);
    for($i=0;$i<count($id_ary);$i++) {

        $execute_menu_main = Yii::$app->db->createCommand("UPDATE carousel_text SET slot ='" . $i . "' WHERE id=". $id_ary[$i])->execute();
    }

    echo "<script>window.location='index.php?r=carousel-text';</script>";
}
$result = Yii::$app->db->createCommand("SELECT * FROM carousel_text  ORDER BY slot ASC")->queryAll();

?>
<div class="carousel-text-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a('เพิ่มสไลด์ข่าวหน้าเข้าสู่ระบบ', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <h4><b>จัดการสไลด์ข่าวหน้าเข้าสู่ระบบ</b></h4>
                            <p>สามารถเพิ่ม ลบ แก้ไขเมนูย่อย และเรียงลำดับของสไลด์ข่าวหน้าเข้าสู่ระบบ</p>
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
                                <input type="hidden" name="carousel_slot" id="carousel_slot" /> 
                                <ul id="sortable-row" style="padding: 0;">
                                    <?php
                                    foreach ($result as $row){
                                        ?>
                                        <li id="<?php echo $row["id"]; ?>" class="menu-slot">
                                            <div class="menu-slot-left"><?php echo $row["name"]; ?></div>
                                            <div class="menu-slot-right">
                                                <a href="index.php?r=carousel-text%2Fview&amp;id=<?php echo $row["id"]; ?>">
                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                </a> 
                                                <a href="index.php?r=carousel-text%2Fupdate&amp;id=<?php echo $row["id"]; ?>">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a> 
                                                <a href="index.php?r=carousel-text%2Fdelete&amp;id=<?php echo $row["id"]; ?>" data-confirm=" ต้องยกเลิกเมนูใช่หรือไม่?" data-method="post" data-title="Delete">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </div>
                                        </li>
                                        <?php 
                                    }

                                    ?>  
                                </ul>
                                <input type="submit" class="btn btn-primary" value="บันทึกการเรียงลำดับ" onClick="saveOrder();" style="margin: 0;"/>
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
        document.getElementById("carousel_slot").value = selectedLanguage;
    }
</script>