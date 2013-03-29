<?php

/**
 * This is the model class for table "photos".
 *
 * The followings are the available columns in table 'photos':
 * @property string $id
 * @property string $album_id
 * @property string $description
 * @property string $place_id
 *
 * The followings are the available model relations:
 * @property Albums $album
 */
class Photos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photos the static model class
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
		return 'photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_id', 'required'),
			array('album_id, place_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_id, description, place_id', 'safe', 'on'=>'search'),
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
			'album' => array(self::BELONGS_TO, 'Albums', 'album_id'),
			'image' => array(self::BELONGS_TO, 'Files', 'file'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'album_id' => 'Album',
			'description' => 'Description',
			'place_id' => 'Place',
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
		$criteria->compare('album_id',$this->album_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('place_id',$this->place_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getLastInAlbum($album_id)
	{
		return $this->find(array(
    		'select' => 'file',
    		'condition' => 'album_id=:album_id',
    		'order' => 'id DESC',
    		'limit' => 1,
    		'params' => array(':album_id'=>$album_id)
    	));
	}

	public function getCountInAlbum($album_id)
	{
		return $this->count('album_id = :album_id',array(':album_id' => $album_id));
	}

	public function getAroundInfo($id, $album_id)
	{
		$photos = $this->findAll(array(
			'select' => 'id',
			'condition' => 'album_id = :album_id',
			'params' => array(':album_id' => $album_id),
		));

		$count = count($photos);

		foreach($photos as $ind => $photo)
		{
			if($photo['id'] == $id)
			{
				$num = $ind + 1;
				if($ind == 0)
					$prev = $photos[$count-1]->id;
				else
					$prev = $photos[$ind-1]->id;
				if($ind == $count-1)
					$next = $photos[0]->id;
				else
					$next = $photos[$ind+1]->id;
			}
		}

		return array('num' => $num, 'count' => $count, 'prev' => $prev, 'next' => $next);
	}

	public function LoadLimited($album_id, $ofset, $limit = 20)
	{
		return $this->findAll(array(
			'select' => 't.id, file',
			'with' => 'image',
			'condition' => 'album_id = :album_id',
			'limit' => $limit,
			'offset' => $ofset,
			'params' => array(':album_id' => $album_id),
		));
	}

	//������� ��� �������� <--От винта! Используем UTF-8 братцы, не забваем конвертнуть!
	public function ParametrizedLoadLimited($cond, $ofset, $limit = 20)
	{
		return $this->findAll(array(
			'select' => 'id, file',
			'with' => 'image',
			'condition' => $cond,
			'limit' => $limit,
			'offset' => $ofset
		));
	}

	public function deleteItem($photo = null, $album = null, $photo_id = null, $drop_album_if_empty = true)
	{
		if($photo == null && $photo_id != null)
			$photo = $this->findByPk($photo_id);
		if($album == null && $photo != null)
			$album = Albums::model()->find('user_id = :my_id AND id = :album_id', array(':my_id' => Yii::app()->user->id, ':album_id' => $photo['album_id']) );
		if($album != null && $photo != null)
		{
			if($album['current_photo'] == $photo['id'])
			{
				$album->current_photo = 0;
				$album->save();
			}
			$folder=Yii::getPathOfAlias('webroot').'/upload/photos/';
			$photo->delete();
			if($drop_album_if_empty)
			{
				if($this->count('album_id = :album_id', array('album_id' => $album['id'])) == 0)
				{
					$album->delete();
				}
			}
			return 'ok';
		}else{return 'no_album';}
	}

	public function deletePhotosInAlbum($album_id, $album = null)
	{
		$photos = $this->findAll(array(
			'select' => 'file',
			'condition' => 'album_id = :album_id',
			'params' => array(':album_id' => $album_id),
		));
		if($album == null)
			$album = Albums::model()->findByPk($album_id);
		foreach($photos as $photo)
			$this->deleteItem($photo, $album, null, false);
	}
}