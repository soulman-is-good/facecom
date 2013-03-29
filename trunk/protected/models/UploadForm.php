<?php
class UploadForm extends CFormModel
{
    public $upload_file;

    public function rules()
    {
        return array(
        array('upload_file', 'file', 'types'=>'jpg,jpeg,gif,png'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'upload_file'=>'Upload File',
        );
    }

}