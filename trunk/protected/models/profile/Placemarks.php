<?php

/**
 * This is the model class for table "placemarks".
 *
 * The followings are the available columns in table 'placemarks':
 * @property string $id
 * @property string $user_id
 * @property string $coordinates
 * @property string $zoom
 * @property integer $status
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Placemarks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Placemarks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'placemarks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lat, long', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, created_at', 'length', 'max'=>10),
			array('long, lat', 'length', 'max'=>64),
			array('long, lat', 'vCoordinates', 'allowEmpty'=>false),
			array('zoom', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, lat, long, zoom, status, created_at', 'safe', 'on'=>'search'),
		);
	}
        
        public function vCoordinates($attr, $params=array()) {
            if(isset($params['allowEmpty']) && !$params['allowEmpty'] && empty($this->$attr)){
                $message=isset($params['message'])?$params['message']:Yii::t('yii','{attribute} cannot be blank.');
                $this->addError($attr,strtr($message,array('{attribute}'=>$this->getAttributeLabel($attr))));
                return false;
            }
            if(!is_numeric($this->$attr)){
                $this->addError($attr,strtr(Yii::t('errors',"Не верный формат координат в поле {attribute}",array('{attribute}'=>$this->getAttributeLabel($attr)))));
                return false;
            }
            return true;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'lat' => 'Широта',
			'long' => 'Долгота',
			'zoom' => 'Приближение',
			'status' => 'Видимость',
			'created_at' => 'Дата создания',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('long',$this->long,true);
		$criteria->compare('zoom',$this->zoom,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Adds placemark to a placemarks table
         * 
         * @param string $coordinates separated with comma world coordinates in
         * 'Lattitude,Longitude' order e.g. '123.456,234.567
         * @param string $zoom map zoom
         * @param int $user_id user's id number, default is current user (Yii::app()->user->id)
         * @param int $status visibility status, like 0 - visible for me 1 - for everyone, ...
         * @return mixed you can't add placemarks when not authenticated so FALSE
         * will be returned, on success returns new placemark id on failure
         * array of errors.
         */
        public static function addPlace($coordinates,$zoom = '14',$user_id = null, $status = 1) {
            if(Yii::app()->user->isGuest)
                return false;
            if(is_null($user_id)){
                $user_id = Yii::app()->user->id;
            }
            $placemark = new Placemarks();
            $placemark->user_id = $user_id;
            $placemark->coordinates = $coordinates;
            $placemark->zoom = $zoom;
            $placemark->created_at = time();
            $placemark->status = $status;
            if($placemark->save()){
                return $placemark->id;
            }else
                return $placemark->getErrors();
        }
}