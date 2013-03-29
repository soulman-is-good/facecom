<?php

class AvideosController extends CController
{
	public function actionShow($id, $mid)
	{
		$videos = new Videos;
		$video = $videos->findByPk($mid);
		$aroundInfo = $videos->getAroundInfo($mid);
		$myProfile = UserProfile::model()->getUserProfile(Yii::app()->user->id);

		$my_videos = array();
        if(Yii::app()->user->id == $id){
            $myPage = true;
        }else{
            $mypage = false;
            $videos_on_my_page = Videos::model()->findAll(array(
                'select' => 'file',
                'condition' => 'user_id=:id',
                'params' => array(':id'=>Yii::app()->user->id)
            ));
            foreach($videos_on_my_page as $my_video){
                $my_videos[] = $my_video['file'];
            }
        }

		$comments = Comments::model()->getLast('videos', $mid, 10);
		$comments = array_reverse($comments);
		
		$this->renderPartial('show_video', array('video' => $video, 'my_videos' => $my_videos, 'nav_link' => 'show', 'user_id' => $id, 'aroundInfo' => $aroundInfo, 'myProfile' => $myProfile, 'myPage' => $myPage, 'comments' => $comments, 'comments_tbl' => 'videos', 'comments_item_id' => $video->id));
	}

	public function actionAdd($id)
	{
		$this->renderPartial('add_video', array('user_id' => $id) );
	}
	public function actionUpload()
	{
		$ret = Files::Model()->uploadFile(array('type' => 'video'));
		echo json_encode( array( array(
		    "id" => $ret['filename'],
		    "name" => $ret['filename'].'.'.$ret['extension'],
		) ) );
	}
	public function actionDelete_video($mid)
	{
		$videos = new Videos;
		if($to_delete = $videos->find('user_id = :my_id AND id = :video_id', array(':my_id' => Yii::app()->user->id, ':video_id' => $mid) ))
			$to_delete->delete();
		echo json_encode(array('status' => 'ok','count' => $count = $videos->count('user_id = :user_id', array('user_id' => Yii::app()->user->id))));
	}
	public function actionEdit_video($id, $mid)
	{
		$video = Videos::model()->findByPk($mid);
		$this->renderPartial('show_video_frm', array('user_id' => $id, 'video' => $video) );
	}
	public function actionSave($id)
	{
		$temp = new Files;
		$videos = new Videos;
		$photos_ids=explode(',',$_POST['photo_ids']);
		foreach($photos_ids as $photo_id)
		{
			if($photo_id!='')
			{
				if($temp_file=$temp->findByPk($photo_id))
				{
					$videos->isNewRecord = true;
					$videos->id = 0;
					$videos->user_id = $id;
					$videos->file = $temp_file->id;
					$videos->description = $_POST['photo_description'][$temp_file->id];
					$videos->upload_date = time();
					$videos->save();
				}
			}
		}
		$this->redirect(Yii::app()->createUrl('/id'.$id.'/video'));
	}
	public function ActionSave_description($id, $mid)
	{
		if($video = Videos::model()->find('user_id = :my_id AND id = :video_id', array(':my_id' => Yii::app()->user->id, ':video_id' => $mid) )){
			$video->description = $_POST['description'];
			$video->save();
		}
	}
	public function ActionVideo_add_to_my_page($id, $mid)
	{
		$video_model = new Videos;
		if($video = $video_model->findByPk($mid)){
			$video_model->isNewRecord = true;
			$video_model->id = 0;
			$video_model->file = $video['file'];
			$video_model->upload_date = time();
			$video_model->user_id = Yii::app()->user->id;
			$video_model->save();
		}
	}
}