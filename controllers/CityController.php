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


    public $enableCsrfValidation = false;


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

        $ip_info = $model->IP("94.181.89.169");

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


            $this->view->registerJsFile('js/ajax.js');


        }


        return $this->render('index', ["model" => $model]);


    }


    public function actionCheckSession()
    {

        if (Yii::$app->request->isAjax) {


            $time = time() - Yii::$app->session["city"]["date"];

            if ($time >= 2*3600) {

                unset(Yii::$app->session["city"]);

                return $this->redirect(["/city"]);

            }

            Yii::$app->response->format = 'json';

            return ['time' => $time];


        }

        return true;


    }


    public function actionRecalls()
    {

        $model = new Recalls();

        if (isset($model->recalls)) {
            return $this->render("recalls", ["model" => $model, "dataProvider" => $model->recalls["dataProvider"]]);
        } else {
            return $this->render("recalls", ["template" => "<div class='alert alert-info'>Войдите в свою учетную запись, чтобы видеть отзывы</div>"]);
        }

    }


    public function actionChoose()
    {

        $model = new ChooseCity();

        if (isset($_POST["ChooseCity"])) {

            $model->attributes = $_POST["ChooseCity"];

            Yii::$app->session["city"] = ["name" => $model->city, "date" => time()];

            return $this->redirect(["/city/"]);

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

    public function actionSelectRecall()
    {
        $model = new Recalls();
        if (isset(Yii::$app->request->cookies["login"])) {

            $cities = ChooseCity::find()
                ->select(['name as value', 'name as label'])
                ->asArray()
                ->all();

            return $this->render("selectRecall", ["model" => $model, "cities" => $cities]);
        } else {
            return $this->render("selectRecall", ["template" => "<div class='text-center alert alert-info'>Войдите в свой аккаунт, чтобы добавить отзыв</div>"]);
        }
    }


    public function actionLoadCities()
    {


        if (Yii::$app->request->isAjax) {

            //ini_set('max_execution_time', 0);

            $cities = ['Пермь', 'Воткинск', 'Сарапул'];

            Yii::$app->response->format = 'json';

            return ['cities' => $cities];


        }

        return true;


    }

    public function actionAddRecall()
    {

        $model = new Recalls();

        if ($model->load(Yii::$app->request->post())) {

            $user = Users::findOne(["email" => YII::$app->request->cookies["login"]]);
            $model->id_author = $user->id;
            $city = ChooseCity::findOne(["name" => $model->city]);
            $model->id_city = $city->id;

            if ($model->save()) {
                //return $this->redirect(["city/recalls"]);
            } else {
                var_dump($model->errors);
            }

        }

        return $this->render("recalls", ["model" => $model, "dataProvider" => $model->recalls["dataProvider"]]);

    }

    public function actionDelRecall()
    {

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->get();

            $time = $data["id"];

            $recall = Recalls::findOne($data["id"]);

            $recall->delete();

            Yii::$app->response->format = 'json';

            return ["time" => $time];


        }

        return true;

    }


    public function actionDelete()
    {
        $id = Yii::$app->request->get();
        $recall = Recalls::findOne($id);
        $recall->delete();
        return $this->redirect("recalls");
    }


    public function actionUpdate()
    {
        $id = Yii::$app->request->get();
        $recall = Recalls::findOne($id);
        if (!$recall->update()) {
            $recall->errors;
        }

        return $this->redirect("recalls");
    }

}
