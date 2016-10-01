<?php
pceuropa\menu\MenuAsset::register($this);
$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_menu');?>

<div class="row">
	<?= $this->render('_form');?>
</div>

<?php 
$this->registerJs("var menu = new MyMENU.Menu({
	config: {
		setMysql: true,
		getMysql: true
	}

});", 4);



?>
