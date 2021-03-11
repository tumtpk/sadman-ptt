<?php
use app\models\Setting;
$this->title = 'Send Push Notification';
$this->params['breadcrumbs'][] = $this->title;

$url_node =  $Setting = Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value;
?>
<style>
	#alertSuccess{
		display: none;

	}
	.panel-success{
		background-color: #188E49;
		color: #ffffff;
		padding: 10px;
		margin-bottom: 10px;
		border-radius: 5px;
		font-weight: 900;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<!-- <div class="card-header">
				<h5>ฟอร์มส่งข้อความแจ้งเตือน (Push Notification)</h5>
			</div> -->
            <div class="card-header bg-secondary text-white bline">
				<h3 class="card-title">ฟอร์มส่งข้อความแจ้งเตือน (Push Notification)</h3>
				<div class="card-options">
				</div>
			</div>  
			<div class="card-body">
				<div id="alertSuccess">
					<div class="panel panel-success">
						<div class="panel-heading">ส่งข้อความแจ้งเตือนสำเร็จ!!</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label class="form-label">หัวข้อ</label>
							<input type="text" class="form-control" id="title" placeholder="หัวข้อ">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">รายละเอียด</label>
							<textarea rows="5" class="form-control" id="detail" placeholder="กรอกรายละเอียด" ></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-5">
						<label class="form-label">หน่วยที่ต้องการส่งถึง (Segments)</label>
						<select class="custom-select" id="segment">
							<option value="STATUS_CODE" selected="">ทั้งหมด</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-5 mt-3">
						<button type="submit" id="send-push" class="btn btn-primary">ส่ง</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#send-push").click(function() {
		var title = $("#title").val();
		var detail = $("#detail").val();
		var segment = $("#segment").val();

		var settings = {
			"async": true,
			"crossDomain": true,
			"url": "<?=$url_node?>/send_notification",
			"method": "POST",
			"headers": {
				"content-type": "application/json",
			},
			"processData": false,
			"data": "{\"title\":\""+title+"\",\"detail\":\""+detail+"\"}"
		}

		$.ajax(
		{
			async: true,
			crossDomain: true,
			url: "<?=$url_node?>/send_notification",
			method: "POST",
			headers: {
				"content-type": "application/json",
			},
			processData: false,
			data: "{\"title\":\""+title+"\",\"detail\":\""+detail+"\"}",
			success: function(data) {
				$('#alertSuccess').css('display','block');
				setTimeout(function(){
					//$('#alertSuccess').css('display','none');
					location.reload();
				},3000);

			}
		}
		);
		
	});
</script>



