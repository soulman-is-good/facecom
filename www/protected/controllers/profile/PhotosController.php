<?php

class PhotosController extends Controller
{
    public $layout = 'profile';

	public function init() {
        Yii::app()->clientScript->registerPackage('main');
        Yii::app()->clientScript->registerPackage('photos');
    }

	public function actionIndex($id)
	{
        Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD);

    	$user = UserProfile::model()->getUserProfile($id);
        $myPage = (Yii::app()->user->id == $id);

        $albums = Albums::model()->findAll('user_id=:id',array(':id'=>$id));
        $albums_count = count($albums);
        $photos = Photos::model();

		$this->render('index', array( 'profile' => $user, 'myPage' => $myPage, 'albums' => $albums, 'albums_count' => $albums_count, 'photos' => $photos ) );
	}

    public function actionShow($id,$mid)
    {
        Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD);

        $user = UserProfile::model()->getUserProfile($id);
        $myPage = (Yii::app()->user->id == $id);

        if( $album = Albums::model()->find('user_id=:user_id AND id = :album_id', array('user_id' => $id, 'album_id' => $mid) ) )
        {
            $model = Photos::model();
            $photos = $model->LoadLimited($mid,0);
            $list = $this->renderPartial('//profile/aphotos/photos_list', array('photos' => $photos, 'user_id' => $id), true);
            $this->render('photos', array( 'model' => $model, 'profile' => $user, 'myPage' => $myPage, 'album' => $album, 'photos_count' => count($photos), 'list' => $list ) );
        }else echo 'Альбом не существует.';

    }
}