<?php

namespace frontend\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => !Yii::$app->user->isGuest
                            && in_array($_SESSION['user_role'], array(1, 2)),
                        'actions' => ['index', 'delete'],
                    ],
                    [
                        'allow' => !Yii::$app->user->isGuest
                            && in_array($_SESSION['user_role'], array(1, 2, 3)),
                        'actions' => ['update', 'view', 'create'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDashbord()
    {
        return $this->render('dashbord');
    }
    public function actionDashbord2()
    {
        return $this->render('dashbord2');
    }

    /**
     * Displays a single Users model.
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

    public function actionForgot_password()
    {
        $this->layout = false;
        // return $this->redirect(['forgot_password']);
        return $this->render('forgot_password');
    }


    public function actionChange_password($id)
    {
        return $this->render('change_password', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionChangepass()
    {
        $password = Yii::$app->request->post('password');
        $auth_key = Yii::$app->request->post('auth_key');
        $id = Yii::$app->request->post('id');

        if (Yii::$app->request->post()) {

            if (!empty($auth_key)) {
                $password = md5($auth_key);
                $auth_key = '';
            } else {
                $auth_key = '';
                $password = $password;
            }
            Yii::$app->db->createCommand()
                ->update('users', ['password' => $password], 'id = ' . $id)
                ->execute();
        }

        return $this->redirect(['view', 'id' => $id]);
    }
    public function actionCreate_users()
    {
        // return $this->render('create_users');

        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->images = $model->upload($model, 'images');
                $model->password = md5($model->password);
                if ($model->save())
                    if ($_SESSION['user_role'] == '1') {
                        $change = Yii::$app->db->createCommand("UPDATE unit SET have_active ='1' WHERE unit_id = '" . $model->unit_id . "'")->execute();
                        return $this->redirect(['index', 'unitid' => $model->unit_id]);
                    } else {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
            } else {

                $errors = $model->errors;
            }
        }

        return $this->render('create_users', [
            'model' => $model,
        ]);
    }


    public function actionCreate_users_group()
    {
        // return $this->render('create_users');

        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->images = $model->upload($model, 'images');
                $model->password = md5($model->password);
                if ($model->save())
                    if ($_SESSION['user_role'] == '1') {
                        $change = Yii::$app->db->createCommand("UPDATE unit SET have_active ='1' WHERE unit_id = '" . $model->unit_id . "'")->execute();
                        return $this->redirect(['index', 'unitid' => $model->unit_id]);
                    } else {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
            } else {

                $errors = $model->errors;
            }
        }

        return $this->render('create_users_group', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            $model->images = $model->upload($model, 'images');
            if (!empty($model->images)) {
                if ($model->validate()) {

                    $model->password = md5($model->password);
                    if ($model->save())
                        if ($_SESSION['user_role'] == '1') {
                            $change = Yii::$app->db->createCommand("UPDATE unit SET have_active ='1' WHERE unit_id = '" . $model->unit_id . "'")->execute();
                            return $this->redirect(['unit/view', 'id' => $model->unit_id]);
                        } else {
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

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                if (!empty($model->auth_key)) {
                    $model->password = md5($model->auth_key);
                    $model->auth_key = '';
                } else {
                    $model->auth_key = '';
                    $model->password = $model->password;
                }

                $model->images = $model->upload($model, 'images');
                if ($model->images != $_POST['file_name_old']) {
                    if (!empty($_POST['file_name_old'])) {
                        unlink(Yii::getAlias('@webroot') . '/uploads/' . $_POST['file_name_old']);
                    }
                }


                if ($model->save(false))
                    return $this->redirect(['view', 'id' => $model->id]);
            } else {

                $errors = $model->errors;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if ($_SESSION['user_role'] == '2') {
            return $this->redirect(['index', 'unitid' => $_SESSION['unit_id']]);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
