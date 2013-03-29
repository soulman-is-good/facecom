<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $tbl
 * @property integer $tbl_item
 * @property integer $user_id
 * @property string $text
 * @property integer $timestamp
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl, item_id, author_id, text, timestamp, owner_id', 'required'),
			array('item_id, author_id, owner_id, timestamp', 'numerical', 'integerOnly'=>true),
			array('tbl', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			// array('id, tbl, tbl_item, user_id, text, timestamp', 'safe', 'on'=>'search'),
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
			'tbl' => 'Tbl',
			'item_id' => 'Item ID',
			'author_id' => 'Author',
			'text' => 'Text',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('tbl',$this->tbl,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('timestamp',$this->timestamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getLast($tbl, $item_id, $limit = 5) {
        return $this->findAll(
            array(
                'condition' => 'tbl=:_tbl and item_id=:_item_id', 
                'with'=>'authors',
                'order' => 't.timestamp DESC',
                'limit' => $limit,
                'params' => array(
                    ':_tbl' => $tbl,
                    ':_item_id' => $item_id,
                ),
            )
        );
	}

	public function showAll($tbl, $item_id, $lastVisible) {
        return $this->findAll(
            array(
                'condition' => 'tbl=:_tbl and item_id=:_item_id and t.id<:_lastVisible', 
                'with'=>'authors',
                'order' => 't.timestamp DESC',
                'params' => array(
                    ':_tbl' => $tbl,
                    ':_item_id' => $item_id,
                    ':_lastVisible' => $lastVisible,
                ),
            )
        );
	}

	public function countComments($tbl, $item_id) {
        return $this->count(
            array(
                'condition' => 'tbl=:_tbl and item_id=:_item_id', 
                'params' => array(
                    ':_tbl' => $tbl,
                    ':_item_id' => $item_id,
                ),
            )
        );
	}

	public function lastAfterId($tbl, $item_id, $last_id) {
        return $this->findAll(
            array(
                'condition' => 'tbl=:_tbl and item_id=:_item_id and t.id>:_last_id', 
                'with'=>'authors',
                'order' => 't.timestamp DESC',
                'params' => array(
                	':_tbl' => $tbl,
                	':_item_id' => $item_id,
                    ':_last_id' => $last_id,
                ),
            )
        );
	}

}