<?php
use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FileUploadList */

$eform_template = "SELECT detail as dt FROM `eform` WHERE form_id = '".$model->form_id."' AND active = '1' AND unit_id = '".$_SESSION['unit_id']."'";
$eft = Yii::$app->db->createCommand($eform_template)->queryOne();

$this->title = $model->origin_file_name;
$this->params['breadcrumbs'][] = ['label' => 'ไฟล์จากแฟ้มข้อมูล'.$eft['dt'], 'url' => ['site/pages','view'=>'file-manager-type','form_id'=>$model->form_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url_node = Yii::$app->db->createCommand("SELECT setting_value FROM `setting` WHERE setting_name = 'url_node'")->queryOne();


function checkstatus($val){
    $status = array("0"=>"ยังไม่นำเข้", "1"=>"นำเข้าข้อมูล","2"=>" ไม่สามารถนำเข้าได้");
    return $status[$val];
}
?>
<div class="file-upload-list-view">
    <? #=$model->text_extract?>
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <button class="btn save-btn btn-primary" onclick="showfiles('<?=$model->file_name;?>','<?=$model->id;?>','<?=$model->bucket;?>');"><i class="fa fa-file"></i> เปิดไฟล์</button>
                        <!-- <a href="index.php?r=file-upload-list/manage_words&id=<?=$model->id;?>" class="btn  btn-primary" ><i class="fa fa-cogs"></i> ประมวลผลคำ</a> -->
                        <a href="index.php?r=file-upload-list/words_cut&id=<?=$model->id;?>" class="btn  btn-primary" ><i class="fa fa-cogs"></i> word cut</a>
                        <button class="btn save-btn btn-primary deldata" data-file-id="<?=$model->id;?>" data-name-file="<?=$model->file_name;?>" data-name-bucket="<?=$model->bucket;?>"><i class="fa fa-trash"></i> ลบไฟล์</button>

                        

                        

                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'bucket',
                            'file_name',
                            [
                                'label'=>'ชื่อไฟล์เดิม',
                                'attribute'=>'origin_file_name',
                            ],
                            /* [
                                'attribute'=>'text_extract',
                                'header'=>'',
                                'contentOptions' => ['class' => 'show-tag'],
                            ], */
                            [
                                'attribute'=>'text_extract',
                                'contentOptions' => ['class' => 'show-text'],
                            ],
                            [
                                'attribute'=>'form_id',
                                'format'=>'raw',
                                'value' => function($model)
                                {

                                    $eform_template = "SELECT detail as dt FROM `eform` WHERE form_id = '".$model->form_id."' AND active = '1' AND unit_id = '".$_SESSION['unit_id']."'";
                                    $eft = Yii::$app->db->createCommand($eform_template)->queryOne();
                                    return $eft['dt'];

                                },
                            ],
                            [
                                'attribute'=>'status_upload',
                                'format'=>'raw',
                                'value' => function($model)
                                {

                                    if(!empty($model->eform_data_id)){
                                        $sql_form = "SELECT * FROM `eform_data` WHERE id = '".$model->eform_data_id."'";

                                        $eform_data = Yii::$app->db->createCommand($sql_form)->queryOne();

                                        $eform = Yii::$app->db->createCommand("SELECT * FROM `eform` WHERE id = '".$eform_data['eform_id']."'")->queryOne();
                                    }

                                    $status_upload = ($model->status_upload=='1') ? '<a href="index.php?r=eform-data/view&id='.$model->eform_data_id.'" target="_blank">'.$eform['detail'].' : '.DateThaiTime($eform_data['date_time']).'</a>' : 'ไฟล์จากแฟ้มข้อมูล';
                                    return $status_upload;
                                },
                            ],
                            [
                                'label'=>'ผู้บันทึกข้อมูล',
                                'attribute'=>'user_create',
                                'format'=>'raw',
                                'value' => function($model)
                                {
                                    $user = Yii::$app->db->createCommand("SELECT * FROM `users` WHERE id = '".$model->user_create."'")->queryOne();
                                    return $user['name'];
                                },
                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'raw',
                                'value' => function($model)
                                {
                                    return checkstatus($model->status);
                                },
                            ],
                            [
                                'label'=>'สถานะการประมวลผลเป็นข้อความ',
                                'attribute'=>'status_text_extract',
                                'format'=>'raw',
                                'value' => function($model)
                                {
                                    if($model->status_text_extract==0){
                                        $status_text_extract = 'ยังไม่ประมวลผล';
                                    }else if($model->status_text_extract==1){
                                        $status_text_extract = 'ประมวลผลสำเร็จ';
                                    }else{
                                        $status_text_extract = 'ประมวลผลไม่สำเร็จ';
                                    }
                                    return $status_text_extract;
                                },
                            ],


                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function getTagText(txt) {
             //alert(txt);
             $('.show-tag').html(''+txt);
        }    
        getTagText('<?=$model->text_extract;?>');

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
    <?php
    $url_elasticsearch =  $Setting = Setting::find()->where(['setting_name' => 'url_elasticsearch'])->one()->setting_value;    
    ?>
    var text = '<?=$model->text_extract;?>';

    if (text!='null') {
        var res2 = text.replace(/-/g, ' ');
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


  $('.show-text').html(''+showdata.join(""));
});

}

});

    function showfiles(file_name,file_id,bucket) {
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
    }


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
                alert('ลบไฟล์สำเร็จ');
                window.location='index.php?r=site/pages&view=file-manager-type&form_id=<?=$model->form_id;?>';
            }
        });
    }
</script>  
