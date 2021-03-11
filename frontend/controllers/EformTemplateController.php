<?php

namespace frontend\controllers;

use Yii;
use app\models\EformTemplate;
use app\models\EformTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EformTemplateController implements the CRUD actions for EformTemplate model.
 */
class EformTemplateController extends Controller
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
        'access' => [
          'class' => \yii\filters\AccessControl::className(),
          'only' => ['index', 'create', 'update', 'delete', 'view','eforms_dashboard'],
          'rules' => [
            [
              'allow' => !Yii::$app->user->isGuest
              && in_array($_SESSION['user_role'], array(1)),
              'actions' => ['index', 'view', 'create', 'update', 'delete'],
            ],
            [
              'allow' => !Yii::$app->user->isGuest
              && in_array($_SESSION['user_role'], array(2)),
              'actions' => ['eforms_dashboard'],
            ],
          ],
        ],
      ];
    }

    /**
     * Lists all EformTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new EformTemplateSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
      ]);
    }

    /**
     * Displays a single EformTemplate model.
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
     * Creates a new EformTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new EformTemplate();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        //$model = new Investigator();
      $model = new EformTemplate();

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
     * Updates an existing EformTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionUpdate($id)
    {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post())) {
        
        if($model->save())
          return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
        'model' => $model,
      ]);
    }
    /**
     * Deletes an existing EformTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    public function actionDelete($id)
    {
      
      $model = $this->findModel($id);
      unlink('../../images/template_files/'.$model->images);
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
    }

    public function actionDisable($id)
    {
      $model = $this->findModel($id);
      $model->disable = 1;
      if($model->save(false))
       return $this->redirect(['index']);
   }

   public function actionReportDesignRecord($id)
   {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['update', 'id' => $model->id]);
    }

    return $this->render('report-design-record', [
      'model' => $model,
    ]);

  }
  public function actionUpdateHeader($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post())) {
      $model->images = $model->upload($model,'images');
      if($model->images!=$_POST['file_name_old']){
        if(!empty($_POST['file_name_old'])){
          unlink('../../images/template_files/'.$_POST['file_name_old']);
        }
      }
      if($model->save())
        return $this->redirect(['update', 'id' => $model->id]);
      
    }

    return $this->render('update-header', [
      'model' => $model,
    ]);

  }

  public function actionReportDesignSum($id)
  {
    $this->layout = false;
    return $this->render('report-design-sum',[
      'model' => $this->findModel($id),
    ]);
  }

  public function actionEforms_dashboard()
  {
    $searchModel = new EformTemplateSearch();
    $dataProvider = $searchModel->search_dashboard(Yii::$app->request->queryParams);

    return $this->render('eforms_dashboard', [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel
    ]);
  }

    /**
     * Finds the EformTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EformTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
      if (($model = EformTemplate::findOne($id)) !== null) {
        return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
