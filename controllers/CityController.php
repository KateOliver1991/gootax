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
        ini_set("session.gc_maxlifetime", 10);
        ini_set('session.cookie_lifetime', 5);
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

                Yii::$app->session["city"] = $model->city;

                $this->refresh();

            } else if ($model->is_your_city == "no") {

                return $this->redirect(Url::to(Url::base() . "/city/choose"));

            }

        } else {
			
			if(isset(Yii::$app->session["city"])){
			
				$model2 = new Recalls();
			
				$model->recalls = $model2->recalls;
				
	
	
			}

            return $this->render('index', ["model" => $model]);
			
        }


    }


    public function actionChoose()
    {

        $model = new ChooseCity();

        if (isset($_POST["ChooseCity"])) {

            $model->attributes = $_POST["ChooseCity"];

            Yii::$app->session["city"] = $model->city;
			
            return $this->redirect(Url::to(Url::base() . "/city"));

        } else {

            $list = $model->list;

            return $this->render('Choose', ["model" => $model, "cities" => $list]);

        }

    }


}
