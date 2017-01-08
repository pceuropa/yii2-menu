<?php
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD
pceuropa\menu\MenuAsset::register($this);
$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


echo $this->render('_menu');?>

<div class="row">
	<?= $this->render('_form');?>
</div>

<div class="pull-right">
	<?= \yii\helpers\Html::a ( Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-default'] ); ?>
	<button type="button" id="menu-create" class="btn btn-info">Create Menu</button>
</div>

<?php 
	$this->registerJs("var menu = new MyMENU.Menu({});", 4);
?>
