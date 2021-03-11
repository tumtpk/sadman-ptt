<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Setting;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FileUploadListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Upload Lists';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                    <div class="row clearfix">
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลทั้งหมด </h6>
                                    <h3 class="pt-3"><span class="counter">18,960</span></h3>
                                    <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 5.27%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลที่นำมาแสดงบนแผนที่ได้</h6>
                                    <h3 class="pt-3"><span class="counter">11,783</span></h3>
                                    <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 11.38%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลที่ไม่มีพิกัดบนแผนที่</h6>
                                    <h3 class="pt-3"><span class="counter">2,254</span></h3>
                                    <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 9.61%</span> Since last month</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลอื่น</h6>
                                    <h3 class="pt-3"><span class="counter">8,751</span></h3>
                                    <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 2.27%</span> Since last month</span>
                                        
                                </div>
                                    
                                </div>
                            </div>
                        </div>
</div> -->

<!-- <div class="card">
                <div class="card-body ribbon">

                    <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <h6>ข้อมูลอื่น</h6>
                                    <h3 class="pt-3"><span class="counter">8,751</span></h3>
                                    <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 2.27%</span> Since last month</span>
                                        
                                </div>
                                    
                     </div></div>

                </div>
</div> -->                


<div class="file-upload-list-index">
    
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row clearfix">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body ribbon">
                    <p>
                        <?//= Html::a('Create File Upload List', ['create'], ['class' => 'btn btn-success']) ?>
                        <h5>สืบค้นข้อมูล File Upload Lists</h5>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'bucket',
                            'file_name',
                            'origin_file_name',
                            'text_extract:ntext',
                            'form_id',

                            [
                                'format'=>'raw',
                                'attribute' => 'Action',
                                'headerOptions' => ['style' => 'width:300px !important;'],
                                'value' => function($data){
                                    return 
                                    '<button class="btn btn-info btn-sm" onclick = "extractText(\''.$data->id.'\',\''.$data->file_name.'\',\''.$data->bucket.'\');">Extract</button> '.
                                    //Html::a('Format Text', ['#'], ['title' => 'Format','class'=>'btn btn-info','onclick'=>"alert('');"]).' '.
                                    Html::a('รายละเอียด', ['view','id'=>$data->id], ['title' => 'view','class'=>'btn btn-success btn-sm']).' '.
                                    Html::a('ลบ', ['delete', 'id' => $data->id], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);

                                },

                            ],


                            // ['class' => 'yii\grid\ActionColumn'],
                            
                        ],
                    ]); ?>
                    <script>
                        function extractText(file_id,file_name,bucket){

                                var url = '<?=Setting::find()->where(['setting_name' => 'url_node'])->one()->setting_value?>/readfile?namefile='+file_name+'&bucket='+bucket;
                                //alert(url);
                                $('#exampleModal').modal('show');
                                $('#data').html('On Process... <br> <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>');

                                    $.ajax({
                                        method: "GET",
                                        url: url,
                                        //data: { namefile: file_name, bucket: bucket }
                                    })
                                    .done(function( msg ) {    
                                        if(msg.text===null) $('#data').html('Can not extract text from file !!!');
                                        else{ 
                                            $('#data').html('#data = '+msg.text); 
                                            // insert to DB
                                            console.log(msg.text);
                                                $.ajax({
                                                    method: "POST",
                                                    url: 'index.php?r=site/insert-extract',
                                                    data: { file_id : file_id ,  file_name: file_name, text: JSON.stringify(msg.text) }
                                                })
                                                .done(function( msg ) {  
                                                    //alert(msg);
                                                    console.log(msg);
                                                })
                                            // insert to DB
                                        }
                                    });
                                

                        }
                    </script>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Extract text from file</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
