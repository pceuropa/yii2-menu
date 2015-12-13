<?php
/* @var $this = yii\web\View */
/* @var $model = common\models\Menus */
/* @var $form = yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

$form = ActiveForm::begin(
['id' => 'formCreate',
 'enableAjaxValidation' => true,
 'action' => ['index/create'],
 'validationUrl' => ['index/validate']
]
);?>

<div class="row">
<div class="col-md-2"><?= $form->field($model, 'type')->dropDownList(['Link', 'Dropmenu']);?></div>

<div class="col-md-4"><?= $form->field($model, 'name') ?> </div>
<div class="col-md-6"><?= $form->field($model, 'url') ?> </div>
</div>
<div class="col-md-1 col-md-offset-10">
	<?= Html::SubmitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', ['class' => 'btn btn-success']) ?>
</div>




<?php ActiveForm::end(); 
$this->registerJS("
$( 'select' ).on( 'change', function (){
	if ($('select').val() == 1){
        $('#menus-url').val('#').prop('disabled', true);
    } else {
        $('#menus-url').val('').prop('disabled', false);
    }
});


$('body').on('beforeSubmit', '#formCreate', function (){
		
	var form = $(this);
	if (form.find('.has-error').length) {
		return false;
	}
		
	$.ajax({
	  url: form.attr('action'),
	  type: 'post',
	  data: form.serialize(),
	  success: function (response) {
				if (response.success === false) {console.log(response.message);}
				if (response.success === true) {
					console.log(response.message);
					 $.pjax.reload('*');
				}
			},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert(textStatus);
		}
	});
	return false;
});");?>