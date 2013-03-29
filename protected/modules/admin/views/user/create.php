<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать пользователя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); ?>