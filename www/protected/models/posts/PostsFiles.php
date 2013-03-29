<?php

/**
 * This is the model class for table "posts_files".
 *
 * The followings are the available columns in table 'posts_files':
 * @property string $id
 * @property string $posts_id
 * @property string $filename
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Posts $posts
 */
class PostsFiles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostsFiles the static model class
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
		return 'posts_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('posts_id, filename, type', 'required'),
			array('posts_id', 'length', 'max'=>10),
			array('filename', 'length', 'max'=>100),
			array('type', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, posts_id, filename, type', 'safe', 'on'=>'search'),
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
			'posts' => array(self::BELONGS_TO, 'Posts', 'posts_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'posts_id' => 'Posts',
			'filename' => 'Filename',
			'type' => 'Type',
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
		$criteria->compare('posts_id',$this->posts_id,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getAroundInfo($id, $post_id)
	{
		$photos = $this->findAll(array(
			'select' => 'id',
			'condition' => 'posts_id = :post_id AND type = "photos"',
			'params' => array(':post_id' => $post_id),
		));

		$count = count($photos);

		foreach($photos as $ind => $photo)
		{
			if($photo['id'] == $id)
			{
				$num = $ind + 1;
				if($ind == 0)
					$prev = $photos[$count-1];
				else
					$prev = $photos[$ind-1];
				if($ind == $count-1)
					$next = $photos[0];
				else
					$next = $photos[$ind+1];
			}
		}

		return array('num' => $num, 'count' => $count, 'prev' => $prev, 'next' => $next);
	}


	public function addFiles($post_id)
	{
		$folder=Yii::getPathOfAlias('webroot').'/upload';
		foreach($_POST['files'] as $files)
		{
			foreach($files as $object_id => $type)
			{
				$this->isNewRecord = true;
				$this->id = 0;
				$this->posts_id = $post_id;
				$this->upload_date = time();
				if($type == 'album')
				{
					if($photo = Photos::model()->findByPk($object_id))
					{

						if(file_exists($folder.'/photos/'.$photo['filename'])) 
						{
							$this->filename = $photo['filename'];
							$this->type = 'photos';
							$this->description = $photo['description'];
							$this->save();
						}
					}
				}elseif($type == 'uploaded')
				{
					if($temp = TemporaryFiles::model()->findByPk($object_id))
					{
						if(file_exists($folder.'/photos/'.$temp['filename']))
						{
							$this->filename = $temp['filename'];
							$this->type = 'photos';
							$this->description = $temp['description'];
							$this->save();
						}
						$temp->delete();
					}
				}
			}
		}
		
	}
}