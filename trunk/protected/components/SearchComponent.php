<?php
class SearchComponent extends CComponent {
	//ищет людей
	//$criteria - массив со значениями полей поиска
	//$words - массив, в который будут помещены слова запроса после разбивки
	//возвращает экземпляр CDbDataReader
	public function peopleSearcher($criteria,&$words=Array()){
		$query = trim($criteria['query']);//+
		$country = trim($criteria['country']);//+
		$city = trim($criteria['city']);//+
		$age_from = trim($criteria['age_from']);//+
		$age_to = trim($criteria['age_to']);//+
		$withPhoto = trim($criteria['withPhoto']);//+
		$onlyNames = trim($criteria['onlyNames']);
		$family_state = trim($criteria['family_state']);//+
		$gender = trim($criteria['gender']);//+
		$school = trim($criteria['school']);
		$clas = trim($criteria['clas']);
		$schoolyear = intVal($criteria['schoolyear']);
		$uni = trim($criteria['uni']);
		$fac = trim($criteria['fac']);
		$uniyear = intVal($criteria['uniyear']);
		$workplace = trim($criteria['workplace']);
		$workstate = trim($criteria['workstate']);
		$birthyear = intVal($criteria['birthyear']);
		$birthmonth = trim($criteria['birthmonth']);
		$birthday = trim($criteria['birthday']);
		//build query
		$query = preg_replace('/[^a-zа-яё0-9\\-]+/iu', ' ', $query);
		$words=explode(' ',$query);
		$words = array_diff($words, array(''));
		$f=true;
		$qp='';
		if(!empty($words)){
			foreach($words as $v){
				$qp.=!$f?' AND ':'';
				$qp.='(`first_name` LIKE "%'.$v.'%" OR `second_name` LIKE "%'.$v.'%" OR `third_name` LIKE "%'.$v.'%")';
				$f=false;
			}
		} else $qp='1';
		$city = preg_replace('/ +/', ' ', $city);
		$city = preg_replace('/[^a-zа-яё0-9 ()\\-]+/iu', '', $city);
		if(!empty($city)){
			$cp='`city_id`=(SELECT `city_id` FROM `city` WHERE `name` LIKE "%'.$city.'%" LIMIT 0,1)';
		} else {
			$country=intVal($country);
			if(empty($country)||$country==0)$country=-1;
            if($country!=-1) {
            	$cp='`city_id` IN (SELECT `city_id` FROM `city` WHERE `country_id`='.$country.')';
            }else $cp='1';
		}
		$age_from=intVal($age_from);
		$cYear=date('Y');
		$cMonth=date('m');
		$cDay=date('d');
		$yearfrom=$cYear-$age_from;
		$agestart=mktime(0,0,0,$cMonth,$cDay,$yearfrom);
		$afp=($age_from>0)?'`birth_date`<='.$agestart:'1';
		$age_to=intVal($age_to);
		if($age_to<$age_from)$age_to=$age_from;
		$yearto=$cYear-$age_to-1;
		$ageend=mktime(0,0,0,$cMonth,$cDay,$yearto);
		$atp=($age_to>0)?'`birth_date`>='.$ageend:'1';
		$wpp=($withPhoto)?'`avatar` IS NOT NULL':'1';
        $family_state=intVal($family_state);
        if($family_state>0) {
        	$family_state--;
        	if($family_state>3)$fsp='1';
        	else $fsp='`family`='.$family_state;
        } else $fsp='1';
        $gender=intVal($gender);
        $school = preg_replace('/ +/', ' ', $school);
		$school = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $school);
		$school = str_replace('"','\\"',$school);
        $clas = preg_replace('/ +/', ' ', $clas);
		$clas = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $clas);
		$clas = str_replace('"','\\"',$clas);
		$i12 = (!empty($school))?'`user_school`.`title` LIKE "%'.$school.'%"':'1';
		$i13 = (!empty($clas))?'`user_school`.`class_title` LIKE "%'.$clas.'%"':'1';
		$i14 = (!empty($schoolyear))?'`user_school`.`year_till` = '.$schoolyear:'1';
		$schp = ((!empty($school))||(!empty($clas))||(!empty($schoolyear)))?'`user_id` IN (SELECT `user_id` FROM `user_school` WHERE ('.$i12.') AND ('.$i13.') AND ('.$i14.'))':'1';
        if($gender==0)$gp='1';else {
        	$gender--;
        	$gp=($gender<2)?'`gender`='.$gender:'1';
        }
		$uni = preg_replace('/ +/', ' ', $uni);
		$uni = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $uni);
		$uni = str_replace('"','\\"',$uni);
		$fac = preg_replace('/ +/', ' ', $fac);
		$fac = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $fac);
		$fac = str_replace('"','\\"',$fac);
		$i15 = (!empty($uni))?'`user_university`.`title` LIKE "%'.$uni.'%"':'1';
		$i16 = (!empty($fac))?'`user_university`.`faculty` LIKE "%'.$fac.'%"':'1';
		$i17 = (!empty($uniyear))?'`user_university`.`year_till` = '.$uniyear:'1';
		$up = ((!empty($uni))||(!empty($fac))||(!empty($uniyear)))?'`user_id` IN (SELECT `user_id` FROM `user_university` WHERE ('.$i15.') AND ('.$i16.') AND ('.$i17.'))':'1';
		$workplace = preg_replace('/ +/', ' ', $workplace);
		$workplace = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $workplace);
		$workplace = str_replace('"','\\"',$workplace);
		$workstate = preg_replace('/ +/', ' ', $workstate);
		$workstate = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $workstate);
		$workstate = str_replace('"','\\"',$workstate);
		$i18 = (!empty($workplace))?'`user_work`.`work` LIKE "%'.$workplace.'%"':'1';
		$i19 = (!empty($workstate))?'`user_work`.`state` LIKE "%'.$workstate.'%"':'1';
		$wp = ((!empty($workplace))||(!empty($workstate)))?'`user_id` IN (SELECT `user_id` FROM `user_work` WHERE ('.$i18.') AND ('.$i19.'))':'1';
		if(!empty($birthyear)){
			if(!empty($birthmonth)){
				if(!empty($birthday)){
					$stb=mktime(0,0,0,$birthmonth,$birthday,$birthyear);
					$endb=mktime(23,59,59,$birthmonth,$birthday,$birthyear);
				}else{
					$stb=mktime(0,0,0,$birthmonth,0,$birthyear);
					$endb=mktime(23,59,59,$birthmonth,31,$birthyear);
				}
			}else{
				$stb=mktime(0,0,0,$birthmonth,0,$birthyear);
				$endb=mktime(23,59,59,12,31,$birthyear);
			}
			$bp='`birth_date`>='.$stb.' AND `birth_date`<='.$endb;
		}else $bp='1';
        $data='';
        if (($qp==='1')&&($cp==='1')&&($afp==='1')&&($atp==='1')&&($wpp==='1')&&($gp==='1')&&($fsp==='1')&&($schp==='1')&&($up==='1')&&($wp==='1')&&($bp==='1')){
        	//if noone field is specified
        	return false;
        }else{
        	$sql="SELECT * FROM `user_profile` INNER JOIN `user` ON (`user`.`id`=`user_profile`.`user_id`) WHERE (`status`=1) AND ($fsp) AND ($qp) AND ($cp) AND ($afp) AND ($atp) AND ($wpp) AND ($gp) AND ($schp) AND ($up) AND ($wp) AND ($bp)";
        	//$data.=$sql;
        	//sending request
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->query();
			return $dataReader;
		}
	}

	//ищет респондентов для таргетинга
	public function targetFinder(&$qr=''){
		$country = intVal(trim(Yii::app()->getRequest()->getQuery('country_id',0)));
		$city = Yii::app()->getRequest()->getQuery('city',array());
		if(!is_array($city))$city=array();
		$gender = intVal(Yii::app()->getRequest()->getQuery('gender',-1));
		$fs = Yii::app()->getRequest()->getQuery('fs',array());
		if(!is_array($fs))$fs=array();
		$age_from = intVal(Yii::app()->getRequest()->getQuery('age_from',0));
		$age_to = intVal(Yii::app()->getRequest()->getQuery('age_to',0));
		$school = trim(Yii::app()->getRequest()->getQuery('school',''));
		$clas = trim(Yii::app()->getRequest()->getQuery('class',''));
		$schoolyear = intVal(Yii::app()->getRequest()->getQuery('schoolyear',0));
		$uni = trim(Yii::app()->getRequest()->getQuery('uni',''));
		$fac = trim(Yii::app()->getRequest()->getQuery('fac',''));
		$uniyear = intVal(Yii::app()->getRequest()->getQuery('uniyear',0));
		////////////////////////////////////////////////////////////////////////
		$uni = preg_replace('/ +/', ' ', $uni);
		$uni = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $uni);
		$uni = str_replace('"','\\"',$uni);
		$fac = preg_replace('/ +/', ' ', $fac);
		$fac = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $fac);
		$fac = str_replace('"','\\"',$fac);
		$i15 = (!empty($uni))?'`user_university`.`title` LIKE "%'.$uni.'%"':'1';
		$i16 = (!empty($fac))?'`user_university`.`faculty` LIKE "%'.$fac.'%"':'1';
		$i17 = (!empty($uniyear))?'`user_university`.`year_till` = '.$uniyear:'1';
		$vuz = ((!empty($uni))||(!empty($fac))||(!empty($uniyear)))?'`user_id` IN (SELECT `user_id` FROM `user_university` WHERE ('.$i15.') AND ('.$i16.') AND ('.$i17.'))':'1';
        $school = preg_replace('/ +/', ' ', $school);
		$school = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $school);
		$school = str_replace('"','\\"',$school);
        $clas = preg_replace('/ +/', ' ', $clas);
		$clas = preg_replace('/[^a-zа-яё0-9 ()\\-№\\.\\"]+/iu', '', $clas);
		$clas = str_replace('"','\\"',$clas);
		$i12 = (!empty($school))?'`user_school`.`title` LIKE "%'.$school.'%"':'1';
		$i13 = (!empty($clas))?'`user_school`.`class_title` LIKE "%'.$clas.'%"':'1';
		$i14 = (!empty($schoolyear))?'`user_school`.`year_till` = '.$schoolyear:'1';
		$wkola = ((!empty($school))||(!empty($clas))||(!empty($schoolyear)))?'`user_id` IN (SELECT `user_id` FROM `user_school` WHERE ('.$i12.') AND ('.$i13.') AND ('.$i14.'))':'1';
		$cYear=date('Y');
		$cMonth=date('m');
		$cDay=date('d');
		if($age_to<1){
			$mladwe='1';
		}else{
			if($age_to<$age_from)$age_to=$age_from;
			$yearto=$cYear-$age_to-1;
			$ageend=mktime(0,0,0,$cMonth,$cDay,$yearto);
			$mladwe='`birth_date`>='.$ageend;
		}
		if($age_from<1){
			$starwe='1';
		}else{
			$yearfrom=$cYear-$age_from;
			$agestart=mktime(0,0,0,$cMonth,$cDay,$yearfrom);
			$starwe='`birthdate`>='.$agestart;
		}
		foreach($fs as $v){
			$v=intVal($v);
		}
		$semei=empty($fs)?'1':'(`family`='.implode(')OR(`family`=',$fc).')';
		$g15=array();
		foreach($city as $cid){
			$cid=intVal($cid);
			if($cid==0){
				if((count($city==1))&&($country>0)){
					$g15[]='`city_id` IN (SELECT `city_id` FROM `city` WHERE `country_id`='.$country.')';
					break;
				}else continue;
			}elseif($cid==-1){
				$g15=array();
				break;
			}elseif($cid<0){
				$g15[]='`city_id` IN (SELECT `city_id` FROM `city` WHERE `country_id`='.abs($cid).')';
			}
			else{$g15[]='`city_id`='.$cid;}
		}
		if(empty($g15)){
			if($country>0){
				$gorod='`city_id` IN (SELECT `city_id` FROM `city` WHERE `country_id`='.$country.')';
			}else{$gorod='1';}
		}else{
			$gorod='('.implode(') OR (',$g15).')';
		}
		if($gender<0){
			$pol='1';
		}else{
			$pol='`gender`='.$gender;
		}
		$sql="SELECT * FROM `user_profile` INNER JOIN `user` ON (`user`.`id`=`user_profile`.`user_id`) WHERE (`status`=1) AND ($gorod) AND ($pol) AND ($semei) AND ($starwe) AND ($mladwe) AND ($wkola) AND ($vuz)";
		//$qr=$sql;
		$connection=Yii::app()->db;
		$qr=$sql;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		return $dataReader;
	}

}
?>