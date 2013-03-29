<?php

class BookmarksController extends Controller {

    public $layout = 'profile';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

	public function actionIndex($id)
    {   Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerPackage('photos');
        $user = UserProfile::model()->getUserProfile($id);
        $myPage = (Yii::app()->user->id == $id);
        $photo_id_list=Bookmarks::model()->content_id_list($id,1);
        $model = Photos::model();
        $idcond=(empty($photo_id_list))?'0':implode(' OR `t`.`id`=',$photo_id_list);
        $cond='`t`.`id`='.$idcond;
        $photos = $model->ParametrizedLoadLimited($cond,0);
        $list = $this->renderPartial('_photos_list', array('photos' => $photos, 'user_id' => $id), true);
        $this->render('photos', array( 'model' => $model, 'profile' => $user, 'myPage' => $myPage,'photos_count' => count($photos), 'list' => $list ) );
    }



    public function actionVideo($id)
    {   Yii::app()->clientScript->registerScript('global_user_id', 'var glUserId = '.$id.';', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerPackage('videos');
        $user = UserProfile::model()->getUserProfile($id);
        $myPage = (Yii::app()->user->id == $id);
        $video_id_list=Bookmarks::model()->content_id_list($id,2); // $photo_id_list
        $model = Videos::model();                                  // Photos::model();
        $idcond=(empty($video_id_list))?'0':implode(') OR (`t`.`id`=',$video_id_list);
        $cond='`t`.`id`='.$idcond;
        $videos = $model->ParametrizedLoadLimited($cond,0);        // $photos
        $list = $this->renderPartial('_videos_list', array('videos' => $videos, 'user_id' => $id), true);
        $this->render('videos', array( 'model' => $model, 'profile' => $user, 'myPage' => $myPage, 'videos_count' => count($videos), 'list' => $list ) );
    }

    public function actionPhoto_add($mid)
    {
    	$my_id=Yii::app()->user->id;
    	Bookmarks::model()->addElem($my_id,$mid,1);
    	$this->redirect(Yii::app()->request->baseUrl.'/id'.$my_id.'/bookmarks');
    }

    public function actionPhoto_ajax_add()
    {
    	$mid=Yii::app()->getRequest()->getPost('mid');
    	$my_id=Yii::app()->user->id;
    	Bookmarks::model()->addElem($my_id,$mid,1);
    	echo json_encode(array('status' => 'ok'));
    }

    public function actionVideo_add($mid)
    {
    	$my_id=Yii::app()->user->id;
    	Bookmarks::model()->addElem($my_id,$mid,2);
    	$this->redirect(Yii::app()->request->baseUrl.'/id'.$my_id.'/bookmarks/video');
    }

    public function actionShow($id, $mid)
	{
		//$photos = Photos::model();
		//$photo = $photos->findByPk($mid);
		$ap=Bookmarks::model()->findAll(array(
			'select' => 'content_id',
			'condition' => 'owner_id = :id AND type = 1',
			'params' => array(':id' => $id),
		));
		$count = count($ap);
		foreach($ap as $ind => $ph)
		{   if($ph['content_id'] == $mid)
			{	$num = $ind + 1;
				if($ind == 0)
					$prev = $ap[$count-1]['content_id'];
				else
					$prev = $ap[$ind-1]['content_id'];
				if($ind == $count-1)
					$next = $ap[0]['content_id'];
				else
					$next = $ap[$ind+1]['content_id'];
			}
		}
		$aroundInfo = array('num' => $num, 'count' => $count, 'prev' => $prev, 'next' => $next);
		$myProfile = UserProfile::model()->getUserProfile(Yii::app()->user->id);
		$myPage = ($id == Yii::app()->user->id);
		$comments = Comments::model()->getLast('photos', $mid, 10);
		$comments = array_reverse($comments);
		$photo = Photos::model()->findByPk($mid);
  		$this->renderPartial('_show_photo', array('photo' => $photo, 'nav_link' => 'show', 'user_id' => $id, 'aroundInfo' => $aroundInfo, 'myProfile' => $myProfile, 'myPage' => $myPage, 'comments' => $comments, 'comments_tbl' => 'photos'));
	}

	public function actionDelete_photo($id,$mid)
	{   if($id==Yii::app()->user->id)
		{
			$mid=Yii::app()->getRequest()->getPost('mid');
			if(Bookmarks::model()->remElem($mid,$id,1))$status='ok'; else $status='unable';
			echo json_encode(array('status' => $status));
		} else {
			echo json_encode(array('status' => 'no_permissions'));
		}
	}

	public function actionMore($id)
	{
		$photo_id_list=Bookmarks::model()->content_id_list($id,1);
		$idcond=(empty($photo_id_list))?'0':implode(' OR `id`=',$photo_id_list);
        $cond='`id`='.$idcond;
		$photos = Photos::model()->ParametrizedLoadLimited($cond,$_POST['offset']);
		$list = $this->renderPartial('_photos_list', array('photos' => $photos, 'user_id' => $id), true);

		echo json_encode( array('photos_count' => count($photos), 'data' => $list) );
	}
}
