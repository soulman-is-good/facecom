<?php
/**
 * class UserFriends
 * 
 * Shows User's confirmed friends
 *
 * @author maxim
 * edited by Marat
 */
class WUserFriends extends CWidget{

    public $user_id = null;

    public function init() {
        if(!Yii::app()->user->isGuest){
            if(is_null($this->user_id))
                $this->user_id = Yii::app()->user->id;
        }
    }   
    
    public function run() {

        $friends = UserFriends::model()->getFriends($this->user_id);
        $friends_count = UserFriends::model()->getFriendsCount($this->user_id);
    
        if($friends_count!=null && $friends_count>0)
            $this->render('userfriends', array('friends'=>$friends, 'friends_count'=>$friends_count));
    }

}
