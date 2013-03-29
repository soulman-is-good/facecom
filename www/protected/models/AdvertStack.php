<?php

/**
 * This is the model class for table "advert_stack".
 *
 * The followings are the available columns in table 'advert_stack':
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $content_id
 * @property integer $date_added
 */
class AdvertStack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdvertStack the static model class
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
		return 'advert_stack';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, content_id, date_added', 'required'),
			array('user_id, type, content_id, date_added', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, type, content_id, date_added', 'safe', 'on'=>'search'),
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
			'user_id' => array(self::HAS_MANY, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'content_id' => 'Content',
			'date_added' => 'Date Added',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('date_added',$this->date_added);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function userIvs($user_id){
		return $this->findAll(array(
    		'condition' => 'type=1 AND user_id=:user_id',
    		'order' => 'date_added DESC',
    		'params' => array(':user_id'=>$user_id)
    	));
	}
}