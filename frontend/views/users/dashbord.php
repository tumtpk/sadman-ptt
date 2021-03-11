<?php

$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>" . $token . "" . date("Ymd");
$strMonthCut = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$Numfix = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
$riskfix = array("เสี่ยงต่ำ", "เสี่ยงกลาง", "เสี่ยงสูง");
$Numriskfix = array("1", "2", "3");
$NumSumriskfix = array("10", "20", "30");
$colortable = array('#44bf13', '#fff600', '#ff0505');

// $casefix =Array("ตลิ่งชันขควนมืด","ควนมืด-สะพานรถไฟ","นาหม่อน","หาดใหญ่","บ้านพรุ","เขามีเกียตริ์","พังลา","ปริก","สะเดา");
// $KPfix =Array("00-10","10-23","23-30","30-34","34-45","45-55","55-65","65-75","75-89");
//$this->title = 'วันนี้คุณต้องการทำอะไร?';
// $this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="../../html-version/assets/css/style_equipment.css" />
<?php

/* @var $this yii\web\View */

$this->title = 'TextX';
?>
<style>
    .avatar-xl {
        width: 3rem;
        height: 3rem;
        line-height: 4rem;
        font-size: 1.75rem;
        margin-top: 5px;
    }

    .top_counter .icon i {
        color: #fff;
        margin-top: 14px;
    }

    #sortable-row {
        list-style: none;
    }

    #sortable-row li {
        margin-bottom: 4px;
        padding: 10px;
        background-color: #e3e3e3;
        cursor: move;
        color: #212121;
        width: 100%;
        border-radius: 3px;
        border: #ccc 1px solid
    }

    #sortable-row li.ui-state-highlight {
        height: 2.5em;
        background-color: #F0F0F0;
        border: #ccc 2px dotted;
    }

    /*#manage_sort{ display: none; }*/
    .iconall {
        content: "\e001";
        background-color: #dab90a;
        padding: 16px;
        border: -32;
        border-radius: 50px;
        color: #fff;
        text-align: center !important;
        font-size: 49;

    }

    .bbt {
        border-radius: 30px;
        margin-top: 20;
    }

    .top {
        margin-top: 10;
        margin-bottom: 20;
    }

    .ribbon .ribbon-box {
        padding: 8px !important;
    }

    p {
        margin-bottom: 1px !important;
    }

    .card1 {
        height: 300px;
    }

    .card3 {
        height: 224px;
    }

    .card2 {
        height: 190px;
    }

    .menu-slot {
        height: 40px;
    }

    .menu-slot-left {
        float: left;
        display: inline-block;
    }

    .menu-slot-right {
        float: right;
        display: inline-block;
    }

    .div-scrollbar {
        height: 250px;
        overflow-y: scroll;
        padding: 0em 1em 1em 1em;
        margin-bottom: 1em;
        font-size: 14px !important;
    }
    .progress-bar-success{
        background-color: #44bf13;
    }
    .progress-bar-danger{
       
        background-color:#ff0505;
    
    }
    .progress-bar-warning{
        background-color: #fff600;
    }

</style>

<!-- <button class="button-new">ข้อมูลเพิ่มเติม</button > -->
<!-- <div class="row clearfix">
    <div class="col-md-12">
        <div class="mb-4 mt-3">
            <h4>Welcome # <?= $_SESSION['user_name'] ?> วันนี้คุณต้องการทำอะไร?</h4>
        </div>
    </div>
