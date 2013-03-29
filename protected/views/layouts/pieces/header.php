<div class="headerContainer">
	<div class="header">
		<a href="<?=(Yii::app()->user->isGuest?'/':$this->createUrl('profile/profile',array('id'=>Yii::app()->user->id)))?>">
			<img src="/static/css/logo.png" alt="logo" class="logo" />
		</a>
		<div class="search">
			<form action="<?=Yii::app()->request->baseUrl?>/search" method="get">
				<div>
					<input type="submit" class="searchButton" value="" />
					<input type="text" name="query" class="searchInput" value="Поиск по сайту" onfocus="this.value=(this.value=='Поиск по сайту') ? '' : this.value;" onblur="this.value=(this.value=='') ? 'Поиск по сайту' : this.value;" />
				</div>
			</form>
		</div>
		<div class="win">
			<a href="#" class="blue">
				Заработать
			</a>
		</div>
		<div class="spend">
			<a href="#" class="blue">
				Потратить
			</a>
		</div>
		<div class="balance">
			Баланс: <span>0.00 vd</span> | <a href="#" class="gray">Пополнить</a>
		</div>
		<div class="exit">
			<a href="<?=$this->createUrl('my/logout')?>" class="gray">Выход</a>
		</div>
	</div>
</div>