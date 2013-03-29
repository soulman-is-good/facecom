<?$isMyList = isset($isMyList)?$isMyList:false;?>
<div class="appMenu">
    <a href="<?=$this->createUrl('/apps/my',array('id'=>Yii::app()->user->id))?>" class="myApp">Мои приложения</a>
	<?if($isMyList):?>
	<a href="<?=$this->createUrl('/apps',array('id'=>Yii::app()->user->id))?>"><div class="item<?=$all?' active':''?>">Добавить приложение</div></a>
	<?endif;?>
</div>