<?php

class CategoryController extends Controller
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    
       public function actionFetch() {
           if(!Yii::app()->request->isAjaxRequest)
               throw new CException('Page not found', 404);
           $cri = new CDbCriteria();
           $cri->select = 'id, title';
           if(isset($_GET['cid'])){
               $cri->addCondition('parent_id=:cid');
               $cri->params['cid']=(int)$_GET['cid'];
           }else
               $cri->addCondition('parent_id IS NULL');
               
           $cats = array();
           $models = Category::model()->findAll($cri);
           foreach($models as $model) {
               $cats[$model->id] = $model->title;
           }
           echo CJSON::encode($cats);
           exit;
       }
}