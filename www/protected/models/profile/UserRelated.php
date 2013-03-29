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
class UserRelated extends CActiveRecord
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
		/*return array(
			'users' => array(self::MANY_MANY, 'UserProfile', 'user_id',)
		);*/

		return array(
		   'u_profile' => array(self::BELONGS_TO, 'User', 'friend_id',),
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

	public function getFriendsOfFriends($user_id) {
        $get_mb_friends = Yii::app()->db->createCommand('SELECT up.* FROM user_profile up INNER JOIN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND uf.friend_id NOT IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND NOT uf.friend_id = ' . $user_id . ' GROUP BY uf.friend_id HAVING COUNT(uf.friend_id) > 1) TT ON TT.friend_id = up.USER_ID LIMIT 6')->queryAll();

        return $get_mb_friends;
	}

	public function getFriendsOfFriendsPage($user_id) {
        $get_mb_friends_page = Yii::app()->db->createCommand('SELECT up.* FROM user_profile up INNER JOIN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND uf.friend_id NOT IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND NOT uf.friend_id = ' . $user_id . ' GROUP BY uf.friend_id HAVING COUNT(uf.friend_id) > 1) TT ON TT.friend_id = up.USER_ID')->queryAll();

        return $get_mb_friends_page;
	}

	public function getFriendsOfFriendsCount($user_id) {
        $count_mb_friends = Yii::app()->db->createCommand('SELECT up.* FROM user_profile up INNER JOIN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND uf.friend_id NOT IN (SELECT uf.friend_id FROM user_friends uf WHERE uf.user_id = ' . $user_id . ') AND NOT uf.friend_id = ' . $user_id . ' GROUP BY uf.friend_id HAVING COUNT(uf.friend_id) > 1) TT ON TT.friend_id = up.USER_ID')->queryAll();

        return $count_mb_friends;
	}


}