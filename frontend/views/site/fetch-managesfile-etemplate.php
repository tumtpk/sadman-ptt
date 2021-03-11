<?php

$limit = '7';
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

if($_SESSION['user_role']!='1'){
  $sql = "SELECT id, detail, version FROM eform_template";
  $WHERE_ANOTHER_SEARCH = "AND unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
  $WHERE_ANOTHER = "WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
  $WHERE_ANOTHER = "WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%' AND disable = '0'";
  $WHERE_UNIT = "AND unit_id = '".$_SESSION['unit_id']."'";
  $GROUP = "GROUP BY id";
}else{
  $sql = "SELECT id, detail, version FROM `eform_template`";
  $WHERE_ANOTHER_SEARCH = "";
  $WHERE_ANOTHER = "";
  $GROUP = "";
  $WHERE_UNIT = "";
}

$query = $sql;

if($_POST['query'] != '')
{
  $query .= '
  WHERE detail LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" '.$WHERE_ANOTHER_SEARCH.'
  ';
}else{
  $query .= ' '.$WHERE_ANOTHER;
}

$query .= ' '.$GROUP.' ORDER BY detail ASC ';


$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

//echo $query;

$statement = Yii::$app->db->createCommand($query)->queryAll();
$total_data = count($statement);

$queryAll = Yii::$app->db->createCommand($filter_query)->queryAll();

$result = $queryAll;
$total_filter_data = count($queryAll);


$output = '
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead>
<tr>
<th>#</th>
<th>รายละเอียด</th>';

if($_SESSION['user_role']=='1'){
  $output .= '
  <th class="text-center">Version</th>';
}

$output .= '
  <th class="text-center">จำนวนไฟล์</th>';

$output .= '
  <th></th>';

$output .= '
</tr>
</thead>
<tbody>
';
if($total_data > 0)
{
  $nn = 1;
  foreach($result as $row)
  {
    $output .= '
    <tr>
    <th scope="row">'.$nn.'</th>
    <td>'.$row['detail'].'</td>';

    if($_SESSION['user_role']=='1'){
      $output .= '
      <td class="text-center">'.$row['version'].'</td>';
    }

    $countfile = Yii::$app->db->createCommand("SELECT COUNT(*) FROM file_upload_list WHERE form_id = '".$row['id']."' $WHERE_UNIT")->queryScalar();

    $output .= '<td class="text-center">'.number_format($countfile).'</td>';

    $output .= '
      <td><a class="btn btn-lg" onclick="window.open(\'index.php?r=site/pages&view=file-manager-type&form_id='.$row['id'].'\');" href="#"><span class="tag tag-info" style="cursor: pointer;display: inline-block;font-size: 13px;white-space: nowrap !important;"><i class="fa fa-file-text" aria-hidden="true"></i> อัพโหลดไฟล์</span></a></td>';

    $output .= '
    </tr>';
    $nn++;
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

</tbody>
</table>
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
