<label for="country_id">Регион</label>
 			<?
 	$cl=Country::model()->findAll(array('select'=>'country_id, name'));
 	$anyCountry=new Country;
 	$anyCountry->country_id=-1;
 	$anyCountry->name='любая страна';
 	$countrylist[0]=$anyCountry;
 	$countrylist=array_merge($countrylist,$cl);
 	$countries = CHtml::listData($countrylist, 'country_id', 'name');
 	$country_id = 9999999;
 	$city='любой город';
 	$city_id=-1;
    /*if(is_null($model->city)){
        $country_id = 1894;
        $city = City::model()->find('city_id=1913')->name;
        $city_id=1913;
    }else{
        $country_id = $model->city->country_id;
        $city = $model->city->name;
        $city_id=$model->city->city_id;
    }*/

 			?>
 			<?php echo CHtml::dropDownList('country_id',$country_id,$countries,array('class'=>'country_id','for'=>'#city_id','fcselect'=>false)); ?>
 			<?/*php echo CHtml::dropDownList('city_id', $city_id,$cities,array('class'=>'city_id','fcselect'=>true));*/ ?>
 			<?php echo CHtml::textField('city',$city,array('id'=>'city_id','size' => 60, 'maxlength' => 255)); ?>