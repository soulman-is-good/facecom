<?php

/**
 * This is the model class for table "user_university".
 *
 * The followings are the available columns in table 'user_university':
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $faculty_id
 * @property string $year_from
 * @property string $year_till
 * @property integer $form
 * @property string $state
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserUniversity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserUniversity the static model class
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
		return 'user_university';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, year_from, year_till', 'required'),
			array('form, status', 'numerical', 'integerOnly'=>true),
			array('user_id, state', 'length', 'max'=>10),
                        array('title, faculty', 'length', 'max' => 255, 'encoding' => 'UTF-8'),
			array('year_from, year_till', 'length', 'max'=>4),
			array('year_till', 'compare', 'compareAttribute'=>'year_from', 'operator'=>'>='),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, title, faculty, year_from, year_till, form, state, status', 'safe', 'on'=>'search'),
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
			'title' => 'ВУЗ',
			'faculty' => 'Факультет',
			'year_from' => 'Год поступления',
			'year_till' => 'Год выпуска',
			'form' => 'Форма обучения',
			'state' => 'Статус',
			'status' => 'Видимость',
		);
	}
        
        public function getStudyForm($all = false) {
            $forms = array(
                0=>'Дневная',
                1=>'Вечерняя',
                2=>'Заочная',
            );
            if($all) 
                return $forms;
            return $forms[$this->form];
        }
        
        public function getState($all = false) {
            $states = array(
                'Студент',
                'Специалист',
                'Аспирант',
            );
            if($all)
                return $states;
            return $states[$this->state];
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('faculty',$this->faculty,true);
		$criteria->compare('year_from',$this->year_from,true);
		$criteria->compare('year_till',$this->year_till,true);
		$criteria->compare('form',$this->form);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}