<?php

/**
 * This is the model class for table "jobs".
 *
 * The followings are the available columns in table 'jobs':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $prof_area_id
 * @property string $currency_id
 * @property string $salary
 * @property string $experience_id
 * @property string $region_id
 */
class Jobs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Jobs the static model class
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
		return 'jobs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, prof_area_id, currency_id, salary, experience_id, region_id', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'description' => 'Description',
			'prof_area_id' => 'Prof Area',
			'currency_id' => 'Currency',
			'salary' => 'Salary',
			'experience_id' => 'Experience',
			'region_id' => 'Region',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('prof_area_id',$this->prof_area_id,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('salary',$this->salary,true);
		$criteria->compare('experience_id',$this->experience_id,true);
		$criteria->compare('region_id',$this->region_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function saveJob($oid, $data, $mid)
	{
		$office = Office::Model()->findByPk($oid);
		if($office['user_id'] == Yii::app()->user->id){
			if($mid == 0){
				$this->isNewRecord = true;
				$res = $this;
				$res->date = time();
			}else
				$res = $this->findByPk($mid);
			//$this->id = 0;
			$res->title = $data['title'];
			$res->description = $data['description'];
			$res->prof_area_id = $data['prof_area'];
			$res->salary = $data['salary'];
			$res->currency_id = $data['currency'];
			$res->experience_id = $data['experience'];
			$res->office_id = $oid;
			$res->save();
			if(is_array($data['employment']))
				JobsEmploymentRelations::model()->addItems($res->id, $data['employment']);
		}
	}

	public function deleteJob($oid, $mid)
	{
		$office = Office::Model()->findByPk($oid);
		if($office['user_id'] == Yii::app()->user->id){
			$res = $this->findByPk($mid);
			$res->delete();
		}
	}


}