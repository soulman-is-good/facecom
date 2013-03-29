<?php

/**
 * This is the model class for table "office".
 *
 * The followings are the available columns in table 'office':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $avatar
 * @property string $background
 * @property string $bgposition
 * @property string $about
 * @property string $city_id
 * @property string $address
 * @property string $contacts
 * @property string $website
 * @property string $lat
 * @property string $long
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property City $city
 * @property User $user
 */
class Office extends CActiveRecord
{
        public static $contacts = array(
            'phone'=>'Телефон',
            'email'=>'E-mail',
            'skype'=>'Skype',
            'icq'=>'ICQ',
            'mailru'=>'Mail агент',
            'talk'=>'Google talk',
        );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Office the static model class
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
		return 'office';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name', 'required'),
			array('about, address', 'XssValidator'),
			array('contacts', 'safe'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('id, user_id, city_id', 'length', 'max'=>10),
			array('name, website', 'length', 'max'=>255),
			array('address', 'length', 'max'=>1024),
			array('avatar, background, lat, long', 'length', 'max'=>50),
			array('bgposition', 'length', 'max'=>16),
			array('contacts', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, address, avatar, background, bgposition, about, city_id, contacts, website, lat, long, status', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
        
        /**
         * @return string Formatted string with Country, City information
         */
        public function getRegion() {
            $title = $this->city->country->name . ", " . $this->city->name;
            return $title;
        }
        
        /**
         * Transforms contacts string to associative array with some html tags for skype etc.
         * @param boolean $plain pass 'true' if you want a plain associative array with no html
         * @return array parsed contacts string
         */
        public function contactsArray($plain = false) {
            array_walk($contacts = explode(';',str_replace(',',';',$this->contacts)),create_function('&$v,$k','$v = trim($v);'));
            $result = array();
            $html = array(
                'skype'=>'<a href="skype:{skype}">{skype}</a>',
                'email'=>'<a href="mailto:{email}">{email}</a>',
            );
            foreach($contacts as $c){
                $c = explode(':',$c);
                $key = strtolower(trim($c[0]));
                $name = isset(self::$contacts[$key])?self::$contacts[$key]:ucfirst($c[0]);
                $c = $c[1];
                if(!$plain && isset($html[$key])){
                    $result[$name] = strtr($html[$key], array("{".$key."}"=>$c));
                }else
                    $result[$name] = $c;
            }
            return $result;
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'address' => 'Адрес',
			'name' => 'Название',
			'avatar' => 'Логотип',
			'background' => 'Фон',
			'bgposition' => 'Bgposition',
			'about' => 'О компании',
			'city_id' => 'Город',
			'contacts' => 'Контакты',
			'website' => 'Веб-сайт',
			'lat' => 'На карте',
			'long' => 'Long',
			'status' => 'Status',
		);
	}
        
        public function isMyOffice() {
            return !Yii::app()->user->isGuest && $this->user_id > 0 && Yii::app()->user->id == $this->user_id;
        }
        
        public function getAvatar($size = 'avatar') {
            if($size != '')
                $size = $size . '/';
            if($this->avatar!=null && NULL!=($file = Files::getFile($this->avatar)) && is_file(($file='upload/photos/' . $size . $file))) {
                return "/$file";
            }
            return '/static/css/officeTestAvatar.png';
        }
        
        public function getBackground($size = 'cover') {
            if($size != '')
                $size = $size . '/';
            if($this->background!=null && NULL!=($file = Files::getFile($this->background))) {
                return $file;
            }
            return '/static/css/officeTestBG.png';
        }
        
        public function defaultScope() {
            return array(
                'order'=>'name ASC'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('bgposition',$this->bgposition,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('contacts',$this->contacts,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('long',$this->long,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function beforeValidate() {
            $this->website = str_replace('http://','',$this->website);
            if(trim($this->website)!='' && preg_match("/^(www\.|)[\w0-9-+_]+\.[a-z]{2,4}$/",$this->website)==0){
                $this->addError('website', Yii::t('errors','Не корректно введен веб-сайт'));
            }else
                $this->website = 'http://' . $this->website;
            return parent::beforeValidate();
        }
}