<?php

class NewsController extends Controller
{
    public $layout = 'profile';

	public function init() {
            Yii::app()->clientScript->registerPackage('main');
	}

	public function actionIndex()
	{
		// Вывод представления
		$this->render('index', array());
	}

        public function actionSendmessage() {
            $q = isset($_GET['q'])?$_GET['q']:false;
            $fs = fsockopen('127.0.0.1',8000) or die('No connection');
            fwrite($fs, json_encode(array('user_id'=>Yii::app()->user->id,'message'=>$q)));
            echo fread($fs, 1024);
            fclose($fs);
            exit;
        }
        
        public function actionError() {
            $this->layout = 'main';
            $this->render('error404');
        }

        public function actionCities($cid) {
            if(!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest && $cid>0){
                $data = CHtml::listData(City::model()->findAll(array(
                    'select'=>'name',
                    'condition'=>'country_id=:cid','params'=>array(':cid'=>$cid)))
                ,'name','name');
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            throw new CException('Not Found',404);
        }

        public function actionCitiesWithAny($cid) {
            if(!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest){
                if($cid>0)
            	{
            		$base_cities=City::model()->findAll(array(
                    'select'=>'name',
                    'condition'=>'country_id=:cid','params'=>array(':cid'=>$cid)));
              	}
                elseif($cid==-1)
                {
                	$base_cities=array();
                }
                else throw new CException('Not Found',404);
                $any_city=new City;
            	$any_city->name='любой город';
                $any_city->city_id=-1;
                $cities=array_merge(array($any_city),$base_cities);
                $data = CHtml::listData($cities,'name','name');
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            throw new CException('Not Found',404);
        }

	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('id'.Yii::app()->user->id));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

        public function actionResize() {
            $image = Yii::app()->request->getPost('image',false);
            $type = Yii::app()->request->getPost('type',false);
            if($image!==false && in_array($type,array('avatar'))){
                $image = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . trim($image,'/'));
                if(is_file($image)){
                    $filename = basename($image);
                    $md5file = md5_file($image) . $type;
                    $tmp = TemporaryFiles::model()->find('md5file=:md5f',array(':md5f'=>$md5file));
                    if($tmp == null){
                        $to = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload'
                                . DIRECTORY_SEPARATOR . 'TemporaryFiles') . DIRECTORY_SEPARATOR . $filename;
                        if($to && @copy($image, $to)){
                            $image = $to;
                            $size = getimagesize($image);
                            if($size[0]>656 || $size[1]>520){
                                Yii::import('ext.iwi.Iwi');
                                $img = new Iwi($image);
                                $img->resize(656, 520,2);
                                $img->save();
                            }
                            $tmp = new TemporaryFiles();
                            $tmp->md5file = $md5file;
                            $tmp->filename = $filename;
                            $tmp->upload_date = time();
                            $tmp->save();
                        }else if(!is_file($to)){
                            echo CJSON::encode(array('message'=>'Ошибка копирования файла!','status'=>'ERROR'));
                            exit;
                        }else{
                            echo CJSON::encode(array('message'=>basename($to),'status'=>'OK'));
                            exit;
                        }
                    }
                    echo CJSON::encode(array('message'=>$tmp->filename,'status'=>'OK'));
                }
            }
            exit;
        }

        /**
         * Temporary method for clearing temp files linked with TempoaryFiles class
         * @todo remove!!!
         */
        public function actionCleartemp() {
            if(!YII_DEBUG) exit;
            $tmps = TemporaryFiles::model()->findAll('md5file IS NOT NULL');
            $path = realpath(Yii::app()->basePath.'/../upload/TemporaryFiles/');
            $result = true;
            if($path !== FALSE){
                //we will delete after successfully remove all data from database
                //though this is a transaction we couldn't know if the record where deleted or not
                //..not before commit
                $unlinks = array();
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    foreach($tmps as $tmp){
                        if(is_file($path . DIRECTORY_SEPARATOR . $tmp->filename)){
                            $unlinks[] = $path . DIRECTORY_SEPARATOR . $tmp->filename;
                            $tmp->delete();
                        }
                    }
                    $transaction->commit();
                    //$result = array_reduce($unlinks, function($res,$item){ return $res && @unlink($item);},$result);
                }catch(Exception $e){
                    $transaction->rollback();
                }

            }
            var_dump($result);
            exit;
        }
}