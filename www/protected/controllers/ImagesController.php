<?php

class ImagesController extends Controller {

    public function run($thumb) {
        $x = $_GET;
        end($x);
        $key = strtok(key($x),'.');
        if (NULL == ($file = Files::model()->findByPk($key))){
            throw new CException('Page not found', 404);
        }

        $path = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'upload' .
                DIRECTORY_SEPARATOR . 'photos';
        $src_file = $file->id . '.' . $file->extension;
        $in_file = $path . DIRECTORY_SEPARATOR . $src_file;
        $out_file = $path . DIRECTORY_SEPARATOR . $thumb . DIRECTORY_SEPARATOR . $src_file;
        if (is_file($out_file)) {
            $mime = CFileHelper::getMimeType($out_file);
            header('Content-Type: ' . $mime);
            readfile($out_file);
            exit;
        }
        if (is_file($in_file)) {
            $dir = $path . DIRECTORY_SEPARATOR . $thumb;
            if (YII_DEBUG && !file_exists($dir)) {
                @mkdir($dir, 7777);
            }
            //die($dir);
            if (file_exists($dir)) {
                $image = false;
                if (($image = $file->resize($thumb)) == 0){
                    if(is_file($out_file)){
                        $mime = CFileHelper::getMimeType($in_file);
                        header('Content-Type: ' . $mime);
                        readfile($out_file);
                        exit;
                    }
                    throw new CException('Page not found', 404);
                }
                $mime = CFileHelper::getMimeType($in_file);
                header('Content-Type: ' . $mime);
                $image->render();
                exit;
            }
        }
        return parent::run($thumb);
    }

}