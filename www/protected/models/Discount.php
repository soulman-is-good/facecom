<?php

/**
 * This is the model class for table "discount".
 *
 * The followings are the available columns in table 'discount':
 * @property string $id
 * @property string $category_id
 * @property string $office_id
 * @property string $title
 * @property string $text
 * @property string $rules
 * @property string $starts_at
 * @property string $ends_at
 * @property string $images
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Coupon[] $coupons
 * @property Category $category
 * @property Office $office
 * @property City[] $cities
 */
class Discount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Discount the static model class
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
		return 'discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, text, rules, starts_at, ends_at, images, created_at, office_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('office_id, starts_at, ends_at, created_at', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
			array('text', 'length', 'max'=>512),
			array('images', 'length', 'max'=>1024),
			array('starts_at', 'compare', 'compareAttribute'=>'ends_at','operator'=>'<='),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, office_id, title, text, rules, starts_at, ends_at, images, created_at, status', 'safe', 'on'=>'search'),
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
			'coupons' => array(self::HAS_MANY, 'Coupon', 'discount_id'),
			'office' => array(self::BELONGS_TO, 'Office', 'office_id'),
			'cities' => array(self::MANY_MANY, 'City', 'discount_range(discount_id, city_id)'),
			'categories' => array(self::MANY_MANY, 'Category', 'discount_category(discount_id, category_id)'),
		);
	}
        
        public function assocCategories() {
            if($this->id>0){
                $results = array();
                $models = Yii::app()->db->createCommand()->select('category_id, c.title')->from('discount_category t')->join('category c', 'c.id=t.category_id')->
                where('discount_id='.$this->id)->queryAll(true);
                foreach($models as $model)
                    $results[$model['category_id']] = $model['title'];
                return $results;
            }
            return array();
        }
        
        public function assocRegion() {
            if($this->id>0){
                $results = array();
                $models = Yii::app()->db->createCommand()->select('t.city_id, c.name')->from('discount_range t')->join('city c', 'c.city_id=t.city_id')->
                where('discount_id='.$this->id)->queryAll(true);
                foreach($models as $model)
                    $results[$model['city_id']] = $model['name'];
                return $results;
            }
            return array();
        }
        
        public function maxCoupon() {
            if(empty($this->coupons))
                return (object)array('percent'=>0);
            $min = $this->coupons[0];
            foreach($this->coupons as $coupon){
                if($coupon->percent>$min->percent)
                    $min = $coupon;
            }
            return $min;
        }
        
        public function isMyOffice() {
            return Office::model()->find(array(
                'select'=>'COUNT(0)',
                'condition'=>'id=:oid AND user_id=:uid',
                'params'=>array(
                    'uid'=>Yii::app()->user->id,
                    'oid'=>$this->office_id
                )
            ))!==null;
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'office_id' => 'Офис',
			'title' => 'Название акции',
			'text' => 'Описание акции',
			'rules' => 'Условия акции',
			'starts_at' => 'Дата начала акции',
			'ends_at' => 'Дата окончания акции',
			'images' => 'Изображения',
			'created_at' => 'Дата создания',
			'status' => 'Статус',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('office_id',$this->office_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('rules',$this->rules,true);
		$criteria->compare('starts_at',$this->starts_at,true);
		$criteria->compare('ends_at',$this->ends_at,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function beforeValidate() {
            if(strpos($this->starts_at,'.')>0){
                $this->starts_at = strtotime($this->starts_at);
            }
            if(strpos($this->ends_at,'.')>0){
                $this->ends_at = strtotime($this->ends_at);
            }
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return parent::beforeValidate();
        }
}