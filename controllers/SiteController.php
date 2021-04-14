<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index'],
                'rules' => [
                    // deny all POST requests
                    [
                        'allow' => false,
                        'verbs' => ['POST']
                    ],
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $umodel=User::findOne(['id' => Yii::$app->user->id]);
        $role=$umodel::getRole(Yii::$app->user->id);
        if($role==1) return $this->redirect(['/reestr/list']);
            else return $this->redirect(['/reestr/plan']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionLogin()
    {

            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }
     
            $model = new User();
            if(isset($_GET['log'])) $model->login=$_GET['log'];
            if ($model->load(Yii::$app->request->post()) 
                && $model->login()) {
                return $this->redirect(['/site/index']);
            }
            return $this->render('login', [
                'model' => $model,
            ]);

    }
    public function actionSignup(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->login = $model->login;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->role = $model->role;
            if($user->save()){
                $this->redirect(['/site/login?log='.$model->login]);
            } else print_r($user->geterrors());

    }
     
        return $this->render('signup', compact('model'));
       }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
