<?php
use yii\helpers\Html;
if ($_SESSION['user_role']!='1') {
    echo "<script>window.location='index.php?r=site/pages&view=alert_permission';</script>";
}
$this->title = 'สถิติข้อมูลผู้ใช้งานระบบทั้งหมด';
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");
?>
<style>
.ribbon .ribbon-box {
    padding: 8px !important;
}
</style>
<h4><?= Html::encode($this->title);?></h4>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="Accounts-Invoices" role="tabpanel">
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body ribbon">
                        <div class="ribbon-box azure">
                            <i class="icon-users"></i>
                        </div>
                        <a href="javascript:void(0);" class="my_sort_cut text-muted">
                            <div class="m-0 text-center h1 text-azure counter show_userall">

                            </div>
                            <span class="h6">ผู้ใช้งานทั้งหมด</span>
                        </a>
                        <div class="d-flex">
                            <small class="text-muted">คน</small>
                            <div class="ml-auto">
                                <i class="fa fa-caret-up"></i> 100%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body ribbon">
                        <div class="ribbon-box orange">
                            <i class="icon-user-following"></i>
                        </div>
                        <a href="javascript:void(0);" class="my_sort_cut text-muted">
                            <div class="m-0 text-center h1  counter show_sadmin">
                            </div>
                            <span class="h6">ผู้ดูแลระบบ</span>
                        </a>
                        <div class="d-flex">
                            <small class="text-muted">คน</small>
                            <div class="ml-auto">
                                <i class="fa fa-caret-up"></i>
                                <span class="show_per_sadmin"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body ribbon">
                        <div class="ribbon-box cyan">
                            <i class="icon-user-follow"></i>
                        </div>
                        <a href="javascript:void(0);" class="my_sort_cut text-muted">
                            <div class="m-0 text-center h1  text-cyan counter show_admin">
                            </div>
                            <span class="h6">ผู้ดูแลหน่วยงาน</span>
                        </a>
                        <div class="d-flex">
                            <small class="text-muted">คน</small>
                            <div class="ml-auto">
                                <i class="fa fa-caret-up"></i><span class="show_per_admin"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body ribbon">
                        <div class="ribbon-box danger">
                            <i class="icon-user"></i>
                        </div>
                        <a href="javascript:void(0);" class="my_sort_cut text-muted">
                            <div class="m-0 text-center h1 text-danger counter show_users">
                            </div>

                            <span class="h6">ผู้ใช้งานทั่วไป</span>
                        </a>
                        <div class="d-flex">
                            <small class="text-muted">คน</small>
                            <div class="ml-auto">
                                <i class="fa fa-caret-up"></i>
                                <span class="show_per_users"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row clearfix row-deck">
            <div class="col-xl-8 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">กราฟแสดงสถิติการเข้าใช้งานระบบภายใน 1 สัปดาห์</h3>
                    </div>
                    <div class="card-body">
                        <div id="apex-chart-line-column"></div>
                    </div>
                </div>

            </div>

            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">กราฟวงกลมประเภทผู้ใช้งาน</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-donut" style="height: 16rem"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<h4>สถิติข้อมูลการเข้าใช้งานระบบ</h4>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="Accounts-Invoices" role="tabpanel">
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">กราฟแท่งสถิติการเข้าใช้งานระบบ(แยกตามเดือน) ประจำปี <?=(date("Y")+543);?>
                        </h3>
                    </div>
                    <div class="card-body ribbon">
                        <div id="chart-area" style="height: 16rem"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">กราฟแท่งประเภทผู้ใช้งาน</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-bar-stat" style="height: 250px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    var url_users = "index.php?r=site/json_stat_sadmin&auth=<?=$auth?>&type=countusers";

    var json_users = null;
    var json_users = $.ajax({
        url: url_users,
        global: false,
        dataType: "json",
        async: false,
        success: function(msg) {
            return msg;
        }
    }).responseJSON;
    $(".show_userall").html(json_users.userall);
    $(".show_sadmin").html(json_users.sadmin);
    $(".show_per_sadmin").html(json_users.per_sadmin);
    $(".show_admin").html(json_users.admin);
    $(".show_per_admin").html(json_users.per_admin);
    $(".show_users").html(json_users.users);
    $(".show_per_users").html(json_users.per_users);


    var chart = c3.generate({
        bindto: '#chart-bar-stat', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', json_users.sadmin],
                ['data2', json_users.admin],
                ['data3', json_users.users]
            ],
            type: 'bar', // default type of chart
            colors: {
                'data1': '#004660',
                'data2': '#2FA2BC',
                'data3': '#A6CA16'
            },
            names: {
                // name of each serie
                'data1': 'ผู้ดูแลระบบ',
                'data2': 'ผู้ดูแลหน่วยงาน',
                'data3': 'ผู้ใช้งานทั่วไป'
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['ประภทผู้ใช้งาน']
            },
        },
        bar: {
            width: 16
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });

    $(document).ready(function() {
        var chart = c3.generate({
            bindto: '#chart-donut', // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ['data1', json_users.sadmin],
                    ['data2', json_users.admin],
                    ['data3', json_users.users]
                ],
                type: 'donut', // default type of chart
                colors: {
                    'data1': '#d2b52a',
                    'data2': '#17A2BC',
                    'data3': '#034660'
                },
                names: {
                    // name of each serie
                    'data1': 'ผู้ดูแลระบบ',
                    'data2': 'ผู้ดูแลหน่วยงาน',
                    'data3': 'ผู้ใช้งานทั่วไป'
                }
            },
            axis: {},
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    });


    var url_count_months = "index.php?r=site/json_stat_sadmin&auth=<?=$auth?>&type=countmonths";

    var json_count_months = null;
    var json_count_months = $.ajax({
        url: url_count_months,
        global: false,
        dataType: "json",
        async: false,
        success: function(msg) {
            return msg;
        }
    }).responseJSON;
    // console.log(json_count_months);

    var show_months = [];
    $.each(json_count_months, function(index) {
        show_months.push(json_count_months[index].months);
    });

    var show_count = [];
    show_count.push('จำนวนการเข้าใช้งาน(ครั้ง)');
    $.each(json_count_months, function(index) {
        show_count.push(json_count_months[index].sum);
    });




    $(document).ready(function() {
        var chart = c3.generate({
            bindto: '#chart-area',
            data: {
                columns: [
                    // each columns data
                    show_count,
                ],
                type: 'line', // default type of chart
                colors: ['#ffc107'],

                names: ['จำนวนการเข้าใช้งาน(ครั้ง)'],
            },

            axis: {
                x: {
                    type: 'category',
                    // name of each category
                    categories: show_months,
                },

            },
            legend: {
                // show: false, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },

        });
    });
});
</script>






<script>
var url = "index.php?r=site/json_stat_sadmin&auth=<?=$auth?>&type=graphweek";

var json = null;
var json = $.ajax({
    url: url,
    global: false,
    dataType: "json",
    async: false,
    success: function(msg) {
        return msg;
    }
}).responseJSON;

var showlog_date = [];
$.each(json, function(index) {
    showlog_date.push(json[index].log_date);
});

var showsum = [];
$.each(json, function(index) {
    showsum.push(json[index].sum);
});

$(document).ready(function() {
    var options = {
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        colors: ['#17A2BC'],
        series: [{
            name: 'จำนวนการเข้าใช้งาน',
            type: 'area',
            data: showsum
        }],
        stroke: {
            width: [4]
        },
        labels: showlog_date,

    }
    var chart = new ApexCharts(
        document.querySelector("#apex-chart-line-column"),
        options
    );

    chart.render();
});
</script>