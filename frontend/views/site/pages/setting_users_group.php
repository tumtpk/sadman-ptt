<?php
use yii\helpers\Html;
use app\models\Unit;
use app\models\UserGroup;
use app\models\Users;

$this->title = 'กำหนดสิทธิ์การเข้าใช้งานระบบ';
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");

?>
<style>
.tag{
    margin-right: 5px;
    margin-left: 5px;
}
.tag-left-top{
    margin-top: -20px !important;
}
.card-body {
    padding: 10px 20px !important;
}
.div-scrollbar{
    height: 150px;
    overflow-y: scroll;
    padding: 0em 1em 1em 1em;
    margin-bottom: 1em;
}
.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
.highlight {
    color: #212529;
    background-color: #ffc107;
    border-radius: 5px;
    padding: 0em;
    font-weight: bold;
    font-size: 16px;
}
</style>
<div class="row">
    <div class="col-md-6">
        <h5><?= Html::encode($this->title);?></h5>
    </div>
</div>

<div id="show_error"></div>
<div class="form-group has-search">
    <span class="fa fa-search form-control-feedback"></span>
    <input type="search" class="form-control" id="usr" placeholder="ค้นหา...">
</div>

<div class="row showlist">
</div>
<div id="showresult"></div>

<script>
    $(document).ready(function(){

        load_data();

        $(document).on('keyup', '#usr', function(){
         $('.listgroup').hide();
         var txt = $(this).val();
         $('.listgroup').each(function(){
           if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
               $(this).show();
                 // console.log($('.listgroup').html());
                 // $(this).html(highlight(txt,$(this).html()));
                 $("#showresult").html('');
                 $('.search-list').hide();
                 $('.search-list').each(function(){
                    if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                       $(this).show();}
                   });
             }else{
                $("#showresult").html('<div class="text-center p-5">ไม่พบข้อมูล</div>');
            }
        });
     });

        $(document).on('click', '.clse_user', function(){
         if (confirm('ต้องการเปลี่ยนสถานะการเข้าใช้งานระบบของผู้ใช้รายนี้ใช่หรือไม่?')) {
            var iduser = $(this).data('iduser');
            var user_status = $(this).data('user_status');
            $.ajax({
                url:"index.php?r=site/json_setting_users_group&auth=Authenticator=>qw37176dbf9WAQSAD3a82aqweQSGTadc<?=date("Ymd")?>&type=clse_user",
                data:{iduser:iduser,user_status:user_status},
                type: 'post',
                dataType: 'json',
                success:function(data)
                {
                    if (data.output==1) {
                        $("#show_error").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong><i class="fas fa-check-circle" aria-hidden="true"></i></strong> บันทึกข้อมูลสำเร็จ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
                        load_data();
                    }else{
                        $("#show_error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> ไม่สามารถเพิ่มข้อมูลได้ กรุณาลองใหม่ <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button></div>');
                    }
                }
            });
        }
    });
        function highlight(key,text) {
            var innerHTML = text.toLowerCase();
            var innerHTML_nolow = text;
            var index = innerHTML.indexOf(key.toLowerCase());
            if (index >= 0) { 
                innerHTML_nolow = innerHTML_nolow.substring(0,index) + "<span class='highlight'>" + innerHTML_nolow.substring(index,index+key.length) + "</span>" + innerHTML_nolow.substring(index + key.length);
            }
            return innerHTML_nolow;
        }

        function load_data(){
            var showlist = [];
            $.ajax({
                url:"index.php?r=site/json_setting_users_group&auth=Authenticator=>qw37176dbf9WAQSAD3a82aqweQSGTadc<?=date("Ymd")?>&type=usersgroup&unitid=<?=$_SESSION['unit_id']?>",
                method:"GET",
                dataType:"json",
                crossDomain:true,
                contentType: "application/json; charset=utf-8",
                success:function(data)
                {

                    if (data.length>0) {
                        $.each(data, function(index) {

                            var showdata = '';
                            showdata += `<div class="col-lg-6 col-md-12 listgroup">
                            <div class="card">
                            <div class="card-header">
                            <h3 class="card-title tag-left-top">กลุ่ม : ${data[index].name_group}</h3>
                            <div class="card-options">
                            จำนวนผู้ใช้งานในกลุ่ม <span class="tag tag-blue mb-3">${data[index].sum}</span> คน
                            </div>
                            </div>
                            <div class="card-body" style="font-weight: 400 !important;">
                            <p><b>รายละเอียด :</b> ${data[index].detail_group}</p>
                            <div class="div-scrollbar">`

                            var i = 1;
                            var showuser = '';
                            $.each(data[index].show_user, function(val) {
                                var color = '';
                                var text_stu = '';
                                var chg_stu = '';
                                if (data[index].show_user[val].user_status=='1') {
                                    color = 'dc3545';
                                    text_stu = 'ปิด';
                                    chg_stu = '0';
                                }else{
                                    color = '28a745';
                                    text_stu = 'เปิด';
                                    chg_stu = '1';
                                }
                                showuser += `
                                <div class="row search-list">
                                <div class="col-1 py-1">${i++}</div>
                                <div class="col-4 py-1">${data[index].show_user[val].name}</div>
                                <div class="col-5 py-1">${data[index].show_user[val].email}</div>
                                <div class="col-2 py-1 text-right"><a class="icon" href="index.php?r=users/view&id=${data[index].show_user[val].id_user}" target="_blank"><i class="fe fe-eye mr-1" data-toggle="tooltip" data-placement="bottom" title="รายละเอียดข้อมูลผู้ใช้งาน"></i></a><a href="#" class="clse_user icon d-md-inline-block ml-3" data-iduser="${data[index].show_user[val].id_user}" data-user_status="${chg_stu}"><i class="icon-power mr-1" data-toggle="tooltip" data-placement="bottom" title="${text_stu}การใช้งาน" style="font-weight: bold;color: #${color};"></i></a></div>
                                </div>
                                `
                            });

                            showdata += showuser;

                            showdata += `</div>
                            </div>
                            <div class="card-footer">
                            <div class="clearfix">
                            <div class="float-left"><strong>${data[index].percent}%</strong></div>
                            <div class="float-right"><small class="text-muted">/100%</small></div>
                            </div>
                            <div class="progress progress-xs">
                            <div class="progress-bar bg-red" role="progressbar" style="width: ${data[index].percent}%" aria-valuenow="36" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            </div>
                            </div>
                            </div>`;
                            showlist.push(showdata);
                        });

                    }
                    $(".showlist").html(showlist.join(""));

                }
            });

}
});
</script>