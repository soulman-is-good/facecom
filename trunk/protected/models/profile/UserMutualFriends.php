<?php

/**
 * This is the model class for table "user_friends".
 *
 * The followings are the available columns in table 'user_friends':
 * @property string $id
 * @property string $user_id
 * @property string $friend_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserMutualFriends extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserMutualFriends the static model class
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
		return 'user_friends';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, friend_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, friend_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, friend_id, status', 'safe', 'on'=>'search'),
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
			/*'user' => array(self::BELONGS_TO, 'User', 'user_id'),*/
			'inviter' => array(
				self::BELONGS_TO, 'User', 'user_id',
			),
			'invited' => array(
				self::BELONGS_TO, 'User', 'friend_id',
			)
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
			'friend_id' => 'Friend',
			'status' => 'Status',
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
		$criteria->compare('friend_id',$this->friend_id,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getMutualFriends($user_id, $friend_id){
		$get_mutual_friends = Yii::app()->db->createCommand('SELECT * FROM user_profile WHERE user_id IN (SELECT f1.user_id AS C FROM user_friends f1 INNER JOIN user_friends f2 ON f1.user_id = f2.friend_id WHERE f1.friend_id = '. $friend_id .' AND f2.user_id = '. $user_id.' AND NOT f1.friend_id = '. $user_id.' AND f2.status = 1)')->queryAll();

		return $get_mutual_friends;
	}

}