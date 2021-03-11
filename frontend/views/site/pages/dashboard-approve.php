<?php
use yii\helpers\Html;
$this->title = 'Dashboard Approve';
$token = "2ffa459adcc37176dbf93a82addf61dc";
$auth = "Authenticator=>".$token."".date("Ymd");

$this->title = 'อนุมัติข่าวสาร';
//$this->params['breadcrumbs'][] = ['label' => 'หน้าหลัก', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
.dataTables_wrapper .dataTables_filter {
    color: #292b30;
    float: left;
}
</style>
<link rel="stylesheet" href="../../html-version/assets/css/style_stat_users_department.css"/>
<link rel="stylesheet" href="../../html-version/assets/css/style_dashboard_approve.css"/>

<h4>ข้อมูลรอการอนุมัติ</h4>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="Report-Invoices" role="tabpanel">
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-azure-new"><i class="fe fe-folder"></i></div>
                        <h4 class="mb-1"><span class=" countdataall"></span></h4>
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
                        <div class="card-value float-right text-green-new"><i class="fe fe-check-circle"></i></div>
                        <h4 class="mb-1"><span class=" countdataapprove"></span></h4>
                        <div>อนุมัติแล้ว</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-green-new per_countdataapprove"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-danger-new"><i class="fe fe-alert-circle"></i></div>
                        <h4 class="mb-1"><span class="countdatanotapprove"></span></h4>
                        <div>รอการอนุมัติ</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-danger-new per_countdatanotapprove"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-request-new"><i class="fa fa-question-circle-o"></i></div>
                        <h4 class="mb-1"><span class="countdatarequest"></span></h4>
                        <div>ต้องการข้อมูลเพิ่มเติม</div>
                        <div class="mt-4">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-request-new per_countdatarequest"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <select id="dropdown1" class="form-control col-md-3 mb-1">
                        <option value="">ทั้งหมด</option>
                        <option value="อนุมัติข่าวแล้ว">อนุมัติแล้ว</option>
                        <option value="ต้องการเพิ่มเติม">ต้องการข้อมูลเพิ่มเติม</option>
                        <option value="ยังไม่ได้รับการอนุมัติ">รอการอนุมัติ</option>
                    </select>
                    <table class="table table-hover js-basic-example dataTable table_custom border-style spacing5" id="example">

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
            coutertype();

            function coutertype(){
                $.ajax({
                    url:"index.php?r=site/json_dashboard_approve&auth=<?=$auth?>&type=persent",
                    method:"GET",
                    dataType:"json",
                    contentType: "application/json; charset=utf-8",
                    success:function(data)
                    {
                        $(".countdataall").html(data.countdataall);
                        $(".countdataapprove").html(data.countdataapprove);
                        $(".countdatanotapprove").html(data.countdatanotapprove);
                        $(".countdatarequest").html(data.countdatarequest);
                        $(".per_countdataapprove").css('width', data.per_countdataapprove);
                        $(".per_countdatanotapprove").css('width', data.per_countdatanotapprove);
                        $(".per_countdatarequest").css('width', data.per_countdatarequest);
                    }
                });
            }

            function load_data()
            {
                var show_data_status = [];
                $.ajax({
                    url:"index.php?r=site/json_dashboard_approve&auth=<?=$auth?>&type=showdataall",
                    method:"GET",
                    "dataType": "json",
                    success:function(data)
                    {
                        json_data(data);

                        var result = data.filter(function(el, i, x) {
                            return x.some(function(obj, j) {
                                return obj.select_approve === el.select_approve && (x = j);
                            }) && i == x;
                        });
                        $.each(result, function(i) {
                            show_data_status.push(`<option value="${result[i].select_approve}">${result[i].select_approve}</option>
                                `);
                        });

                        // $("#dropdown1").html('<option value="">เลือกสถานะ</option>'+show_data_status.join(""));
                    }
                });
            }

            function json_data(data)
            {
                var dataSet = data;
                var datatable = $('#example').DataTable({
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
                        title: "แบบฟอร์ม"
                    },
                    {
                        title: "วันที่บันทึก/แก้ไข"
                    },
                    {
                        title: "สถานะ"
                    },
                    {
                        title: "จัดการข้อมูล"
                    }
                    ],
                    'columnDefs': [
                    {
                        "targets": [0],
                        "data" : "no",
                    },
                    {
                        "targets": [1],
                        "data" : "data",
                    },
                    {
                        "targets": [2],
                        "data" : "eform_detail",
                    },
                    {
                        "targets": [3],
                        "data" : "date_record",
                    },
                    {
                        "targets": [4],
                        "data" : "approve",
                        "className": "text-center",
                        "width" : "10%"
                    },
                    {
                        "targets": [5],
                        "data" : "link",
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

                $('#dropdown1').on('change', function () {
                    datatable.columns(4).search( this.value ).draw();
                } );

            }

        });
}) (jQuery);
</script>