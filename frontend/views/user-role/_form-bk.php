<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */
/* @var $form yii\widgets\ActiveForm */

$allow_access_main = $model->allow_access_main;
$allow_access_main = str_replace('"', '', $allow_access_main);
$allow_access_main = str_replace('[', '', $allow_access_main);
$allow_access_main = str_replace(']', '', $allow_access_main);
$arraycheck_menumain = explode(",", $allow_access_main);


$allow_access_sub = $model->allow_access_sub;
$allow_access_sub = str_replace('"', '', $allow_access_sub);
$allow_access_sub = str_replace('[', '', $allow_access_sub);
$allow_access_sub = str_replace(']', '', $allow_access_sub);
$arraycheck_menusub = explode(",", $allow_access_sub);
?>

<style>
<?php if ($model->isNewRecord) {?>
    #old_data{
        display: none;
    }
<?php } else {?>
    #serialized{
        display: none;
    }
<?php }?>
?>

ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>

<div class="user-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'allow_access_main')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'allow_access_sub')->textarea(['rows' => 6]) ?>

    <label class="control-label" for="holidaylist-emp_type">การให้สิทธิ์การเข้าถึงเมนูในระบบ</label><hr>
    <?=$form->field($model, 'allow_access_main')->textInput(['id' => 'choose_choice', 'value' => $model->allow_access_main])->label(false);?>
    <?= $form->field($model, 'allow_access_sub')->textInput(['id' => 'choose_choice_sub', 'value' => $model->allow_access_sub])->label(false); ?>

    <input id="myInput" type="text" placeholder="คำค้น..." class="form-control"><br>

    <table>
        <tbody id="myTable">
            <tr>
                <td>
                    <input type="checkbox" onClick="toggle(this);" />  เลือกทั้งหมด
                </td>
            </tr>
            <?php
            $array_menu_main = Yii::$app->db->createCommand("SELECT * FROM `menu_main` WHERE m_status = 'Y' ORDER BY id,m_name ASC")->queryAll();
            foreach ($array_menu_main as $rows_main) {
                if (in_array($rows_main['id'], $arraycheck_menumain)) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                ?>

                <tr class="parent">
                    <td class="menu_main_check">
                        <input type="checkbox" value="<?php echo $rows_main['id']; ?>,<?php echo $rows_main['m_name']; ?>" id="checkAll" <?=$checked;?>>
                        <b style="text-decoration: underline;"><?php echo $rows_main['m_name']; ?></b>
                    </td>
                </tr>

                <?php
                $array_menu_sub = Yii::$app->db->createCommand("SELECT * FROM `menu_sub` WHERE submenu_active = 'Y' AND menu_id = '".$rows_main['id']."' ORDER BY menu_id,submenu_id ASC")->queryAll();
                foreach ($array_menu_sub as $rows_sub) {
                    if (in_array($rows_sub['submenu_id'], $arraycheck_menusub)) {
                        $checked_sub = "checked";
                    } else {
                        $checked_sub = "";
                    }
                    ?>

                    <tr class="child">
                        <td class="menu_sub_check">
                            <input type="checkbox" value="<?php echo $rows_sub['submenu_id']; ?>,<?php echo $rows_sub['submenu_name']; ?>" id="checkAll" <?=$checked_sub;?>> <?php echo $rows_sub['submenu_name']; ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>

                <?php
            }
            ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>



<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>

<!-- <script type="text/javascript" src="../../js/jquery-1.9.1.min.js"></script> -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

<script>

  function toggle(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

  jQuery(document).ready(function($){
    

    $('#myTable').change(function() {
        var values = [];
        var values_sub = [];
        var ex = [];
        {
            $('.menu_main_check :checked').each(function() {
                if ($(this).val()!='') {
                    var str = $(this).val().split(",");
                    values.push('"'+str[0]+'"');
                    ex.push(''+str[1]+'');
                }
            });
            console.log(values);
            document.getElementById('choose_choice').value = '['+values+']';
        }

        {
            $('.menu_sub_check :checked').each(function() {
                if ($(this).val()!='') {
                    var str = $(this).val().split(",");
                    values_sub.push('"'+str[0]+'"');
                }
            });
            document.getElementById('choose_choice_sub').value = '['+values_sub+']';
        }
    });

    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

  
  $('.child').on('change', ':checkbox', function() {
    if ($(this).is(':checked')) {
      var currentRow = $(this).closest('tr');
      var targetedRow = currentRow.prevAll('.parent').first();
      var targetedCheckbox = targetedRow.find(':checkbox');
      targetedCheckbox.prop('checked', true).trigger('change');
    }
  });



  });

</script>

