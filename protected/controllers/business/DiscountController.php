<?php

class DiscountController extends Controller {

    public $layout = 'advert';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionIndex() {
        Yii::app()->user->setState('salePage', 0);
        Yii::app()->clientScript->registerPackage('discount');
        $this->render('index', array());
    }

    public function actionShow($id) {
        Yii::app()->clientScript->registerPackage('discount');
        $model = Discount::model()->findByPk($id);
        if(!$model)
            throw new CException('Page not found', 404);
        $this->render('show', array('model'=>$model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::app()->clientScript->registerPackage('discount-edit');
        $id = null;
        if(isset($_GET['id']))
            $id = (int)$_GET['id'];
        elseif(isset($_POST['Discount']['id']))
            $id = (int)$_POST['Discount']['id'];
            
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $coupons = $model->coupons;
        if (isset($_POST['Discount'])) {
            if(!isset($_POST['Coupon']))
                $model->addError('status',Yii::t('errors','В предложении должен быть хотябы один купон'));
            else{
                $data = $_POST['Coupon'];
                $coupons = array();
                foreach($data as $c){
                    $coupon = null;
                    if(isset($c['id']) && $c['id']>0){
                        $coupon = Coupon::model()->findByPk($c['id']);
                        if(isset($c['delete']))
                            $coupon->delete();
                    }
                    if(!isset($c['delete'])){
                        if($coupon === null)
                            $coupon = new Coupon();
                        $coupon->attributes = $c;
                        $coupons[] = $coupon;
                    }
                }
            }
            $model->attributes = $_POST['Discount'];
            if (!$model->hasErrors() && $model->save()){
                $fail = false;
                foreach($coupons as $coupon){
                    $coupon->discount_id = $model->id;
                    if(!$coupon->save())
                        $fail = true;
                }
                if(!$fail){
                    if(isset($_POST['Cats'])){
                        $cats =array_map('intval',explode(',',$_POST['Cats'])); //Normalize
                        
                        $dicats = DiscountCategory::model()->findAllByAttributes(array('discount_id'=>$model->id));
                        foreach($dicats as $i=>$d){
                            if(FALSE !== ($k=array_search($d->category_id, $cats))){
                                unset($cats[$k]);
                                unset($dicats[$i]);
                            }else
                                $d->delete();
                        }
                        if(!empty($cats)){
                            $cats = Category::model()->findAllByAttributes(array('id'=>$cats));
                            foreach($cats as $c){
                                $DC = new DiscountCategory;
                                $DC->discount_id = $model->id;
                                $DC->category_id = $c->id;
                                if(!$DC->save())
                                    echo CHtml::errorSummary($DC);
                            }
                        }
                    }
                    if(isset($_POST['Region'])){
                        $cats =array_map('intval',explode(',',$_POST['Region'])); //Normalize
                        
                        $dicats = DiscountRange::model()->findAllByAttributes(array('discount_id'=>$model->id));
                        foreach($dicats as $i=>$d){
                            if(FALSE !== ($k=array_search($d->category_id, $cats))){
                                unset($cats[$k]);
                                unset($dicats[$i]);
                            }else
                                $d->delete();
                        }
                        if(!empty($cats)){
                            $cats = City::model()->findAllByAttributes(array('id'=>$cats));
                            foreach($cats as $c){
                                $DC = new DiscountRange;
                                $DC->discount_id = $model->id;
                                $DC->city_id = $c->id;
                                if(!$DC->save())
                                    echo CHtml::errorSummary($DC);
                            }
                        }
                    }
                    $this->redirect('/business/discount');
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'coupons' => $coupons
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if($model!==null && (Yii::app()->user->role == 'admin' || $model->isMyOffice())){
            $model->delete();
            if (Yii::app()->request->isAjaxRequest)
                $this->redirect('/business/discount');
        }else
            throw new CException('Page not found', 404);
    }

    public function actionMore() {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CException('Page not found', 404);
        $page = Yii::app()->user->salePage++;
        $pages = ceil(Discount::model()->count('status')/9);
        $models = Discount::model()->findAll(array(
            'condition'=>(Yii::app()->user->role=='admin'?'1':'status'),
            'limit'=>9,
            'offset'=>9*$page
        ));
        $result = array();
        foreach($models as $model){
            $dayleft = (int)date('d',$model->ends_at) - (int)date('d');
            $timeLeft = date('H:i:s',$model->ends_at - time());
            $result[] = array(
                'id' => $model->id,
                'link' => $this->createUrl('business/discount/show',array('id'=>$model->id)),
                'image' => '/upload/test.png',
                'discount' => $model->maxCoupon()->percent.'%',
                'left' => $dayleft.' дней '.$timeLeft,
                'bought' => '0',
                'title' => $model->title,
                'description' => nl2br($model->text),
                'last'=>(int)($page==$pages-1)
            );
        }
        echo CJSON::encode($result);
        exit;
    }
    

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
            $model = null;
            if($id>0)
		$model=Discount::model()->findByPk($id);
		if($model===null)
                    return new Discount;
			//throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='discount-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}