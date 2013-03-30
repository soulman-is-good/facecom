<?php

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property string $id
 * @property string $user_id
 * @property string $city_id
 * @property string $address
 * @property string $first_name
 * @property string $second_name
 * @property string $third_name
 * @property integer $birth_date
 * @property string $languages
 * @property string $bgposition
 * @property integer $family
 * @property integer $gender
 * @property string $phone
 * @property string $email
 * @property string $activities
 * @property string $interests
 * @property string $music
 * @property string $quotes
 * @property string $about
 */
class UserProfile extends Record {

    /**
     * @var boolean try to load gravatar on save
     */
    public $tryGravatar = false;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserProfile the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function get($param=array(),$single=false) {
        if($single)
            return self::model()->find($param);
        else
            return self::model()->findAll($param);
        return null;
    }
    
    public static function myProfile() {
        $id = Yii::app()->user->id;
        return self::model()->getUserProfile($id);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_profile';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('first_name, second_name', 'required','on'=>'register'),
            array('user_id, city_id, first_name, second_name, third_name', 'required','on'=>'insert'),
            array('user_id, city_id, first_name, second_name, third_name, family', 'required','on'=>'update'),
            array('family, gender, birth_date', 'numerical', 'integerOnly' => true),
            array('user_id, city_id, birth_date', 'length', 'max' => 10),
            array('address, first_name, second_name, third_name, phone, email', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
            array('address, first_name, second_name, third_name, phone, activities, interests, music, quotes, about', 'XssValidator'),
            array('email', 'email'),
            array('languages, bgposition', 'length', 'max' => 128),
            array('avatar, background', 'file' , 'mimeTypes'=>array("image/gif, image/jpeg, image/png"),'maxSize'=>1048576/*1Mb*/,'allowEmpty'=>true),
            array('activities, interests, music, quotes, about, bgposition', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, city_id, address, first_name, second_name, third_name, languages, family, gender, phone, email, activities, interests, music, quotes, about', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id' ,'with'=>'country'),
            'universities' => array(self::HAS_MANY, 'UserUniversity', 'user_id'),
            'schools' => array(self::HAS_MANY, 'UserSchool', 'user_id'),
            'works' => array(self::HAS_MANY, 'UserWork', 'user_id' ),
        );
    }
    
