<?php

/**
 * This is the model class for table "videos".
 *
 * The followings are the available columns in table 'videos':
 * @property string $id
 * @property string $file
 * @property string $description
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Videos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Videos the static model class
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
		return 'videos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file, user_id', 'required'),
			array('file', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, file, description, user_id', 'safe', 'on'=>'search'),
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
			'file' => 'File',
			'description' => 'Description',
			'user_id' => 'User',
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
		$criteria->compare('file',$this->file,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getAroundInfo($id)
	{
		$videos = $this->findAll(array('select' => 'id'));

		$count = count($videos);

		foreach($videos as $ind => $video)
		{
			if($video['id'] == $id)
			{
				$num = $ind + 1;
				if($ind == 0)
					$prev = $videos[$count-1]->id;
				else
					$prev = $videos[$ind-1]->id;
				if($ind == $count-1)
					$next = $videos[0]->id;
				else
					$next = $videos[$ind+1]->id;
			}
		}

		return array('num' => $num, 'count' => $count, 'prev' => $prev, 'next' => $next);
	}

	//функция для закладок
	public function ParametrizedLoadLimited($cond, $ofset, $limit = 20)
	{
		return $this->findAll(array(
			'select' => 'id, file',
			'condition' => $cond,
			'limit' => $limit,
			'offset' => $ofset
		));
	}
}