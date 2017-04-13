<?php

namespace app\models;

use Yii;

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
class Recalls extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recalls';
    }
	
	
	public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'id']);
    }
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_city', 'title', 'text', 'rating', 'img', 'id_author'], 'required'],
            [['id', 'id_city', 'rating', 'id_author'], 'integer'],
            [['date_create'], 'safe'],
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
	
	public function getRecalls(){
		
		$city_id = IsYourCity::find("id")->where(["name"=>Yii::$app->session["city"]])->one();
		
		$data = $this->find()->joinWith("users")->where(["recalls.id_city"=>$city_id])->all();
		
		return $data;
	}
}
