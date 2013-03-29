<?php

class ContactsController extends Controller {

    public $layout = 'office';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

        
}