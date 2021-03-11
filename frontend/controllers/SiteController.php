<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'pages' => [
                'class' => 'yii\web\ViewAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->mongodb->open(); // ทดสอบการเชื่อมต่อ
        return $this->render('index');
    }

    public function actionLogout_clear()
    {
        $this->layout = false;
        return $this->render('logout_clear');
    }

    public function actionMap()
    {
        $this->layout = false;
        return $this->render('map');
    }

    public function actionForgot_password()
    {
        $this->layout = false;
        return $this->render('forgot_password');
    }

    public function actionInsert_file_upload_list()
    {
        $this->layout = false;
        return $this->render('insert_file_upload_list');
    }

    public function actionInsert_file_upload_list_type()
    {
        $this->layout = false;
        return $this->render('insert_file_upload_list_type');
    }

    public function actionWebservice_formly()
    {
        $this->layout = false;
        return $this->render('webservice_formly');
    }

    public function actionStat_use_me_months()
    {
        $this->layout = false;
        return $this->render('stat_use_me_months');
    }

    public function actionJson_stat_department()
    {
        $this->layout = false;
        return $this->render('json_stat_department');
    }

    public function actionJson_log_unit()
    {
        $this->layout = false;
        return $this->render('json_log_unit');
    }

    public function actionJson_select_news()
    {
        $this->layout = false;
        return $this->render('json_select_news');
    }

    public function actionJson_select_unit()
    {
        $this->layout = false;
        return $this->render('json_select_unit');
    }

    public function actionJson_search_news()
    {
        $this->layout = false;
        return $this->render('json_search_news');
    }

    public function actionJson_graph_group()
    {
        $this->layout = false;
        return $this->render('json_graph_group');
    }

    public function actionJsonReportDesignRecord()
    {
        $this->layout = false;
        return $this->render('json-report-design-record');
    }

    public function actionJson_news_process()
    {
        $this->layout = false;
        return $this->render('json_news_process');
    }

    public function actionJson_organization()
    {
        $this->layout = false;
        return $this->render('json_organization');
    }

    public function actionJson_add_equipment()
    {
        $this->layout = false;
        return $this->render('json_add_equipment');
    }

    public function actionJson_stat_equipment()
    {
        $this->layout = false;
        return $this->render('json_stat_equipment');
    }

    public function actionCheckuser_online()
    {
        $this->layout = false;
        return $this->render('checkuser_online');
    }

    public function actionApprove_all()
    {
        $this->layout = false;
        return $this->render('approve_all');
    }

    public function actionManage_menu()
    {
        $this->layout = false;
        return $this->render('manage_menu');
    }

    public function actionCheckuser_users()
    {
        $this->layout = false;
        return $this->render('checkuser_users');
    }

    public function actionCheck_users_status()
    {
        $this->layout = false;
        return $this->render('check_users_status');
    }

    public function actionJson_stat_sadmin()
    {
        $this->layout = false;
        return $this->render('json_stat_sadmin');
    }

    public function actionJson_stat_users()
    {
        $this->layout = false;
        return $this->render('json_stat_users');
    }


    public function actionJson_stst_index_user()
    {
        $this->layout = false;
        return $this->render('json_stst_index_user');
    }

    public function actionJson_setting_users_group()
    {
        $this->layout = false;
        return $this->render('json_setting_users_group');
    }

    public function actionJson_datatable_file()
    {
        $this->layout = false;
        return $this->render('json_datatable_file');
    }

    public function actionJson_dashboard_approve()
    {
        $this->layout = false;
        return $this->render('json_dashboard_approve');
    }

    public function actionJson_check_news_process()
    {
        $this->layout = false;
        return $this->render('json_check_news_process');
    }

    public function actionJson_change_font_size()
    {
        $this->layout = false;
        return $this->render('json_change_font_size');
    }

    public function actionAcceptNews()
    {
        $this->layout = false;
        return $this->render('accept-news');
    }
    public function actionMyNotification()
    {
        return $this->render('my-notification');
    }

    public function actionReportDesignMultiple()
    {
        return $this->render('report-design-multiple');
    }

    public function actionFetchDraggableGroup()
    {
        $this->layout = false;
        return $this->render('fetch-draggable-group');
    }

    public function actionFetchDraggableUser()
    {
        $this->layout = false;
        return $this->render('fetch-draggable-user');
    }

    public function actionFetchManagesfileEtemplate()
    {
        $this->layout = false;
        return $this->render('fetch-managesfile-etemplate');
    }

    public function actionDescModel()
    {
        $this->layout = false;
        return $this->render('desc-model');
    }

    public function actionUpdateDraggable()
    {
        $this->layout = false;
        return $this->render('update-draggable');
    }

    public function actionJson_description_keywords()
    {
        $this->layout = false;
        return $this->render('json_description_keywords');
    }
    public function actionNewsProcess()
    {
        //$this->layout = false;
        return $this->render('news-process');
    }

    public function actionReportDesignRecord()
    {
        //$this->layout = false;
        return $this->render('report-design-record');
    }

    public function actionReportDesignSum()
    {
        //$this->layout = false;
        return $this->render('report-design-sum');
    }

    public function actionElasticGetdata()
    {
        $this->layout = false;
        return $this->render('elastic-getdata');
    }
    /// 
    public function actionElasticGettype()
    {
        $this->layout = false;
        return $this->render('elastic-gettype');
    }
    public function actionElasticPostdata()
    {
        $this->layout = false;
        return $this->render('elastic-postdata');
    }
    public function actionElasticUpdatedata()
    {
        $this->layout = false;
        return $this->render('elastic-updatedata');
    }
    public function actionElasticDeletedata()
    {
        $this->layout = false;
        return $this->render('elastic-deletedata');
    }
    /////
    public function actionLinkTimeline()
    {
        $this->layout = false;
        return $this->render('link-timeline');
    }
    public function actionLinkTimelineTab()
    {
        $this->layout = false;
        return $this->render('link-timeline-tab');
    }

    public function actionJsonTimeline()
    {
        $this->layout = false;
        return $this->render('json-timeline');
    }

    public function actionPrintPdf()
    {
        $this->layout = false;
        return $this->render('print-pdf');
    }

    public function actionJson_dynamic_select()
    {
        $this->layout = false;
        return $this->render('json_dynamic_select');
    }

    public function actionJson_check_request_information_eformdata()
    {
        $this->layout = false;
        return $this->render('json_check_request_information_eformdata');
    }

    public function actionJsonOperating()
    {
        $this->layout = false;
        return $this->render('json-operating');
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');
    }
    public function actionAppsearch()
    {
        $this->layout = false;
        return $this->render('appsearch');
    }
    public function actionSearch()
    {
        //$this->layout = false;
        return $this->render('search');
    }
    /*public function actionSendToAppSearch()
    {
        $this->layout = false;
        return $this->render('es-appsearch-putdata');
    } */
    public function actionPageSearch()
    {
        return $this->render('page-search');
    }

    public function actionInsertExtract()
    {
        $this->layout = false;
        return $this->render('insert-extract');
    }
    public function actionInsertExtractFalse()
    {
        $this->layout = false;
        return $this->render('insert-extract-false');
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
