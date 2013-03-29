<?php
/**
 * class UserChat
 * 
 * Shows User's chat window
 *
 * @author maxim
 */
class WUserChat extends CWidget{

    /**
     * @var int user_id for chat
     */
    public $user_id = null;
    
    private $users = null;
    private $me = null;
    
    public function init() {
        if(!Yii::app()->user->isGuest){
            if(is_null($this->user_id))
                $this->user_id = Yii::app()->user->id;
            //TODO: store name in session
            $this->me = UserProfile::model()->find('user_id=:iid',array(':iid'=>Yii::app()->user->id));
        }
        if(!is_null($this->user_id)){
            $this->users = $this->me->getFriends();
        }
    }
    
    public function run() {
        if(!Yii::app()->user->isGuest && $this->users!=null && count($this->users)>0){
            $this->render('userchat',array('users'=>$this->users,'profile'=>$this->me));
        }
    }
}