</div> -->
<!-- <div class="container"> -->
<div class="row clearfix">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body ribbon">

                <div class="row">
                    <div class="col-12">
                        <div class="body-content">
                            <table class="table table-bordered">
                                <thead class="">
                                    <tr>
                                        <th> </th>
                                        <?php
                                        foreach ($strMonthCut as $value) {
                                            echo '<th>' . $value . "63" . '</th>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th scope="row">เคสใหม่</th>
                                        <?php
                                        foreach ($Numfix as $value) {
                                            echo '<td>' . $value . '</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">เคสสะสม</th>
                                        <?php
                                        foreach ($Numfix as $value) {
                                            echo '<td>' . $value = $value + 1 . '</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">เคสแก้ไขแล้ว</th>
                                        <?php
                                        foreach ($Numfix as $value) {
                                            echo '<td>' . $value = $value + 2 . '</td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">เคสคงค้าง</th>
                                        <?php
                                        foreach ($Numfix as $value) {
                                            echo '<td>' . $value = $value + 3 . '</td>';
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- graph -->
                <div class="row">
                    <div class="col-10">
                        <div id="apex-chart-line-column"></div>
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <div class="card">
                                <div class="card-body" style="background-color: #77B6EA">
                                    <h5>เคสสะสม</h5>
                                    <h4>35</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-body" style="background-color: #44bf13">
                                    <h5>เคสแก้ไขแล้ว</h5>
                                    <h4>40</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-body" style="background-color: #fff019">
                                    <h5>เคสคงค้าง</h5>
                                    <h4>20</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-body" style="background-color: #ff0505">
                                    <h5>เคสใหม่</h5>
                                    <h4>15</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                            <div id="apex-chart-bar-column"></div>

                            <div class="row">
                                <div class="col-2">รวมเคสบุกรุกเขตระบบฯ</div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10"
                                            aria-valuemin="0" aria-valuemax="100" style="width:64%">
                                            64%
                                        </div>
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100" style="width:14%">
                                        14%
                                        </div>
                                        <div class="progress-bar progress-bar-danger " role="progressbar" aria-valuenow="20"
                                        aria-valuemin="0" aria-valuemax="100" style="width:22%">
                                        2%
                                        </div> 
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                    </div>
                    <div class="col-3">
                        <div class="body-content">
                            <table class="table table-bordered">
                                <thead >
                                    <tr>
                                    <th class="progress-bar-success">ความเสี่ยงต่ำ</th>
                                    <th class="progress-bar-warning">เสี่ยงกลาง</th>
                                    <th class="progress-bar-danger">เสี่ยงสูง</th>
                                        <?php
                                        // foreach ($riskfix as $value) {
                                        //     echo '<th >' . $value . '</th>';
                                        // }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<tr>';
                                        foreach ($Numriskfix as $value) {
                                            echo '<td>' . $value . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                    <tr>

                                        <?php
                                        foreach ($NumSumriskfix as $value) {
                                            echo '<td>' . $value . '</td>';
                                        }
                                        ?>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->


<script>
    var url = "index.php?r=site/json_stst_index_user&auth=<?= $auth ?>&type=graphweek&id=<?= $_GET['id']; ?>";

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

    // var showlog_date = [];
    // $.each(json, function(index) {
    //     showlog_date.push(json[index].log_date);
    // });

    // var showsum = [];

    $(document).ready(function() {
        var options = {
            series: [{
                    name: "เคสสะสม",
                    data: [28, 29, 33, 36, 32, 32, 33, 17, 15, 18, 20, 35]
                },
                {
                    name: "เคสแก้ไขแล้ว",
                    data: [12, 11, 14, 18, 17, 13, 13, 20, 25, 20, 28, 40]
                },
                {
                    name: "เคสคงค้าง",
                    data: [1, 10, 14, 20, 17, 18, 12, 18, 13, 17, 28, 20]
                },
                {
                    name: "เคสใหม่",
                    data: [1, 2, 10, 15, 12, 10, 9, 13, 17, 19, 20, 15]
                },
            ],
            chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#77B6EA', '#44bf13', '#fff600', '#ff0505'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'ประวัติ เคสบุกรุก ในเขตระบบท่อส่งก๊าซฯ TTM',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
                title: {
                    text: 'Month'
                }
            },
            yaxis: {
                title: {
                    text: 'Temperature'
                },
                min: 5,
                max: 50
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                //   offsetY: -5,
                //   offsetX: -1
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-chart-line-column"), options);
        chart.render();
    });
</script>
<!-- end scrip graph line -->
<script>
    var url = "index.php?r=site/json_stst_index_user&auth=<?= $auth ?>&type=graphweek&id=<?= $_GET['id']; ?>";

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

    $(document).ready(function() {
        var options = {
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,

                //   stackType: '100%'
            },
            series: [{
                name: 'เสี่ยงต่ำ',
                data: [44, 55, 41, 37, 22, 43, 21, 25, 47]
            }, {
                name: 'เสี่ยงกลาง',
                data: [53, 32, 33, 52, 13, 43, 32, 33, 57]
            }, {
                name: 'เสี่ยงสูง',
                data: [12, 17, 11, 9, 15, 11, 20, 8, 12]
            }],
            colors: ['#44bf13', '#fff600', '#ff0505'],
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 8,
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            title: {
                text: 'กราฟประเมิน บุกรุก ในแต่ละตำแหน่งของเขตระบบท่อส่งก๊าซฯ'
            },
            xaxis: {
                categories: ["ตลิ่งชันควนมืด  KP 00-10 " , "ควนมืด-สะพานรถไฟ  KP 10-23 ", "นาหม่อน  KP 23-30 ", "หาดใหญ่  KP 30-34 ", "บ้านพรุ  KP 34-45 ", "เขามีเกียตริ์  KP 45-55 ", "พังลา  KP 55-65 ", "ปริก  KP 65-75 ", "สะเดา  KP 75-85 "],
            },
        };
        var chartbar = new ApexCharts(document.querySelector("#apex-chart-bar-column"), options);
        chartbar.render();
    });
    // end chart bar full 
</script>
<!-- end scrip graph bar -->
<script>
    $(document).ready(function() {

        var url_users =
            "index.php?r=site/json_stst_index_user&auth=<?= $auth ?>&type=countusers&id=<?= $_GET['id']; ?>";

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
        $(".show_user_ues_all").html(json_users.useAll);
        $(".show_sadmin").html(json_users.useday);
        $(".show_per_sadmin").html(json_users.per_useday);
        $(".show_admin").html(json_users.usemonths);
        $(".show_per_admin").html(json_users.per_usemonths);
        $(".show_user").html(json_users.useyear);
        $(".show_per_users").html(json_users.per_useyear);



    });
    // });
</script>