<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRole */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="user-role-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

  <?//= $form->field($model, 'allow_access_main')->textarea(['rows' => 6]) ?>

  <?//= $form->field($model, 'allow_access_sub')->textarea(['rows' => 6]) ?>

  <label class="control-label" for="holidaylist-emp_type">การให้สิทธิ์การเข้าถึงเมนูในระบบ</label>
  <?=$form->field($model, 'allow_access_main')->hiddenInput(['id' => 'result_main', 'value' => $model->allow_access_main])->label(false);?>
  <?= $form->field($model, 'allow_access_sub')->hiddenInput(['id' => 'result_sub', 'value' => $model->allow_access_sub])->label(false); 
    //hiddenInput
  ?>

  <div class="demo-section k-content">
    <input id="filterText" type="text" class="form-control" placeholder="ค้นหาเมนู" />
    <div id="treeview"></div>
  </div>

  <br>

  <div class="form-group">
    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success savesort']) ?>
      <?= Html::resetButton('ล้างค่า', ['class' => 'btn btn-light']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>


<!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
 -->
<link rel="stylesheet" href="../../kendo_treeview/kendo.default-v2.min.css" />

<script src="../../kendo_treeview/jquery.min.js"></script>
<script src="../../kendo_treeview/kendo.all.min.js"></script>




<script>
  (function($) {
    $(document).ready(function() {

    <?php if($model->isNewRecord):?>
      var url = 'index.php?r=site/manage_menu&key=sdsfgsfasa88765^8';
    <?php else: ?>
      var url = 'index.php?r=site/manage_menu&key=sdsfgsfasa88765^8&id=<?=$model->id;?>&type=1';
    <?php endif; ?>
    

    var json = (function () {
    var json = null;
    $.ajax({
      'async': false,
      'global': false,
      'url': url,
      'dataType': "json",
      'success': function (data) {
        json = data;
      }
    });
    return json;

  })();


      $("#treeview").kendoTreeView({
        checkboxes: {
          checkChildren: true
        },

        check: onCheck,
        expand: onExpand,
        dataSource: json,
      });




      function checkedNodeIds(nodes, checkedNodes,checkedNodes_main) {
        for (var i = 0; i < nodes.length; i++) {
          if (nodes[i].checked) {
            console.log(nodes[i].type);
            getParentIds(nodes[i],checkedNodes_main);
            if (nodes[i].id != null) {
              if (nodes[i].type=="sub") {
                checkedNodes.push('"'+nodes[i].id+'"');
              }else{
                checkedNodes_main.push('"'+nodes[i].id+'"');
              }
            }
          }

          if (nodes[i].hasChildren) {
            checkedNodeIds(nodes[i].children.view(), checkedNodes,checkedNodes_main);
          }
        }
      }

      function getParentIds(node,checkedNodes_main) {
        if (node.parent() && node.parent().parent() && checkedNodes_main.indexOf(node.parent().parent().id) == -1) {
          getParentIds(node.parent().parent(), checkedNodes_main);
          if (node.parent().parent().id != null) {
            checkedNodes_main.push('"'+node.parent().parent().id+'"');
          }
        }
      }

      function uniq(a) {
       return Array.from(new Set(a));
     }

        // show checked node IDs on datasource change
        function onCheck() {
          var checkedNodes = [],
          treeView = $("#treeview").data("kendoTreeView"),
          message_sub;

          var checkedNodes_main = [], $mainid,
          message_main;

          checkedNodeIds(treeView.dataSource.view(), checkedNodes,checkedNodes_main);

          $mainid = uniq(checkedNodes_main);

          if (checkedNodes.length > 0) {
            message_sub = checkedNodes.join(",");
            message_main = $mainid.join(",");
          } else {
            if ($mainid.length>0) {
              message_sub = "";
              message_main = $mainid.join(",");
            }else{
              message_sub = "";
              message_main = "";
            }
            
          }

          $("#result_main").val("["+message_main+"]");
          $("#result_sub").val("["+message_sub+"]");
        }

        function onExpand(e) {
          if ($("#filterText").val() == "") {
            $(e.node).find("li").show();
          }
        }
        $("#filterText").keyup(function (e) {
          var filterText = $(this).val();

          if (filterText !== "") {

            $("#treeview .k-group .k-group .k-in").closest("li").hide();
            $("#treeview .k-group").closest("li").hide();
            $("#treeview .k-in:contains(" + filterText + ")").each(function () {
              $(this).parents("ul, li").each(function () {
                var treeView = $("#treeview").data("kendoTreeView");
                treeView.expand($(this).parents("li"));
                $(this).show();
              });
            });
            $("#treeview .k-group .k-in:contains(" + filterText + ")").each(function () {
              $(this).parents("ul, li").each(function () {
                $(this).show();
              });
            });
          }
          else {
            $("#treeview .k-group").find("li").show();
            var nodes = $("#treeview > .k-group > li");

            $.each(nodes, function (i, val) {
              if (nodes[i].getAttribute("data-expanded") == null) {
                $(nodes[i]).find("li").hide();
              }
            });

          }
        });
      });
}) (jQuery);
</script>

<style>

.rootfolder { background-position: 0 0; }
.folder     { background-position: 0 -16px; }
.pdf        { background-position: 0 -32px; }
.html       { background-position: 0 -48px; }
.image      { background-position: 0 -64px; }
 .fa.k-sprite,
      .fa.k-sprite::before {
        font-size: 12px;
        line-height: 12px;
        vertical-align: middle;
      }
</style>
