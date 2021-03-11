<?php

$limit = '8';
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
SELECT * FROM user_group
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" OR description LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
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

<div class="row">
';
if($total_data > 0)
{
  foreach($result as $row)
  {
    $countusers = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `users` WHERE user_group = '".$row['id']."'")->queryScalar();
    $allow_access_main = (!empty($row['allow_access_main']) && strlen($row['allow_access_main'])>2) ? getList($row['allow_access_main'],'menu_main','id','m_name') : '';
    $allow_access_sub = (!empty($row['allow_access_sub']) && strlen($row['allow_access_sub'])>2) ? getList($row['allow_access_sub'],'menu_sub','submenu_id','submenu_name') : '';
    $output .= '
    <div class="col-md-6">
    <div class="card">
    <div class="card-status bg-blue"></div>
    <div class="card-header">
    <h3 class="card-title"><b>'.$row['name'].' : '.$row['description'].'</b></h3>
    <div class="card-options">
    <span class="badge badge-secondary"><b>'.number_format($countusers).'</b></span> <span class="badge badge-light text-dark" style="background-color: #fff !important;">คน</span>
    </div>
    </div>
    <div class="card-body div-scrollbar2">
    <b>สิทธิ์การเข้าถึงเมนูหลัก :</b>
    <small class="text-muted">
    '.$allow_access_main.'
    </small><br>
    <label for="" class="mt-2"><dt>การให้สิทธิ์การเข้าถึงเมนูย่อย :</dt></label><br>
    <small class="text-muted">
    '.$allow_access_sub.'
    </small>
    </div>
    <div class="card-footer text-right" style="padding:5px;">
    <a class="icon" href="index.php?r=user-group%2Fview_usergroup&amp;id='.$row['id'].'&amp;name='.$row['name'].'" title="สิทธิ์การเข้าถึงเมนู"><i class="fe fe-eye mr-1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="รายละเอียด"></i></a>
    <a class="icon d-md-inline-block ml-3" href="index.php?r=user-group%2Fupdate_usergroup&amp;id='.$row['id'].'" title="สิทธิ์การเข้าถึงเมนู"><i class="fe fe-edit-3 mr-1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="แก้ไขข้อมูล"></i></a>
    <a class="icon d-md-inline-block ml-3" href="index.php?r=user-group%2Fdelete_usergroup&amp;id='.$row['id'].'" data-confirm="ต้องการยกเลิกกลุ่มผู้ใช้นี้ใช่หรือไม่?" data-method="post"><i class="fe fe-trash-2" style="color:#dc3545 !important;" data-toggle="tooltip" title="" data-original-title="fe fe-trash-2"></i></a>
    </div>
    </div>
    </div>
    ';
  }
}
else
{
  $output .= '
  <div class="card text-center p-2">
  ไม่พบข้อมูล
  </div>
  ';
}

$output .= '
</div>
<!--<label>จำนวนข้อมูลทั้งหมด : '.$total_data.'</label>-->
<br />
<div>
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
    <a class="click-page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class=""><a class="click-page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'"><</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="prev disabled">
      <a class="click-page-link" href="#"><</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id >= $total_links)
    {
      $next_link = '
      <li class="next disabled">
      <a class="click-page-link" href="#">></a>
      </li>
      ';
    }
    else
    {
      $next_link = '<li class="next"><a class="click-page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">></a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '...')
    {
      $page_link .= '
      <li class=" disabled">
      <a class="click-page-link" href="#">...</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class=""><a class="click-page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
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
