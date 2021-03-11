<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Kendo UI Snippet</title>
  <link rel="stylesheet" href="../../draggable/kendo.default-v2.min.css"/>
  <script src="../../draggable/jquery-1.12.4.min.js"></script>
  <script src="../../draggable/kendo.all.min.js"></script>
  <link rel="stylesheet" href="../../html-version/assets/css/style_draggable.css"/>
</head>
<body>
<?
$this->title = 'จัดกลุ่มผู้ใช้งาน';
$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="row clearfix">
    <div class="col-xl-12 col-lg-12 col-md-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><dt>จัดกลุ่มผู้ใช้งาน</dt></h2>
        </div>
        <div class="card-body ribbon">
          <div id="message"></div>
          <div class="row">
            <div class="col-md-6" >
              <input type="text" id="search_group" class="form-control" placeholder="ค้นหากลุ่มผู้ใช้งาน">
              <div id="dynamic_group"></div>
            </div>
            <div class="col-md-6">
              <input type="text" id="search_user" class="form-control" placeholder="ค้นหาข้อมูลบุคคล">
             <div id="dynamic_user"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

 <script>
  $(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
      $.ajax({
        url:"index.php?r=site/fetch-draggable-group",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_group').html(data);
        }
      });
    }

    $(document).on('click', '.click-page-link', function(){
      var page = $(this).data('page_number');
      var query = $('#search_group').val();
      load_data(page, query);
    });

    $('#search_group').keyup(function(){
      var query = $('#search_group').val();
      load_data(1, query);
    });

  });
</script>
<script>
  $(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
      $.ajax({
        url:"index.php?r=site/fetch-draggable-user",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_user').html(data);
        }
      });
    }

    $(document).on('click', '.click-page-link-user', function(){
      var page = $(this).data('page_number');
      var query = $('#search_user').val();
      load_data(page, query);
    });

    $('#search_user').keyup(function(){
      var query = $('#search_user').val();
      load_data(1, query);
    });

  });
</script>
</body>
</html>