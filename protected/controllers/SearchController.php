<?php

class SearchController extends Controller {

    public $layout = 'profile';
    public $defaultAction = 'people';
    private $searcher = null;


    public function init() {
        Yii::app()->clientScript->registerPackage('main');
        $this->searcher=new SearchComponent;
    }

	//я рыба я рыба
    public function actionPeople($query='')
	{
		Yii::app()->clientScript->registerPackage('profile-index');
		Yii::app()->clientScript->registerPackage('search');
		$words=Array();
		$dataReader=$this->searchPeopleByGetData($words);
		$data='';
		//$dataReader=$this->peopleSearcher($criteria,$words);
        if (!$dataReader){
        	//if noone field is specified
        	$data.=$this->renderPartial('_emptyReq', array(), true);
        }else{
			$total=$dataReader->rowCount;
			if($total>0){
				$people=array();
				if(!empty($dataReader)) {
					while($row=$dataReader->read())
					{
						$people[]=$row;
					}
				}
				//output
				foreach ($people as $item):
					$data.=$this->renderPartial('_manItem', array('item' => $item,'words'=>$words), true);
				endforeach;
			}else {
				$data.=$this->renderPartial('_emptyRes', array(), true);
			}
		}

		$this->render('people', array(
			'data'=>$data,
			'query'=>$query,
			'total'=>$total,
			'words'=>$words
		));

	}

	public function actionPeopleUpdate()
	{   //receiving parmeters
		$ajax=Yii::app()->getRequest()->getQuery('ajax');
		$ajax=($ajax==='ajax');
		$words=Array();
		$dataReader=$this->searchPeopleByGetData($words);
		$data='';
		//$dataReader=$this->peopleSearcher($criteria,$words);
        if (!$dataReader){
        	//if noone field is specified
        	$data.=$this->renderPartial('_emptyReq', array(), true);
        }else{
			$total=$dataReader->rowCount;
			if($total>0){
				$people=array();
				if(!empty($dataReader)) {
					while($row=$dataReader->read())
					{
						$people[]=$row;
					}
				}
				//output
				foreach ($people as $item):
					$data.=$this->renderPartial('_manItem', array('item' => $item,'words'=>$words), true);
				endforeach;
			}else {
				$data.=$this->renderPartial('_emptyRes', array(), true);
			}
		}
		if($ajax)echo json_encode(array('status' => 'ok', 'data' => $data,'total'=>$total));
		else {
			Yii::app()->clientScript->registerPackage('profile-index');
			Yii::app()->clientScript->registerPackage('search');
			$this->render('people', array(
				'data'=>$data,
				'query'=>$query,
				'total'=>$total,
				'words'=>$words
			));
		}
	}

	//разведи огонь
	public function highlightMatch($words,$str)
	{
		foreach($words as $v) {
			$str=preg_replace ('#'.$v.'#iu','<span class="found">$0</span>', $str);
		}
		return $str;
	}

 	public function actionInterviewCount(){
		$qr='';
		//$searcher=new SearchComponent;
		$dataReader=$this->searcher->targetFinder();
		$total=$dataReader->rowCount;
		echo json_encode(array('status' => 'ok','total'=>$total,'chk'=>$qr));
	}

	//возвращает укомплектованный запрос к таблице по критерию на возврат id
	//массив $table:
	//$table['name'] - имя таблицы
	//$table['idField'] - имя поля таблицы соответствующее ид юзера
	//$table['fields']=array(fieldName1,fieldName2,...,fieldNameN)
	private function getSet($words,$table) {
		$ww=Array();
		foreach($table['fields'] as $f){
			$ww[]='(`'.$f.'` LIKE "%'.implode('%") OR (`'.$f.'` LIKE "%',$words).'%")';
		}
		$res='SELECT `'.$table['idField'].'` FROM `'.$table['name'].'` WHERE '.implode(' OR ',$ww);
		return $res;
			/*foreach($words as $w){
				$tez=$f.' LIKE "%'.$w.'%"';
			}*/
	}

	//обрабатывает гет-запрос и направляет функции поиска,
	//в массив в параметрах помещаются слова после разбивки
	private function searchPeopleByGetData(&$words=array()){
		$criteria=Array();
		$criteria['query'] = Yii::app()->getRequest()->getQuery('query');//+
		$criteria['country'] = Yii::app()->getRequest()->getQuery('country');//+
		$criteria['city'] = Yii::app()->getRequest()->getQuery('city');//+
		$criteria['age_from'] = Yii::app()->getRequest()->getQuery('age_from');//+
		$criteria['age_to'] = Yii::app()->getRequest()->getQuery('age_to');//+
		$criteria['withPhoto'] = Yii::app()->getRequest()->getQuery('withPhoto');//+
		$criteria['onlyNames'] = Yii::app()->getRequest()->getQuery('onlyNames');
		$criteria['family_state'] = Yii::app()->getRequest()->getQuery('family_state');//+
		$criteria['gender'] = Yii::app()->getRequest()->getQuery('gender');//+
		$criteria['school'] = Yii::app()->getRequest()->getQuery('school');
		$criteria['clas'] = Yii::app()->getRequest()->getQuery('clas');
		$criteria['schoolyear'] = Yii::app()->getRequest()->getQuery('schoolyear');
		$criteria['uni'] = Yii::app()->getRequest()->getQuery('uni');
		$criteria['fac'] = Yii::app()->getRequest()->getQuery('fac');
		$criteria['uniyear'] = Yii::app()->getRequest()->getQuery('uniyear');
		$criteria['workplace'] = Yii::app()->getRequest()->getQuery('workplace');
		$criteria['workstate'] = Yii::app()->getRequest()->getQuery('workstate');
		$criteria['birthyear'] = Yii::app()->getRequest()->getQuery('birthyear');
		$criteria['birthmonth'] = Yii::app()->getRequest()->getQuery('birthmonth');
		$criteria['birthday'] = Yii::app()->getRequest()->getQuery('birthday');
		$words=Array();
		$dataReader=$this->searcher->peopleSearcher($criteria,$words);
		return $dataReader;
	}

}