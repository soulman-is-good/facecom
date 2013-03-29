<?php

/**
 * This is the model class for table "interviews".
 *
 * The followings are the available columns in table 'interviews':
 * @property integer $id
 * @property integer $owner
 * @property string $name
 * @property integer $status
 * @property string $questions
 * @property string $targeting
 * @property integer $price
 * @property integer $limit
 * @property integer $spent
 * @property string $crt
 * @property integer $shows
 * @property string $activity_log
 */
class Interviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Interviews the static model class
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
		return 'interviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner, name, status, questions, targeting, price, activity_log, title', 'required'),
			array('owner, status, price, limit, spent, shows', 'numerical', 'integerOnly'=>true),
			array('name, title', 'length', 'max'=>255),
			array('crt', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner, name, status, questions, targeting, price, limit, spent, crt, shows, activity_log, title', 'safe', 'on'=>'search'),
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
			'owner' => array(self::HAS_ONE, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner' => 'Owner',
			'name' => 'Name',
			'title'=> 'Title',
			'status' => 'Status',
			'questions' => 'Questions',
			'targeting' => 'Targeting',
			'price' => 'Price',
			'limit' => 'Limit',
			'spent' => 'Spent',
			'crt' => 'Crt',
			'shows' => 'Shows',
			'activity_log' => 'Activity Log',
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
		$criteria->compare('owner',$this->owner);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('questions',$this->questions,true);
		$criteria->compare('targeting',$this->targeting,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('limit',$this->limit);
		$criteria->compare('spent',$this->spent);
		$criteria->compare('crt',$this->crt,true);
		$criteria->compare('shows',$this->shows);
		$criteria->compare('activity_log',$this->activity_log,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//посчитать число ответов на этот опрос
	public function answerCount()
	{
		return InterviewAnswers::model()->count('interview_id=:interview_id',array(':interview_id'=>$this->id));
	}

	//проверяет, существует ли в БД опрос с таким именем у этого пользователя
	public function is_exist()
	{
		return Interviews::model()->exists(
			array(
				'condition'=>"owner=:owner AND name=:name",
				'params'=>array(
					':owner'=>$this->owner,
					':name'=>$this->name
                )
            )
		);
	}

	public function fixShow()
	{
		$this->shows++;
		$this->save();
	}
}