<?php
use yii\helpers\Html;
use app\models\Unit;
use app\models\UserGroup;
use app\models\UserRole;
use app\models\Users;

if ($_SESSION['user_role']!='2') {
    echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
}

$this->title = 'สถิติข้อมูลการเข้าใช้งานระบบ';
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");


$group = UserGroup::find()->where("id = '".$_SESSION['user_group']."'")->one();
$unit = Unit::find()->where("unit_id = '".$_SESSION['unit_id']."'")->one();
// Count
$Users_inUnit = Users::find()->where("unit_id = '".$_SESSION['unit_id']."'")->count();
$Admin_inUnit = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `users` WHERE unit_id = '".$_SESSION['unit_id']."' AND role = '2'")->queryone();
$User_inUnit = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `users` WHERE unit_id = '".$_SESSION['unit_id']."' AND role = '3'")->queryone();

$log_all = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."'")->queryone();
$log_month = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND MONTH(create_date) = MONTH(CURRENT_DATE())")->queryone();
$log_day = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND DATE(create_date) = DATE(CURRENT_DATE())")->queryone();
$log_day_user = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND DATE(create_date) = DATE(CURRENT_DATE()) AND users.role = '3'")->queryone();
$log_day_admin = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND DATE(create_date) = DATE(CURRENT_DATE()) AND users.role = '2'")->queryone();

// count time
$day_now = date('Y-m-d');
$time_one = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND `log_date` BETWEEN '".$day_now." 08:00:00.000000' AND '".$day_now." 10:00:00.000000'")->queryone();
$time_two = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND `log_date` BETWEEN '".$day_now." 10:00:00.000000' AND '".$day_now." 12:00:00.000000'")->queryone();
$time_three = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND `log_date` BETWEEN '".$day_now." 13:00:00.000000' AND '".$day_now." 14:00:00.000000'")->queryone();
$time_four = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND `log_date` BETWEEN '".$day_now." 14:00:00.000000' AND '".$day_now." 15:00:00.000000'")->queryone();
$time_five = Yii::$app->db->createCommand("SELECT COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND `log_date` BETWEEN '".$day_now." 15:00:00.000000' AND '".$day_now." 16:00:00.000000'")->queryone();

$per1 = (int)(($time_one['count']/$log_day['count'])*100);
$per2 = (int)(($time_two['count']/$log_day['count'])*100);
$per3 = (int)(($time_three['count']/$log_day['count'])*100);
$per4 = (int)(($time_four['count']/$log_day['count'])*100);
$per5 = (int)(($time_five['count']/$log_day['count'])*100);
?>
<link rel="stylesheet" href="../../html-version/assets/css/style_stat_users_department.css"/>
<div class="row">
	<div class="col-md-6">
		<h5>สถิติข้อมูลผู้ใช้งานภายในหน่วยงาน <?=$unit['unit_name'];?></h5>
	</div>
	<div class="col-md-6">
		<h5>สถิติข้อมูลการเข้าใช้งานภายในหน่วยงาน <?=$unit['unit_name'];?></h5>
	</div>
