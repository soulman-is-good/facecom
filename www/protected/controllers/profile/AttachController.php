<?php

class AttachController extends CController
{
	public function actionPhoto($id) {
		$user = UserProfile::model()->getUserProfile($id);
		$this->renderPartial('//profile/profile/_attach_photo', array('profile' => $user) );
	}
}