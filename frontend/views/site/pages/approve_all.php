<?php
use app\models\Setting;
use app\models\FileUploadList;
$this->title = 'อนุมัติข่าวสาร';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
.iconall{
    content: "\e001";
    background-color: #dab90a;
    padding: 16px;
    border: -32;
    border-radius: 50px;
    color: #fff;
    text-align: center !important;
    font-size: 49;
   
}
.bbt{
  border-radius: 30px;
  margin-top: 20;
}
.top{
  margin-top: 10;
    margin-bottom: 20;
}

.card{
  padding: 0em 1em 1em 1em;
}
</style>


<div class="row">
  <div class="col-12 col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="row ">
          <div class="col-9 col-md-9">
            <h2 class=""><b>HUMINT  120</b></h2>
          </div>
          <div class="col-3 col-md-3">
            <div class=" text-center top">
              <i class="icon-bell iconall"></i> 
            </div>
          </div><hr>
          <div class="col-6 col-md-6 top">
            <h5>การแจ้งข่าว</h5>             <!-- class="card-title" -->
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
          <div class="col-6 col-md-6 top">
            <h5>การแจ้งเหตุ</h5>             <!-- class="card-title" -->
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <div class="col-12 col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="row ">
          <div class="col-9 col-md-9">
            <h2 class=""><b>เครื่องมือข่าว</b></h2>
          </div>
          <div class="col-3 col-md-3">
            <div class=" text-right top">
              <i class="icon-bell iconall"></i> 
            </div>
          </div><hr>
          <div class="col-6 col-md-6 top">
            <h5>อุปกรณ์</h5>             <!-- class="card-title" -->
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
          <div class="col-6 col-md-6 top">
            <h5>สายข่าว</h5>             <!-- class="card-title" -->
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="row ">
          <div class="col-9 col-md-9">
            <h2 class=""><b>อื่นๆ</b></h2>
          </div>
          <div class="col-3 col-md-3">
            <div class=" text-right top">
              <i class="icon-bell iconall"></i> 
            </div>
          </div><hr>
          <div class="col-12 col-md-12 top">
            <h5>ข้อมูลข่าวในอดีต</h5>             <!-- class="card-title" -->
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div>
          <!-- <div class="col-6 col-md-6 top">
            <h5>การแจ้งเหตุ</h5>            
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-1 col-md-1">
                <i class="icon-arrow-right"></i> 
              </div> 
              <div class="col-11 col-md-11">
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              </div>
            </div>
            <a href="#" class="btn btn-primary bbt">Go somewhere</a>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
