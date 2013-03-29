<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $id
 * @property string $extension
 */
class Images extends CActiveRecord {

    public $WIDTH = 0;
    public $HEIGHT = 1;
    public $previews = array(
        'full' => array(1280, 1024),
        'small' => array(147, 147),
        'album' => array(179, 179),
        'big' => array(799, 0),
        '80x80' => array(80, 80),
        'mini' => array(40, 40),
        'micro' => array(32, 32),
        'cover'=>array(1024,768),
    );
    public $available_types = array(
        'photo' => array('jpeg', 'jpg', 'png', 'gif'),
        'video' => array('avi', 'flv', 'mpeg', 'mp4', '3gp'),
        'files' => array('doc', 'xls', 'txt')
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Images the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'files';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, extension', 'required'),
            array('id', 'length', 'max' => 50),
            array('extension', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, extension', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'extension' => 'Extension',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('extension', $this->extension, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Resize image to this size
     * 
     * @param string $thumb @see $this->previews
     */
    public function resize($thumb) {
        Yii::import('ext.iwi.Iwi');
        $folder = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'photos';
        $file = $this->id . '.' . $this->extension;
        $folder = DIRECTORY_SEPARATOR . trim($folder, DIRECTORY_SEPARATOR . ' ');
        if (!isset($this->previews[$thumb]))
            return 0;
        $size = $this->previews[$thumb];
        if (!is_file($folder . DIRECTORY_SEPARATOR . $file)) {
            return 0;
        }
        $out_file = $folder . DIRECTORY_SEPARATOR . $thumb . DIRECTORY_SEPARATOR . $file; //output file
        if (is_file($out_file)) {
            return $out_file;
        }
        $image = new Iwi($folder . DIRECTORY_SEPARATOR . $file);
        if ($size[$this->WIDTH] == 0) {
            $image->resize(0, $size[$this->HEIGHT], Image::HEIGHT);
        } elseif ($size[$this->HEIGHT] == 0) {
            $image->resize($size[$this->WIDTH], 0, Image::WIDTH);
        } else {
            $image->adaptive($size[$this->WIDTH], $size[$this->HEIGHT])->crop($size[$this->WIDTH], $size[$this->HEIGHT], 'top', 'center')->sharpen(10);
        }
        if (!file_exists($folder . DIRECTORY_SEPARATOR . $thumb))
            mkdir($folder . DIRECTORY_SEPARATOR . $thumb, 777);
        $image->save($out_file);
        return $out_file;
    }
    
    public function resizeAll() {
        $sizes = $this->previews;
        foreach($sizes as $thumb=>$size){
            if($this->resize($thumb)==0)
                Yii::log ("Ошибка при сжатии изображения '$this->id.$this->extension' до '$thumb'", CLogger::LEVEL_ERROR);
        }
    }

    public function uploadFile($field = 'files', $resize = false, $validator = null, $type = 'photo') {
        $options = array(
            'type' => 'photo',
            'resize' => $resize,
        );
        if (is_array($field)) {
            $options = array_merge($options, $field);
            $field = $options['field'];
        }
        $type = $options['type'];
        $upload = CUploadedFile::getInstanceByName($field);
        if ($upload != null && $upload->error == 0) {
            $folder = Yii::getPathOfAlias('webroot') . '/upload/' . $type . '/';
            $fn = sha1_file($upload->tempName);
            $ext = pathinfo($upload->name, PATHINFO_EXTENSION);
            if (!($validator instanceof CValidator))
                $validator->validate($this, array('@file' => $upload, '@attribute' => 'id'));
            if (!$this->hasErrors()) {
                if (!$this->findByPk($fn)) {
                    $upload->saveAs($folder . $fn . '.' . $ext);
                    $this->isNewRecord = true;
                    $this->id = $fn;
                    $this->type = $type;
                    $this->extension = $ext;
                    if (!$this->save()) {
                        Yii::trace("Error saving file '$upload->name' " . CHtml::errorSummary($temp));
                        return array('error' => CHtml::errorSummary($this));
                    }
                }
                switch ($type) {
                    case 'photo':
                        if ($resize)
                            $this->resizeAll();
                        break;
                    case 'video':
                        $this->convertVideo($folder, $fn . '.' . $ext);
                        break;
                }
            }else {
                return array('error' => CHtml::errorSummary($this));
            }
            return array('filename' => $fn, 'extension' => $ext);
        }
        return false;
    }

}
