<?php

namespace frontend\controllers;

use Yii;
use app\models\EformData;
use app\models\EformDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EformDataController implements the CRUD actions for EformData model.
 */
class EformDataController extends Controller
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
     * Lists all EformData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EformDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EformData model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionPrintPdfCsv()
    {
        $this->layout = false;
        return $this->render('print-pdf-csv');
    }

    public function actionPrintPdf()
    {
        $this->layout = false;
        return $this->render('print-pdf');
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewProcess($id)
    {
        return $this->render('view-process', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewPerson($id)
    {
        return $this->render('view-person', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionUpdateProcess()
    {
        return $this->render('update-process');
    }

    public function actionViewManageWord($id)
    {
        return $this->render('view-manage-word', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPrintReportRecord()
    {
        $this->layout = false;
        return $this->render('print-report-record');
    }

    public function actionViewTest($id)
    {
        return $this->render('view-test', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApprove_status($id)
    {
        return $this->render('approve_status', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new EformData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EformData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EformData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EformData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EformData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EformData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EformData::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
