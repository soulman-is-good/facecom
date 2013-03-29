<?php
/**
 * class AdsBlock
 *
 * Ads widget. Depending on a user
 *
 * @author maxim
 */
class WAdsBlock extends CWidget{

    /**
     * @var int Passable variable to define for whom will the advertisments be
     */
    public $mini = false;

    //private $ivs = null;
    private $ads = null;
    private $user_id = null;

    public function init() {
        if(!Yii::app()->user->isGuest){
            if(is_null($this->user_id))
                $this->user_id = Yii::app()->user->id;
        }
        if(!is_null($this->user_id)){
            //TODO: Fill ads
        }
    }

    public function run() {
//        if($this->ads!=null && $this->ads->count()>0)
        if($this->mini)
            $this->render('adsBlockMini',array('ads'=>$this->ads));
        else
            $this->render('adsBlock',array('ads'=>$this->ads));
        $ivs=array();
        $total=0;
        $uivs=AdvertStack::model()->userIvs($this->user_id);
        $trace=0;
        foreach($uivs as $iv){
        	$ivs[$total]=Interviews::model()->find(array(
    			'condition' => 'id=:id AND status=1',
    			'params' => array(':id'=>$iv->content_id)
    		));
    		$ivs[$total]->fixShow();
    		$total++;
    		if($total>=2)break;
        }
        $this->render('ivsBlock',array('ivs'=>$ivs,'trace'=>$trace));
    }
}
