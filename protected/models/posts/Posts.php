<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property string $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property string $author_id
 */
class Posts extends CActiveRecord
{
	protected $_owner_type;
	protected $_owner_id;
	protected $_post_type;
	protected $_last_id;
	protected $_limit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Posts the static model class
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
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author_id', 'required'),
			array('status, creation_date', 'numerical', 'integerOnly'=>true),
			array('author_id', 'length', 'max'=>10),
			array('content', 'safe'),
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
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'status' => 'Status',
			'creation_date' => 'Creation Date',
			'author_id' => 'Author',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('creation_date',$this->creation_date);
		$criteria->compare('author_id',$this->author_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getLast() { // Получить последние n записей
        return $this->findAll(
            array(
                'condition' => 'owner_id=:_owner_id', 
                'with'=>'authors',
                'order' => 'creation_date DESC',
                'limit' => $this->_limit,
                'params' => array(
                    ':_owner_id' => $this->_owner_id,
                ),
            )
        );
	}

	public function lastAfterId() {
        return $this->findAll(
            array(
                'condition' => 't.id>:_last_id and owner_type=:_owner_type and owner_id=:_owner_id', 
                'with' => 'authors',
                'order' => 'creation_date DESC',
                'params' => array(
                    ':_last_id' => $this->_last_id,
                    ':_owner_type' => $this->_owner_type,
                    ':_owner_id' => $this->_owner_id,
                ),
            )
        );
	}

	public function loadMore() { 
        return $this->findAll(
            array(
                'condition' => 'owner_type=:_owner_type and owner_id=:_owner_id and post_type=:_post_type and t.id<:_last_id', 
                'with'=>'authors',
                'order' => 't.id DESC',
                'limit' => $this->_limit,
                'params' => array(
                	':_owner_type' => $this->_owner_type,
                    ':_owner_id' => $this->_owner_id,
                    ':_post_type' => $this->_post_type,
                    ':_last_id' => $this->_last_id
                ),
            )
        );
	}

	public function getMyFeed($friends) { 
        return $this->findAll(
            array(
                'condition' => '(author_id IN (:friends)) OR (parent_id > 0 AND owner_id IN (:friends))', 
                'with'=>'authors',
                'order' => 'creation_date DESC',
                'limit' => $this->_limit,
                'params' => array(
                	':friends' => $friends,
                ),
            )
        );
	}
}
