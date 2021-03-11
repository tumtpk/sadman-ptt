<?php
use app\models\SummaryType;
use app\models\EformTemplate;

$this->title = Yii::t('app', 'ดำเนินกรรมวิธีข่าว'); 
$this->params['breadcrumbs'][] = ['label' => 'ดำเนินกรรมวิธีข่าว', 'url' => ['site/news-process']];
$this->params['breadcrumbs'][] = $this->title;

$today_sum = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '16'")->queryAll();
$notify_sum = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '17'")->queryAll();

$date_now = date('Y-m-d');
$today = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '16' AND data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();
$notify = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id = '17' AND data_json LIKE '%\"date_record\":\"".$date_now."%'")->queryAll();
$today_to_unit = Yii::$app->db->createCommand("SELECT * FROM `eform_data` WHERE form_id IN ('16','17') AND data_json LIKE '%unit-send-news%'")->queryAll();
?>
<link rel="stylesheet" href="../../html-version/assets/css/style_dashboard_approve.css"/>
<style>
    .card-news{
        padding: 10px;
        margin-top: 0px !important;
    }
    .card-value{
        font-size: 22px !important;
    }
    .link-to-view{
        color: #537480;
        font-weight: 100 !important;
    }
</style>
<h4>ดำเนินกรรมวิธีข่าว</h4>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="Report-Invoices" role="tabpanel">
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-azure-new"><i class="fe fe-folder"></i></div>
                        <h4 class="mb-1"><span class="countAll"></span></h4>
                        <div>ข่าวสารทั้งหมด</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-azure-new" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-green-new"><i class="fe fe-calendar"></i></div>
                        <h4 class="mb-1"><span class="sumToDay"></span></h4>
                        <div>สรุปข่าวประจำวัน</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-green-new sumToDay_per"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-danger-new"><i class="fe fe-file-text"></i></div>
                        <h4 class="mb-1"><span class="sumNotify"></span></h4>
                        <div>สรุปข่าวกรอง</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger-new sumNotify_per"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-request-new">
                            <i class="fe fe-send"></i></div>
                        <h4 class="mb-1"><span class="toUnit"></span></h4>
                        <div>ส่งข่าวออกไปยังหน่วยงาน</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-request-new toUnit_per"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div  style="float:right;">

                    <div class="dropdown">
                        <button class="btn btn-lg btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-plus"></i> สร้างรายงานสรุปข่าว
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php
                            $summarytype = EformTemplate::find()
                            ->where(['in', 'id', [16,17]])
                            ->all();
                            foreach($summarytype as $s){    
                                ?>

                                <a class="dropdown-item" href="index.php?r=site/pages&view=process_news&form_id=<?=$s->id?>" ><?=$s->detail?></a>

                            <?php  } ?>

                        </div>
                    </div>
                </div>
                <script>
                    function jump(){

                    }
                </script>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="card-value float-right text-azure-new">
                                <i class="fe fe-folder"></i></div>
                            <div><strong>รายการสรุปข่าวประจำวัน (ข้อมูลวันที่ <?php echo dateThai(date("Y-m-d")); ?>)</strong></div><br>
                            <div class="row" id="show-array-data"></div>
                        </div>
                        <div style="float:right;" id="show-btn-etc">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="card-value float-right text-azure-new"><i class="fe fe-folder"></i></div>
                            <div><strong>รายการสรุปข่าวกรอง (ข้อมูลวันที่ <?php echo dateThai(date("Y-m-d")); ?>)</strong></div><br>
                            <div class="row" id="show-array-data-notify"></div>
                        </div>
                        <div style="float:right;" id="show-btn-etc-notify"></div>
                    </div>
                </div>
            </div>
        </div> 
    </div>      

</div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        coutertype();

        function coutertype(){
            $.ajax({
                url:"index.php?r=site/json_news_process&type=boxstat",
                method:"GET",
                dataType:"json",
                contentType: "application/json; charset=utf-8",
                success:function(data)
                {
                    $(".countAll").html(data.countAll);
                    $(".sumToDay").html(data.sumToDay);
                    $(".sumNotify").html(data.sumNotify);
                    $(".toUnit").html(data.toUnit);
                    $(".sumToDay_per").css('width', data.sumToDay_per);
                    $(".sumNotify_per").css('width', data.sumNotify_per);
                    $(".toUnit_per").css('width', data.toUnit_per);
                }
            });
        }

        datatoday();

        function datatoday(){
            var array_data = [];
            $.ajax({
                url:"index.php?r=site/json_news_process&type=newstoday",
                method:"GET",
                dataType:"json",
                contentType: "application/json; charset=utf-8",
                success:function(data)
                {

                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {
                            var no = data[i]['no'];
                            var detail = data[i]['detail'];
                            var tounit = data[i]['tounit'];
                            var link = data[i]['link'];

                            array_data.push(`<div class="col-md-12 card card-news"><a href="index.php?r=eform-data/view-process&id=${link}" class="link-to-view"><div class="row"><div class="col-md-1">${no}</div><div class="col-md-11">${detail}</div><div class="col-md-1"></div><div class="col-md-11">ส่งถึงหน่วย : ${tounit}</div></div></a></div>`);

                        }

                        $("#show-array-data").html(array_data.join(" "));
                        $("#show-btn-etc").html(`<button class="btn btn-primary">ข้อมูลทั้งหมด</button>`);

                    }else{

                     $("#show-array-data").html(`<div class="col-md-12">ไม่พบข้อมูล</div>`);
                     $("#show-btn").html("");

                 }
             }
         });
        }

        datanotify();

        function datanotify(){
            var array_notify = [];
            $.ajax({
                url:"index.php?r=site/json_news_process&type=newsnotify",
                method:"GET",
                dataType:"json",
                contentType: "application/json; charset=utf-8",
                success:function(data)
                {

                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {
                            var no = data[i]['no'];
                            var detail = data[i]['detail'];
                            var tounit = data[i]['tounit'];
                            var link = data[i]['link'];

                            array_notify.push(`<div class="col-md-12 card card-news"><a href="index.php?r=eform-data/view-process&id=${link}" class="link-to-view"><div class="row"><div class="col-md-1">${no}</div><div class="col-md-11">${detail}</div><div class="col-md-1"></div><div class="col-md-11">ส่งถึงหน่วย : ${tounit}</div></div></a></div>`);



                        }

                        $("#show-array-data-notify").html(array_notify.join(" "));
                        $("#show-btn-etc-notify").html(`<button class="btn btn-primary">ข้อมูลทั้งหมด</button>`);

                    }else{

                        $("#show-array-data-notify").html(`<div class="col-md-12">ไม่พบข้อมูล</div>`);
                        $("#show-btn-etc-notify").html("");

                    }


                }
            });
        }


    });
    
</script>