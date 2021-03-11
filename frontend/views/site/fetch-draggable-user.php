<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script> -->

  <?php
  $limit = '30';
  $page = 1;
  if($_POST['page'] > 1)
  {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
  }
  else
  {
    $start = 0;
  }

  $query = "
  SELECT * FROM users
  ";

  if($_POST['query'] != '')
  {
    $query .= '
    WHERE name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
    ';
  }

  $query .= 'ORDER BY name ASC ';


  $filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

  $statement = Yii::$app->db->createCommand($query)->queryAll();
  $total_data = count($statement);

  $queryAll = Yii::$app->db->createCommand($filter_query)->queryAll();

  $result = $queryAll;
  $total_filter_data = count($queryAll);


  $output = '
  <label style="margin-top:5px;">จำนวนข้อมูลทั้งหมด  '.$total_data.' รายการ</label> <div class="row">';
  if($total_data > 0)
  {
    foreach($result as $row)
    {
      $queryone = Yii::$app->db->createCommand("SELECT * FROM `user_group` WHERE id = '".$row['user_group']."'")->queryone();
      $output .= ' <div class="col-4">
      <div class="orange content-user" data-id="'.$row['id'].'" data-group-old="'.$row['user_group'].'" data-name-user="'.$row['name'].'" data-old-depart="'.$queryone['name'].'"><div class="box-group-draggable">'.$queryone['name'].'</div></b>'.$row['name'].'</div>
      </div>
      ';
    }
  }
  else
  {
    $output .= 'No Data Found';
  }

  $output .= '</div>
  <br />
  <div align="center">
  <ul class="pagination">
  ';

  $total_links = ceil($total_data/$limit);
  $previous_link = '';
  $next_link = '';
  $page_link = '';

//echo $total_links;

  if($total_links > 4)
  {
    if($page < 5)
    {
      for($count = 1; $count <= 5; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
    else
    {
      $end_limit = $total_links - 4;
      if($page > $end_limit)
      {
        $page_array[] = 1;
        $page_array[] = '...';
        for($count = $end_limit; $count <= $total_links; $count++)
        {
          $page_array[] = $count;
        }
      }
      else
      {
        $page_array[] = 1;
        $page_array[] = '...';
        for($count = $page - 1; $count <= $page + 1; $count++)
        {
          $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
      }
    }
  }
  else
  {
    for($count = 1; $count <= $total_links; $count++)
    {
      $page_array[] = $count;
    }
  }

  for($count = 0; $count < count($page_array); $count++)
  {
    if($page == $page_array[$count])
    {
      $page_link .= '
      <li class=" active">
      <a class="click-page-link-user" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
      </li>
      ';

      $previous_id = $page_array[$count] - 1;
      if($previous_id > 0)
      {
        $previous_link = '<li class=""><a class="click-page-link-user" href="javascript:void(0)" data-page_number="'.$previous_id.'"><</a></li>';
      }
      else
      {
        $previous_link = '
        <li class="prev disabled">
        <a class="click-page-link-user" href="#"><</a>
        </li>
        ';
      }
      $next_id = $page_array[$count] + 1;
      if($next_id >= $total_links)
      {
        $next_link = '
        <li class="next disabled">
        <a class="click-page-link-user" href="#">></a>
        </li>
        ';
      }
      else
      {
        $next_link = '<li class="next"><a class="click-page-link-user" href="javascript:void(0)" data-page_number="'.$next_id.'">></a></li>';
      }
    }
    else
    {
      if($page_array[$count] == '...')
      {
        $page_link .= '
        <li class=" disabled">
        <a class="click-page-link-user" href="#">...</a>
        </li>
        ';
      }
      else
      {
        $page_link .= '
        <li class=""><a class="click-page-link-user" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
        ';
      }
    }
  }

  $output .= $previous_link . $page_link . $next_link;
  $output .= '
  </ul>

  </div>
  ';

  echo $output;

  ?>


<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<button onClick="$('#exampleModal').modal('show')">Click</button>-->


<div class="modal fade show" id="modal-true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="z-index: inherit;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">จัดการกลุ่มผู้ใช้งาน</h5>
        <button type="button" id="close-modal" class="close close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <input type="hidden" id="user-id">
        <input type="hidden" id="newgroup">
        <input type="hidden" id="oldgroup">
        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">ปิด</button>
        <button id="submit-update" type="button" class="btn btn-primary submit-modal">ใช่</button>
      </div>
    </div>
  </div>
  <div class="modal-backdrop show"></div>
</div> 

<script>
  var user_id = '';
  var user_group = '';
  var user_group_old = '';
  var user_name = '';
  var data_old_depart = '';
  var data_new_depart = '';
  $(".orange").kendoDraggable({
    group: "orangeGroup",
    hint: function(element) {
      user_id = $(element).attr("data-id");
      user_group_old = $(element).attr("data-group-old");
      user_name = $(element).attr("data-name-user");
      data_old_depart = $(element).attr("data-old-depart");
      return element.clone();
    }
  });

  function onDrop(e) {
    e.draggable.destroy();
    e.draggable.element.remove();
  }

  $(document).on('click', '.close-modal', function(){
    $("#modal-true").css("display", "none");
    $("#modal-false").css("display", "none");
  });

  $(document).on('click', '.submit-modal', function(){
   var user_id = $("#user-id").val();
   var newgroup = $("#newgroup").val();
   var oldgroup = $("#oldgroup").val();

   
   $.ajax({
    method: "POST",
    url: 'index.php?r=site/update-draggable',
    dataType:"json",
    data: { user_id : user_id , newgroup : newgroup, oldgroup : oldgroup},
    success:function(data){
      if(data.status == 1){
        $("#modal-true").css("display", "none");
        console.log("success!!");
        $("#message").html("<div class='message-success-update'>บันทึกข้อมูลสำเร็จ</div>");
        setTimeout(function(){
          $("#message").html("");
          location.reload();
        },3000);
      }else{
        $("#modal-true").css("display", "none");
        $("#message").html("<div class='message-false-update'>ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง</div>");
        setTimeout(function(){
          $("#message").html("");
        },3000);
      }
    }
  });
   

 });

  function update_group(user_id,newgroup,oldgroup,name_user,data_old_depart,data_new_depart){
    console.log('id = '+user_id+' new = '+newgroup+' = old = '+oldgroup+' name = '+name_user);
    $("#modal-true").css("display", "block");
    $("#user-id").val(user_id);
    $("#newgroup").val(newgroup);
    $("#oldgroup").val(oldgroup);
    $(".close-modal").css("color", "#FFFFFF");


    if (newgroup != oldgroup) {
      $(".modal-body").html(`ต้องการย้าย ${name_user} จากกลุ่ม ${data_old_depart} ไปกลุ่ม ${data_new_depart} ใช่หรือไม่?`);
      $("#submit-update").css("display", "block");
      $(".modal-header").css({"background-color": "#28AE60","color" : "#FFFFFF"});
    }else{
      //$(".modal-body").html(`ไม่สามารถย้าย ${name_user} จากกลุ่ม ${data_old_depart} ไปกลุ่ม ${data_new_depart} ได้ <br>เนื่องจากอยู่ในกลุ่มดังกล่าวแล้ว!`);
      $(".modal-body").html(`ผู้ใช้งาน ${name_user} อยู่ในกลุ่ม ${data_old_depart}  แล้ว!`);
      $("#submit-update").css("display", "none");
      $(".modal-header").css({"background-color": "#BE3B2B","color" : "#FFFFFF"});
    }

  }

</script>