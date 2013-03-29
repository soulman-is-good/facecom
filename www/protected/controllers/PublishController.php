<?php

class PublishController extends Controller {
    
    public function actionIndex() {
        require_once "protected/extensions/Dklab/Realplexor.php";
        $rp = new Dklab_Realplexor('127.0.0.1', '10010');
        $rp->send(array('alpha'),'hello!');
        Yii::app()->end();
    }
}
