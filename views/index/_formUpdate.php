<?php
/* @var $this = yii\web\View */
/* @var $model = common\models\Menus */
/* @var $form = yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

$form = ActiveForm::begin([
	'id' => 'formUpdate',
	'enableAjaxValidation' => true,
	'action' => ['index/update', 'id' => $model->menu_id ],
	'validationUrl' => ['index/validate']
]);
?>

<div class="row">
	<div class="col-md-5"><?= $form->field($model, 'name') ?></div>
	<div class="col-md-4"><?= $form->field($model, 'url')->textInput(['disabled' => $model->url == '#']) ?> </div>	
	<div class="col-md-1">
		<?= Html::SubmitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', ['class' => 'btn btn-success']) ?>
	</div>
</div>

<?php ActiveForm::end();  

$this->registerJS("

$('body').on('beforeSubmit', '#formUpdate', function (){
		
	var form = $(this);
    if (form.find('.has-error').length) {
		return false;
    }

    $.ajax({
		url: form.attr('action'),
		type: 'post',
		data: form.serialize(),
		enctype: 'multipart/form-data',
		success: function (response) {
				if (response.success === true) {
					
					$('#modalUpdate').modal('hide');
					$.pjax.reload('*');
				}
			},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert(textStatus);
		}
	 });
	return false;
});
");