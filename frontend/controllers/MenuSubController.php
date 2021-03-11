<?php

namespace frontend\controllers;

use Yii;
use frontend\models\MenuSub;
use app\models\MenuSubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuSubController implements the CRUD actions for MenuSub model.
 */
class MenuSubController extends Controller
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
               'only' => ['index','create', 'update', 'delete','view'],
               'rules' => [
                    [
                        'allow' => !empty($_SESSION['user_id']),
                        'actions' => ['view','update'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => !empty($_SESSION['user_id']),
                        'actions' => ['index','view', 'create', 'update', 'delete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all MenuSub models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuSub model.
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
     * Creates a new MenuSub model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuSub();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu-main/view', 'id' => $model->menu_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuSub model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu-main/view', 'id' => $model->menu_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuSub model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$menu_id)
    {
        $this->findModel($id)->delete();

        // return $this->redirect(['menu-main/index']);
        return $this->redirect(['menu-main/view', 'id' => $menu_id]);
    }

    /**
     * Finds the MenuSub model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuSub the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuSub::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
