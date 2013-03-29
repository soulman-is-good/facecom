<?php

/*
 * File validator
 */
class FileValidator extends CFileValidator {
        /**
         * Image size check.
         * @var array could be two values defining maximum sizes (width,height) or could be defined as 'min','max' keys
         */
        public $sizes = array();
	public function validate($object,$attributes=null)
	{
            if(is_string($attributes))
                $file = CUploadedFile::getInstance ($object, $attributes);
            else if(is_array($attributes) && isset($attributes['@file'])){
                if($attributes['@file'] instanceof CUploadedFile)
                    $file = $attributes['@file'];
                else
                    $file = CUploadedFile::getInstanceByName ($attributes['@file']);
                $attributes = $attributes['@attribute'];
            }else 
                return false;
            $this->validateFile($object, $attributes, $file);
            $this->validateSize($object, $attributes, $file);
	}
        
        protected function validateSize($object,$attribute,$file) {
            if(empty($this->sizes)) 
                return true;
            $size = getimagesize($file->tempName);
            $min = isset($this->sizes['min'])?$this->sizes['min']:false;
            $max = isset($this->sizes['max'])?$this->sizes['max']:($min?false:$this->sizes);
            if($min && ($min[0]>$size[0] || $min[1]>$size[1])){
                $this->addError($object,$attribute,Yii::t('errors',"Размер изображения должен быть не меньше {width} по ширине на {height} по высоте пикселей"),array('width'=>$min[0],'height'=>$min[1]));
            }
            if($max && ($max[0]<$size[0] || $max[1]<$size[1])){
                $this->addError($object,$attribute,Yii::t('errors',"Размер изображения должен быть не больше {width} по ширине на {height} по высоте пикселей"),array('width'=>$max[0],'height'=>$max[1]));
            }
        }
}