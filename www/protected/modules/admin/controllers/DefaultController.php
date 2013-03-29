<?php

class DefaultController extends Controller {

    public function actionIndex() {
        if (!Yii::app()->user->isGuest)
            $this->render('index');
        else {
            $model = new AdminLoginForm;
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['AdminLoginForm'])) {
                $model->attributes = $_POST['AdminLoginForm'];
                if ($model->validate() && $model->login())
                    $this->refresh();
            }            
            $this->render('login',array('model'=>$model));
        }
    }
    
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }    

}