    public function getFriends() {
        $friends = UserProfile::model()->findAll(
                    array(
                        'condition'=>"t.user_id IN (SELECT friend_id FROM user_friends uf WHERE uf.user_id=:uid AND status=1)",
                        'params'=>array(
                            ':uid'=>$this->user_id
                        )
                    )
                );
        return $friends;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'city_id' => 'Город',
            'address' => 'Адрес',
            'avatar' => 'Аватар',
            'background' => 'Подложка',
            'bgposition' => 'Положение подложки',
            'birth_date' => 'Дата рождения',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'third_name' => 'Отчество',
            'languages' => 'Языки',
            'family' => 'Семейное положение',
            'gender' => 'Пол',
            'phone' => 'Телефон',
            'email' => 'Отображаемый E-mail',
            'activities' => 'Деятельность',
            'interests' => 'Интересы',
            'music' => 'Музыка',
            'quotes' => 'Цитаты',
            'about' => 'О себе',
        );
    }  
    
    /**
     * @return string Formatted string with Country, City information
     */
    public function getRegion() {
        if($this->city==null)
            return '';
        $title = $this->city->country->name . ", " . $this->city->name;
        return $title;
    }

    /**
     * 
     * @param integer $type type of return value, noun, verb, else...
     * @return string gender info
     */
    public function getGenderInfo($type = 0) {
        //TODO: Make i18n for words
        switch ($type) {
            case 2:
                return array('мужской', 'женский');
                break;
            case 1:
                $state = array('мужчина', 'женщина');
                return $state[$this->gender];
                break;
            default:
                $state = array('мужской', 'женский');
                return $state[$this->gender];
        }
    }

    public function getFamilyState($all = false) {
        //TODO: Make i18n for words
        $state = array(
            0 => array(//Male
                'холост',
                'женат',
                'есть подруга',
                'в активном поиске',
            ),
            1 => array(//Female
                'не замужем',
                'замужем',
                'есть друг',
                'в активном поиске',
            )
        );
        if($all)
            return $state;
        return $state[$this->gender][$this->family];
    }

    public function getSpokenLanguages() {
        if (empty($this->languages))
            return 'немой';
        $langs = Yii::app()->db->createCommand("SELECT title FROM language WHERE id IN ($this->languages)")->queryAll();
        if (empty($langs))
            return 'немой';
        $tmp = '';
        foreach ($langs as $lang) {
            $tmp .= $lang['title'] . ', ';
        }
        return trim($tmp, ', ');
    }
    
    public function getFullname() {
        return $this->second_name . " " . $this->first_name . " " . $this->third_name;
    }
    
    public function getHalfname() {
        return $this->first_name . " " . $this->second_name;
    }
    
        
        public function getAvatar($size = 'avatar') {
            if($size != '')
                $size = $size . '/';
            if($this->avatar!=null && NULL!=($file = Files::getFile($this->avatar)) && is_file(('upload/photos/' . $file))) {
                return "/images/$size$file";
            }
            return '/images/avatar/default_profile.png';
        }
        
        public function getBackground($size = 'cover') {
            if($size != '')
                $size = $size . '/';
            if($this->background!=null && NULL!=($file = Files::getFile($this->background))) {
                return '/images/'.$size.$file;
            }
            return '/images/cover/bg.png';
        }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('city_id', $this->city_id, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('second_name', $this->second_name, true);
        $criteria->compare('third_name', $this->third_name, true);
        $criteria->compare('languages', $this->languages, true);
        $criteria->compare('family', $this->family);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activities', $this->activities, true);
        $criteria->compare('interests', $this->interests, true);
        $criteria->compare('music', $this->music, true);
        $criteria->compare('quotes', $this->quotes, true);
        $criteria->compare('about', $this->about, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * manage scope chain for user all friends
     * @param int $user_id user table id
     * @return \User
     */
    public function friends($user_id = null) {
        if (is_null($user_id) && !Yii::app()->user->isGuest)
            $user_id = Yii::app()->user->id;
        elseif (is_null($user_id))
            return $this;

        $this->getDbCriteria()->mergeWith(
                array(
                    'join' => 'INNER JOIN user_friends uf ON uf.user_id=t.user_id',
                    'condition' => 'uf.friend_id=:userid', 
                    // модифицирован С.Марат, чтобы выводил корректно имя пользователей
                    /*'condition' => 't.user_id=:userid',*/
                    'params' => array(':userid' => $user_id))
        );
        return $this;
    }

    public function scopes() {
        return array(
            //For friends scope
            'confirmed' => array('condition' => 'uf.status=1'),
            'notConfirmed' => array('condition' => 'uf.status=0'),
        );
    }
    
    public function beforeValidate() {
        if(is_array($this->languages))
            $this->languages = implode (',', $this->languages);
        if($this->tryGravatar && 0){
            $email = $this->user->email;
            $url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=190&d=404";
            $url = parse_url($url);
            $errno = '';$errstr='';
            if(FALSE !== ($f = @fsockopen($url['hostname'],'80',$errno,$errstr,30))){
                $out = "GET {$url['path']}?{$url['query']} HTTP/1.1\r\n";
                $out.= "Host: {$url['hostname']}\r\n";
                $out.= "Connection: close\r\n\r\n";
                @fwrite($f, $out);
            }
        }
        parent::beforeValidate();
        return true;
    }

    public function getUserProfile($id) {
        return $this->find(
            array(
                'condition' => 'user_id=:id', 
                'select' => 'user_id, first_name, second_name, third_name, avatar, background, bgposition', 
                'params' => array(
                    ':id' => $id
                )
            )
        );
    }

    public function afterFind() {
        parent::afterFind();
    }
    
    public function __call($name, $parameters) {
        if(strpos($name,'render')==0){
            $attr = str_replace('render', '', strtolower($name));
            $value = $this->$attr;
            $value = str_replace("\r\n\r\n",',',$value);
            $value = str_replace("\n\n",',',$value);
            array_walk(explode(',',$value),  create_function('$item', 'echo \'<a href="/search/?query=\'.urlencode(trim($item)).\'" class="blue">\'.trim($item)."</a> ";'));
        }else
            parent::__call($name, $parameters);
    }

}