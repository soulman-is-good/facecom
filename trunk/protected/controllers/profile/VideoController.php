<?php

class VideoController extends Controller
{
	public $layout = 'profile';

	public function init() {
        Yii::app()->clientScript->registerPackage('main');
        Yii::app()->clientScript->registerPackage('videos');
    }

    public function actionIndex($id)
	{
        Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD);
        
    	$user = UserProfile::model()->getUserProfile($id);
        $myPage = (Yii::app()->user->id == $id);

        $videos = Videos::model()->findAll('user_id=:id',array(':id'=>$id));
        $videos_count = count($videos);

		$this->render('index', array( 'profile' => $user, 'myPage' => $myPage, 'videos' => $videos, 'videos_count' => $videos_count ) );
	}
    
}