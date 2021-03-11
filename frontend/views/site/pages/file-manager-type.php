<?php  
use app\models\Setting;
use app\models\FileUploadList;




$id = isset($_GET['form_id']) ?  $_GET['form_id'] : (isset($_POST['form_id']) ? $_POST['form_id'] : '');

if ($_SESSION['user_role']=='1') {
	$eform_template = "SELECT detail as dt FROM `eform_template` WHERE id = '$id'";
} else {
	$eform_template = "SELECT detail as dt FROM `eform_template` WHERE id = '$id' AND disable = '0' AND unit_id LIKE '%\"".$_SESSION['unit_id']."\"%'";
}


$eft = Yii::$app->db->createCommand($eform_template)->queryOne();



$this->title = 'จัดการไฟล์ แฟ้มข้อมูล'.$eft['dt'];


//$this->params['breadcrumbs'][] = ['label' => 'ระบบจัดการไฟล์', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'ระบบจัดการไฟล์ '.$model->detail, 'url' => ['site/pages','view'=>'view=file-manager-type', 'form_id' => $id]];
$this->params['breadcrumbs'][] = ['label' => 'ระบบจัดการไฟล์ '.$model->detail, 'url' => ['site/pages','view'=>'file-manager-all', 'form_id' => $id]];
$this->params['breadcrumbs'][] = $this->title;


$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

