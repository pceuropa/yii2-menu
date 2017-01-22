<?php
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD

use yii\widgets\ActiveForm;
use yii\helpers\Html;

pceuropa\menu\MenuAsset::register($this);
$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'menu_name'); ?>
		<?=  Html::submitButton('Create', ['class' => 'btn btn-success pull-right col-xs-12']); ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>
