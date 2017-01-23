<?php 
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
// $this->registerJsFile('@web/js/menu/menu.js', ['depends' => 'yii\web\YiiAsset']);

use yii\bootstrap\BaseHtml;
use pceuropa\menu\models\Model;
//$glyphicons = \pceuropa\menu\icons\Glyphicons::forge()->getAll();
//$glyphicons = json_encode($glyphicons);
//$this->registerJs( " window.glyphicons = {$glyphicons}; ", \yii\web\View::POS_HEAD);
?>


<div id="inputsData" class="col-md-6 form-horizontal">
	<h4>Add element</h4>

	<div class="form-group">	
		<label class="col-sm-3 control-label">Type</label>
		<div class="col-sm-7">
			<?= BaseHtml::dropDownList(
				'',
				'link',
				Model::$availableMenuTypes,
				['id' => 'type', 'class' => 'form-control input-sm']
			); ?>
		</div>
	</div>

	<div id="anchor-box" class="form-group">
    <label class="col-sm-3 control-label">Label</label>
    <div class="col-sm-8">
		<?= BaseHtml::input('text', '', '', ['id' => 'label', 'class' => 'form-control input-sm']); ?>
	</div>
	</div>

	<div id="url-box" class="form-group">
    <label class="col-sm-3 control-label">URL</label>
    <div class="col-sm-8">
		<?= BaseHtml::input('text', '', '', ['id' => 'url', 'class' => 'form-control input-sm']); ?>
	</div>
	</div>
	
	
	<div id="location-box" class="form-group">
	<label class="col-sm-3 control-label">Location</label>
	<div class="col-sm-8">
		<?= BaseHtml::dropDownList(
			'',
			'left',
			['left' => 'Navbar Left', 'right' => 'Navbar Right'],
			['id' => 'location', 'class' => 'form-control input-sm']
		); ?>
	</div>
	</div>
<!--	
	<div class="form-group" id="icon-box">
        <label for="icon" class="col-sm-3 control-label">Icon</label>
        <div class="col-sm-7">
            <?= \kartik\select2\Select2::widget([
                'name' => 'icon',
                'data' => \pceuropa\menu\icons\Glyphicons::forge()->getDropDownOptions(),
                'options' => ['placeholder' => 'Select an icon ...', 'id' => 'icon'],
                'pluginOptions' => [
                    'escapeMarkup' => new \yii\web\JsExpression("function(m) { return m; }"),
                    'allowClear' =>  true
                ],
            ]); ?>
        </div>
    </div>
 -->   
    
	<div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-8">
		<?= BaseHtml::button(
			BaseHtml::tag('span', '', ['class' => 'glyphicon glyphicon-ok', 'aria-hidden' => 'true']) . ' Add',
			['id' => 'add', 'class' => 'btn btn-success']
		); ?>
	</div>
	</div>
	
	
</div>
	<ul id="edit" class="col-md-2 well">Drop here to edit</ul>
	<ul id="trash" class="col-md-2 well">Drop here to trash</ul>




