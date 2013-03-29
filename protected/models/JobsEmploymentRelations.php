<?php

/**
 * This is the model class for table "jobs_employment_relations".
 *
 * The followings are the available columns in table 'jobs_employment_relations':
 * @property string $id
 * @property string $job_id
 * @property string $employment_id
 */
class JobsEmploymentRelations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JobsEmploymentRelations the static model class
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
		return 'jobs_employment_relations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('job_id, employment_id', 'required'),
			array('job_id, employment_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, job_id, employment_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'job_id' => 'Job',
			'employment_id' => 'Employment',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

	public function addItems($job_id, $data)
	{
		$this->deleteAll('job_id=:job_id', array(':job_id' => $job_id));
		foreach($data as $emp_id => $item)
		{
			$this->isNewRecord = true;
			$this->id = 0;
			$this->job_id = $job_id;
			$this->employment_id = $emp_id;
			$this->save();
		}
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('job_id',$this->job_id,true);
		$criteria->compare('employment_id',$this->employment_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}