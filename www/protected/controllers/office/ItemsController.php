<?php

class ItemsController extends Controller {

    public $layout = 'profile';

    //public $defaultAction = 'p_and_s';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionIndex($oid) {
        Yii::app()->clientScript->registerPackage('items');
        $cdb = new CDbCriteria(array(
            'condition'=>'office_id=:oid',
            'params'=>array(
                'oid'=>$oid
            )
        ));
        if(isset($_GET['tags']) && $_GET['tags']!=''){
            $tags = explode('+',urldecode($_GET['tags']));
            //TODO: SQL Injection breach fix
            $cdb->join = "INNER JOIN items_category ic ON ic.item_id=t.id INNER JOIN category c ON c.id=ic.category_id";
            $cname = "'".implode("','",  $tags)."'";
            $cdb->addCondition("c.name IN ($cname)");
            $cdb->distinct = true;
        }
        $cnt = Items::model()->count($cdb);
        $paginator = new Paginator('Image',$cnt);
        $paginator->applyLimit($cdb);
        $models = Items::model()->findAll($cdb);
        $this->render('index',array('models'=>$models));
    }

    public function actionShow($name) {
        Yii::app()->clientScript->registerPackage('items');
        $id = (int)trim(strrchr($name, '-'),'-');
        $model = Items::model()->findByPk($id);
        $this->render('show', array('model'=>$model));
    }
    
    public function actionCreate() {
        Yii::app()->clientScript->registerPackage('items-edit');
        if(!isset($_GET['id']) || NULL==($model = Items::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'id'=>(int)$_GET['id'])))){
            $model = new Items;
        }
        if(isset($_POST['Items'])){
            $model->attributes = $_POST['Items'];
            $fn = Files::model()->uploadFile('Items[image]');
            if($fn)
                $model->image = $fn['filename'];
            elseif(isset($_POST['Items']['image_src']))
                $model->image = $_POST['Items']['image_src'];
            $new = $model->isNewRecord;
            if($model->save()){
                $cats = isset($_POST['categories'])?$_POST['categories']:array();
                if(!$new && empty($cats)) {
                    ItemsCategory::model()->deleteAllByAttributes(array('item_id'=>$model->id));
                }else{
                    if(!$new){
                        $dbcats = ItemsCategory::model()->findAll('item_id=:iid',array('iid'=>$model->id));
                        $ids = array();
                        foreach($dbcats as $i=>$dbc){
                            if(false!==($k=array_search($dbc->category_id, $cats))){
                                unset($cats[$k]);
                                unset($dbc[$i]);
                            }else {
                                $ids[] = $dbc->category_id;
                            }
                        }
                        //deleteing corresponding categories
                        if(!empty($ids)){
                            $ids = implode(",",$ids);
                            ItemsCategory::model()->deleteAll('item_id=:iid AND category_id IN (:cid)', array('iid'=>$model->id,'cid'=>$ids));
                        }
                    }
                    if(!empty($cats)){
                        foreach($cats as $cat){
                            $c = new ItemsCategory();
                            $c->attributes = array('category_id'=>$cat,'item_id'=>$model->id);
                            $c->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('ItemSaved','1');
                $this->refresh();
            }
        }
        $this->render('_form',array('model'=>$model));
    }

}