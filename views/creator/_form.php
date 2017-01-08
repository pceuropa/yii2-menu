<?php 
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD
// $this->registerJsFile('@web/js/menu/menu.js', ['depends' => 'yii\web\YiiAsset']);?>


<div id="inputsData" class="col-md-6 form-horizontal">
	<h4>Add element</h4>

	<div class="form-group">	
		<label class="col-sm-3 control-label">Type</label>
		<div class="col-sm-7">
			<select id="type" class="form-control input-sm">
				  <option value="link">Link</option>
				  <option value="dropmenu">Dropdown menu</option>
				  <option value="line">Line (divider)</option>
			</select>
		</div>
	</div>

	<div id="location-box" class="form-group">
	<label class="col-sm-3 control-label">Location</label>
	<div class="col-sm-8">
	<select id="location" class="form-control input-sm">
		<option value="left">Navbar Left</option>
		<option value="right">Navbar Right</option>
	</select>
	</div>
	</div>

	<div id="anchor-box" class="form-group">
    <label class="col-sm-3 control-label">Label</label>
    <div class="col-sm-8">
      <input id="label" type="text" class="form-control input-sm">
	</div>
	</div>

	<div id="url-box" class="form-group">
    <label class="col-sm-3 control-label">URL</label>
    <div class="col-sm-8">
      <input id="url" type="text" class="form-control input-sm">
	</div>
	</div>
	
	<div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-8">
		<button type="button" id="add" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Add</button>
	</div>
	</div>
</div>
	<ul id="edit" class="col-md-2 well">Drop here to edit</ul>
	<ul id="trash" class="col-md-2 well">Drop here to trash</ul>




