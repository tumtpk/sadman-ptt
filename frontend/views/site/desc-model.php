<?php
header("Content-Type: application/json; charset=UTF-8");

  $desc_modal = Yii::$app->db->createCommand("SELECT * FROM `desc_modal` WHERE `id` = '".$_POST['id']."'")->queryone();
  $data = array();

  $data['topic'] = "'".$desc_modal['topic']."'";
  $data['description'] = "'".$desc_modal['description']."'";


  echo json_encode($data);
?>
