<?php
use app\models\Setting;
use app\models\FileUploadList;
use app\models\EformTemplate;
$this->title = 'จัดการไฟล์';
$this->params['breadcrumbs'][] = $this->title;

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();
?>
<style>
.dataTables_paginate > ul.pagination > li{
    padding: 0px !important;
}
.dataTables_wrapper .dataTables_filter{
    display: none !important;
}
.show_card > a{
    color: #292b30 !important;
}
</style>

<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                            <h4 class="mb-1"><span class="couterfileall"><?php //echo $query_count['sum'];?></span></h4>
                            <div>ไฟล์ทั้งหมด</div>
                            <div class="mt-4">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>    
            </div> 
            <!-- end div -->
            <!-- start div -->
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-value float-right text-azure-new"><i class="fa fa-database"></i></div>
                            <h4 class="mb-1"><span class="couterfilestatus1"><?php //echo $query_count['sum'];?></span></h4>
                            <div>นำเข้า Database</div>
                            <div class="mt-4">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>    
            </div> 
            <!-- end div -->
            <!-- start div -->
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-value float-right text-azure-new"><i class="fa fa-check-circle"></i></div>
                            <h4 class="mb-1"><span class="couterfilestatus0"><?php //echo $query_count['sum'];?></span></h4>
                            <div>ไฟล์ที่ประมวลผลแล้ว</div>
                            <div class="mt-4">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-azure-new" style="width: 23%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>    
            </div> 
            <!-- end div -->
            <!-- start div -->
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-value float-right text-azure-new"><i class="fa fa-times-circle"></i></div>
                            <h4 class="mb-1"><span class="couterfilestatus2"><?php //echo $query_count['sum'];?></span></h4>
                            <div>จำนวนไฟล์ที่ประมวลผลไม่ได้</div>
                            <div class="mt-4">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-azure-new" style="width: 23%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>    
            </div> 

            <div class="col-md-12">
                <a  class="btn btn-lg btn-primary click_checkfiletypeall" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    อัพโหลดไฟล์
                </a>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                    <div class="alert alert-primary">
                        * เลือกแบบฟอร์ม/แฟ้มข้อมูลที่ต้องการอัพโหลดไฟล์
                    </div>
                        <div class="row clearfix show_checkfiletypeall">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            รายการไฟล์ข้อมูลทั้งหมด
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <font size="4"><strong>รายการไฟล์ข้อมูลรอตรวจสอบ</strong></font>
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

            <div class="card bg-none b-none col-md-6">

                <b>จัดการไฟล์จำแนกตามแฟ้มข้อมูล</b>
                <hr>
                <input type="text" name="search_box" id="search_box" class="form-control" placeholder="ค้นหา (EFORM TEMPLATES รายละเอียด)" />

                <div id="dynamic_content">

                </div>

            </div>


            <div class="card bg-none b-none col-md-6">
                <b>จำแนกไฟล์ตามประเภทข้อมูล</b>
                <hr>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter table_custom text-nowrap spacing5 text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>โฟลเดอร์</th>
                                    <th>Last Update</th>
                                    <th>จำนวนไฟล์</th>
                                </tr>
                            </thead>
                            <tbody id="menu">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="show-status text-center col-md-12">
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

</div>

</div>
</div>
</div>


<script type="text/javascript" src="../../datatable/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../../datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../datatable/dataTables.bootstrap4.min.js"></script>

<script>
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

$(document).ready(function(){

load_data();
var showlist = new Array();

function couterfile(gettype){
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type="+gettype,
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
$.each(data, function(index) {
if(jQuery.inArray(data[index].name, ['textx','webboardtext']) == -1)
{
    showfile(data[index].name);
}
});
couterfile('couterfileall');
couterfile('couterfilestatus1');
couterfile('couterfilestatus0');
couterfile('couterfilestatus2');
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
url:"index.php?r=site/insert_file_upload_list&type=insert&namefile="+namefile+"&namebucket="+namebucket+"&namefileold="+namefileold,
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
<td class="width100">
<span>${filetypebucket_lastupdate(namebucket)}</span>
</td>
<td class="width100 text-center">
<span class="size"> ${filetypebucket(namebucket)} </span>
</td>
</tr>`);
//${kb.toFixed(2)} KB
$("#menu").html(showlist.join(","));
}
});


}

function filetypebucket(bucket){

var countfile = null;
var countfile = $.ajax({
url:"index.php?r=site/insert_file_upload_list&type=filetypebucket&bucket="+bucket,
global: false,
dataType: "json",
async:false,
success: function(msg){
return msg.couterfile;
}
}
).responseJSON;

return countfile.couterfile;
}

function filetypebucket_lastupdate(bucket){

var check = null;
var check = $.ajax({
url:"index.php?r=site/insert_file_upload_list&type=filetypebucket_lastupdate&bucket="+bucket,
global: false,
dataType: "json",
async:false,
success: function(msg){
return msg.date_upload;
}
}
).responseJSON;

return check.date_upload;
}
});
</script>

<script>

$(document).ready(function() {

load_data_table();

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

$(document).on('click', '.click_checkfiletypeall', function(){
var show_checkfiletypeall = [];
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type=checkfiletypeall",
method:"GET",
"dataType": "json",
success:function(data)
{
$.each(data, function(i) {
show_checkfiletypeall.push(`
  <div class="col-lg-3 col-md-6 show_card">
                        <a href="#" onclick="window.open('index.php?r=site/pages&view=file-manager-type&form_id=${data[i].id}');">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-value float-right text-azure-new"><i class="fa fa-folder"></i></div>
                                    <h4 class="mb-1"><span class="couter">${data[i].countfile}</span></h4>
                                    <div>${data[i].detail}</div>
                                <!--<div class="mt-4">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-azure-new" style="width: 23%"></div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </a>    
                </div>
  `);
});
$(".show_checkfiletypeall").html(show_checkfiletypeall.join(""));
}
});
});

function load_data_table()
{
$.ajax({
url:"index.php?r=site/insert_file_upload_list&type=showdatatable",
method:"GET",
"dataType": "json",
success:function(data)
{
json_data(data);
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
"width" : "12%"
},
{
"targets": [2],
"data" : "bucket",
},
{
"targets": [3],
"data" : "text_extract",
"width" : "20%"
},
{
"targets": [4], 
"data" : "user_create",
},
{
"targets": [5],
"data" : "status_upload",
"width" : "18%"
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
        load_data_table();
    }
})
}else{
<?php
$url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;    
?>
load_data_table();
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
load_data_table();
}
});
}

});

</script>

<script>
$(document).ready(function(){

load_etemplate(1);

function load_etemplate(page, query = '')
{
$.ajax({
url:"index.php?r=site/fetch-managesfile-etemplate",
method:"POST",
data:{page:page, query:query},
success:function(data)
{
$('#dynamic_content').html(data);
}
});
}

$(document).on('click', '.click-page-link', function(){
var page = $(this).data('page_number');
var query = $('#search_box').val();
load_etemplate(page, query);
});

$('#search_box').keyup(function(){
var query = $('#search_box').val();
load_etemplate(1, query);
});

});
</script>