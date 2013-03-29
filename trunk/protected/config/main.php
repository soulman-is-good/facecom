<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(dirname(__FILE__)),
    'name' => 'Facecom',
    'sourceLanguage'=>'ru',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.helpers.*',
        'application.components.*',
        'application.extensions.yiidebugtb.*',
        'application.modules.srbac.controllers.SBaseController',
        'application.models.profile.*',
        'application.models.comments.*',
        'application.models.posts.*',
        'application.models.cv.*',
    ),
    'aliases' => array(
        'xupload' => 'ext.xupload'
    ),
    'defaultController' => 'my',
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin'=>array(),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
          'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>include 'routes.php',
            'showScriptName' => false
          ),
        'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
             // GD or ImageMagick
             'driver' => 'GD',
             // ImageMagick setup path
             //'params'=>array('directory'=>'C:/ImageMagick'),
        ),
        /* 		'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ), */
        // uncomment the following to use a MySQL database

        'db' => include('mysql.php'),
        'errorHandler' => array(
            'errorAction' => 'my/error',
        ),
//        'messages'=>array(
//            'class'=>'CDbMessageSource',
//            'sourceMessageTable'=>'i18n_source',
//            'translatedMessageTable'=>'i18n_message',
//            'onMissingTranslation'=>'InsertMessage',
//        ),
        'messages'=>array(
            'class'=>'CGettextMessageSource',
            'useMoFile'=>true,
            'onMissingTranslation'=>'InsertMessage',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CEmailLogRoute',
                    'levels' => 'email',
                    'emails'=>array('soulman.is.good@gmail.com'),
                    'subject'=>'Facecom error',
                    //'from'=>'info@facecom.kz'
                ),
                array(
                    'class' => 'CProfileLogRoute',
                ),
                array(
                    'class' => 'XWebDebugRouter',
                    'config' => 'opaque, runInDebug, yamlStyle, collapsed',
                    'levels' => 'error, warning, trace, profile, info',
                ),
            ),
        ),
        'clientScript' => array(
            'packages' => array(
                'main'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/main.js','js/wnd.js','js/facecom.avatarUpload.js','js/interview.js'),
                    'css' => array('css/main.css','css/photos/view_photos.css'),
                    'depends' => array('jquery','jquery-ui','jscrollpane', 'mousewheel','jcrop')
                ),
                'comments'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/comments/comments.js'),
                    'css' => array('css/comments/comments.css'),
                ),
                'profile-index'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/profile/profile.js'),
                    'css' => array('css/profile/profile.css'),
                    'depends' => array('comments','multiple-uploader'),
                ),
                'profile-about'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/profile/profile-about.js'),
                ),
                'profile-edit'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/profile/profile-edit.js'),
                    'css' => array('css/profile/profile-edit.css'),
                ),
                'photos'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/main.js','js/photos/photos.js'),
                    'css' => array('css/photos/photos.css', 'css/profile/profile.css'),
                    'depends' => array('comments','multiple-uploader'),
                ),
                'videos'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/main.js','js/videos/videos.js'),
                    'css' => array('css/photos/photos.css', 'css/profile/profile.css'),
                    'depends' => array('comments','multiple-uploader'),
                ),
                'apps'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/apps/apps.js')
                ),
                'search'=>array(
                    'baseUrl' => 'static',
                    'css'=>array('css/search/search.css'),
                    'js' => array('js/search.js')
                ),
                'office'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/office/office.js'),
                    'css' => array('css/office/office.css'),
                    'depends' => array('main')
                ),
                'jobs'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/office/jobs/jobs.js'),
                    'css' => array('css/office/jobs.css'),
                    'depends' => array('office')
                ),
                'office-edit'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/office/office-edit.js'),
                    'css' => array('css/office/office-edit.css'),
                    'depends' => array('tipTip'),
                ),
                'items'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/office/items.js'),
                    'depends' => array('office')
                ),
                'items-edit'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/office/office-edit.js','js/office/items.js'),
                    'css' => array('css/office/office-edit.css'),
                    'depends' => array('tipTip'),
                ),
                'jcrop' => array(
                    'baseUrl' => 'static',
                    'js' => array('js/jquery.Jcrop.js','js/jquery.fcselect.js'),
                    'css'=>array('css/jquery.Jcrop.css'),
                ),
                'multiple-uploader'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/multiuploader.js'),
                    'depends' => array('multi-uploader-lib'),
                ),
                'tipTip'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/jquery.tipTip.js'),
                    'css' => array('css/tipTip.css'),
                ),
                'multi-uploader-lib'=>array(
                    'baseUrl' => 'static/lib/uploader/js',
                    'js' => array('vendor/jquery.ui.widget.js','jquery.iframe-transport.js','jquery.fileupload.js'),
                ),
                'jscrollpane' => array(
                    'baseUrl' => 'static',
                    'js' => array('js/jquery.jscrollpane.js'),
                    'css'=>array('css/jquery.jscrollpane.css'),
                ),
                'timepicker' => array(
                    'baseUrl' => 'static',
                    'js' => array('js/jquery.timepicker.js'),
                    'css'=>array('css/jquery-timepicker.css'),
                ),
                'mousewheel' => array(
                    'baseUrl' => 'static',
                    'js' => array('js/jquery.mousewheel.js'),
                ),
                'jquery'=>array(
                    'baseUrl' => 'static/js',
                    'js'=>array('jquery-1.8.2.min.js')
                ),
                'jquery-ui'=>array(
                    'baseUrl' => 'static/js/jquery-ui',
                    'js'=>array('jquery-ui.min.js','jquery-ui-i18n.js'),
                    'css'=>array('css/flick/jquery-ui.min.css')
                ),
                'validate'=>array(
                    'baseUrl' => 'static/js',
                    'js'=>array('jquery.validate.js'),
                ),
                'advert'=>array(
                    'baseUrl' => 'static',
                    'css' => array('css/advert/advert.css'),
                    'js' => array('js/advert/advert.js')
                ),
                'interview-create'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/advert/interview-create.js')
                ),
                'interview-my'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/advert/interview-my.js')
                ),
                'target-create'=>array(
                    'baseUrl' => 'static',
                    'js' => array('js/advert/target-create.js')
                ),
                'business'=>array(
                    'baseUrl' => 'static',
                    'css' => array('css/business/business.css'),
                    'js' => array('js/business/business.js')
                ),
                'business-edit'=>array(
                    'baseUrl' => 'static',
                    'css' => array('css/business/business-edit.css'),
                    'js' => array('js/business/business-edit.js'),
                    'depends' => array('business','timepicker','validate'),
                ),
                'discount'=>array(
                    'baseUrl' => 'static',
                    'css' => array('css/discount/discount.css','css/office/headblock.css'),
                    'js' => array('js/discount/discount.js')
                ),
                'discount-edit'=>array(
                    'baseUrl' => 'static',
                    'css' => array('css/business/business-edit.css','css/discount/discount.css'),
                    'js' => array('js/discount/discount-edit.js'),
                    'depends' => array('timepicker','validate'),
                ),
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'info@facecom.kz',
        'maxPostPerRequest' => 10, // Количество подгружаемых постов при нажатии на кнопку "Загрузить еще" на странице со стеной
        'maxAppsPerRequest' => 9,  // Количество подгружаемых приложений при нажатии на кнопку "Показать еще приложения"
        'PeopleSearchLimit' => 10,        // Количество подгружаемых пользователей при нажатии на кнопку "Показать еще результаты"
    ),
);
