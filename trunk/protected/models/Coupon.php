<?php

/**
 * This is the model class for table "coupon".
 *
 * The followings are the available columns in table 'coupon':
 * @property string $id
 * @property string $discount_id
 * @property string $text
 * @property string $percent
 * @property integer $type
 * @property string $cost
 * @property string $price
 * @property string $limit
 * @property string $limit_per_user
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Discount $discount
 * @property User[] $users
 */
class Coupon extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Coupon the static model class
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
		return 'coupon';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('discount_id, text, percent, price, created_at', 'required'),
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('discount_id, percent, limit, limit_per_user, created_at', 'length', 'max'=>10),
			array('text', 'length', 'max'=>512),
			array('cost', 'length', 'max'=>64),
			array('price', 'length', 'max'=>9),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, discount_id, text, percent, type, cost, price, limit, limit_per_user, created_at, status', 'safe', 'on'=>'search'),
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
			'discount' => array(self::BELONGS_TO, 'Discount', 'discount_id'),
			'users' => array(self::MANY_MANY, 'User', 'coupon_bought(coupon_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'discount_id' => 'Discount',
			'text' => 'Описание',
			'percent' => 'Процент скидки',
			'type' => 'Тип купона',
			'cost' => 'Стоимость товара',
			'price' => 'Стоимость купона',
			'limit' => 'Количество купонов',
			'limit_per_user' => 'Купонов на одного пользователя',
			'created_at' => 'Created At',
			'status' => 'Status',
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
		$criteria->compare('discount_id',$this->discount_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('percent',$this->percent,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('limit',$this->limit,true);
		$criteria->compare('limit_per_user',$this->limit_per_user,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function beforeValidate() {
            if ($this->percent<0)
                $this->percent = abs($this->percent);
            $this->type = $this->type>0?1:0;
            if($this->isNewRecord)
                $this->created_at = time();
            return parent::beforeValidate();
        }
}