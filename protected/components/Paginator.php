<?php

/**
 * Class directed to provide session based pagination
 * @author Maxim Savin
 */

class Paginator extends CPagination {
    
    public $view = 'paginator';
    
    public function __construct($name,$itemCount = 0) {
        $pageTmpl = $name . "Page";
        $limTmpl = $name . "Limit";
        $limit = (int)SysSettings::getValue($limTmpl,10);
        $pages = $itemCount / $limit;
        $page = isset($_GET['page'])?(int)$_GET['page']:Yii::app()->user->getState($pageTmpl);
        if($page<0 || $page>$pages-1)
            $page = 0;
        Yii::app()->user->setState($pageTmpl,$page);
        parent::__construct($itemCount);
    }
}
?>
