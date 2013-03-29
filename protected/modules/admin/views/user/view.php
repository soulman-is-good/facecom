<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Пользователи' => array('index'),
    $model->login,
);

$this->menu = array(
    array('label' => 'Список', 'url' => array('index')),
    array('label' => 'Создать', 'url' => array('create')),
    array('label' => 'Редактировать', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Удалить', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Управление', 'url' => array('admin')),
);
$profile = $model->profile;
?>

<h1>Просмотр пользователя <?php echo $model->login; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'login',
        'password',
        'salt',
        'email',
        'activation_key',
        array('label' => $model->getAttributeLabel('status'), 'value' => User::getState($model->status)),
        'created_at',
    ),
));
?>

<h1>Профиль пользователя <?php echo $model->login; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $profile,
    'attributes' => array(
        'first_name',
        'second_name',
        'third_name',
        array('label' => 'Город', 'value' => $profile->getRegion()),
        'address',
        'email',
        'phone',
        'gender'=>array('label'=>'Пол','value'=>$profile->getGenderInfo()),
        'family'=>array('label'=>'Семейное положение','value'=>$profile->getFamilyState()),
        'activities',
        'interests',
        'music',
        'quotes',
        'about',
    ),
));
?>
