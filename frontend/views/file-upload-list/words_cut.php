<?php
use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\DetailView;


$eform_template = "SELECT detail as dt FROM `eform` WHERE form_id = '".$model->form_id."' AND active = '1' AND unit_id = '".$_SESSION['unit_id']."'";
$eft = Yii::$app->db->createCommand($eform_template)->queryOne();

$this->title = $model->origin_file_name;
$this->params['breadcrumbs'][] = ['label' => 'ไฟล์จากแฟ้มข้อมูล'.$eft['dt'], 'url' => ['site/pages','view'=>'file-manager-type','form_id'=>$model->form_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();

?>
<style>
.sub{
	cursor: move;
}
.sub-in-main {
	width: max-content;
	padding: 5px;
	border-radius: 5px;
	cursor: pointer;
	background-color: #E9ECEF;
	margin-bottom: 5px;
	display: inline-block;
}
.sub-in-main i {
	color: crimson;
}

.person {
	display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #79bb0e !important;padding: 3px 5px;border-radius: 4px;"';
}	
.location {
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #9aa0ac !important;padding: 3px 5px;border-radius: 4px;';
}
.date {	
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #9ab0cb !important;padding: 3px 5px;border-radius: 4px;';
}
.time {	
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #FF5733 !important;padding: 3px 5px;border-radius: 4px;';
}
.organization {	
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #3361FF !important;padding: 3px 5px;border-radius: 4px;';
}
.len {
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #FF33F6 !important;padding: 3px 5px;border-radius: 4px;';
}
.phone {
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #33FFFF !important;padding: 3px 5px;border-radius: 4px;';
}
.money {
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #F633FF !important;padding: 3px 5px;border-radius: 4px;';
}
.law { 
    display: inline-block !important;margin: 1px;color: #FFF !important;background-color: #FF3333 !important;padding: 3px 5px;border-radius: 4px;';
}

</style>
<script>

//var tag = {LOCATION:"LOCALTION", DATE:"DATE", TIME:"TIME" , EMAIL: "EMAIL", LEN: "LEN", ORGANIZATION : "ORGANIZATION", PERSON : "PERSON", : "", : "", : "", : "", : "", : "", : "", : ""
//, : "", : "", : ""};

$(document).ready(function() {

   function getTagText(txt) {

            // $.get( "http://localhost:8000/itemsTag/<?=$model->id?>", function( data ) {
                //alert( "Data Loaded: " + data );
                // console.log("Data Loaded: " + data.text );
                var d = '';
                // d = data.text;

                d = 'หนุ่มเมาเหล้า แวะทักคนผิด เวิ่นเว้อไม่จบ โดนชกแล้วคว้ามีดแทง หนีชนประตูล้มลงกลางทาง ถูกตามแทงซ้ำกลางอก ดับจมกองเลือด ส่วนมือมีดขี่ จยย.หลบหนี เมื่อ<TIME class="time">ช่วงเย็น</TIME>วันที่ 3 ธ.ค.63 <PERSON class="person">ร.ต.อ.ศุภณัฐ สิงห์สุวรรณ</PERSON> รอง <ORGANIZATION class="organization">สว.</ORGANIZATION> สอบสวน <LOCATION class="location">สภ.เมืองนครราชสีมา</LOCATION> รับแจ้งเหตุมีคนถูกแทงเสียชีวิต ภายใน<LOCATION class="location">ซอยเบญจรงค์</LOCATION> ซอย 8 2 ม.4 สะเตง <LOCATION class="location">อำเภอเมืองยะลา</LOCATION> <LOCATION class="location">จ.ยะลา</LOCATION> พิกัด 6.551641893242722 101.29908170857809 จึงรุดไปตรวจสอบ พร้อมเจ้าหน้าที่<ORGANIZATION class="organization">กู้ภัยสว่างเมตตาธรรมสถาน</ORGANIZATION> ที่เกิดเหตุพบศพ <PERSON class="person">นาย สมชาย แสงดี</PERSON> อายุ 43 ปี อยู่บ้านเลขที่ 51 ม.4 สะเตง <LOCATION class="location">อำเภอเมืองยะลา</LOCATION> <LOCATION class="location">จ.ยะลา</LOCATION>นอนเสียชีวิตอยู่บนถนน สภาพถูกแทงบริเวณหน้าอกด้านซ้าย 1 แผล เลือดไหลนองเต็มพื้นถนน เจ้าหน้าที่กู้ภัยพยายามช่วยกันปั๊มหัวใจ เพื่อช่วยชีวิตนานกว่า <TIME class="time">10 นาที</TIME> แต่ไม่เป็นผล เสียชีวิตในเวลาต่อมา จากการสอบถาม <PERSON class="person">นายวิรัตน์ ภูมิยาง</PERSON> อายุ <TIME class="time">34 ปี</TIME> ผู้อยู่ในเหตุการณ์ เล่าว่า ตนนั่งดื่มเหล้าบริเวณหน้าห้องพักกับ <PERSON class="person">นายแกะ</PERSON> ซึ่งเป็นคนรู้จักกัน แต่ไม่สนิทจึงไม่ทราบชื่อจริง และเพิ่งแวะมาหาตนที่ห้องพักเป็นครั้งแรกเท่านั้น ส่วนผู้ตายเดินมาลักษณะเหมือนเมามาแล้ว เปิดประตูรั้วเข้ามาหาพร้อมกับเรียกตนว่าต้น ตนจึงตอบกับไปว่าตนชื่อหมูไม่ได้ชื่อต้น ส่วน <PERSON class="person">นายแกะ</PERSON> ก็บอกว่าทักผิดคนแล้ว ที่นี่ไม่มีคนชื่อต้น แต่ผู้ตายยังไม่ยอมออกไปยังพูดจาเหมือนจะขอกินเหล้าด้วย <PERSON class="person">นายแกะ</PERSON> จึงลุกขึ้นชกผู้ตาย ระหว่างนั้น <PERSON class="person">นายแกะ</PERSON> ได้หยิบมีดพับที่พกมาในกระเป๋า แทงเข้าไป 1 ที แต่ไม่โดน ผู้ตายวิ่งหนีชนประตูเหล็กจนพัง ก่อนจะไปเสียหลักล้มลงกลางถนน ห่างหน้าห้องพักตนประมาณ <LEN>10 เมตร</LEN> จากนั้น <PERSON class="person">นายแกะ</PERSON> วิ่งตามไป จึงใช้มีดแทงเข้าไปที่หน้าอกผู้ตาย 1 ครั้ง ก่อนจะขี่รถจักรยานยนต์หลบหนีไป ตนจึงรีบโทรศัพท์แจ้งเจ้าหน้าที่ตำรวจมาตรวจสอบดังกล่าว เบื้องต้นตำรวจรู้ตัวคนร้ายแล้ว ตอนนี้อยู่ระหว่างการติดตามจับกุมตัวมาดำเนินคดีตามกฎหมายต่อไป';
                
                d = d.replaceAll('<DATE>','<DATE class="date">');
                d = d.replaceAll('<TIME>','<TIME class="time">');
                d = d.replaceAll('<EMAIL>','<EMAIL class="email">');
                
                d = d.replaceAll('<LOCATION>','<LOCATION class="location">');
                d = d.replaceAll('<ORGANIZATION>','<ORGANIZATION class="organization">');
                d = d.replaceAll('<PERSON>','<PERSON class="person">');
                d = d.replaceAll('<PHONE>','<PHONE class="phone">');
                d = d.replaceAll('<URL>','<URL class="url">');
                d = d.replaceAll('<Money>','<Money class="money">');
                d = d.replaceAll('<LAW>','<LAW class="law">');
                
                
                

                //$('#text_display').text(d); // data.text
                // $('#text_display').text(d);
                $('#text_display2').html(d);

                

            // });
        }
        getTagText('<?=$model->text_extract;?>');

        var date = [];
        var time = [];
        var email = [];
        var location = [];
        var organization = [];
        var person = [];
        var phone = [];
        var url = [];
        var money = [];
        var law = [];

        push_array_and_show("organization");
        push_array_and_show("person");
        push_array_and_show("location");
        push_array_and_show("law");

        function push_array_and_show(value){
            var data_all = [];
            var html_design = [];
            $("."+value).each(function() {
                data_all.push($(this).html());
                html_design.push(`<span style="">${$(this).html()}</span>`);
            });

            var data = unique(data_all);
            var html_show = unique(html_design);

            if ($("#"+value).length > 0) {
                $("#"+value).html(html_show.join("<br> "));
            }

            if (value=='date') {
                date = data;
            }
            if (value=='time') {
                time = data;
            }
            if (value=='email') {
                email = data;
            }
            if (value=='location') {
                location = data;
            }
            if (value=='organization') {
                organization = data;
            }
            if (value=='person') {
                person = data;
            }
            if (value=='phone') {
                phone = data;
            }
            if (value=='url') {
                url = data;
            }
            if (value=='money') {
                money = data;
            }
            if (value=='law') {
                law = data;
            }

            // update_data_json();
        }

        

        var data_json = [];
        // function update_data_json(){
            data_json = [{
                "date": date,
                "time": time,
                "email": email,
                "location": location,
                "organization":organization,
                "person": person,
                "phone": phone,
                "url": url,
                "money": money,
                "law": law
            }
            ];
            console.log(data_json);
        // }

        function unique(list) {
          var result = [];
          $.each(list, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
          return result;
      }


  })  



</script>  

<div class="row">
    <div class="col-8">
        <div>
            <div class="card-header bg-secondary text-white">
                <dt>ข้อมูล</dt>
            </div>
            <br>
            <div id="text_display"></div>
            <hr>
            <div id="text_display2"></div>

        </div>
    </div>
    <div class="col-4">

        <div class="card-header bg-secondary text-white">
            <dt>ประเภทข้อมูล - บุคคล</dt>
        </div> <br>
        <div id="person"></div>
        <!-- <span style="<?=$style_person?>">นายอาทิตย์ โฉมเนตร  </span>
        <span style="<?=$style_person?>">พ.ต.อ.ปรีชา เพ็งเภา</span>
        <span style="<?=$style_person?>">พ.ต.อ.ปรีชา เพ็งเภา</span>
        <span style="<?=$style_person?>">นายอาทิตย์ โฉมเนตร  </span>
        <span style="<?=$style_person?>">นายสมชาย เรียนดี</span>
        <span style="<?=$style_person?>">พ.ต.อ.ไกรวิทย์ อุณหก้องไตรภพ </span> -->
        <br><br>
        <div class="card-header bg-secondary text-white">
            <dt>ประเภทข้อมูล - สถานที่</dt>
        </div>
        <br>
        <div id="location"></div>
       <!--  <span style="<?=$style_place?>"> จ.ปัตตานี พิกัด 6.541780928792409, 101.27767520810859 </span> 
        <span style="<?=$style_place?>">โรงพยาบาลศิริราช</span>
        <span style="<?=$style_place?>">ปากซอยจรัญสนิทวงศ์ 6 </span> -->
        <br><br>
        <div class="card-header bg-secondary text-white">
            <dt>ประเภทข้อมูล - พฤติกรรม</dt>
        </div>
        <br>
        <div id="law"></div>
        <!-- <span style="<?=$style_behavior?>">  มือปืนโหดพฤติกรรมอุกอาจ บุกจ่อยิงหมดโม่ดับวิศวกรพ่อลูกอ่อนคาร้านบะหมี่จับกัง </span>  -->
        <br><br>
        <div class="card-header bg-secondary text-white">
            <dt>ประเภทข้อมูล - องค์กร</dt>
        </div>
        <br>
        <div id="organization"></div>


        
    </div>

</div>
