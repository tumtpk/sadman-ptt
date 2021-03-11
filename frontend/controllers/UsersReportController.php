<?php

namespace frontend\controllers;

use Yii;
use app\models\UsersReport;
use app\models\UsersReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
date_default_timezone_set("Asia/Bangkok");

/**
 * UsersReportController implements the CRUD actions for UsersReport model.
 */
class UsersReportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UsersReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportDesignManySourcesPdf() {
        $this->layout = false;
        return $this->render('report-design-many-sources-pdf');
    }

    public function actionJson_report_design_many_sources() {
        $this->layout = false;
        return $this->render('json_report_design_many_sources');
    }



    /**
     * Displays a single UsersReport model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsersReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsersReport();
        if ($model->load(Yii::$app->request->post())) {
           $model->date_record = date("Y-m-d H:i:s");
           $model->logo_report = $model->upload($model,'logo_report');
           if($model->save())
              return $this->redirect(['view', 'id' => $model->id]);

      }

      return $this->render('create', [
        'model' => $model,
    ]);
  }

    /**
     * Updates an existing UsersReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
           $model->date_record = date("Y-m-d H:i:s");
           $model->logo_report = $model->upload($model,'logo_report');
           if($model->logo_report!=$_POST['file_name_old']){
            if(!empty($_POST['file_name_old'])){
                unlink('../../images/logo_users_report/'.$_POST['file_name_old']);
            }
        }
        if($model->save())
          return $this->redirect(['view', 'id' => $model->id]);
      
  }

  return $this->render('update', [
    'model' => $model,
]);
}

    /**
     * Deletes an existing UsersReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        unlink('../../images/logo_users_report/'.$model->logo_report);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the UsersReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
