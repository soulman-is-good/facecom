<?php

/**
 * 
 * WHAT FOR IS THIS FILE!!!
 * 
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $id
 * @property string $extension
 */
class Files extends CActiveRecord
{
	public $WIDTH = 0;
	public $HEIGHT = 1;

	public $previews = array(
		'small' => array(147,147),
		'album' => array(179,179),
		'big' => array(799,0),
		'80x80' => array(80,80)
	);

	public $available_types = array(
		'photo' => array('jpeg','jpg', 'png', 'gif'),
		'video' => array('avi', 'flv', 'mpeg', 'mp4', '3gp'),
		'files' => array('doc', 'xls', 'txt')
	);
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Images the static model class
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
		return 'files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, extension', 'required'),
			array('id', 'length', 'max'=>50),
			array('extension', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, extension', 'safe', 'on'=>'search'),
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
			'extension' => 'Extension',
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
		$criteria->compare('extension',$this->extension,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function resize($folder, $file, $sizes)
	{
                $previews = $this->previews;
                if(is_string($sizes))
                    $previews = isset($this->previews[$sizes])?$this->previews[$sizes]:$this->previews;
                else if(is_array($sizes))
                    $previews = array_intersect_key($this->previews, array_fill_keys($sizes, '1'));
                if($folder === null)
                    $folder = Yii::getPathOfAlias('webroot').'/upload/photos';
                if($file === null)
                    $file = $this->id . '.' . $this->extension;
                $folder = '/' . trim($folder,'/ ');
                var_dump($previews);
                exit;
		foreach($this->previews as $sub => $size)
		{
                    if(is_file($folder.'/'.$sub.'/'.$file)) continue;
			$image = new Iwi($folder.'/'.$file);
			if($size[$this->WIDTH] == 0){
				$image->resize(0, $size[$this->HEIGHT], Image::HEIGHT);
			}elseif($size[$this->HEIGHT] == 0){
				$image->resize($size[$this->WIDTH], 0, Image::WIDTH);
			}else{
				$image->adaptive($size[$this->WIDTH], $size[$this->HEIGHT])->crop($size[$this->WIDTH], $size[$this->HEIGHT], 'top', 'center')->sharpen(10);
			}
			if(!file_exists($folder.'/'.$sub))
				mkdir($folder.'/'.$sub, 777);
			$image->save($folder.'/'.$sub.'/'.$file);
		}
	}

	public function convertVideo()
	{

	}

	public function uploadFile($param = array())
	{
		$options = array(
			'field' => 'files',
			'type' => 'photos',
			'resize' => true,
			'previews' => $this->previews,
		);
		$options = array_merge ($options, $param);
		
		$folder = Yii::getPathOfAlias('webroot').'/upload/'.$options['type'].'/';
		$fn = sha1_file($_FILES[$options['field']]['tmp_name']);
		$ext = pathinfo($_FILES[$options['field']]['name'], PATHINFO_EXTENSION);

		if(!$this->findByPk($fn))
		{
			move_uploaded_file($_FILES['files']['tmp_name'], $folder.$fn.'.'.$ext);
			$this->isNewRecord = true;
			$this->id = $fn;
			$this->extension = $ext;
			
			switch ($options['type']) {
				case 'photo':
					if($options['resize'])
						$this->resize($folder, $fn.'.'.$ext, $options['previews']);
					break;
				case 'video':
					$this->convertVideo($folder, $fn.'.'.$ext);
					break;
			}

			$this->save();
		}
		return array('filename' => $fn, 'extension' => $ext);
	}
}