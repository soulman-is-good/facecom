<?php

class FindjobController extends Controller {
	 
	 public $layout = 'advert';

	function filling()
	{
		$data['profArea'] = JobsProfArea::Model()->findAll();
        $data['currency'] = Currency::Model()->findAll();
        $data['exp'] = JobsExperience::Model()->findAll();
        $data['employment'] = JobsEmployment::Model()->findAll();
        return $data;
	}

	public function init() {
        Yii::app()->clientScript->registerPackage('jobs');
    }

    public function actionIndex()
	{
		$jobs = Jobs::Model()->findAll('office_id = :office_id', array(':office_id' => $oid));
		echo $jobs['description'];
		if(strlen($jobs['description']) > 600)
			$jobs['description'] = mb_substr($jobs['description'], 0, 600, 'utf-8').'...';

		$this->render('/office/jobs/index', array('jobs' => $jobs, 'my_office' => $this->checkMyOffice($oid)));
		$this->render('/business/findjob/index');
	}

}

?>