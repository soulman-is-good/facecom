<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $profile
 *
 * The followings are the available model relations:
 * @property Post[] $posts
 */
class User extends Record {

    public static function getState($id){
        $states = array(
            0=>'Не активирован',
            1=>'Активирован',
            2=>'Удален',
        );
        return $states[$id];
    }
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return string model title
     */
    public function modelTitle() {
        return 'Пользователи';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password', 'required' , 'on'=>'insert'),
            array('login, salt, email', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('login, password, email', 'length', 'max' => 255),
            array('salt', 'length', 'max' => 64),
            array('activation_key', 'length', 'max' => 45),
            array('created_at', 'length', 'max' => 10),
            array('password', 'safe', 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login, password, salt, email, activation_key, status, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stats' => array(self::HAS_MANY, 'UserStat', 'user_id'),
            'profile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'salt' => 'Соль',
            'email' => 'E-mail',
            'activation_key' => 'Ключ акивации',
            'status' => 'Статус пользователя',
            'created_at' => 'Создан',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('profile', $this->profile, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function beforeValidate() {
        if($this->isNewRecord){
            $this->password = md5($this->salt . $this->password);
            $this->created_at = time();
        }
        if(empty($this->activation_key))
            $this->activation_key = md5(microtime()) . rand(10,100);
        return parent::beforeValidate();
    }

    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }



/** Added by S.Marat **/
    public function isFriendOf($invited_id)
    {
        foreach ($this->getFriendships() as $friendship) {
            if ($friendship->user_id == $this->id && $friendship->friend_id == $invited_id)
                return $friendship->status;
        }

        return false;
    }

    public function getFriendships()
    {
        $condition = 'user_id = :uid or friend_id = :uid';
        return UserFriends::model()->findAll($condition, array(':uid' => $this->id));
    }

    // Friends can not be retrieve via the relations() method because a friend
    // can either be in the invited_id or in the friend_id column.
    // set $everything to true to also return pending and rejected friendships
    public function getFriends($everything = false)
    {
        if ($everything)
            $condition = 'user_id = :uid';
        else
            $condition = 'user_id = :uid and status = 2';

        $friends = array();
        Yii::import('application.models.UserFriends');
        $friendships = UserFriends::model()->findAll($condition, array(
                    ':uid' => $this->id));
        if ($friendships != NULL && !is_array($friendships))
            $friendships = array($friendships);

        if ($friendships)
            foreach ($friendships as $friendship)
                $friends[] = User::model()->findByPk($friendship->friend_id);

        if ($everything)
            $condition = 'friend_id = :uid';
        else
            $condition = 'friend_id = :uid and status = 2';

        $friendships = UserFriends::model()->findAll($condition, array(
                    ':uid' => $this->id));

        if ($friendships != NULL && !is_array($friendships))
            $friendships = array($friendships);


        if ($friendships)
            foreach ($friendships as $friendship)
                $friends[] = User::model()->findByPk($friendship->user_id);

        return $friends;
    }
/** Added by S.Marat **/
}