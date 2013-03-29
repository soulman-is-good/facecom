<?php

class AppsController extends Controller {

    public $layout = 'profile';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

	public function actionIndex($id)
	{   $user = UserProfile::model()->getUserProfile($id);
        if (empty($user))
            throw new CException('Not Found', 404);
        $apps = Apps::model()->appList(0);
        $total = Apps::model()->count();
        $user_apps_ids=UserApps::model()->userAppIds($id);
        Yii::app()->clientScript->registerPackage('apps');
		$this->render('appList', array(
			'profile' => $user,
			'apps' => $apps,
			'list' => 'all',
			'user_apps_ids' => $user_apps_ids,
			'total'=>$total,
		));
	}

	public function actionMy($id)
	{   $user = UserProfile::model()->getUserProfile($id);
        if (empty($user))
            throw new CException('Not Found', 404);
        $user_apps = UserApps::model()->appList($id);
        $total = UserApps::model()->count(array('condition' =>'user_id='.$id));
        $user_apps_ids=UserApps::model()->userAppIds($id);
        Yii::app()->clientScript->registerPackage('apps');
		$this->render('appList', array(
				'profile' => $user,
				'apps' => $user_apps,
				'list' => 'my',
				'user_apps_ids' => $user_apps_ids,
				'total'=>$total,
			)
		);
	}

	public function actionAdd($aid)
	{
	    if ((!isSet($aid))||(empty($aid)))
	    {/*тут обработать исключение*/throw new CException('Not Found', 404);}
		$user_id = Yii::app()->user->id;
		$user = UserProfile::model()->getUserProfile($user_id);
        $has = UserApps::model()->count(
       		array (
				'condition' => 'user_id='.$user_id.' AND app_id='.$aid
			)
        );
        if($has>0)
        {$this->redirect(Yii::app()->request->baseUrl.'/id'.Yii::app()->user->id.'/apps/play/'.$aid);}
        $newapp = new UserApps;
        $newapp->user_id=$user_id;
        $newapp->app_id=$aid;
        $newapp->added=time();
        if(!$newapp->save())
        {/*тут обработать исключение*/throw new CException('Not Found', 404);}
        $app = Apps::model()->find(
        	array (
				'condition' => 'id='.$newapp->app_id
			)
        );
        $app->users++;
        $app->update();
        Yii::app()->clientScript->registerPackage('apps');
		$this->render('app', array(
				'profile' => $user,
				'app' => $app
			)
		);
	}

	public function actionPlay($aid)
	{
		if ((!isSet($aid))||(empty($aid)))
	    {/*тут обработать исключение*/throw new CException('Not Found', 404);}
		$user_id = Yii::app()->user->id;
		$app = Apps::model()->getUserApp($aid,$user_id);
		$user = UserProfile::model()->getUserProfile($user_id);
		Yii::app()->clientScript->registerPackage('apps');
		$this->render('app', array(
				'profile' => $user,
				'app' => $app,
			)
		);
	}

	public function actionDelete($aid)
	{
		if ((!isSet($aid))||(empty($aid)))
	    {/*тут обработать исключение*/throw new CException('Not Found', 404);}
		$user_id = Yii::app()->user->id;
		$user = UserProfile::model()->getUserProfile($user_id);
        $has = UserApps::model()->count(
       		array (
				'condition' => 'user_id='.$user_id.' AND app_id='.$aid
			)
        );
        if(intVal($has)<1)
        {$this->redirect(Yii::app()->request->baseUrl.'/id'.Yii::app()->user->id.'/apps/my');}
        $dApp = UserApps::model()->find(
        	array (
        		'condition' => 'user_id='.$user_id.' AND app_id='.$aid
        	)
        );
        if(!$dApp->delete())
        {/*тут обработать исключение*/throw new CException('Not Found', 404);}
        $appDec=Apps::model()->find(
        	array (
        		'condition' => 'id='.$aid
        	)
        );
        $appDec->users--;
        $appDec->update();
        $this->redirect(Yii::app()->request->baseUrl.'/id'.Yii::app()->user->id.'/apps/my');
	}

	public function actionLoadMore($id) {
        if (Yii::app()->request->isAjaxRequest) {
        	$lastOffset=Yii::app()->getRequest()->getPost('lastOffset');
        	$list=Yii::app()->getRequest()->getPost('list');
        	if($list=='all'){$apps = Apps::model()->appList($lastOffset);}
        	else{$apps = UserApps::model()->appList($id,$lastOffset);}
        	$user_apps_ids=UserApps::model()->userAppIds($id);
        	$res = $this->renderPartial('_appTable',array('apps'=>$apps,'user_apps_ids'=>$user_apps_ids,$display='none'), true);
        	$lastOffset+=Yii::app()->params->maxAppsPerRequest;
        	echo json_encode(array('status' => 'ok','offset'=>$lastOffset, 'data' => $res));
        }
        else
        {
            throw new CException('Not Found', 404);
        }
    }
    /*echo json_encode(array('status' => 'no','offset'=>15, 'data' => '111'));
    }*/
}
