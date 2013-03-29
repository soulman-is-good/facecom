<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    // Макет для вывода представления
    public $layout = 'main';
    public $title = 'Facecom';
    public $css;
    public $js;
    // Данные об авторизованном пользователе (а что на счет сессии?)
    public $myProfile;
    // For administative part.. at least....
    public $breadcrumbs = array();
    public $menu = array();

    /**
     *
     * @var boolean задает отобажать боковую панель справа или нет
     */
    public $bDisplayRightPanel = true;
    
    public function init() {
        //internalization in javascript. $.i18n http://www.jquerysdk.com/api/jQuery.i18n.formatDate
    }

    function beforeAction($action) {
        Yii::app()->clientScript->registerScriptFile('/static/js/jquery-ui/i18n.min.js');
        Yii::app()->clientScript->registerScriptFile('/static/js/jquery-ui/i18n/'.Yii::app()->language.'.min.js');        
        parent::beforeAction($action);

        if (Yii::app()->user->isGuest) {
            if (Yii::app()->controller->action->id != 'login') {
                $this->redirect(Yii::app()->createUrl('my/login'));
            }
        }
        else {
            $this->myProfile = UserProfile::model()->getUserProfile(Yii::app()->user->id);
        }

        return true;
    }

}
