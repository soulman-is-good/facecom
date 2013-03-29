<?php
/**
 * Record extending CActiveRecord
 *
 * @author maxim
 */
class Record extends CActiveRecord {
    
    public function __construct($scenario = 'insert') {
        $this->beforeConstruct();
        parent::__construct($scenario);
    }
    
    public function beforeConstruct() {
        //EventManager::raiseEvent('onBeforeConstruct', new CEvent($this));
    }
}
