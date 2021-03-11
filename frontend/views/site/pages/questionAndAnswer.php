<?php
use yii\helpers\Html;
$this->title = 'คำถามที่พบบ่อย';

?>
<h4><?= Html::encode($this->title);?></h4>
<div class="row clearfix">

	<?php
	$sql = Yii::$app->db->createCommand("SELECT * FROM `question_and_answer` WHERE qa_status = 1 ORDER BY qa_slot ASC")->queryAll();
	$i=1;
	foreach ($sql as $row){
		?>

		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card card-QA card-collapsed">
				<div class="card-header">
					<h4 class="card-title">
						<b><?php echo $i.'. '.$row['qa_questions'];?></b>
					</h4>
					<div class="card-options">
						<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
					</div>
				</div>
				<div class="card-body">
					<?php echo $row['qa_answer'];?>
				</div>
			</div>
		</div>
	<?php $i++; } ?>

</div>