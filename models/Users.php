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
            ['status', 'safe', 'on' => 'check'],
            [['fio', 'email', 'phone', 'password', 'password_repeat'], 'required', 'on' => 'register', 'message' => 'Заполните поле {attribute}'],
            [['date_create', 'status', 'key_auth', 'verifyCode'], 'safe', 'on' => 'register'],
            [['fio', 'email', 'phone', 'password', 'password_repeat'], 'string', 'max' => 100, 'on' => 'register'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'register', "message" => "Пароли должны совпадать"],
            [['fio', 'email'], 'unique', 'on' => 'register'],
            ['email', 'email', 'on' => 'register', "message" => "Email является не корректным"],
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


            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password, 10);


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


}
