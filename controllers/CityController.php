<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\IsYourCity;
use app\models\ChooseCity;
use app\models\Recalls;
use app\models\Users;



class CityController extends Controller
{

    public $layout = 'gootax';


    public function init()
    {


    }


    /**
     * @inheritdoc
     */

    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    */

    /**
     * @inheritdoc
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

        $model = new Users();

        $model->setScenario("check");

        if (isset($_GET["id"]) && isset($_GET["key"])) {

            if ($account = $model->checkKey($_GET["id"], $_GET["key"])) {

                if ($account == "success") {

                    return $this->render("success_account");

                } else if ($account == "activated") {
                    return $this->render("account_is_activated");
                }

            }
        }


        $model = new IsYourCity();

        $ip_info = $model->IP("91.146.47.84");

        $model->city = $ip_info->city;

        if (isset($_POST["IsYourCity"])) {

            $model->attributes = $_POST["IsYourCity"];

            if ($model->is_your_city == "yes") {

                Yii::$app->session["city"] = ["name" => $model->city, "date" => time()];

                $this->refresh();

            } else if ($model->is_your_city == "no") {

                return $this->redirect(["/city/choose"]);

            }

        }

        if (isset(Yii::$app->session["city"])) {

            $model2 = new Recalls();

            $model->recalls = $model2->recalls;


            if (Yii::$app->request->isAjax) {

                ini_set('max_execution_time', 0);

                while (1) {

                    $time = time() - Yii::$app->session["city"]["date"];


                    if ($time >= 5) {

                        unset(Yii::$app->session["city"]);

                        Yii::$app->response->format = 'json';

                        return ['time' => $time];

                    }

                }


            }

        }


        return $this->render('index', ["model" => $model]);


    }


    public function actionChoose()
    {

        $model = new ChooseCity();

        if (isset($_POST["ChooseCity"])) {

            $model->attributes = $_POST["ChooseCity"];

            Yii::$app->session["city"] = ["name" => $model->city, "date" => time()];

            return $this->redirect(["/city"]);

        } else {

            $list = $model->list;

            return $this->render('Choose', ["model" => $model, "cities" => $list]);

        }

    }

    public function actionRegistration()
    {
        $model = new Users();

        $model->setScenario("register");


        if ($model->load(Yii::$app->request->post())) {


            $model->key_auth = md5($model->id);


            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);

            $model->password_repeat = $model->password;


            $model->save();


            /*
        Yii::$app->mailer->compose()
->setFrom('from@domain.com')
->setTo($model->email)
->setSubject('Активация аккаунта')
->setTextBody('Перейдите по ссылке:')
->setHtmlBody("<a href='сайт'>сайт?id=".$model->id."&key=".$model->key_auth."</a>")
->send();
        */
            Yii::$app->session->setFlash('success_register', 'Регистрация выполнена успешно! Для активации аккаунта необходимо перейти по ссылке в электронном письме.');
            $this->redirect(["city/"]);


        }

        return $this->render("Registration", ["model" => $model]);


    }


    public function actionLogin()
    {
        $model = new Users();

        $model->setScenario("login");

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->checkStatus($model->email)) {
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'login',
                    'value' => $model->email
                ]));
                Yii::$app->session->setFlash('success', 'Вход успешно выполнен!');
                return $this->redirect(["city/"]);
            } else {
                return $this->render("account_is_not_activated");
            }
        }

        return $this->render("Login", ["model" => $model]);
    }


    public function actionLogout()
    {
        unset(Yii::$app->response->cookies["login"]);
        return $this->redirect(["city/"]);
    }


}
