<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileHelper
 *
 * @author maxim
 */
class FileHelper extends CFileHelper implements RecursiveIterator {
    
    private $_handle = null;
    private $_directory = '';
    private $_file = '';
    private static $_counter = 0;
    
    public function __construct($dir) {
        $this->_directory = $dir;
        $this->_handle = @opendir($dir);
    }
    
    public static function cleanUpload($className,$src) {
        $path = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' .
                DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $className);
        $files = new self($path);
        $files->removeFileRecursive($src);
        Yii::log('FileHelper: ' . self::$_counter . ' files were deleted.');
    }
    
    public function removeFileRecursive($src) {
        $i = 0;
        foreach($this as $dir=>$file){
            $filename = $this->getDirectory() . DIRECTORY_SEPARATOR . $file;
            if($this->hasChildren()){
                $this->getChildren()->removeFileRecursive($src);
            }
            if($file!='' && $src === $file){
                @unlink($filename);
                self::$_counter++;
            }
        }
    }
    
    public function getDirectory() {
        return $this->_directory;
    }
    
    public function setDirectory($dir) {
        if(is_dir($dir)){
            $this->_file = '';
            $this->_directory = $dir;
            $this->_handle = readdir($dir);
        }
    }

    public function current() {
        return $this->_file;
    }

    public function getChildren() {
        return $this->hasChildren()?new self($this->_directory . DIRECTORY_SEPARATOR . $this->_file):null;
    }

    public function hasChildren() {
        return $this->_file!='' && $this->_file != '.' && $this->_file != '..' && is_dir($this->_directory . DIRECTORY_SEPARATOR . $this->_file);
    }

    public function key() {
        $this->_directory;
    }

    public function next() {
        return $this->_file = @readdir($this->_handle);
    }

    public function rewind() {
        $this->_file = '';
        return $this->_handle = @opendir($this->_directory);
    }

    public function valid() {
        return is_resource($this->_handle) && $this->_file !== FALSE;
    }
}
