<?php

class AphotosController extends CController
{
	public function actionAdd($mid)
	{
		$user_id = Yii::app()->user->id;
                $albums = array();
		$albums_model = Albums::model()->findAll(array(
			'select' => 'id, title, user_id',
			'condition' => 'user_id = :id',
			'params' => array(':id'=>$user_id)
		));
		foreach( $albums_model as $album)
		{
			if($mid == 0)
				$mid = $album['id'];
			$albums[$album['id']] = $album;
		}
		$this->renderPartial('add_photo',array('albums' => $albums, 'user_id' => $user_id, 'album_selected' => $mid) );
	}
	public function actionShow($id, $mid)
	{
		$photos = Photos::model();
		$photo = $photos->findByPk($mid);
		$aroundInfo = $photos->getAroundInfo($mid, $photo['album_id']);
		$myProfile = UserProfile::model()->getUserProfile(Yii::app()->user->id);
		$myPage = ($id == Yii::app()->user->id);

		$comments = Comments::model()->getLast('photos', $mid, 10);
		$comments = array_reverse($comments);
		
		$this->renderPartial('show_photo', array('photo' => $photo, 'nav_link' => 'show', 'user_id' => $id, 'aroundInfo' => $aroundInfo, 'myProfile' => $myProfile, 'myPage' => $myPage, 'comments' => $comments, 'comments_tbl' => 'photos', 'comments_item_id' => $photo->id));
	}

	public function actionShowPosts($id, $mid, $sid)
	{
		
		$posts = Posts::model()->findByPk($sid);
		$multimedia = json_decode($posts->multimedia);
		$count = count($multimedia);
		foreach($multimedia as $ind => $file){
			if($file->nomber == $mid)
			{
				$num = $ind + 1;
				if($ind == 0) $prev = $multimedia[$count-1]->nomber.'/'.$sid; else $prev = $multimedia[$ind-1]->nomber.'/'.$sid;
				if($ind == $count-1) $next = $multimedia[0]->nomber.'/'.$sid; else $next = $multimedia[$ind+1]->nomber.'/'.$sid;
				$current_photo = $file;
			}
		}

		$myPage = ($id == Yii::app()->user->id);
		$myProfile = UserProfile::model()->getUserProfile(Yii::app()->user->id);
		$ext = Files::model()->findByPk($current_photo->id)->extension;
		$aroundInfo = array('num' => $num, 'count' => $count, 'prev' => $prev, 'next' => $next);
		$comments = Comments::model()->getLast('posts_'.$sid, $mid, 10);
		$comments = array_reverse($comments);
		$file = array('id' => $current_photo->id, 'file'=>$current_photo->id, 'image'=>array('extension'=>$ext), 'description' => '', 'upload_date' => $current_photo->upload_date);

		$this->renderPartial('show_photo', array('photo' => $file, 'nav_link' => 'showposts', 'user_id' => $id, 'aroundInfo' => $aroundInfo, 'myProfile' => $myProfile, 'myPage' => $myPage, 'comments' => $comments, 'comments_tbl' => 'posts_'.$sid, 'comments_item_id' => $mid));
	}

	public function actionMore($id)
	{
		$photos = Photos::model()->LoadLimited($_POST['album_id'],$_POST['offset']);
		$list = $this->renderPartial('photos_list', array('photos' => $photos, 'user_id' => $id), true);

		echo json_encode( array('photos_count' => count($photos), 'data' => $list) );
	}

	public function actionDescription($id, $mid)
	{
		$photo = TemporaryFiles::model()->findByPk($mid);
		$this->renderPartial('show_description', array('user_id' => $id, 'photo' => $photo) );
	}

	public function actionSet_description($mid)
	{
		$photo = TemporaryFiles::model()->findByPk($mid);
		$photo->description = $_POST['description'];
		$photo->save();
	}

	public function actionRemove($mid)
	{
		$photo = TemporaryFiles::model()->findByPk($mid);
		$photo->delete();
	}

