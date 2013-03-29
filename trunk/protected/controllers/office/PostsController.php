<?php

class PostsController extends Controller {

    public $layout = 'office';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionIndex()
	{
		Yii::app()->clientScript->registerPackage('office');
		$this->render('/office/posts', array());

	}
}