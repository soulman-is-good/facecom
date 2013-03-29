<?php
/* @var $this OfficeController */
/* @var $model Office */

$this->breadcrumbs=array(
	'Offices'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('office-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Offices</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'office-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'name',
		'avatar',
		'background',
		'bgposition',
		/*
		'about',
		'city_id',
		'contacts',
		'website',
		'lat',
		'long',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
