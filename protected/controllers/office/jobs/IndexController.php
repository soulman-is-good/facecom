<?php

class IndexController extends Controller {

    public $layout = 'office';

    public function init() {
        Yii::app()->clientScript->registerPackage('jobs');
    }

    function checkMyOffice($oid)
	{
		$office = Office::Model()->findByPk($oid);
		return $office['user_id'] == Yii::app()->user->id;
	}

	function filling()
	{
		$data['profArea'] = JobsProfArea::Model()->findAll();
        $data['currency'] = Currency::Model()->findAll();
        $data['exp'] = JobsExperience::Model()->findAll();
        $data['employment'] = JobsEmployment::Model()->findAll();
        return $data;
	}
	
    public function actionIndex($oid)
	{
		$jobs = Jobs::Model()->findAll('office_id = :office_id', array(':office_id' => $oid));
		echo $jobs['description'];
		if(strlen($jobs['description']) > 600)
			$jobs['description'] = mb_substr($jobs['description'], 0, 600, 'utf-8').'...';

		Yii::app()->clientScript->registerScript('global_office_id', 'var glOfficeId = '.$oid.';', CClientScript::POS_HEAD);
		$this->render('/office/jobs/index', array('jobs' => $jobs, 'my_office' => $this->checkMyOffice($oid)));
	}

	public function actionCreate($oid)
	{
		if(!Yii::app()->request->isAjaxRequest)
               throw new CException('Page not found', 404);

        if($this->checkMyOffice($oid) == false){
        	$this->renderPartial('/office/jobs/denied');
        	exit();
        }

        $fields = $this->filling();
		$this->renderPartial('/office/jobs/form', array('mid' => 0, 'action' => 'create', 'oid' => $oid, 'fields' => $fields, 'profAreaInd' => 0, 'currencyInd' => 0, 'expInd' => 0, 'empItems' => array()));
		exit();
	}

	public function actionEdit($oid, $mid)
	{
		if(!Yii::app()->request->isAjaxRequest)
               throw new CException('Page not found', 404);

        if($this->checkMyOffice($oid) == false){
        	$this->renderPartial('/office/jobs/denied');
        	exit();
        }

        $fields = $this->filling();
        $job = Jobs::Model()->findByPk($mid);
        $empRels = JobsEmploymentRelations::Model()->findAll('job_id=:job_id', array(':job_id' => $mid));

        $profAreaInd = 0;
        $currencyInd = 0;
        $expInd = 0;
        foreach($fields['profArea'] as $ind => $item)
        	if($job['prof_area_id'] == $item['id'])
        		$profAreaInd = $ind;
        foreach($fields['currency'] as $ind => $item)
        	if($job['currency_id'] == $item['id']) 
        		$currencyInd = $ind;
        foreach($fields['exp'] as $ind => $item)
        	if($job['experience_id'] == $item['id']) 
        		$expInd = $ind;
        foreach($empRels as $item)
        	$empItems[] = $item['employment_id'];

		$this->renderPartial('/office/jobs/form', array('mid' => $mid, 'action' => 'edit', 'oid' => $oid, 'job' => $job, 'fields' => $fields, 'profAreaInd' => $profAreaInd, 'currencyInd' => $currencyInd, 'expInd' => $expInd, 'empItems' => $empItems));
		exit();
	}

	public function actionView($oid, $mid)
	{
		if(!Yii::app()->request->isAjaxRequest)
               throw new CException('Page not found', 404);

        $job = Jobs::Model()->findByPk($mid);
        $jobsEmploymentModel = JobsEmployment::model();
        $empRels = JobsEmploymentRelations::Model()->findAll('job_id=:job_id', array(':job_id' => $job['id']));

        $data['profArea'] = JobsProfArea::Model()->findByPk($job['prof_area_id']);
        $data['currency'] = Currency::Model()->findByPk($job['currency_id']);
        $data['exp'] = JobsExperience::Model()->findByPk($job['experience_id']);
        foreach($empRels as $item){
        	$data['employment'][] = $jobsEmploymentModel->findByPk($item['employment_id'])->title;
	    }

		$this->renderPartial('/office/jobs/view', array('mid' => $mid, 'job' => $job, 'data' => $data));
		exit();
	}

	public function actionSave($oid, $mid)
	{
		Jobs::Model()->saveJob($oid, $_POST, $mid);
		$this->redirect(Yii::app()->createUrl('/office'.$oid.'/jobs'));
	}

	public function actionDelete($oid, $mid)
	{
		if(!Yii::app()->request->isAjaxRequest)
               throw new CException('Page not found', 404);
		Jobs::Model()->deleteJob($oid, $mid);
		exit();
	}
}