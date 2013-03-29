<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $id
 * @property string $extension
 */
class Files extends CActiveRecord {

    public $WIDTH = 0;
    public $HEIGHT = 1;
    public $previews = array(
        'small' => array(147, 147),
        'album' => array(179, 179),
        'big' => array(799, 0),
        'productico' => array(122, 122),
        '80x80' => array(80, 80),
        'avatar' => array(190, 192),
        'cover' => array(1024, 768),
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
     * Returns file name.
     * 
     * @author Maxim Savin <i@soulman.kz>
     * @param string $name hash of the file
     * @return string Filename
     */
    public static function getFile($name) {
        $file = self::model()->findByPk($name);
        return $name . '.' . $file->extension;
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
        //$folder = DIRECTORY_SEPARATOR . trim($folder, DIRECTORY_SEPARATOR . ' ');
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

    public function convertVideo($folder, $fn, $ext, $previews) {
        $photo_dir = Yii::getPathOfAlias('webroot') . '/upload/photos/';
        if ($ext != 'flv') {
            $s = passthru('ffmpeg -i ' . $folder . $fn . '.' . $ext . ' -ar 22050 -ab 32k -f flv -b 700k -s 320x240 -ac 2 -y ' . $folder . $fn . '.flv');
        }
        exec('ffmpeg -i ' . $folder . $fn . '.' . $ext . '  -an -ss 00:00:03 -t 00:00:01 -r 1 -y ' . $photo_dir . $fn . '.jpg');
        $this->resizeAll();
    }

    /**
     * 
     * @param mixed $param could be either upload name or array of params.<br/>
     *  An array will be like this:<br/><pre>
     * array(
     *  'field' => 'files', //field name
     *  'type' => 'photos', //kind of file: 'photos' or 'video'
     *  'resize' => false,  //will photos be resized now
     *  'previews' => $this->previews, //what thumbs will be generated
     * )
     * </pre>
     * @return mixed Array of basename of the file and it's extension or false otherwise
     */
    public function uploadFile($param = array()) {
        $options = array(
            'field' => 'files',
            'type' => 'photos',
            'resize' => false,
            'previews' => $this->previews,
        );
        if(is_string($param))
            $options['field'] = $param;
        else
            $options = array_merge($options, $param);

        $folder = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $options['type'] . DIRECTORY_SEPARATOR;
        $upload = CUploadedFile::getInstanceByName($options['field']);
        if($upload==null || $upload->error!=0)
            return false;
        $fn = sha1_file($upload->tempName);
        $ext = pathinfo($upload->name, PATHINFO_EXTENSION);
        $return_ext = 'jpg';
        switch ($options['type']) {
            case 'photos':$return_ext = $ext;
                break;
            case 'video':$return_ext = 'jpg';
                break;
        }

        $error = false;
        if (!$this->findByPk($fn)) {
            move_uploaded_file($upload->tempName, $folder . $fn . '.' . $ext);
            $this->isNewRecord = true;
            $this->type = $options['type'];
            $this->id = $fn;
            $this->extension = $ext;

            switch ($options['type']) {
                case 'photos':
                    /*if (FALSE !== ($coords = $this->getLongLat())) {
                        $error = Filemarks::addPlace($coords, '14', $fn);
                    }*/

                    if ($options['resize'])
                        $this->resizeAll();
                    break;
                case 'video':
                    $this->convertVideo($folder, $fn, $ext, $options['previews']);
                    break;
            }

            $this->save();
        }
        return array('filename' => $fn, 'extension' => $return_ext, 'error' => $error);
    }
    
    /**
     * Gets Longitude and Latitude information from a photo exif data, if exists.
     * 
     * @return mixed array of longitude and latitude or false otherwise
     */
    public function getLongLat() {
        try {
            $exif = read_exif_data('upload/photos/' . $this->id . '.' . $this->extension);
            if (isset($exif["GPSLongitude"], $exif['GPSLongitudeRef'], $exif["GPSLatitude"], $exif['GPSLatitudeRef'])) {
                $lon = $this->getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                $lat = $this->getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                return array('lat' => $lat, 'long' => $lon);
            }
        } catch (Exception $e) {
            
        }
        return false;
    }

    private function getGps($exifCoord, $hemi) {

        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    private function gps2Num($coordPart) {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

}