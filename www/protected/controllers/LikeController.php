<?php

class LikeController extends Controller {
    
    public function actionLike() {
    	$user_id = Yii::app()->user->id;

        if (Yii::app()->request->isAjaxRequest && !empty($user_id)) {
        	$tbl = Yii::app()->getRequest()->getPost('_tbl');
        	$item_id = Yii::app()->getRequest()->getPost('_item_id');
        	$hash = md5($tbl.$item_id.$user_id);

        	$likesObj = Likes::model()->find('hash=:_hash', array(':_hash' => $hash));

        	if (empty($likesObj->id)) {
        		$likesObj = new Likes;
	        	$likesObj->tbl = $tbl;
	        	$likesObj->item_id = $item_id;
	        	$likesObj->user_id = $user_id;
	        	$likesObj->hash = $hash;
	        	$likesObj->save();
	        	Yii::app()->db->createCommand("UPDATE $tbl SET likes=likes+1 WHERE id=".intval($item_id))->execute();
	        	echo json_encode(array('status' => 'ok', 'data' => 'like'));
        	}
        	else {
        		$likesObj->delete();
        		Yii::app()->db->createCommand("UPDATE $tbl SET likes=likes-1 WHERE id=".intval($item_id))->execute();
        		echo json_encode(array('status' => 'ok', 'data' => 'unlike'));
        	}
        }
        else {
            throw new CException('Not Found', 404);
        }
    }

}
