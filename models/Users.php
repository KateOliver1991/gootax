<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "Users".
 *
 * @property integer $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $date_create
 * @property string $password
 */
class Users extends \yii\db\ActiveRecord
{


    public $password_repeat;

    public $verifyCode;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['email', 'email', 'on' => ['login', 'register'], "message" => "Email является не корректным"],
            [['email', 'password'], 'required', 'on' => 'login', 'message' => 'Заполните поле {attribute}'],
            [['password'], 'checkLogin', 'on' => 'login'],
            ['status', 'safe', 'on' => 'check'],
            [['fio', 'email', 'phone', 'password', 'password_repeat'], 'required', 'on' => 'register', 'message' => 'Заполните поле {attribute}'],
            [['date_create', 'status', 'key_auth', 'verifyCode'], 'safe', 'on' => 'register'],
            [['fio', 'email', 'phone', 'password', 'password_repeat'], 'string', 'max' => 100, 'on' => 'register'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'register', "message" => "Пароли должны совпадать"],
            [['fio', 'email'], 'unique', 'on' => 'register'],
            ['phone', 'match', 'pattern' => '/^\+7|8\(\d{3}\)-\d{3}-\d{4}$/', 'message' => '{attribute} должен быть в формате: 8(xxx)-(xxx)-(xxxx) или +7(xxx)-(xxx)-(xxxx).', 'on' => 'register'],
            ['verifyCode', 'captcha', 'captchaAction' => 'city/captcha', 'caseSensitive' => false, 'on' => 'register']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Телефон',
            'date_create' => 'Date Create',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль еще раз',
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {


            //$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);


            return true;
        }
        return false;
    }


    public function checkKey($id, $key)
    {


        if ($user = $this->findOne(["id" => $id, "key_auth" => $key, "status" => 0])) {


            $user->status = 1;
            $user->save();


            return "success";

        } else if ($user = $this->findOne(["id" => $id, "key_auth" => $key, "status" => 1])) {

            return "activated";

        }
        return false;
    }


    public function checkStatus($email)
    {
        if ($user = $this->findOne(["email" => $email])) {
            if ($user->status == 1) {
                return true;
            }
        }
        return false;
    }

    public function checkLogin($attribute)
    {
        $user = $this->findOne(["email" => $this->email]);


        if ($user && Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {

            return true;

        }


        return $this->addError($attribute, 'Неправильный Email или пароль.');


    }


}
