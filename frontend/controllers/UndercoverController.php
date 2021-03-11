<?php

namespace frontend\controllers;

use Yii;
use app\models\Undercover;
use app\models\UndercoverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UndercoverController implements the CRUD actions for Undercover model.
 */
class UndercoverController extends Controller
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
     * Lists all Undercover models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UndercoverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Undercover model.
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
     * Creates a new Undercover model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Undercover();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionCreate()
    {
        $model = new Undercover();

        if ($model->load(Yii::$app->request->post())) {
            $model->images = $model->upload($model,'images');
            if (!empty($model->images )) {
                if ($model->validate()) {

                 $model->password = md5($model->password); 
                 if($model->save())
                    if ($_SESSION['user_role']=='1') {
                        $change = Yii::$app->db->createCommand("UPDATE unit SET have_active ='1' WHERE unit_id = '".$model->unitid."'")->execute();
                        return $this->redirect(['unit/view', 'id' => $model->unitid]);
                    }else{
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                } else {

                    $errors = $model->errors;
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    
    public function actionCreate_undercover() {
        // return $this->render('create_undercover');

        $model = new Undercover();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
               $model->images = $model->upload($model,'images');
               $model->password = md5($model->password);
               if($model->save())
                if ($_SESSION['user_role']=='1') {
                    $change = Yii::$app->db->createCommand("UPDATE unit SET have_active ='1' WHERE unit_id = '".$model->unitid."'")->execute();
                    return $this->redirect(['index', 'unitid' => $model->unitid]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {

                $errors = $model->errors;
            }

        }

        return $this->render('create_undercover', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Undercover model.
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
                    unlink(Yii::getAlias('@webroot').'/uploads/'.$_POST['file_name_old']);
                }
            }
        

        //         if($model->save(false))
        //             return $this->redirect(['view', 'id' => $model->id]);
        // } else {

        //         $errors = $model->errors;
        //     }


        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Undercover model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
      public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if ($_SESSION['user_role']=='2') {
            return $this->redirect(['index', 'unitid' => $_SESSION['unit_id']]);
        }else{
            return $this->redirect(['index']);
        }
        
    }

    /**
     * Finds the Undercover model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Undercover the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Undercover::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
