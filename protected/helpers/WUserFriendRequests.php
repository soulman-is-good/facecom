<?php
/**
 * class UserFriends
 * 
 * Shows User's confirmed friends
 *
 * @author maxim
 * edited by Marat
 */
class WUserFriendRequests extends CWidget{

    public $user_id = null;

    public function init() {
        if(!Yii::app()->user->isGuest){
            if(is_null($this->user_id))
                $this->user_id = Yii::app()->user->id;
        }
    }   
    
    public function run() {

        $friendrequests = UserFriendRequests::model()->getFriendsRequests($this->user_id);
        $friendrequests_count = UserFriendRequests::model()->getFriendsRequestsCount($this->user_id);

        $my_u_id = Yii::app()->user->id;
        $u_id = $this->user_id;
        
        if($friendrequests_count!=null && $friendrequests_count>count($friendrequests_count) && $u_id == $my_u_id)
            $this->render('userfriendrequests', array('friendrequests'=>$friendrequests, 'friendrequests_count'=>$friendrequests_count));
    }

}
