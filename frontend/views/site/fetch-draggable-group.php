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
SELECT * FROM user_group
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
<label style="margin-top:5px;">กลุ่มผู้ใช้งาน  '.$total_data.' กลุ่ม</label>
<div class="row">
';
if($total_data > 0)
{
	foreach($result as $row)
	{
		$output .= ' <div class="col-4">
        <div class="orangeArea groupMain content-group" data-new-depart="'.$row['name'].'" data-user-group="'.$row['id'].'"><b> กลุ่ม # '.$row['name'].'</b>
                <br>'.$row['description'].' <br> ผู้ใช้งาน : 
        </div>
        </div>
		';
	}
}
else
{
	$output .= 'No Data Found';
}

$output .= '
</div>
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
<script>
	$(".groupMain").kendoDropTarget({ group: "orangeGroup", drop : function( event, ui ){
		var drag = event.dropTarget.context.outerHTML;
		var part = drag.substring(
			drag.lastIndexOf('data-user-group="') + 17, 
			drag.lastIndexOf('" data-role="droptarget'));
		var part2 = drag.substring(
			drag.lastIndexOf('data-new-depart="') + 17, 
			drag.lastIndexOf('" data-user-group'));
		user_group = part;
		data_new_depart = part2;
		update_group(user_id,user_group,user_group_old,user_name,data_old_depart,data_new_depart);
		//console.log(part2);

	}
});
</script>