<?php

/**
 * This is the model class for table "interview_questions".
 *
 * The followings are the available columns in table 'interview_questions':
 * @property integer $id
 * @property integer $interview_id
 * @property integer $question
 * @property string $question_text
 * @property string $answers
 */
class InterviewQuestions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InterviewQuestions the static model class
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
		return 'interview_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('interview_id, question, question_text, answers', 'required'),
			array('interview_id, question', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, interview_id, question, question_text, answers', 'safe', 'on'=>'search'),
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
			'interview_id' => array(self::HAS_ONE, 'Interviews', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'interview_id' => 'Interview',
			'question' => 'Question',
			'question_text' => 'Question Text',
			'answers' => 'Answers',
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
		$criteria->compare('interview_id',$this->interview_id);
		$criteria->compare('question',$this->question);
		$criteria->compare('question_text',$this->question_text,true);
		$criteria->compare('answers',$this->answers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}