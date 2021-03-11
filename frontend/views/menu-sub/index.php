<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu Subs');
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
    #sortable-row { list-style: none; }
    #sortable-row li { margin-bottom:4px; padding:10px; background-color:#e3e3e3;cursor:move;color: #212121;width: 100%;border-radius: 3px;border:#ccc 1px solid}
    #sortable-row li.ui-state-highlight { height: 2.5em; background-color:#F0F0F0;border:#ccc 2px dotted;}
</style>

<?php

if(isset($_POST["submit"])) {
    // echo "<script>alert('".$_POST["menu_slot"]."');</script>";
    $id_ary = explode(",",$_POST["menu_slot"]);
    for($i=0;$i<count($id_ary);$i++) {

        $execute_menu_main = Yii::$app->db->createCommand("UPDATE menu_sub SET submenu_sort ='" . $i . "' WHERE submenu_id =". $id_ary[$i])->execute();
    }

    echo "<script>window.location='index.php?r=menu-sub';</script>";
}
$result = Yii::$app->db->createCommand("SELECT * FROM menu_main WHERE m_status = 'Y' ORDER BY m_sort ASC")->queryAll();

?>

<div class="menu-sub-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?= Html::a(Yii::t('app', 'เพิ่มเมนูย่อย'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        </div>


                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

            // 'submenu_id',
                            'submenu_name:ntext',
            // 'submenu_role',
            // 'submenu_link:ntext',
            // 'submenu_active:ntext',
            // [
            //     'attribute'=>'submenu_role',
            //     'format'=>'raw',
            //     'value' => function($model, $key, $index)
            //     {
            //         if(!empty($model->submenu_role) && strlen($model->submenu_role)>2)
            //         {
            //             return getList($model->submenu_role,'ms_user_type_group','USER_TYPE_GROUP_CODE','USER_TYPE_GROUP_DESC');
            //         }
            //     },
            // ],
            // 'submenu_link:ntext',
                            [
                                'attribute'=>'submenu_active',
                                'format'=>'raw',
                                'value' => function($model, $key, $index)
                                {
                                    if($model->submenu_active=='Y')
                                    {
                                        return 'เปิดารใช้งานเมนู';
                                    }else{
                                        return 'ปิดารใช้งานเมนู';
                                    }
                                },
                            ],
            //'menu_id',

                            // ['class' => 'yii\grid\ActionColumn'],
                            ['class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->submenu_id,'menu_id'=>$model->menu_id], ['data' => ['confirm' => Yii::t('app', 'ต้องยกเลิกเมนูใช่หรือไม่?'),'method' => 'post','title'=>'ยกเลิกเมนู'],]);;
                                },
                            ]
                        ]
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>


                    <div class="row">

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
                                <?php
                                foreach ($result as $row){
                                    ?>
                                    <hr>
                                    <b><?php echo $row["m_name"]; ?></b>

                                    <ul id="sortable-row" class="sortable-all" style="padding: 0;">
                                        <?php $result_sub = Yii::$app->db->createCommand("SELECT * FROM menu_sub WHERE submenu_active = 'Y' AND menu_id = '".$row["id"]."' ORDER BY submenu_sort ASC")->queryAll(); 
                                        foreach ($result_sub as $row_sub){
                                            if(!empty($row_sub['submenu_role']) && strlen($row_sub['submenu_role'])>2)
                                            {
                                                $show_role = getList($row_sub['submenu_role'],'ms_user_type_group','USER_TYPE_GROUP_CODE','USER_TYPE_GROUP_DESC');
                                            }
                                            ?>
                                            <li class="sub" id=<?php echo $row_sub["submenu_id"]; ?>><?php echo $row_sub["submenu_name"]; ?>
                            <!-- <span style="color: #000 !important">
                                <?php echo $row_sub['submenu_role']; ?>
                            </span> -->
                        </li>
                        <?php
                    }

                    ?>
                </ul>
                <?php
            }

            ?>
            <input type="submit" class="btn btn-primary" name="submit" value="บันทึกการเรียงลำดับ" onClick="saveOrder();" style="margin: 0;"/>
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
        // document.getElementById("manage_sort").style.display = "none";
        (function($) {
            $(document).ready(function() {
                $( ".sortable-all" ).sortable({
                    placeholder: "ui-state-highlight"
                });
            });
        }) (jQuery);


        function saveOrder() {
            var selectedLanguage = new Array();
            $('ul.sortable-all li.sub').each(function() {
                selectedLanguage.push($(this).attr("id"));
            });
            document.getElementById("menu_slot").value = selectedLanguage;
        }
    </script>