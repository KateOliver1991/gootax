<?php

namespace app\models;

use Yii;

use SimpleXMLElement;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 */
class IsYourCity extends \yii\db\ActiveRecord
{
    public $city;

    public $is_your_city="yes";
	
	public $recalls;
	
	public $author;


 protected $ip;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['date_create'], 'safe'],
            [['is_your_city'], 'safe'],
            [['city'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date_create' => 'Date Create',
            'is_your_city' => 'Ваш город?'
        ];
    }


    public function getList(){
        $data = $this->find()->orderBy("name")->all();
        return $data;
    }



    public function IP($ip) {

        $postData = "
        <ipquery>
            <fields>
                <all/>
            </fields>
            <ip-list>
                <ip>$ip</ip>
            </ip-list>
        </ipquery>
        ";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://194.85.91.253:8090/geo/geo.html');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $responseXml = curl_exec($curl);
        curl_close($curl);

        if (substr($responseXml, 0, 5) == '<?xml') {
            $ipinfo = new SimpleXMLElement($responseXml);
            //echo $ipinfo->ip->city; // город
            //echo $ipinfo->ip->region; // регион
            //echo $ipinfo->ip->district; // федеральный округ РФ
            return $ipinfo->ip;
        }
        return false;
    }
	
	
	public function getCityId(){
		return $this->find("id")->where(["name"=>Yii::$app->session["city"]])->one();
	}




}
