<?php 
$this->title = 'Report Design Multiple';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.text-right{
		float: right;
	}
	.btn-width{
		width: 100%;
	}
</style>
<div class="row">
	<div class="col-md-12 mt-3">
		<h4>Report Design Multiple <i class="fa fa-question-circle" aria-hidden="true" data-toggle="modal" data-target="#exampleModal"></i></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h2 class="card-title"><dt>Title</dt></h2>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-lg btn-primary text-right">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</button>
					</div>

					<div class="col-md-12">
						<div class="card">
							<div class="card-header bg-secondary text-white">
								Row 1 [column 12]
							</div>
							<div class="card-body" style="height: 100px;">
								---
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card">
							<div class="card-header bg-secondary text-white">
								Row 2 [column 3]
							</div>
							<div class="card-body" style="height: 100px;">
								---
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">

		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h2 class="card-title"><dt>Title</dt></h2>
			</div>
			<div class="card-body" style="height: 100px;">

			</div>
		</div>

		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h2 class="card-title"><dt>Title</dt></h2>
			</div>
			<div class="card-body" style="height: 100px;">

			</div>
		</div>

		<div class="card">
			<div class="card-header bg-secondary text-white">
				<h2 class="card-title"><dt>Title</dt></h2>
			</div>
			<div class="card-body" style="height: 100px;">
				<div class="row">
					<div class="col-md-4">
						<div class="btn btn-secondary btn-width">Text area</div>
					</div>
					<div class="col-md-4">
						<div class="btn btn-secondary btn-width">แผนที่</div>
					</div>
					<div class="col-md-4">
						<div class="btn btn-secondary btn-width">รูปภาพ</div>
					</div>
				</div>
			</div>
		</div>


	</div>

</div>
<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-2">
		<button type="submit" class="btn btn-lg btn-primary">บันทึก</button>
		<button type="reset" class="btn btn-lg btn-danger">ยกเลิก</button>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">คำแนะนำ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        -
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>