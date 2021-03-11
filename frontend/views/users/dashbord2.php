<?php
   use app\models\Setting;
   use app\models\FileUploadList;
   use frontend\models\MenuMain;
   use frontend\models\MenuSub;
   
   $token = "2ffa459adcc37176dbf93a82addf61dc";
   $auth = "Authenticator=>".$token."".date("Ymd");
   
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
   .circle {
   width: 350px;
   height: 350px;
   line-height: 350px;
   border-radius: 50%;
   font-size: 50px;
   color: #fff;
   display: table-cell;
   text-align: center;
   vertical-align: middle;
   }
   .circle-small{
   width: 100px;
   height: 100px;
   line-height: 350px;
   border-radius: 50%;
   font-size: 50px;
   color: #fff;
   display: table-cell;
   text-align: center;
   vertical-align: middle;
   }
</style>
<!-- <button class="button-new">ข้อมูลเพิ่มเติม</button > -->
<div class="row clearfix">
   <div class="col-md-12">
      <div class="mb-5 mt-3">
         <!-- <h4>Welcome # <?=$_SESSION['user_name']?> วันนี้คุณต้องการทำอะไร?</h4> -->
         <h4>รายงานสถานการณ์ การบุกรุก และกิจกรรมเสี่ยงใน เขตระบบท่อส่งก๊าซธรรมชาติ TTM</h4>
         <h6>ข้อมูล ประจำเดือน xxxx ปี xxxx</h6>
      </div>
   </div>
