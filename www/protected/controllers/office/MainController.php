<?php

class MainController extends Controller {

    public $layout = 'profile';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionIndex()
	{
		Yii::app()->clientScript->registerPackage('office');
                $models = Office::model()->findAll('user_id=:uid',array(':uid'=>Yii::app()->user->id));
		$this->render('/office/index', array('models'=>$models));

	}
        

    public function actionAbout($oid)
	{
		Yii::app()->clientScript->registerPackage('office');
                if(NULL == ($office = Office::model()->findByPk($oid)))
                    throw new CException('Page not found',404);
		$this->render('/office/about', array('model'=>$office));
	}
        

    public function actionContacts($oid)
	{
		Yii::app()->clientScript->registerPackage('office');
                if(NULL == ($office = Office::model()->findByPk($oid)))
                    throw new CException('Page not found',404);
		$this->render('/office/contacts', array('model'=>$office));

	}
        
        public function actionNames() {
            if(!Yii::app()->request->isAjaxRequest)
                throw new CException('Page not found', 404);
            $q = Yii::app()->request->getQuery('q');
            $cri = new CDbCriteria();
            $cri->addCondition('status')->addCondition('name LIKE :q');
            $cri->params['q'] = "%$q%";
            if(Yii::app()->user->getState('role') == 'user'){
                $cri->addCondition('user_id=:uid');
                $cri->params['uid'] = Yii::app()->user->id;
            }
            $cri->limit = 30;
            $models = Office::model()->findAll($cri);
            $res = array();
            foreach($models as $model){
                $res[$model->id] = $model->name;
            }
            echo CJSON::encode($res);
            exit;
        }
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                Yii::app()->clientScript->registerPackage('office-edit');
		$model=new Office;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Office']))
		{
			$model->attributes=$_POST['Office'];
                        $model->user_id = Yii::app()->user->id;
                        $fl = Files::model()->uploadFile('Office[avatar]');
                        $model->avatar = $fl['filename'];
                        $fl = Files::model()->uploadFile('Office[background]');
                        $model->background = $fl['filename'];
                        if(Yii::app()->request->getPost('city')){
                            $city = Yii::app()->request->getPost('city');
                            $city = City::model()->find(array('select'=>'city_id','condition'=>"`name` LIKE :city",'params'=>array(':city'=>$city)));
                            if($city!=null)
                                $model->city_id = $city->city_id;
                            else
                                $model->addError('city_id',Yii::t('errors','Такого города не существует'));
                        }else{
                            $model->addError('city_id',Yii::t('errors','Нужно указать город'));
                        }                        
			if($model->save())
				$this->redirect(array('/office'));
		}
                
                $country_id = 0;
                if(is_null($model->city_id)){
                    $country_id = 1894;
                    $city = City::model()->find('city_id=1913')->name;
                }else{
                    $country_id = $model->city->country_id;
                    $city = $model->city->name;
                }
                $countries = CHtml::listData(Country::model()->findAll(array('select'=>'country_id, name')), 'country_id', 'name');

		$this->render('/office/create',array(
			'model'=>$model,
                        'country_id'=>$country_id,
                        'countries'=>$countries,
                        'city'=>$city
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($oid)
	{
                Yii::app()->clientScript->registerPackage('office-edit');
                $id = Yii::app()->user->id;
		$model=$this->loadModel($id,$oid);
                if($model == NULL)
                    throw new CException('Page not found',404);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Office']))
		{
			$model->attributes=$_POST['Office'];
                        $model->user_id = Yii::app()->user->id;
                        $fl = Files::model()->uploadFile('Office[avatar]');
                        if(!$fl)
                            $model->avatar = $_POST['Office']['avatar_src'];
                        else
                            $model->avatar = $fl['filename'];
                        $fl = Files::model()->uploadFile('Office[background]');
                        if(!$fl)
                            $model->background = $_POST['Office']['background_src'];
                        else
                            $model->background = $fl['filename'];
                        if(Yii::app()->request->getPost('city')){
                            $city = Yii::app()->request->getPost('city');
                            $city = City::model()->find(array('select'=>'city_id','condition'=>"`name` LIKE :city",'params'=>array(':city'=>$city)));
                            if($city!=null)
                                $model->city_id = $city->city_id;
                            else
                                $model->addError('city_id',Yii::t('errors','Такого города не существует'));
                        }else{
                            $model->addError('city_id',Yii::t('errors','Нужно указать город'));
                        }                        
			if($model->save())
                            $this->refresh();
		}
                
                $country_id = 0;
                if(is_null($model->city_id)){
                    $country_id = 1894;
                    $city = City::model()->find('city_id=1913')->name;
                }else{
                    $country_id = $model->city->country_id;
                    $city = $model->city->name;
                }
                $countries = CHtml::listData(Country::model()->findAll(array('select'=>'country_id, name')), 'country_id', 'name');

		$this->render('/office/update',array(
			'model'=>$model,
                        'country_id'=>$country_id,
                        'countries'=>$countries,
                        'city'=>$city
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($oid)
	{
                $id = Yii::app()->user->id;
		$this->loadModel($id,$oid)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id,$oid)
	{
		$model=Office::model()->find('user_id=:uid AND id=:oid',array(':uid'=>$id,':oid'=>$oid));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='office-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
}