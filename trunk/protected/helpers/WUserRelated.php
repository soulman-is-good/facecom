<?php
/**
 * class UserRelated
 * 
 * Shows current User related users. Current user could be specified by passing
 * User instance in variable array
 *
 * @author maxim
 */
class WUserRelated extends CWidget{
    
    public $count = 6;
    public $user_id = null;
    
    public function run() {

        $friends_of_friends = UserRelated::model()->getFriendsOfFriends($this->user_id);
        $friends_of_friends_count = UserRelated::model()->getFriendsOfFriendsCount($this->user_id);

        $my_u_id = Yii::app()->user->id;
        $u_id = $this->user_id;

        if($friends_of_friends!=null && $friends_of_friends>count($friends_of_friends) && $u_id == $my_u_id)
            $this->render('userrelated', array('related'=>$friends_of_friends, 'related_count'=>$friends_of_friends_count)); 
    }

    /**
     * @var int Passable variable to define for whom we are searching related users
     */
    /*public $user_id = null;
    
    private $users = null;
    
    public function init() {
        if(!Yii::app()->user->isGuest){
            if(is_null($this->user_id))
                $this->user_id = Yii::app()->user->id;
        }
        if(!is_null($this->user_id)){
            //TODO: Fill users's guests
        }
    }
    
    public function run() {
        if($this->users!=null && $this->users->count()>0)
            $this->render('userrelated',array('users'=>$this->users));
    }*/
}
