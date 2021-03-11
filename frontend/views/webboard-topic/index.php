<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\WebboardForum;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WebboardTopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'กระดานข่าว';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webboard-topic-index">
	<a href=""></a>

	<h4><?= Html::encode($this->title) ?></h4>
	<div class="row clearfix">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body ribbon">

					<p>
						<?= Html::a('เพิ่มกระดานข่าว', ['create'], ['class' => 'btn btn-success']) ?>
					</p>

					<?php Pjax::begin(); ?>
					<?php echo $this->render('_search', ['model' => $searchModel]); ?>

					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'columns' => [
							['class' => 'yii\grid\SerialColumn'],

							[
								'attribute'=>'topic_name',
								'format'=>'raw',
								'value' => function($model, $key, $index)
								{
									if (!empty($model->topic_name)) {
										return '<a href="index.php?r=webboard-topic/view&id='.$model->topic_id.'">'.$model->topic_name.'</a>';
									}
								},
							],
							[
								'attribute'=>'topic_detail',
								'format'=>'raw',
								'value' => function($model, $key, $index)
								{
									if (strlen($model->topic_detail)>90) {
										return iconv_substr($model->topic_detail, 0, 90, 'utf-8')."...";
									}else{
										return $model->topic_detail;
									}
								},
							],
							[
								'label' => 'หมวดหมู่',
								'attribute' => 'forum_id',
								'format' => 'raw',
								'value' => function ($model, $key, $index) {
									if (!empty($model->forum_id)) {
										$query = WebboardForum::find()
										->select('forum_id,forum_name')
										->where("forum_id = " . $model->forum_id)->one();
										return $query->forum_name;
									}
								},
							],
							'topic_view',
							'topic_reply',
							[
								'attribute'=>'status_del',
								'format'=>'raw',
								'value' => function($model, $key, $index)
								{
									if ($_SESSION['user_role']=='1') {
										if ($model->status_del=='1') {
											return 'ใช้งาน';
										}else{
											return 'ยกเลิก';
										}

									}
								},
								'visible' => $_SESSION['user_role']=='1' ? true : false
							],
							['class' => 'yii\grid\ActionColumn',
							'buttons' => [
								'view' => function ($url, $model, $key) {
									return false;
								},
								'update' => function ($url, $model, $key) {
									if($_SESSION['user_id']==$model->topic_user_create || $_SESSION['user_role']=='1'){
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
											['webboard-topic/update', 'id' => $model->topic_id]
										);
									}else{
										return false;
									}
								},
								'delete' => function ($url, $model, $key) {
									if($_SESSION['user_role']=='1') {
										return  Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->topic_id], ['data' => ['confirm' => Yii::t('app', 'ต้องยกเลิกกระดานข่าวใช่หรือไม่?'),'method' => 'post','title'=>'Delete'],]);
									}else if($model->topic_user_create==$_SESSION['user_id']){
										return  Html::a('<span class="glyphicon glyphicon-trash"></span>', ['update_status_del', 'id' => $model->topic_id], ['data' => ['confirm' => Yii::t('app', 'ต้องยกเลิกกระดานข่าวใช่หรือไม่?'),'method' => 'post','title'=>'Delete'],]);
									}else{
										return false;
									}
								},
							]
						]
					],
				]); ?>

				<?php Pjax::end(); ?>
			</div>
		</div>
	</div>
</div>

</div>


