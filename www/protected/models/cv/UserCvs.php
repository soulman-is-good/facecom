<?php

/**
 * This is the model class for table "user_cvs".
 *
 * The followings are the available columns in table 'user_cvs':
 * @property integer $id
 * @property integer $user_id
 * @property string $cv_avatar
 * @property string $desire_position
 * @property integer $professional_field
 * @property integer $salary
 * @property integer $emploment
 */
class UserCvs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserCvs the static model class
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
		return 'user_cvs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, desire_position, professional_field, salary, employment', 'required'),
			array('user_id, professional_field, salary, employment', 'numerical', 'integerOnly'=>true),
			array('cv_avatar, desire_position', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, cv_avatar, desire_position, professional_field, salary, employment', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'city_id' ,'with'=>'country'),
            'universities' => array(self::HAS_MANY, 'UserUniversity', 'user_id'),
            'schools' => array(self::HAS_MANY, 'UserSchool', 'user_id'),
            'works' => array(self::HAS_MANY, 'UserWork', 'user_id' ),
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
			'cv_avatar' => 'Cv Avatar',
			'desire_position' => 'Desire Position',
			'professional_field' => 'Professional Field',
			'salary' => 'Salary',
			'employment' => 'Employment',
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
		$criteria->compare('cv_avatar',$this->cv_avatar,true);
		$criteria->compare('desire_position',$this->desire_position,true);
		$criteria->compare('professional_field',$this->professional_field);
		$criteria->compare('salary',$this->salary);
		$criteria->compare('employment',$this->employment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function listCv($user_id){
		$get_cv_list = Yii::app()->db->createCommand('SELECT *, DATE_FORMAT(creation_date,"%d/%M/%Y %H:%i") as c_date, DATE_FORMAT(last_edited_date,"%d %M %Y") as le_date, DATE_FORMAT(last_edited_date, "%H:%i") as le_date_time  FROM user_cvs uc INNER JOIN cv_counters cc ON uc.cv_id = cc.cv_id WHERE uc.user_id = '. $user_id .'')->queryAll();
		return $get_cv_list;
	}

	public function cvCounter($user_id){
		$cv_count = Yii::app()->db->createCommand('SELECT * FROM user_cvs WHERE user_id = '. $user_id .'')->queryAll();
		$count = count($cv_count);
		return $count;
	}

	public function viewCvDetail($cv_id) {
		$cv_view = Yii::app()->db->createCommand('SELECT * FROM user_cvs ucv INNER JOIN cv_prof_field cpf ON ucv.professional_field = cpf.id_prof_field INNER JOIN  cv_employment cve ON ucv.employment = cve.id_empl INNER JOIN user_work uw ON ucv.user_id = uw.user_id INNER JOIN user_university uu ON ucv.user_id = uu.user_id INNER JOIN user_profile up ON ucv.user_id = up.user_id INNER JOIN user_school us ON ucv.user_id = us.user_id WHERE ucv.cv_id = ' . $cv_id . ' GROUP BY ucv.cv_id')->queryAll();
		return $cv_view;
	}

	public function getLanguages($lang_ids) {
		if (empty($lang_ids))
            return 'немой';
        $langs = Yii::app()->db->createCommand('SELECT title FROM language WHERE id IN (' . $lang_ids . ')')->queryAll();
        if (empty($langs))
            return 'немой';
        $tmp = '';
        foreach ($langs as $lang) {
            $tmp .= $lang['title'] . ', ';
        }
        return trim($tmp, ', ');
	}

	public function getRegion($r_id) {
		$region_query = Yii::app()->db->createCommand('SELECT cy.name as cy_name, ct.name as ct_name FROM city ct INNER JOIN country cy ON ct.country_id = cy.country_id WHERE ct.city_id = ' . $r_id . '')->queryAll();

        $title = $region_query[0]['cy_name'] . ", " . $region_query[0]['ct_name'];
        return $title;
    }
}