<?php

class FeedController extends Controller {

    public $layout = 'profile';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }
    
    public function actionIndex() {
        Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD); // хуй знает что это
        $myFriends = UserFriends::model()->getFriends($this->myProfile->user_id);

        foreach ($myFriends as $key => $item) {
            $friends .= ', '.$item->friend_id;
        }

        $friends = trim($friends, ',');
        $wall = new Posts; // Получаем последние 10 постов
        $wall->_limit = Yii::app()->params->maxPostPerRequest; // Количество получаемых постов

        Yii::app()->clientScript->registerPackage('profile-index');
        $this->render('index', array(
            'myProfile' => $this->myProfile,
            'wall' => $wall->getMyFeed($friends),
        ));
    }

}
