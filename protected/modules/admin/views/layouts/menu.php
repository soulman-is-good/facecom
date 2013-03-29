<div class="fc-mainmenu">
    <ul class="right-menu">
        <li><a href="/admin/logout">Выход</a></li>
    </ul>
    <ul class="left-menu"><?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
                        'homeLink'=>CHtml::link(Yii::t('zii','Home'),'/admin'),
			'links'=>$this->breadcrumbs,
		));?>
    </ul>
    <br clear="all"/>
</div>
