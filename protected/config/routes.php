<?php

return array(
////////////////////////////////////////////////////////////////////////////////
//Profile routes
////////////////////////////////////////////////////////////////////////////////
                'id<id:\d+>/cv' => 'cv',
                'id<id:\d+>/cv/view/<cvid:\d+>' => 'cv/view',
                'id<id:\d+>/mutual/fid<fid:\d+>' => 'userMutualFriends',
                'id<id:\d+>/requests' => 'userFriendRequests',
                'id<id:\d+>/myfriends' => 'userFriends',
                'id<id:\d+>/related' => 'userRelated',
                'id<id:\d+>/apps' => 'apps',
                'id<id:\d+>/apps/<action>' => 'apps/<action>',
                'id<id:\d+>/apps/<action>/<aid:\d+>' => 'apps/<action>',
                'id<id:\d+>' => 'profile/profile',
                'id<id:\d+>/<action:(edit|profile|placemarks)>'=>'profile/profile/<action>',
                'id<id:\d+>/<controller>/<action>/<mid:\d+>' => 'profile/<controller>/<action>', // Удаление постов например
                'id<id:\d+>/<controller>/<action>/<mid>/<sid>' => 'profile/<controller>/<action>', // К примеру - открытие фотографии со стены
                'id<id:\d+>/<controller>/<action>'=>'profile/<controller>/<action>',
                'id<id:\d+>/<controller>'=>'profile/<controller>/index',
                'profile/profile'=>'profile',
                'my/cart/<item_id:\d+>/<type>/<count:\d+>'=>'my/cart',
    //posts logic goes further
                'comments/<action:\w+>' => 'comments/comments/<action>', // Комментарии
                'comments/<action:\w+>/<id:\d+>' => 'comments/comments/<action>', // Удаление комментария
                'posts/<action:\w+>' => 'posts/posts/<action>', // Добавить пост (к примеру)
                /*'posts/<action:\w+>/<id:\d+>' => 'posts/posts/<action>', // Удаление поста (к примеру)*/
                'feed' => 'feed/index',
                'like' => 'like/like',
                'share' => 'share/share',
                //'search'=>'search?query=',
////////////////////////////////////////////////////////////////////////////////
//Office routes
////////////////////////////////////////////////////////////////////////////////
                'office'=>'office/main/index', //офисный контроллер по-умолчанию
                'office/create'=>'office/main/create',
                'office/<action:\w+>'=>'office/main/<action>',
                'office<oid:\d+>'=>'office/main/about',
                'office<oid:\d+>/sale'=>'office/sale/index',
                'office<oid:\d+>/contacts'=>'office/main/contacts',
                'office<oid:\d+>/edit'=>'office/main/edit',
                'office<oid:\d+>/products'=>'office/items/index',
                'office<oid:\d+>/wall'=>'office/posts/index',
                'office<oid:\d+>/jobs'=>'office/jobs/index/index',
                'office<oid:\d+>/jobs/<action>/<mid:\d+>'=>'office/jobs/index/<action>',
                'office<oid:\d+>/item-<name>'=>'office/items/show',
                //items logic
                'office<oid:\d+>/items/edit/<id:\d+>'=>'office/items/create',
                'office<oid:\d+>/items/add'=>'office/items/create',

                'office<oid:\d+>/<controller>/<action>'=>'office/<controller>/<action>', //other
////////////////////////////////////////////////////////////////////////////////
//Advert routes
////////////////////////////////////////////////////////////////////////////////
                'advert/<controller>'=>'advert/<controller>/index',
                'advert'=>'advert/main', //рекламный контроллер по-умолчанию
                'advert/<action:\w+>'=>'advert/index/<action>',
               // 'advert/<controller>/<actionn:\w+>'=>'advert/<controller>/<actionn:\w+>',
////////////////////////////////////////////////////////////////////////////////
//Business routes
////////////////////////////////////////////////////////////////////////////////
                //discounts
                'business/discount'=>'business/discount/index',
                'business/discount/edit/<id:\d+>'=>'business/discount/create',
                'business/discount/delete/<id:\d+>'=>'business/discount/delete',
                'business/discount/<action:\w+>'=>'business/discount/<action>',
                'business/discount/<id:\d+>'=>'business/discount/show',
                'business/findjob/'=>'business/findjob/index',
                'business/findjob/<action><id:\d+>'=>'business/findjob/<action>',
                //main
                'business'=>'business/main', //рекламный контроллер по-умолчанию
                'business/<controller>'=>'business/<controller>/index',
                'business/<action:\w+>'=>'business/index/<action>',
            )
?>
