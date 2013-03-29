<?php

/**
 *
 * @author Soul_man
 */
class XTable extends CComponent {

    public $defaultCharset = 'utf8';
    public $defaultCollation = 'utf8_general_ci';
    public $path = 'schemas';
    
    private $directory = '';

    public function __construct() {
        $this->directory = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . Yii::getPathOfAlias($this->path));
        EventManager::addEvent('onBeforeConstruct', array($this, 'beforeConstruct'));
    }

    public function init() {
    }

    public function beforeConstruct(CEvent $event) {
        if($this->directory === false) 
            return false;
        $className = get_class($event->sender);
        $tableName = $event->sender->tableName();
        $schemaFile = $this->directory . DIRECTORY_SEPARATOR . $className . '.xml';
        if(is_file($schemaFile)){
            $data = $this->handleSchema($schemaFile);
            $this->verifyTable($tableName);
        }
        return false;
    }
    
    /**
     * 
     * @param string $schemaFile path to a table schema file. 
     * Contains table structure and could contain table data
     * 
     * @return array structured array of table structure and data
     */
    public function handleSchema($schemaFile) {
        
    }
    
    public function verifyTable($tableName) {
        
    }

}

/**
 * EventManager
 * 
 * Crossclass event handling logic
 * 
 * @author maxim
 */
class EventManager {

    private static $_events = array();

    public static function addEvent($name, $handler) {
        $name = strtolower($name);
        self::$_events[$name][] = $handler;
    }

    public static function raiseEvent($name, $event) {
        $name = strtolower($name);
        if (isset(self::$_events[$name])) {
            foreach (self::$_events[$name] as $handler) {
                if (is_string($handler))
                    call_user_func($handler, $event);
                else if (is_callable($handler, true)) {
                    if (is_array($handler)) {
                        // an array: 0 - object, 1 - method name
                        list($object, $method) = $handler;
                        if (is_string($object)) // static method call
                            call_user_func($handler, $event);
                        else if (method_exists($object, $method))
                            $object->$method($event);
                        else
                            throw new CException(Yii::t('yii', 'Event "{class}.{event}" is attached with an invalid handler "{handler}".', array('{class}' => get_class($this), '{event}' => $name, '{handler}' => $handler[1])));
                    }
                    else // PHP 5.3: anonymous function
                        call_user_func($handler, $event);
                }
                else
                    throw new CException(Yii::t('yii', 'Event "{class}.{event}" is attached with an invalid handler "{handler}".', array('{class}' => get_class($this), '{event}' => $name, '{handler}' => gettype($handler))));
                // stop further handling if param.handled is set true
                if (($event instanceof CEvent) && $event->handled)
                    return;
            }
        }
        else if (YII_DEBUG && !$this->hasEvent($name))
            throw new CException(Yii::t('yii', 'Event "{class}.{event}" is not defined.', array('{class}' => get_class($this), '{event}' => $name)));
    }

}