</div>
<div class="section-body">
   <div class="container-fluid">
      <div class="row clearfix">
         <div class="pp col-lg-3 col-md-6 col-sm-12 ">
            <h6 class="menu-slot-right">เคสใหม่เกิดขึ้นในเดือนนี้</h6>
            <div class="card bg-orange">
               <div class="card-body">
                  <div class="widgets2">
                     <div class="state">
                        <h1>+0 <span>เคส</span></h1>
                     </div>
                  </div>
                  <div class="progress progress-sm mb-3">
                     <div class="progress-bar bg-gray-light" role="progressbar" aria-valuenow="62"
                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                  </div>
                  <p class="text-small">เสี่ยงสูง</p>
                  <h6 class="text-small">เสียงปานกลาง</h6>
                  <h6 class="text-small">เสียงต่ำ</h6>
               </div>
            </div>
         </div>
         <div class="pp col-lg-3 col-md-6 col-sm-12">
            <h6 class="menu-slot-right">เคสสะสมในปี xxxx</h6>
            <div class="card bg-yellow">
               <div class="card-body">
                  <div class="widgets2">
                     <div class="state">
                        <h1>
                           17 <span>เคส</span>
                        </h1>
                     </div>
                  </div>
                  <div class="progress progress-sm mb-3">
                     <div class="progress-bar bg-gray-light" role="progressbar" aria-valuenow="78"
                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                  </div>
                  <p class="text-small">เสี่ยงสูง</p>
                  <h6 class="text-small">เสียงปานกลาง</h6>
                  <h6 class="text-small">เสียงต่ำ</h6>
               </div>
            </div>
         </div>
         <div class="pp col-lg-3 col-md-6 col-sm-12">
            <h6 class="menu-slot-right">เคสใหม่เกิดขึ้นสะสมทั้งหมด</h6>
            <div class="card bg-green">
               <div class="card-body">
                  <div class="widgets2">
                     <div class="state">
                        <h1>
                           67 <span>เคส</span>
                        </h1>
                     </div>
                  </div>
                  <div class="progress progress-sm mb-3">
                     <div class="progress-bar bg-gray-light" role="progressbar" aria-valuenow="31"
                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                  </div>
                  <p class="text-small">เสี่ยงสูง</p>
                  <h6 class="text-small">เสียงปานกลาง</h6>
                  <h6 class="text-small">เสียงต่ำ</h6>
               </div>
            </div>
         </div>
         <div class="pp col-lg-3 col-md-6 col-sm-12">
            <h6 class="menu-slot-right">ดำเนินการแก้ไชแล้วเสร็จ</h6>
            <div class="card bg-black-active">
               <div class="card-body">
                  <div class="widgets2">
                     <div class="state">
                        <h1>42 <span>เคส</span></h1>
                     </div>
                  </div>
                  <div class="progress progress-sm mb-3">
                     <div class="progress-bar bg-gray-light" role="progressbar" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                  </div>
                  <p class="text-small">เสี่ยงสูง</p>
                  <h6 class="text-small">เสียงปานกลาง</h6>
                  <h6 class="text-small">เสียงต่ำ</h6>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="pp col-lg-3 col-md-3">
            <div class="card bg-teal-pd">
               <div class="card-body">
                  <h3 class="text-small">กำลังแก้ไข 25 เคส <span></span></h3>
                  <h3 class="text-small">เสี่ยงสูง 5 เคส <span></span></h3>
               </div>
            </div>
            <div class="card bg-gray">
               <div class="card-body">
                  <h6 class="text-small">ถนน Crossing ในเขตฯ <span></span></h6>
                  <h6 class="text-small">ปลุกต้นไม้ ในเขตฯ<span></span></h6>
                  <h6 class="text-small">อาคาร ถาวร ในเขตฯ<span></span></h6>
                  <h6 class="text-small">อาคาร ชั่วคราว ในเขตฯ<span></span></h6>
                  <h6 class="text-small">ขุดดิน ในเขตฯ<span></span></h6>
                  <h6 class="text-small">วางสิ่งของ ในเขตฯ<span></span></h6>
                  <h6 class="text-small">อื่นๆ<span></span></h6>
               </div>
            </div>
         </div>
         <div class="pp col-lg-9 col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">แผนที่แสดงที่ตั้งหน่วยงาน</h3>
                  <div class="card-options"></div>
               </div>
               <div class="card-body">
                  <link data-require="leaflet@0.7.3" data-semver="0.7.3" rel="stylesheet"
                     href="../../leaflet-0.7.3/leaflet.css" />
                  <script data-require="leaflet@0.7.3" data-semver="0.7.3" src="../../leaflet-0.7.3/leaflet.js"></script>
                  <div id="mapshow" style="border-radius: 5px;
                     width: 100%;
                     height: 490px;
                     margin-top: 11px;"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="pp col-lg-12  col-sm-12">
            <div class="card">
               <div class="card-body">
               <!-- <----------------------------------------------------table------------------------------------------------> 
                  <table style="height: 100%; width: 100%;" class="table">
                     <tbody class="table-body">
                        <tr style="height: 28px;">
                           <td style="width: 209px; height: 28px;">ปีที่พบ</td>
                           <td style="width: 393px; height: 28px;">ตำแหน่งที่พบ</td>
                           <td style="width: 585px; height: 28px;">รายละเอียดการบุกรุก</td>
                           <td style="width: 159px; height: 28px;">Status</td>
                           <td style="width: 114px; height: 28px;"></td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2559</td>
                           <td style="width: 393px; height: 29px;">KP 47+035</td>
                           <td style="width: 585px; height: 29px;">ต้นยางพารารุกล้ำ 10 ต้น</td>
                           <td style="width: 159px; height: 29px;">100</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                    100%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2560</td>
                           <td style="width: 393px; height: 29px;">KP 82+050</td>
                           <td style="width: 585px; height: 29px;">ต้นยางพารารุกล้ำ 10 ต้น</td>
                           <td style="width: 159px; height: 29px;">60</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width:60%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 31+600</td>
                           <td style="width: 585px; height: 29px;">พบร้านสิ่งก่อสร้าง (ขายกาแฟ)</td>
                           <td style="width: 159px; height: 29px;">80</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100" style="width:80%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 41+900</td>
                           <td style="width: 585px; height: 29px;">ดินพังทลายจนเห็นแนวท่อ</td>
                           <td style="width: 159px; height: 29px;">80</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100" style="width:80%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 83+849</td>
                           <td style="width: 585px; height: 29px;">ต้นยางพารารุกล้ำ 52 ต้น,ต้นเนียง 6 ต้น</td>
                           <td style="width: 159px; height: 29px;">0</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 12+248</td>
                           <td style="width: 585px; height: 29px;">ทำถนนลุกลังทางเข้าสวน</td>
                           <td style="width: 159px; height: 29px;">10</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="10"
                                    aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 20+550</td>
                           <td style="width: 585px; height: 29px;">ทำถนนลุกลังทางเข้าสวน</td>
                           <td style="width: 159px; height: 29px;">20</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="20"
                                    aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                    100%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 20+807</td>
                           <td style="width: 585px; height: 29px;">ทำถนนคอนกรีตเข้าเต๊น ขายรถมือสอง</td>
                           <td style="width: 159px; height: 29px;">30</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 22+808</td>
                           <td style="width: 585px; height: 29px;">มีการถมดินทำทางเข้าจุดรับซื้อน้ำยาง</td>
                           <td style="width: 159px; height: 29px;">20</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="20"
                                    aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 34+938</td>
                           <td style="width: 585px; height: 29px;">ทำถนนยกสูงเข้าที่ดินส่วนบุคคลทับถมป้าย</td>
                           <td style="width: 159px; height: 29px;">50</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr style="height: 29px;">
                           <td style="width: 209px; height: 29px;">2561</td>
                           <td style="width: 393px; height: 29px;">KP 22+172</td>
                           <td style="width: 585px; height: 29px;">มีการก่อสร้างทาง U-TURN 200 เมตร</td>
                           <td style="width: 159px; height: 29px;">9</td>
                           <td style="width: 114px; height: 29px;">
                              <div class="progress">
                                 <div class="progress-bar" role="progressbar" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100" style="width:90%">
                                    70%
                                 </div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
             <!-- <----------------------------------------------------table------------------------------------------------> 
         
         </div>
      </div>
   </div>
</div>
<script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
<script>
   mapboxgl.accessToken = 'pk.eyJ1Ijoid2ljMDE0NCIsImEiOiJja20zbmY2dzMyNzhlMnNseThpejE4ajA5In0.h5Df-2IwkGWQNMxS-Mgujg';
   var map = new mapboxgl.Map({
      container: 'mapshow',
      style: 'mapbox://styles/wic0144/ckm3qzk7e0sq617q3k2jb4iy7',
      interactive: true,
      attributionControl: false,
      maxZoom:20,
      minZoom:5,
   });
   map.on('style.load', function() {
   map.on('click', function(e) {
   var coordinates = e.lngLat;
   new mapboxgl.Popup()
   .setLngLat(coordinates)
   .setHTML('you clicked here:' + coordinates)
   .addTo(map);
   });
   });
</script>
<script>
   var url = "index.php?r=site/json_stst_index_user&auth=<?=$auth?>&type=graphweek&id=<?= $_GET['id'];?>";
   
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
               height: 300,
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
<script>
   $(document).ready(function() {
   
       var url_users =
       "index.php?r=site/json_stst_index_user&auth=<?=$auth?>&type=countusers&id=<?= $_GET['id'];?>";
   
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