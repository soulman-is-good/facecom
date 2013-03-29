<?php

/**
 * This is the model class for table "apps".
 *
 * The followings are the available columns in table 'apps':
 * @property integer $id
 * @property string $caption
 * @property integer $users
 * @property string $tn
 * @property string $desc
 * @property string $address
 */
class Apps extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Apps the static model class
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
		return 'apps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('caption, users, tn, desc, address', 'required'),
			array('users', 'numerical', 'integerOnly'=>true),
			array('caption, tn, address', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, caption, users, tn, desc, address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'caption' => 'Название',
			'users' => 'Пользователей',
			'tn' => 'Превью',
			'desc' => 'Описание',
			'address' => 'Адрес',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('users',$this->users);
		$criteria->compare('tn',$this->tn,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//Функция возвращает сортитрованный массив всех приложений
	public function appList($offset=0)
	{
		return $this->findAll(
			array (
				'order'=>'users DESC',
				'limit'=>Yii::app()->params->maxAppsPerRequest,
				'offset'=>$offset
			)

    	);
	}
	//Функция разбивает число по разрядам
	public function explodeToTreads($num)
	{
		return preg_replace(
			'~'.
			'(\d'. // число
			'(?='. // после есть (логическое есть)
			'(?:\d{3})+'. // число
			'(?!\d)'. // после нет числа (логическое отрицание)
			')'.
			')'.
			'~s', "\\1 ", $num);
	}

	public function getUserApp($aid,$user_id)
	{
		$exists=UserApps::model()->exists(
			array (
				'condition' => 'user_id='.$user_id.' AND app_id='.$aid
			)
		);
		if($exists) return $this->find(array('condition'=>'id='.$aid));
	}
}