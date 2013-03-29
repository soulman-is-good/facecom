<?php

class UploadController extends Controller {

    public function run($class_name) {
        $path = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' .
                    DIRECTORY_SEPARATOR . 'upload' .
                    DIRECTORY_SEPARATOR . $class_name);        
        $class_name = ucfirst($class_name);
        if($path && is_dir($path) && is_writable($path)){
            $dir = key($_GET);
            $filename = $_GET[$dir];
            $pk = pathinfo($filename,PATHINFO_FILENAME);
            $image = Images::model()->findByPk($pk);
            if($image!=null){
                $image->resize($dir);
            }
        }elseif(class_exists($class_name)){
            $dir = key($_GET);
            $filename = $_GET[$dir];
            $size = explode('x',$dir);
            $path = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' .
                    DIRECTORY_SEPARATOR . 'upload' .
                    DIRECTORY_SEPARATOR . $class_name);
            if(YII_DEBUG && !file_exists($path . DIRECTORY_SEPARATOR . $dir)){
                mkdir($path . DIRECTORY_SEPARATOR . $dir,0777);
            }
            if($path!==FALSE && file_exists($path . DIRECTORY_SEPARATOR . $dir) && 
                    is_file($path . DIRECTORY_SEPARATOR . $filename) && $size[0]>0 && $size[1]>0){
                Yii::import('ext.iwi.Iwi');
                $image = new Iwi($path . DIRECTORY_SEPARATOR . $filename);
                $image->adaptive($size[0], $size[1]);
                $image->save($path . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $filename,0644,TRUE);
                $mime = CFileHelper::getMimeType($path . DIRECTORY_SEPARATOR . $filename);
                header('Content-Type: '.$mime);
                $image->render();
                exit;
            }
        }
        return parent::run($class_name);
    }
}