<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\IsYourCity;
use app\models\ChooseCity;
use app\models\Recalls;
use yii\helpers\Url;


class CityController extends Controller
{


    public function init()
    {


    }


    /**
     * @inheritdoc
     */
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


        $model = new IsYourCity();

        $ip_info = $model->IP("91.146.47.84");

        $model->city = $ip_info->city;

        if (isset($_POST["IsYourCity"])) {

            $model->attributes = $_POST["IsYourCity"];

            if ($model->is_your_city == "yes") {

                Yii::$app->session["city"] = ["name" => $model->city, "date" => time()];

                $this->refresh();

            } else if ($model->is_your_city == "no") {

                return $this->redirect(Url::to(Url::base() . "/city/choose"));

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

            return $this->redirect(Url::to(Url::base() . "/city"));

        } else {

            $list = $model->list;

            return $this->render('Choose', ["model" => $model, "cities" => $list]);

        }

    }


}
