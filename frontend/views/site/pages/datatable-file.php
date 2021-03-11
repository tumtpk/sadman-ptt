<?php
use yii\helpers\Html;

$this->title = 'DATA TABLE';
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");

?>
<style>
	.box-right{
		float: right;
	}
	.card-footer{
		padding: 10px !important;
	}
	.card-body-edit{
		padding: 10px !important;
	}
	.pagination li {
		margin-left: 3px;
		color: black;
		float: left;
		padding: 0px !important;
		text-decoration: none;
		transition: background-color .3s;
		background-color: #FFFFFF !important;
		border-radius: 3px;
	}
	.pagination li.active {
		background-color: #FFFFFF !important;
	}
</style>
<div class="row clearfix">
	<div class="col-12 col-sm-12"><div class="card">
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
<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			load_data();

			function load_data()
			{
				$.ajax({
					url:"index.php?r=site/insert_file_upload_list_type&type=show&form_id=4&unitid=316%20Request%20Method:%20GET",
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
						title: "รายการ"
					},
					{
						title: "ประเภทไฟล์"
					},
					{
						title: "ชื่อไฟล์"
					},
					{
						title: "ผู้อัปโหลด"
					},
					{
						title: "จัดการ"
					}
					],
					'columnDefs': [
					{
						"targets": [0],
						"data" : "no",
					},
					{
						"targets": [1],
						"data" : "file_name",
					},
					{
						"targets": [2],
						"data" : "bucket",
					},
					{
						"targets": [3],
						"data" : "origin_file_name",
					},
					{
						"targets": [4],
						"data" : "user_create",
					},
					{
						"targets": [5],
						"data" : "status_upload",
					},
					{
						"targets": [6],
						"data" : "button",
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