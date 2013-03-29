<?php
class PhoneValidator extends CValidator {
    protected function validateAttribute($object,$attribute) {
        $values=$object->$attribute;
        if(!is_array($values)) {
            $message = Yii::t('site','Не верный формат телефона! Перезагрузпите страницу.');
            $this->addError($object,$attribute,$message);
        }
        foreach($values as $value){
            if(empty($value['c_code'])) {
                $message = Yii::t('site','Поле "код страны" не может быть пустым!');
                $this->addError($object,$attribute,$message);
                return false;
            }
            if(empty($value['t_code'])) {
                $message = Yii::t('site','Поле "код города" не может быть пустым!');
                $this->addError($object,$attribute,$message);
                return false;
            }
            if(empty($value['tel'])) {
                $message = Yii::t('site','Поле "телефон" не может быть пустым!');
                $this->addError($object,$attribute,$message);
                return false;
            }
        }
    }
}
?>
