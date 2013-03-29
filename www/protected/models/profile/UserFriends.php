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
class UserFriends extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserFriends the static model class
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

	public function getFriends($user_id) {
		return $this->findAll(
            array(
            	'condition' => 'user_id=:id AND t.status=1',
                'with'=>'invited',
                'limit' => 6,
                'group' => 'friend_id',
                'params' => array(
                ':id' => $user_id,
            )
        ));
	}

	public function getFriendsPage($user_id) {
		return $this->findAll(
            array(
            	'condition' => 'user_id=:id AND t.status=1', 
                'with'=>'invited',
                'group' => 'friend_id',
                'params' => array(
                    ':id' => $user_id,
            )
        ));
	}

	public function getFriendsCount($user_id) {
		return $this->findAll(
            array(
            	'condition' => 'user_id=:id AND t.status=1', 
                'with'=>'invited',
                'group' => 'friend_id',
                'params' => array(
                    ':id' => $user_id,
            )
        ));
	}

	public static function areFriends($uid1, $uid2) {
		if(is_numeric($uid1) && is_numeric($uid2)) {
			$friendship = UserFriends::model()->find('status = 1 and user_id = '.$uid1 . ' and friend_id = '.$uid2);
			if($friendship)
				return ('friends');

			$friendship = UserFriends::model()->find('status = 1 and user_id = '.$uid2 . ' and friend_id = '.$uid1);
			if($friendship)
				return ('friends');

			$friendship = UserFriends::model()->find('status = 2 and user_id = '.$uid1 . ' and friend_id = '.$uid2);
			if($friendship)
				return ('myrequest');

			$friendship = UserFriends::model()->find('status = 3 and user_id = '.$uid1 . ' and friend_id = '.$uid2);
			if($friendship)
				return ('request');

		} 
		return ('false');		
	}
}