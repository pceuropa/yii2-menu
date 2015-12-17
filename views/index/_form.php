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
<div class="col-md-2"><?= $form->field($model, 'type')->dropDownList(['Link', 'Dropdown', 'Line (divider)']);?></div>

<div class="col-md-4"><?= $form->field($model, 'name')->textInput(['id' => 'create-name']); ?> </div>
<div class="col-md-6"><?= $form->field($model, 'url')->textInput(['id' => 'create-url']); ?> </div>
</div>
<div id="additional-info" class="col-md-8"></div>
<div class="col-md-1">
	<?= Html::SubmitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Add', ['class' => 'btn btn-success']) ?>
</div>




<?php ActiveForm::end(); 
$this->registerJS("
$( 'select' ).on( 'change', function (){
	
switch(true) {
    case ($('select').val() == 0):
		$('#create-name, #create-url').val('').prop('disabled', false);
			$( '#additional-info' ).html('Possible values Url field: /address_url, http://example/');
			break;
    case ($('select').val() == 1):
        $('#create-name').val('').prop('disabled', false); 
        $('#create-url').val('#').prop('disabled', true); 
		$( '#additional-info' ).html('Toggleable menu for displaying lists of links');
		break;
	case ($('select').val() == 2):
        $('#create-name').val('OnlyToDropMenu').prop('disabled', false); 
        $('#create-url').val('').prop('disabled', true); 
		$( '#additional-info' ).html('After adding, drag to the dropmenu. In dropmenu little hard to drag but possible');break;
    default:
        $('#create-url').val('').prop('disabled', true);
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