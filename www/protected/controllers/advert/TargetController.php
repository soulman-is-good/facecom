<?php

class TargetController extends Controller {

    public $layout = 'advert';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
        Yii::app()->clientScript->registerPackage('advert');
    }

    public function actionIndex()
	{
		$this->render('/advert/target_index', array());

	}

	public function actionMy()
	{
		$ivs=Interviews::model()->findAll('owner=:owner',array(':owner'=>Yii::app()->user->id));
		Yii::app()->clientScript->registerPackage('interview-my');
		$this->render('/advert/interview_my', array('ivs'=>$ivs));
	}

	public function actionCreate()
	{
		Yii::app()->clientScript->registerPackage('target-create');
		//$model = UserProfile::model();
		$this->render('/advert/target_create', array(/*'model'=>$model*/));

	}

	public function actionRun()
	{
		$iv=new Interviews;
		$iv->owner=Yii::app()->user->id;
		$iv->name = Yii::app()->getRequest()->getPost('name');
		$iv->title = Yii::app()->getRequest()->getPost('title');
		$iv->status=1;
		$qs=Yii::app()->getRequest()->getPost('q',array());
		$answs=Yii::app()->getRequest()->getPost('a',array());
		$quests=array();
		foreach($qs as $k=>$v){
			$cq=array();
			$cq['question']=$v;
			foreach($answs[$k] as $kk=>$vv){
				$cq['answs'][]=$vv;
			}
			array_push($quests,$cq);
		}
		$iv->questions=json_encode($quests);
		$targ=array();
		$targ['country'] = intVal(trim(Yii::app()->getRequest()->getPost('country_id',0)));
		$targ['cities'] = Yii::app()->getRequest()->getPost('city',array());
		if(!is_array($targ['cities']))$targ['cities']=array();
		$targ['gender'] = intVal(Yii::app()->getRequest()->getPost('gender',-1));
		$targ['family_state'] = Yii::app()->getRequest()->getPost('fs',array());
		if(!is_array($targ['family_state']))$targ['family_state']=array();
		$targ['age_from'] = intVal(Yii::app()->getRequest()->getPost('age_from',0));
		$targ['age_to'] = intVal(Yii::app()->getRequest()->getPost('age_to',0));
		$targ['school'] = trim(Yii::app()->getRequest()->getPost('school',''));
		$targ['class'] = trim(Yii::app()->getRequest()->getPost('class',''));
		$targ['schoolyear'] = intVal(Yii::app()->getRequest()->getPost('schoolyear',0));
		$targ['uni'] = trim(Yii::app()->getRequest()->getPost('uni',''));
		$targ['fac'] = trim(Yii::app()->getRequest()->getPost('fac',''));
		$targ['uniyear'] = intVal(Yii::app()->getRequest()->getPost('uniyear',0));
		$targ['workplace'] = trim(Yii::app()->getRequest()->getPost('workplace',''));
		$targ['workstate'] = trim(Yii::app()->getRequest()->getPost('workstate',''));
		$iv->targeting=json_encode($targ);
		$iv->price=intVal(Yii::app()->getRequest()->getPost('cost',0));
		$iv->limit=intVal(Yii::app()->getRequest()->getPost('limit',0));
		$iv->spent=0;
		$iv->crt=0;
		$iv->shows=0;
		$iv->activity_log=json_encode(array(''.time()=>'create',''.time()=>'start'));
		if($iv->is_exist()){
			$name=$iv->name.'_';
			$i=-1;
			do{
				$i++;
				$iv->name=$name.$i;
			}while($iv->is_exist());
		}
		//YiiBase::trace($iv->name);
        $success=$iv->save();
        foreach($quests as $k=>$v){
			$qqq=new InterviewQuestions;
			$qqq->interview_id=$iv->primaryKey;
			$qqq->question=$k;
			$qqq->question_text=$v['question'];
			$qqq->answers=json_encode($v['answs']);
			if(!$qqq->save()){
				$errs=$qqq->getErrors();
        		foreach($errs as $ev){
        			foreach($ev as $evv){
        				YiiBase::trace($evv);
        			}
        		}
        	}
		}
		$search=new SearchComponent;
		$udr=$search->targetFinder();
		foreach($udr as $row){
			$addon=new AdvertStack;
			$addon->user_id=$row['user_id'];
			$addon->type=1;
			$addon->content_id=$iv->primaryKey;
			$addon->date_added=time();
			$addon->save();
		}
        if($success){$this->redirect('/advert/interview/my');}
        else{
        	$errs=$iv->getErrors();
        	foreach($errs as $v){
        		foreach($v as $vv){
        			YiiBase::trace($vv);
        		}
        	}
        }
	}

	public function actionUseranswer()
	{
		return json_encode(array('status'=>'ok','data'=>Yii::app()->user->id));
	}
}