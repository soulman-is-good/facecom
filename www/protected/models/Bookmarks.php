<?php

/**
 * This is the model class for table "bookmarks".
 *
 * The followings are the available columns in table 'bookmarks':
 * @property integer $id
 * @property integer $owner_id
 * @property integer $type
 * @property integer $content_id
 * @property integer $added
 */
class Bookmarks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bookmarks the static model class
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
		return 'bookmarks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, type, content_id, added', 'required'),
			array('owner_id, type, content_id, added', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner_id, type, content_id, added', 'safe', 'on'=>'search'),
			array('type','match','pattern'=>'/^[0-9]$/'),
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
			'owner_id' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'Owner',
			'type' => 'Type',
			'content_id' => 'Content',
			'added' => 'Added',
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
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('added',$this->added);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function content_id_list($id,$ctype)
	{
		$items=$this->findAll(
			array (
				'condition' => 'owner_id='.$id.' AND `type`='.$ctype,
				'select' => 'content_id',
				'order' => 'added DESC',
			)
    	);
    	$id_list=array();
    	foreach($items as $v)
    	{
    		$id_list[]=$v->content_id;
    	}
    	return $id_list;
	}
    //вызвать этот метод, чтобы добавить элемент в избранное, овнер - ИД юзера, контент - ИД элемента (в его таблице), тип - см. комментарии в таблице "букмарк"
	public function addElem($owner,$content,$type)
	{
		if(!$this->exists(
			array (
				'condition'=>'owner_id='.$owner.' AND content_id='.$content.' AND type='.$type,
			)
		))
		{
			$newItem=new Bookmarks;
			$newItem->owner_id=$owner;
			$newItem->content_id=$content;
		 	$newItem->type=$type;
		 	$newItem->added=time();
		 	$newItem->save();
		}
	}

	//когда бежишь на свет в тоннеле
	//шагов за десять до конца
	//сверни налево там аптечка
	//патроны бонусы и жизнь
	public function remElem($cid,$owner,$type)
	{
		$remItem=$this->find(
			array (
				'condition'=>'content_id = :cid AND owner_id = :owner AND type = :type',
				'params'=>array(':cid'=>$cid,':owner'=>$owner,':type'=>$type)
			)
		);
		return $remItem->delete();
	}

}