?>
<link rel="stylesheet" href="../../html-version/assets/css/style_file_manager.css"/>
<!-- End  -->                
<div class="section-body mt-3">
	<div class="container-fluid">
		<div class="row clearfix">

			<div class="col-lg-12">
				<h4><dt><?=$this->title;?></dt></h4>
				<div class="row clearfix">
					<div class="col-lg-3 col-md-6">
						<div class="card">
							<div class="card-status card-status-left bg-blue"></div>
							<div class="card-body">
								<div class="widgets2">
									<div class="state">
										<h6><dt>ไฟล์ทั้งหมด</dt></h6>
										<h3><span class="couterfileall">
										</span></h3>
									</div>
									<div class="icon">
										<i class="fe fe-file"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card">
							<div class="card-status card-status-left bg-green"></div>
							<div class="card-body">
								<div class="widgets2">
									<div class="state">
										<h6><dt>ไฟล์ที่นำเข้า Database</dt></h6>
										<h3><span class="couterfilestatus1">
										</span></h3>
									</div>
									<div class="icon">
										<i class="fe fe-upload"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card">
							<div class="card-status card-status-left bg-red"></div>
							<div class="card-body">
								<div class="widgets2">
									<div class="state">
										<h6><dt>ไฟล์ที่ประมวลผลแล้ว</dt></h6>
										<h3><span class="couterfilestatus0">
										</span></h3>
									</div>
									<div class="icon">
										<i class="fe fe-check"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="card">
							<div class="card-status card-status-left bg-purple"></div>
							<div class="card-body">
								<div class="widgets2">
									<div class="state">
                                        <h6><dt>ไฟล์ที่ประมวลผลไม่ได้</dt></h6>
                                        <h3><span class="couterfilestatus2">
                                        </span></h3>
                                    </div>
                                    <div class="icon">
                                      <i class="fe fe-x"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <?php if ($_SESSION['user_role']!='1'): ?>


                      <div class="col-md-12">
                         <div class="card">
                            <div class="card-status bg-teal"></div>
                            <div class="card-header">
                               <h3 class="card-title">Upload ไฟล์ที่ไม่เกี่ยวข้องกับข้อมูลชุดใดๆ</h3>

                           </div>

                           <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>ลากไฟล์มาวาง/ Click เพื่อเลือกไฟล์อัพโหลด</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" name="multiple_files" id="multiple_files" multiple="multiple" required="required"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">ลากไฟล์มาวาง/ Click เพื่อเลือกไฟล์อัพโหลด</p></div></div></div></div>
                       </div>

                       <div class="show-status text-center">

                       </div>
                   </div>
               <?php endif ?>
           </div>

           <div class="row"> 
                <!--         <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Accessed Files</h3>
                        <div class="card-options">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#uploadModal" data-dismiss="modal"><i class="fa fa-plus" data-toggle="tooltip" data-placement="right" title="Upload New"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="file_folder">
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-folder text-success"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Family</p>
                                    <small>3 File, 1.2GB</small>
                                </div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-file-word-o text-primary"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Report2017.doc</p>
                                    <small>Size: 68KB</small>
                                </div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Report2017.pdf</p>
                                    <small>Size: 68KB</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div> -->
            
        </div>

        <div class="row">
        	<div class="col-md-12">
        		<div class="card">
        			<div class="card-header">
        				<h3 class="card-title">
        					รายการไฟล์ในแฟ้มข้อมูล<?=$eft['dt'];?>
        				</h3>
        			</div>
        			<div class="card-body">
        				<div class="row">
        					<label for="myInputTextField" class="col-sm-1 col-form-label">ค้นหา :</label>
        					<div class="col-sm-11">
        						<input type="text" class="form-control" id="myInputTextField" placeholder="กรอกคำค้น">
        					</div>
        				</div>
        				<hr>

        				<div class="table-responsive">
        					<table id="example" class="table table-hover js-basic-example dataTable table_custom border-style spacing5">
        					</table>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>



                    <!-- <div class="card bg-none b-none">
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-vcenter table_custom text-nowrap spacing5 text-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>โฟลเดอร์</th>
                                            <th>Share With</th>
                                            <th></th>
                                            <th>Last Update</th>
                                            <th>จำนวนไฟล์</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menu">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="exampleModalLabel">Upload Files</h5>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">

    				<!-- Upload -->


    			</div>

    		</div>
    	</div>
    </div>


    <div class="modal " id="myModal">
    	<div class="modal-dialog modal-xl">
    		<div class="modal-content">

    			<!-- Modal Header -->
    			<div class="modal-header">
    				<h4 class="modal-title">แปลงข้อมูลจากไฟล์</h4>
    				<button type="button" class="close" data-dismiss="modal">&times;</button>
    			</div>

    			<!-- Modal body -->
    			<div class="modal-body" id="data_show">
    			</div>

    			<!-- Modal footer -->
    			<div class="modal-footer">
    				<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    				<!-- <button type="button" onClick="saveToDatabase(data.value)" class="btn btn-primary">Save to Database</button> -->
    				<script>
    					function saveToDatabase(data){
    						console.log(data);
    					}
    				</script>
    			</div>

    		</div>
    	</div>
    </div>


    <script type="text/javascript" src="../../datatable/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../../datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../datatable/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
    	function convertDate(date){
    		var date_auth =
    		date.getFullYear() + "" +
    		("00" + (date.getMonth() + 1)).slice(-2) + "" +
    		("00" + (date.getDate()+ 1)).slice(-2) + "" +
    		("00" + date.getHours()).slice(-2) + "" +
    		("00" + date.getMinutes()).slice(-2) + "" +
    		("00" + date.getSeconds()).slice(-2);

    		return date_auth;
    	}

    	var monthShortNames = ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];


    	function dateFormat(d) {
    		var t = new Date(d);
    		return t.getDate() + ' ' + monthShortNames[t.getMonth()] + ' ' +(t.getFullYear()+543)+' / '+t.getHours()+':'+t.getMinutes()+':'+t.getSeconds()+' น.';
    	}

    	(function($) {
    		$(document).ready(function() {

    			load_data();

    			load_data_table();

    			function load_data_table()
    			{
    				$.ajax({
    					url:"index.php?r=site/insert_file_upload_list_type&type=show&form_id=<?=$id;?>&unitid=<?=$_SESSION['unit_id'];?>",
    					method:"GET",
    					"dataType": "json",
    					success:function(data)
    					{
    						json_data(data);
                            // console.log(data);
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
    					destroy: true,
    					columns: [
    					{
    						title: "ลำดับ"
    					},
    					{
    						title: "ชื่อไฟล์"
    					},
    					{
    						title: "ประเภทไฟล์"
    					},
    					{
    						title: "ข้อความ"
    					},
    					{
    						title: "ผู้อัปโหลด"
    					},
    					{
    						title: "ประเภท"
    					},
    					{
    						title: ""
    					}
    					],
    					'columnDefs': [
    					{
    						"targets": [0],
    						"data" : "no",
    						"className": "text-center",
    					},
    					{
    						"targets": [1],
    						"data" : "origin_file_name",
                            "width" : "12%",
                        },
                        {
                          "targets": [2],
                          "data" : "bucket",
                      },
                      {
                          "targets": [3],
                          "data" : "text_extract",
                          "width" : "20%",
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
                       "className": "text-center",
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

    				$('#myInputTextField').keyup(function(){
    					datatable.search($(this).val()).draw() ;
    				})
    			}

    			var showlist = new Array();

    			function couterfile(gettype){
    				$.ajax({
    					url:"index.php?r=site/insert_file_upload_list_type&type="+gettype+'&form_id=<?=$id;?>&unitid=<?=$_SESSION['unit_id'];?>',
    					method:"GET",
    					dataType:"json",
    					contentType: "application/json; charset=utf-8",
    					success:function(data)
    					{

    						$("."+gettype).html(data.couterfile);
    					}
    				});
    			}

    			function load_data(){
    				$.ajax({
    					url:"<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/listbucket",
    					method:"GET",
    					dataType:"json",
    					crossDomain:true,
    					contentType: "application/json; charset=utf-8",
    					success:function(data)
    					{

    						couterfile('couterfileall');
    						couterfile('couterfilestatus1');
    						couterfile('couterfilestatus0');
    						couterfile('couterfilestatus2');
    						load_data_table();
    					}
    				});
    			}

    			function switchColor(val) {
    				var text = '';
    				switch(val) {
    					case 1:
    					text = "display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #79bb0e !important;padding: 3px 5px;border-radius: 4px;";
    					break;
    					case 2:
    					text = "display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #9aa0ac !important;padding: 3px 5px;border-radius: 4px;";
    					break;
    				}
    				return text;
    			}


    			$(document).on('click', '.extractText', function(){
    				var file_id = $(this).data("file_id");
    				var file_name = $(this).data("file_name");
    				var bucket = $(this).data("bucket");
    				var text_extract = $(this).data("text_extract");


    				var url = '<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/readfile?namefile='+file_name+'&bucket='+bucket;
    				$('#data_show').html('กำลังประมวลผล... <br> <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>');

    				$.ajax({
    					method: "GET",
    					url: url,
    				})
    				.done(function(msg) {
    					if(msg.text===null){
    						$('#data_show').html('Can not extract text from file !!!');
    						$.ajax({
    							method: "POST",
    							url: 'index.php?r=site/insert-extract-false',
    							data: { file_id : file_id ,  file_name: file_name, text: JSON.stringify(msg.text) },
    							success:function(data){
    								load_data();
    							}
    						})
    					}else{
    						<?php
    						$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;    
    						?>
    						load_data();
    						var res2 = msg.text.replace(/-/g, ' ');
    						var res3 = res2.replace(/,/g, ' ');
    						var res4 = res3.replace(/"/g, ' ');
    						var res5 = res4.replace(/\"/g, ' ');
    						var res = res5.replace(/[&!@,'"^$*+?()[{\|/#\":;]/g, ' ');
    						var settings = {
    							"async": true,
    							"crossDomain": true,
    							"url": "<?=$url_elasticsearch?>/_analyze",
    							"method": "POST",
    							"headers": {
    								"Authorization": "Basic " + btoa("elastic:changeme"),
    								"content-type": "application/json",
    							},
    							"processData": false,
    							"data": "{\r\n  \"tokenizer\": \"thai\",\r\n  \"text\": \""+res+"\"\r\n}"
    						}
    						$.ajax(settings).done(function (response) {
    							var showdata = [];
    							var data = response.tokens;
    							var len_r = data.length;
    							for (i = 0; i < len_r; i++) {
    								var b = (i%2 == 0)? 1 : 2;
    								showdata.push(`<span style="${switchColor(b)}">${data[i].token}</span>`
    									);
    							}


    							$('#data_show').html(''+showdata.join(""));
    						});


    						$.ajax({
    							method: "POST",
    							url: 'index.php?r=site/insert-extract',
    							data: { file_id : file_id ,  file_name: file_name, text: JSON.stringify(res) }
    						})
    						.done(function( msg ) {  

                            // console.log(msg);
                        })

    					}
    				});
    			});

    			$(document).on('click', '.openfile', function(){
    				var file_id = $(this).data("file_id");
    				var file_name = $(this).data("file_name");
    				var bucket = $(this).data("bucket");

    				$.ajax({
    					url:"<?=$url_node['setting_value'];?>/filepathminio?namefile="+file_name+"&bucket="+bucket,
    					method:"GET",
    					dataType:"json",
    					contentType: "application/json; charset=utf-8",
    					success:function(data)
    					{
    						window.open(data.url, "_blank");
    					}
    				});
    			});

    			$(document).on('click', '.deldata', function(){
    				var file_id = $(this).data("file-id");
    				var namefile = $(this).data("name-file");
    				var bucket = $(this).data("name-bucket");
    				console.log(namefile);
    				if(confirm("ต้องการลบไฟล์ใช่หรือไม่?"))
    				{
    					$.ajax({
    						url:"<?=$url_node['setting_value'];?>/removefileminio?namefile="+namefile+"&bucket="+bucket,
    						method:"GET",
    						dataType:"json",
    						contentType: "application/json; charset=utf-8",
    						success:function(data)
    						{
    							deleteDatabase(file_id);
    						}
    					});
    				}
    			});

    			function deleteDatabase(file_id){
    				$.ajax({
    					url:"index.php?r=site/insert_file_upload_list_type&type=delete&file_id="+file_id,
    					method:"GET",
    					success:function(data)
    					{
    						$('.show-status').html(`
    							<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ลบไฟล์สำเร็จ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>
    							`);
    						load_data();
    					}
    				});
    			}

    			var count = 0;
    			$('#multiple_files').change(function(){
    				upload();
    				$( ".close" ).trigger( "click" );
    				count = 0;
    			});

    			function upload() {
    				showlist = [];
    				var files = document.querySelector("#multiple_files").files;
    				var file_all = files.length;
    				var namebucket = '';
    				var nameold = '';
    				for (var i = 0; i < files.length; i++) {
    					var file = files[i];
    					var name = files[i].name;
    					nameold = name;
    					var ext = name.split('.').pop().toLowerCase();
    					if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) != -1) 
    					{
    						namebucket = 'image';
    					}else if(jQuery.inArray(ext, ['doc','docx','xls','xlsx','ppt','pptx']) != -1) {
    						namebucket = 'office';
    					}else if(jQuery.inArray(ext, ['pdf']) != -1) {
    						namebucket = 'pdf';
    					}else if(jQuery.inArray(ext, ['csv']) != -1) {
    						namebucket = 'csv';
    					}else{
    						namebucket = 'other';
    					}
    					var namefile = convertDate(new Date()) +'-' +Date.now()+ '.'+ext;

    					retrieveNewURL(file_all,namebucket,namefile, nameold, file, (file, url,namebucket,namefile,nameold) =>{

    						uploadFile(nameold,namebucket,namefile,file_all,file, url);
    						$('.show-status').html(`
    							<div class="alert alert-secondary alert-dismissible">
    							<div class="spinner-grow text-dark" style="width: 3rem; height: 3rem;" role="status">
    							<span class="sr-only">Loading...</span>
    							</div>
    							<h6 class="mt-3"><dt>กำลังอัพโหลดไฟล์ ${count}/${file_all}</dt></h6>
    							</div>
    							`);
    					});

    				}

    			}

    			function retrieveNewURL(file_all,namebucket,namefile,nameold, file, cb) {

    				fetch(`<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/uploadminio?name=${file.name}&bucket=${namebucket}&namefile=${namefile}`).then((response) => {
    					response.text().then((url) => {
    						cb(file, url,namebucket,namefile,nameold);
    					});
    				}).catch((e) => {
    					console.error(e);
    				});
    			}

    			function uploadFile(namefileold,namebucket,namefile,file_all,file, url) {
    				console.log(url);
    				fetch(url, {
    					method: 'PUT',
    					body: file,
    				}).then(() => {
    					count = count+1;
    					if (count==file_all) {
    						$('.show-status').html(`
    							<div class="alert alert-success alert-dismissible">
    							<button type="button" class="close" data-dismiss="alert"></button>
    							<i class="fas fa-check-circle fa-3x"></i>
    							<h6 class="mt-3"><dt>อัพโหลดไฟล์สำเร็จ</dt></h6>
    							</div>
    							`);
    						load_data();
    					}else{
    						$('.show-status').html(`
    							<div class="alert alert-secondary alert-dismissible">
    							<div class="spinner-grow text-dark" style="width: 3rem; height: 3rem;" role="status">
    							<span class="sr-only">Loading...</span>
    							</div>
    							<h6 class="mt-3"><dt>กำลังอัพโหลดไฟล์ ${count}/${file_all}</dt></h6>
    							</div>
    							`);
    					}
    					insertDatabase(namefile,namebucket,namefileold)
    				}).catch((e) => {
    					console.error(e);
    				});
    			}

    			function insertDatabase(namefile,namebucket,namefileold){
    				$.ajax({
    					url:"index.php?r=site/insert_file_upload_list_type&type=insert&namefile="+namefile+"&namebucket="+namebucket+"&namefileold="+namefileold+"&form_id=<?=$id;?>&unitid=<?=$_SESSION['unit_id'];?>&usercreate=<?=$_SESSION['user_id'];?>&status_upload=2",
    					method:"GET",
    					dataType:"json",
    					crossDomain:true,
    					contentType: "application/json; charset=utf-8",
    					success:function(data)
    					{

    					}
    				});
    			}

    			function showfile(namebucket){
    				var allsize = 0;
    				var last_update = '';
    				$.ajax({
    					url:"<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/objbucket?bucket="+namebucket,
    					method:"GET",
    					dataType:"json",
    					crossDomain:true,
    					contentType: "application/json; charset=utf-8",
    					success:function(data)
    					{
    						$.each(data, function(index) {
    							allsize += parseInt(data[index].size);
    							last_update = dateFormat(new Date(data[index].lastModified));
    						});
    						var kb = parseFloat(allsize/1024);
    						showlist.push(`<tr>
    							<td class="width45">
    							<i class="fa fa-folder"></i>
    							</td>
    							<td>
    							<span class="folder-name">
    							${namebucket}</span>
    							</td>
    							<td>
    							-
    							</td>
    							<td class="width100">
    							<span>Me</span>
    							</td>
    							<td class="width100">
    							<span>${last_update}</span>
    							</td>
    							<td class="width100 text-center">
    							<span class="size"> ${kb.toFixed(2)} KB </span>
    							</td>
    							</tr>`);
    						$("#menu").html(showlist.join(","));
    					}
    				});


    			}



    		});
}) (jQuery);
</script>

