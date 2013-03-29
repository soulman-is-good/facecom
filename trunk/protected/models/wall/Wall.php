<?php

/**
 * This is the model class for table "wall".
 *
 * The followings are the available columns in table 'wall':
 * @property integer $id
 * @property string $text
 * @property integer $timestamp
 * @property integer $author_id
 * @property integer $user_id
 */
class Wall extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wall the static model class
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
		return 'wall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timestamp, author_id, user_id', 'numerical', 'integerOnly'=>true),
			array('text, timestamp, author_id, user_id', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
			'authors' => array(
				self::BELONGS_TO, 'User', 'author_id',
			)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'timestamp' => 'Timestamp',
			'author_id' => 'Author',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getLast($offset = 0, $limit = 10, $user_id) {
        return $this->findAll(
            array(
                'condition' => 'user_id=:id', 
                'with'=>'authors',
                'order' => 't.id DESC',
                'limit' => $limit,
                'offset' => $offset,
                'params' => array(
                    ':id' => $user_id,
                ),
            )
        );
	}

	public function loadNext($last = 0, $limit = 10, $user_id) {
        return $this->findAll(
            array(
                'condition' => 'user_id=:id AND t.id<:last', 
                'with'=>'authors',
                'order' => 't.id DESC',
                'limit' => $limit,
                'params' => array(
                    ':id' => $user_id,
                    ':last' => $last
                ),
            )
        );
	}
}