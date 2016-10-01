<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use pceuropa\menu\Menu;

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

NavBar::begin();
echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => Menu::NavbarLeft($model->id) ]);

echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => Menu::NavbarRight($model->id)]);		
NavBar::end();			

?>


