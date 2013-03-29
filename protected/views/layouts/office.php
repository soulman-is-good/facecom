<?php $this->beginContent('/layouts/main'); ?>
<div class="wrapper">
	<?= $this->renderPartial('//layouts/pieces/header') ?>
	<div class="mainContainer">
		<div class="main">
			<!-- Чат -->
                        <? $this->widget('WUserChat') ?>
			<!-- Меню слева -->
                        <?= $this->renderPartial('//layouts/pieces/generalMenu') ?>

			<?= $content ?>
		</div>
	</div>
	<?= $this->renderPartial('//layouts/pieces/footer') ?>
</div>
<?php $this->endContent(); ?>
