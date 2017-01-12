<?php
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use pceuropa\menu\Menu;

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo \yii\bootstrap\Html::tag('h1', $model->menu_name);

NavBar::begin();
echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => Menu::NavbarLeft($model->menu_id) ]);

echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => Menu::NavbarRight($model->menu_id)]);		
NavBar::end();			

?>


