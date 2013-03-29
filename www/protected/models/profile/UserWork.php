<?php

/**
 * This is the model class for table "user_work".
 *
 * The followings are the available columns in table 'user_work':
 * @property string $id
 * @property string $user_id
 * @property string $work
 * @property string $state
 * @property string $city_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Workplaces $work
 * @property Jobstates $state
 * @property Placemarks $place
 */
class UserWork extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserWork the static model class
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
		return 'user_work';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, work, state', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
                        array('work, state', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
			array('user_id, city_id', 'length', 'max'=>10),
                        array('year_till', 'compare', 'compareAttribute'=>'year_from', 'operator'=>'>='),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, work, state, city_id, status', 'safe', 'on'=>'search'),
		);
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
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
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
			'work' => 'Компания',
			'state' => 'Должность',
			'city_id' => 'Город',
			'status' => 'Видимость',
			'year_from' => 'Начало работы',
			'year_till' => 'Конец работы',                    
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
		$criteria->compare('work_id',$this->work_id,true);
		$criteria->compare('state_id',$this->state_id,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}