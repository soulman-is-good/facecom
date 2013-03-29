<?php

/**
 * This is the model class for table "user_apps".
 *
 * The followings are the available columns in table 'user_apps':
 * @property integer $id
 * @property integer $user_id
 * @property integer $app_id
 */
class UserApps extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserApps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_apps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, app_id, added', 'required'),
			array('user_id, app_id, added', 'numerical', 'integerOnly'=>true),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, app_id, added', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'app_id' => array(self::BELONGS_TO, 'Apps', 'app_id'),
			'user_id' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'app_id' => 'App',
			'added' => 'Added',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('app_id',$this->app_id);
		$criteria->compare('added',$this->added);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//Функция возвращает сортитрованный массив всех приложений пользователя $id
	public function appList($id,$offset=0)
	{
		$user_app_list=$this->findAll(
			array (
				'condition' => 'user_id='.$id,
				'select' => 'app_id',
				'order' => 'added DESC',
				'limit'=>Yii::app()->params->maxAppsPerRequest,
				'offset'=>$offset
			)
    	);
    	$uappids=Array();
    	if(empty($user_app_list))$cond='0';
    	else
    	{
    		foreach($user_app_list as $v)
    		{
    			$uappids[]=$v->app_id;
	    	}
	    $cond=implode(' OR id=',$uappids);
	    }
    	$ua=Apps::model()->findAll(
			array (
				'condition' => 'id='.$cond,
				'order'=>'users DESC',
			)
    	);
    	$ua2=array();
    	foreach ($ua as $v)
    	{
    		$ua2[$v->id]=$v;
    	}
    	$userapps=array();
    	foreach($user_app_list as $v)
    	{
    		$userapps[]=$ua2[$v->app_id];
    	}
    	return $userapps;
	}

	public function userAppIds($id)
	{
		$user_apps=$this->findAll(
			array (
				'condition'=>'user_id='.$id,
				'select'=>'app_id'
			)
		);
		$appIds=array();
		foreach($user_apps as $v)
		{
			$appIds[]=$v->app_id;
		}
		return $appIds;
	}
}