<?php
/**
 * class UserGuests
 * 
 * Shows current User page guests.
 *
 * @author maxim
 */
class WUserGuests extends CWidget{

    public $count = 6;
    public $user_id = null;
    
    public function run() {

        /** user friends query **/
        $criteria = new CDbCriteria;
        $criteria->condition='user_id=:id';
        $criteria->limit = $this->count;
        $criteria->order = 'RAND()';
        $user_id = $this->user_id;
        $criteria->params = array(':id' => $user_id);

        $guests = UserFriends::model()->findAll($criteria);
        $guests_count = UserFriends::model()->count($criteria);    
        /** user friends query **/

        if($guests_count!=null && $guests_count>0)
            $this->render('userguests', array('guests'=>$guests, 'guests_count'=>$guests_count));
    }







/*    public $user_id = null;
    
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
            $this->render('userguests',array('users'=>$this->users));
    }*/
}
