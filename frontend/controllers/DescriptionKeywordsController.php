<?php

namespace frontend\controllers;

use Yii;
use app\models\DescriptionKeywords;
use app\models\DescriptionKeywordsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DescriptionKeywordsController implements the CRUD actions for DescriptionKeywords model.
 */
class DescriptionKeywordsController extends Controller
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
     * Lists all DescriptionKeywords models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DescriptionKeywordsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DescriptionKeywords model.
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
     * Creates a new DescriptionKeywords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DescriptionKeywords();

        if ($model->load(Yii::$app->request->post())) {
            $model->images = $model->upload($model,'images');
            
        
        if($model->save())
          return $this->redirect(['view', 'id' => $model->id]);
  } 
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DescriptionKeywords model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

        

            $model->images = $model->upload($model,'images');
            if($model->images!=$_POST['file_name_old']){
                if(!empty($_POST['file_name_old'])){
                    unlink('../../images_keywords/'.$_POST['file_name_old']);
                }
            }

            if($model->save(false))
                return $this->redirect(['view', 'id' => $model->id]);
      } else {

        $errors = $model->errors;
    }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DescriptionKeywords model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $data = FileList::findOne($id);
        //$path = 'https://www.friends1935.com/';
        unlink('../../images_keywords/'.$model->images);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DescriptionKeywords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DescriptionKeywords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DescriptionKeywords::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
