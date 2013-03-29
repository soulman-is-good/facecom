<?php
define('NODEJS_KEY','KNCa3FrpSY4IEvIpVHLmAOwhOF7QWCPIOa52glVQQw8Sniv7Of8s7WTXmUKuI0Cg');
include('protected/components/InsertMessage.php');
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//error_reporting(E_ALL & ~E_NOTICE);
require_once($yii);
Yii::createWebApplication($config)->run();