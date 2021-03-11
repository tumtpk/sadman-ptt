<?  use app\models\Setting;
use app\models\FileUploadList;
?>

<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-yellow"><i class="fa fa-building"></i> </div>
                        <div class="content">
                            <span>Properties</span>
                            <h5 class="number mb-0">53,251</h5>
                        </div>
                    </div>                        
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-green"><i class="fa fa-area-chart"></i> </div>
                        <div class="content">
                            <span>Growth</span>
                            <h5 class="number mb-0">62%</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-blue"><i class="fa fa-shopping-cart"></i> </div>
                        <div class="content">
                            <span>Total Sales</span>
                            <h5 class="number mb-0">$3205</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body top_counter">
                        <div class="icon bg-indigo"><i class="fa fa-tag"></i> </div>
                        <div class="content">
                            <span>Rented</span>
                            <h5 class="number mb-0">3,217</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card google w_social">
                    <div id="w_social1" class="carousel slide" data-ride="carousel" data-interval="2000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <i class="fa fa-google-plus fa-2x"></i>
                                <p>18th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form WrapTheme</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="fa fa-google-plus fa-2x"></i>
                                <p>28th Mar</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form Epic Theme</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card twitter w_social">
                    <div id="w_social2" class="carousel vert slide" data-ride="carousel" data-interval="2000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <i class="fa fa-twitter fa-2x"></i>
                                <p>23th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form Epic Theme</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="fa fa-twitter fa-2x"></i>
                                <p>25th Jan</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form WrapTheme</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card facebook w_social">
                    <div id="w_social2" class="carousel vert slide" data-ride="carousel" data-interval="2000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <i class="fa fa-facebook fa-2x"></i>
                                <p>20th Jan</p>
                                <h4>Now Get <span>50% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form Theme</i></div>
                            </div>
                            <div class="carousel-item">
                                <i class="fa fa-facebook fa-2x"></i>
                                <p>23th Feb</p>
                                <h4>Now Get <span>Up to 70% Off</span><br>on buy</h4>
                                <div class="mt-20"><i>- post form Theme</i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>                                

<!-- End  -->                
<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>จำนวนไฟล์ที่อัพโหลดทั้งหมด</h6>
                                <h3 class="pt-3"><span class=" couterfileall">
                                    <?//=FileUploadList::find()->count()?>
                                </span></h3>
                                <!-- <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 5.27%</span> Since last month</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>จำนวนไฟล์ที่นำเข้า Database</h6>
                                <h3 class="pt-3"><span class=" couterfilestatus1">
                                    <?//=FileUploadList::find()->where(['status' => '1'])->count()?>
                                </span></h3>
                                <!-- <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 11.38%</span> Since last month</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>จำนวนไฟล์ที่ประมวลผลแล้ว</h6>
                                <h3 class="pt-3"><span class=" couterfilestatus0">
                                    <?//=FileUploadList::find()->where(['status' => '0'])->count()?>
                                </span></h3>
                                <!-- <span><span class="text-success mr-2"><i class="fa fa-long-arrow-up"></i> 9.61%</span> Since last month</span> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6>จำนวนไฟล์ที่ประมวลผลไม่ได้</h6>
                                <h3 class="pt-3"><span class=" couterfilestatus2">
                                    <?//=FileUploadList::find()->where(['status' => '2'])->count()?>
                                </span></h3>
                                <!-- <span><span class="text-danger mr-2"><i class="fa fa-long-arrow-down"></i> 2.27%</span> Since last month</span> -->

                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="row"> 
                <!--         <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Accessed Files</h3>
                        <div class="card-options">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#uploadModal" data-dismiss="modal"><i class="fa fa-plus" data-toggle="tooltip" data-placement="right" title="Upload New"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="file_folder">
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-folder text-success"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Family</p>
                                    <small>3 File, 1.2GB</small>
                                </div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-file-word-o text-primary"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Report2017.doc</p>
                                    <small>Size: 68KB</small>
                                </div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="icon">
                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                </div>
                                <div class="file-name">
                                    <p class="mb-0 text-muted">Report2017.pdf</p>
                                    <small>Size: 68KB</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload ไฟล์ที่ไม่เกี่ยวข้องกับแฟ้มข้อมูลใดๆ</h3>
                                    <!-- <div class="card-options">                                
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#uploadModal" data-dismiss="modal"><i class="fa fa-plus" data-toggle="tooltip" data-placement="right" title="Upload New"></i></a>
                                    </div> -->
                                </div>

                                <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"></span> <p>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" name="multiple_files" id="multiple_files" multiple="multiple" required="required"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                            </div>

                        </div>
                    </div>


                    <div class="show-status text-center">

                    </div>
                    <div class="card bg-none b-none">
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-vcenter table_custom text-nowrap spacing5 text-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>โฟลเดอร์</th>
                                            <th>Share With</th>
                                            <th></th>
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
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <!-- Upload -->


               </div>

           </div>
       </div>
   </div>

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
    // couterfile('couterfileall');
    // couterfile('couterfilestatus1');
    // couterfile('couterfilestatus0');
    // couterfile('couterfilestatus2');
    var showlist = new Array();

    function couterfile(gettype){
        $.ajax({
            url:"index.php?r=site/insert_file_upload_list&type="+gettype,
            method:"GET",
            dataType:"json",
            contentType: "application/json; charset=utf-8",
            success:function(data)
            {
                // console.log(gettype+' = '+data.couterfile);
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
                console.log('Log - '+data);
                $.each(data, function(index) {
                    if(jQuery.inArray(data[index].name, ['textx','webboardtextx']) == -1)
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
                    <td>
                    -
                    </td>
                    <td class="width100">
                    <span>Me</span>
                    </td>
                    <td class="width100">
                    <span>${last_update}</span>
                    </td>
                    <td class="width100 text-center">
                    <span class="size"> ${kb.toFixed(2)} KB </span>
                    </td>
                    </tr>`);
                $("#menu").html(showlist.join(","));
            }
        });


    }


});
</script>

<!-- <script src="../../html-version/assets/bundles/lib.vendor.bundle.js"></script>

<script src="../../html-version/assets/js/core.js"></script> -->