</div>
<div class="row clearfix">
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box green"><i class="icon-users"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$Users_inUnit;?></h4>
					<span>ผู้ใช้งานในหน่วยงาน</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box azure"><i class="icon-user-following"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$Admin_inUnit['count'];?></h4>
					<span>ผู้ดูแลหน่วย</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box cyan"><i class="icon-user"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$User_inUnit['count'];?></h4>
					<span>ผู้ใช้งานทั่วไป</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box orange"><i class="icon-layers"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$log_all['count'];?></h4>
					<span>การเข้าใช้งาน(ทั้งหมด)</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box orange"><i class="icon-bar-chart"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$log_month['count'];?></h4>
					<span>การเข้าใช้งาน(เดือนนี้)</span>
				</a>
			</div>
		</div>
	</div>
	<div class="col-6 col-md-4 col-xl-2">
		<div class="card">
			<div class="card-body ribbon">
				<div class="ribbon-box orange"><i class="icon-calendar"></i></div>
				<a href="#" class="my_sort_cut text-muted">
					<h4><?=$log_day['count'];?></h4>
					<span>การเข้าใช้งาน(วันนี้)</span>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="row clearfix row-deck">
	<div class="col-xl-4 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">สถิติข้อมูลการเข้าใช้งานระบบในวันนี้(ครั้ง)</h3>
			</div>
			<div class="card-body card-body-edit">
				<div class="row text-center">
					<div class="col-sm-4 border-right pb-4 pt-4">
						<label class="mb-0">ผู้ใช้งานทั้งหมด</label>
						<h4 class="font-30 font-weight-bold text-col-blue counter">
							<?=$log_day['count'];?>
						</h4>
					</div>
					<div class="col-sm-4 border-right pb-4 pt-4">
						<label class="mb-0">ผู้ดูแลระบบ</label>
						<h4 class="font-30 font-weight-bold text-col-blue counter">
							<?=$log_day_admin['count'];?>
						</h4>
					</div>
					<div class="col-sm-4 pb-4 pt-4">
						<label class="mb-0">ผู้ใช้งานทั่วไป</label>
						<h4 class="font-30 font-weight-bold text-col-blue counter">
							<?=$log_day_user['count'];?>
						</h4>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-vcenter mb-0">
					<tbody>
						<tr>
							<td>
								<div class="clearfix">
									<div class="float-left"><strong><?=$per1;?>%</strong></div>
									<div class="float-right"><small class="text-muted">8.00 - 10.00 น.</small></div>
								</div>
								<div class="progress progress-xs">
									<div class="progress-bar bg-azure" role="progressbar" style="width: <?=$per1;?>%" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="clearfix">
									<div class="float-left"><strong><?=$per2;?>%</strong></div>
									<div class="float-right"><small class="text-muted">10.00 - 12.00 น.</small></div>
								</div>
								<div class="progress progress-xs">
									<div class="progress-bar bg-green" role="progressbar" style="width: <?=$per2;?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="clearfix">
									<div class="float-left"><strong><?=$per3;?>%</strong></div>
									<div class="float-right"><small class="text-muted">13.00 - 14.00 น.</small></div>
								</div>
								<div class="progress progress-xs">
									<div class="progress-bar bg-orange" role="progressbar" style="width: <?=$per3;?>%" aria-valuenow="36" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="clearfix">
									<div class="float-left"><strong><?=$per4;?>%</strong></div>
									<div class="float-right"><small class="text-muted">14.00 - 15.00 น.</small></div>
								</div>
								<div class="progress progress-xs">
									<div class="progress-bar bg-indigo" role="progressbar" style="width: <?=$per4;?>%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="clearfix">
									<div class="float-left"><strong><?=$per5;?>%</strong></div>
									<div class="float-right"><small class="text-muted">15.00 - 16.00 น.</small></div>
								</div>
								<div class="progress progress-xs">
									<div class="progress-bar bg-pink" role="progressbar" style="width: <?=$per5;?>%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xl-8 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">สถิติข้อมูลการเข้าใช้งานระบบในเดือนนี้</h3>
			</div>
			<div class="card-body card-body-edit">
				<div id="chart-combination" style="height: 105px;"></div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-12 col-xl-12 col-md-12">
						<h5 class="tag tag-blue">4 อันดับการเข้าใช้งานสุดสูง</h5>
					</div>
				</div>
				<div class="row">
					<?php
					$top_four = Yii::$app->db->createCommand("SELECT user_log_usaged.username,user_log_usaged.user,COUNT(*) AS count FROM `user_log_usaged`,`users` WHERE user_log_usaged.username = users.id AND users.unit_id = '".$_SESSION['unit_id']."' AND MONTH(create_date) = MONTH(CURRENT_DATE()) GROUP BY username ORDER BY Count DESC LIMIT 4")->queryAll();
					$t=1;
					foreach ($top_four as $tf) {
						$per = (int)(($tf['count']/$log_month['count'])*100);
						?>
						<div class="col-6 col-xl-3 col-md-6">
							<div class="clearfix">
								<div class="float-left"><strong><?=$per;?>%</strong></div>
								<div class="float-right"><small class="text-muted"><?=$tf['count'];?> ครั้ง</small></div>
							</div>
							<div class="progress progress-xs">
								<div class="progress-bar bg-gray" role="progressbar" style="width: <?=$per;?>%" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<span class="text-uppercase font-10"><?=$tf['user'];?></span>
						</div>
						<?php $t++; } ?>

					</div>
				</div>
			</div>
		</div>
	</div>   
	<div class="row clearfix">
		<div class="col-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">สถิติข้อมูลการเข้าใช้งานระบบของหน่วยงาน<?=$unit['unit_name'];?></h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-hover js-basic-example dataTable table_custom border-style spacing5">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="../../datatable/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../../datatable/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../../datatable/dataTables.bootstrap4.min.js"></script>
	<script>
		$(function() {
			var url = "index.php?r=site/json_stat_department&auth=<?=$auth?>";

			var json = null;
			var json = $.ajax({
				url: url,
				global: false,
				dataType: "json",
				async:false,
				success: function(msg){
					return msg;
				}
			}
			).responseJSON;

			var datadate = [];
			$.each(json, function(index) {
				datadate.push(json[index].log_date);    
			});

			var datacount = [];
			$.each(json, function(index) {
				datacount.push(json[index].count);    
			});
			console.log(datadate);
			console.log(datacount);

			$(document).ready(function() {

				var options = {
					colors: ['#fed284'],
					series: [{
						name: "จำนวน(ครั้ง)",
						data: datacount
					}],
					chart: {
						height: 260,
						type: 'line',
						zoom: {
							enabled: false
						}
					},
					dataLabels: {
						enabled: false
					},
					stroke: {
						curve: 'straight'
					},
					grid: {
						row: {
							colors: ['#f3f3f3', 'transparent'], 
							opacity: 0.5
						},
					},
					xaxis: {
						categories: datadate,
					}
				};

				var chart = new ApexCharts(document.querySelector("#chart-combination"), options);
				chart.render();

			});

		});
	</script>
	<script type="text/javascript">
		(function($) {
			$(document).ready(function() {
				load_data();

				function load_data()
				{
					$.ajax({
						url:"index.php?r=site/json_log_unit&auth=<?=$auth?>",
						method:"GET",
						"dataType": "json",
						success:function(data)
						{
							json_data(data);
							console.log(data);
						}
					});
				}

				function json_data(data)
				{
					var dataSet = data;
					datatable = $('#example').DataTable({
						"language": {
							"lengthMenu": "แสดง &nbsp; _MENU_ &nbsp; จำนวน",
							"zeroRecords": "ไม่พบข้อมูล",
							"info": "แสดงข้อมูลจาก _START_ ถึง _END_ จำนวน _TOTAL_ รายการ",
							"infoEmpty": "ไม่มีรายการ",
							"search": "ค้นหา : &nbsp;",
							"searchPlaceholder": "กรอกคำค้น",
							"infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
							"paginate": {
								"first":      "หน้าแรก",
								"last":       "หน้าสุดท้าย",
								"next":       "ถัดไป",
								"previous":   "ก่อนหน้า"
							},
						},

						"pageLength": 10,
						"lengthMenu": [ [15, 50, 80, 100, -1], [15, 50, 80, 100, "ทั้งหมด"] ],
						data: dataSet,
						columns: [
						{
							title: "ลำดับ"
						},
						{
							title: "ชื่อ-นามสกุล"
						},
						{
							title: "หน่วยงาน"
						},
						{
							title: "วันเวลาเข้าสู่ระบบ"
						},
						{
							title: "IP ADDRESS"
						}
						],
						'columnDefs': [
						{
							"targets": [0],
							"data" : "no",
						},
						{
							"targets": [1],
							"data" : "name",
						},
						{
							"targets": [2],
							"data" : "unit",
						},
						{
							"targets": [3],
							"data" : "log_date",
						},
						{
							"targets": [4],
							"data" : "ipaddress",
						}
						],
						dom: 'Bfrtip',
						select: true,
						buttons: [{
							text: 'Select all',
							action: function () {
								table.rows().select();
							}
						},
						{
							text: 'Select none',
							action: function () {
								table.rows().deselect();
							}
						}
						],
					});
				}
			});
		}) (jQuery);
	</script>