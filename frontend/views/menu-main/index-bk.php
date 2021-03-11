<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการเมนูหลัก');
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
    #sortable-row { list-style: none; }
    #sortable-row li { margin-bottom:4px; padding:10px; background-color:#e3e3e3;cursor:move;color: #212121;width: 100%;border-radius: 3px;border:#ccc 1px solid}
    #sortable-row li.ui-state-highlight { height: 2.5em; background-color:#F0F0F0;border:#ccc 2px dotted;}
    /*#manage_sort{ display: none; }*/
</style>

<?php

if(isset($_POST["submit"])) {
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
                        <?= Html::a(Yii::t('app', 'เพิ่มเมนูหลัก'), ['create'], ['class' => 'btn btn-success']) ?>
                        <!-- <a class="btn btn-primary" onclick="click_show();">จัดเรียงลำดับเมนู</a> -->
                    </p>

                    <?php Pjax::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'm_name',
                                    'm_link:ntext',
                                    [
                                        'attribute'=>'m_status',
                                        'format'=>'raw',
                                        'value' => function($model, $key, $index)
                                        {
                                            if($model->m_status=='Y')
                                            {
                                                return 'enable';
                                            }else{
                                                return 'disable';
                                            }
                                        },
                                    ],

                                    ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                                ['menu-main/view', 'id' => $model->id]
                                            );
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                                ['menu-main/update', 'id' => $model->id]
                                            );
                                        },
                                        'delete' => function ($url, $model, $key) {
                                            if($model->id=='1') {
                                                return false;
                                            }else{
                                                return  Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], ['data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'method' => 'post','title'=>'Delete'],]);
                                            }
                                        },

                                    ],
                                ],
                            ],
                        ]); ?>

                        <?php Pjax::end(); ?>
                  

                    <div class="col-md-6">
                        <h4><b>จัดเรียงลำดับเมนู</b></h4>
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
                                    <li id=<?php echo $row["id"]; ?>><?php echo $row["m_name"]; ?></li>
                                    <?php 
                                }

                                ?>  
                            </ul>
                            <input type="submit" class="float-right btn btn-primary" name="submit" value="บันทึกการเรียงลำดับ" onClick="saveOrder();" style="margin: 0;"/>
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