	public function actionUpload()
	{
		$ret = Files::model()->uploadFile(array('resize' => FALSE));
		echo json_encode( array( array(
		    "id" => $ret['filename'],
		    "name" => $ret['filename'].'.'.$ret['extension'],
                    'error' => $ret['error']
		) ) );
	}
	public function actionSave($id)
	{
		$my_id = Yii::app()->user->id;
		$albums=new Albums;
		if($_POST['album_set'] == '1')
		{
			$albums->title = $_POST['album_create'];
			$albums->create_date = time();
			$albums->current_photo = 0;
			$albums->user_id = $my_id;
			$albums->save();
		}else{
			$albums=$albums->find('user_id = :user_id AND id = :album_id',array(':user_id' => $my_id, ':album_id' => $_POST['albom_sel']) );
		}
		$photos=new Photos;
		$temp = new Files;
		$photos_ids=explode(',',$_POST['photo_ids']);

		foreach($photos_ids as $photo_id)
		{
			if($photo_id!='')
			{
				if($temp_file=$temp->findByPk($photo_id))
				{
					$photos->isNewRecord = true;
					$photos->id = 0;
					$photos->album_id = $albums->id;
					$photos->file = $temp_file->id;
					$photos->description = $_POST['photo_description'][$temp_file->id];
					$photos->upload_date = time();
					$photos->place_id = 0;
					$photos->save();
				}
			}
		}
		$this->redirect(Yii::app()->createUrl('/id'.$id.'/photos/show/'.$albums->id));
	}

        /**
         * Action for getting json representation of an album-photos of an specified user<br/>
         * Structure:<br/>
         * [{'album_name':'The Album Name','photos':[{'filename':'thefilename.jpg','description':'The photo description'},...]},{...},...]<br/>
         * @param int $id user's id for whom album-photos list must be passed
         */
	public function actionGet_json($id)
	{
                if(!$id>0)
                    $id = Yii::app()->user->id;
		$ret = array();
		$photos_model = Photos::model();
                //TODO: Handle users that don't want to share their photos
		$albums = Albums::model()->findAll('user_id = :user_id', array(':user_id' => $id) );
		foreach($albums as $album)
		{
			$ph = array();
			$photos = $photos_model->findAll(array(
                            'select'=>'t.id, file, description',
                            'with' => 'image',
                            'condition'=>'album_id = :album_id',
                            'order'=>"IF(t.id='{$album['current_photo']}',(SELECT MAX(id) FROM photos)+1,t.id) DESC",
                            'params'=>array(':album_id' => $album['id'])
                        ));
			foreach($photos as $photo)
			{
				$ph[] = array('id'=>$photo['id'], 'filename' => $photo->image->id, 'file_ext' => $photo->image->extension, 'description' => $photo['description']);
			}
			$ret[] = array('album_name' => $album['title'], 'photos' => $ph);
		}
		echo json_encode($ret);
	}

	public function actionEdit_album($id, $mid)
	{
		$album = Albums::model()->findByPk($mid);
		$this->renderPartial('show_album_frm', array('user_id' => $id, 'album' => $album) );
	}

	public function actionSet_album_name($id, $mid)
	{
		$album = Albums::model()->find('user_id = :my_id AND id = :album_id', array(':my_id' => Yii::app()->user->id, ':album_id' => $mid) );
		$album->title = $_POST['title'];
		$album->save();
		$this->redirect(Yii::app()->createUrl('/id'.$id.'/photos'));
	}
	public function actionDelete_album($id, $mid)
	{
		$albums = Albums::model()->deleteAlbum(Yii::app()->user->id, $mid);
		//$this->redirect(Yii::app()->createUrl('/id'.$id.'/photos/'));
	}
	public function actionEdit_photo($id, $mid)
	{
		$photo = Photos::model()->findByPk($mid);
		$this->renderPartial('show_photo_frm', array('user_id' => $id, 'photo' => $photo) );
	}
	public function actionSet_photo_title($id,$mid)
	{
		$photo = Photos::model()->findByPk($mid);
		if($album = Albums::model()->find('user_id = :my_id AND id = :album_id', array(':my_id' => Yii::app()->user->id, ':album_id' => $photo['album_id']) ))
		{
			$photo->description = $_POST['description'];
			$photo->save();
			$status = 'ok';
		}else{
			$status = 'no_album';
		}
		$json = array('status' => $status, 'data' => $_POST['description']);

		echo json_encode($json);
	}
	public function actionSet_poster_photo($mid)
	{
		$photo = Photos::model()->findByPk($mid);
		if($album = Albums::model()->find('user_id = :my_id AND id = :album_id', array(':my_id' => Yii::app()->user->id, ':album_id' => $photo['album_id']) ))
		{
			$album->current_photo = $mid;
			$album->save();
			$status = 'ok';
		}else{
			$status = 'no_album';
		}
		echo json_encode(array('status' => $status));
	}
	public function actionDelete_photo($mid)
	{
		$photos = Photos::model();
		$photo = $photos->findByPk($mid);
		$album_id = $photo['album_id'];
		$status = $photos->deleteItem($photo);
		$count = $photos->count('album_id = :album_id', array('album_id' => $album_id));
		echo json_encode(array('status' => $status,'count' => $count));
	}
}