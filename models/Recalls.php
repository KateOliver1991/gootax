<?php

namespace app\models;

use Yii;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;

/**
 * This is the model class for table "recalls".
 *
 * @property integer $id
 * @property integer $id_city
 * @property string $title
 * @property string $text
 * @property integer $rating
 * @property string $img
 * @property integer $id_author
 * @property string $date_create
 */
class Recalls extends ActiveRecord
{


    public $city;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recalls';
    }


    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_author']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['city', 'checkCity'],
            [['id_city','title', 'text', 'rating', 'img'], 'required'],
            [['id_city', 'rating', 'id_author'], 'integer'],
            [['city','date_create'], 'safe'],
            [['title', 'text'], 'string', 'max' => 30],
            [['img'], 'string', 'max' => 11],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_city' => 'Id City',
            'title' => 'Title',
            'text' => 'Text',
            'rating' => 'Rating',
            'img' => 'Img',
            'id_author' => 'Id Author',
            'date_create' => 'Date Create',
        ];
    }

    public function getRecalls()
    {


        $data = $this->getDb()->cache(function ($db) {

            $city = IsYourCity::findOne(["name" => Yii::$app->session["city"]]);

            return $this->find()->joinWith("users")->where(["recalls.id_city" => $city->id]);

        });


        $dataProvider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return ["data" => $data, "dataProvider" => $dataProvider];
    }


    public function checkCity($attr, $param)
    {


        $html = SHD::file_get_html('http://hramy.ru/regions/city_reg.htm');


        foreach ($html->find('table[id=table2] tr') as $element) {
            if (trim($element->first_child()->plaintext) != "Город") {
                if ($this->city == $element->first_child()->plaintext) {
                    return;
                }
            }
        }

        $this->addError($this->city, "нет такого города");


    }



}
