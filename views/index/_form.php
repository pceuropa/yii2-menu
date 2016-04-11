<?php
/* @var $this = yii\web\View */
/* @var $model = common\models\Menus */
/* @var $form = yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use pceuropa\menu\models\Model;

$form = ActiveForm::begin(
['id' => 'formCreate',
 'enableAjaxValidation' => true,
 'action' => ['index/create'],
 'validationUrl' => ['index/validate']
]
);
?>

<div class="row">
<div class="col-md-2"><?= $form->field($model, 'type')->dropDownList(['Link', 'Dropdown', 'Line (divider)']);?></div>
<div class="col-md-4"><?= $form->field($model, 'name')->textInput(['id' => 'create-name']); ?> </div>
<div class="col-md-4"><?= $form->field($model, 'url')->textInput(['id' => 'create-url']); ?> </div>
<div class="col-md-2">
<?= $form->field($model, 'gr')->dropDownList($model->ListOfGroup())->label("Place");?> </div>
</div>
<div id="additional-info" class="col-md-8"></div>
<div class="col-md-1">
	<?= Html::SubmitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Add', ['class' => 'btn btn-success']) ?>
</div>



<?php ActiveForm::end(); 
$this->registerJS("
  if ($('#model-gr option').length == 2) {
       $('#model-type option:eq(2)').prop('disabled', true);
	}
	$( '#model-type' ).on( 'change', function (){
	
switch(true) {
	case ($('#model-type').val() == 0):
		$('#create-name, #create-url').val('').prop('disabled', false);
		
		$( '#additional-info' ).html('Possible values Url field: /address_url, http://example/');
		$('#model-gr option:eq(0)').show().prop('selected', true);
		$('#model-gr option:gt(0)').show();
		break;
	
	case ($('#model-type').val() == 1):
		$('#create-name').val('').prop('disabled', false); 
		$('#create-url').val('#').prop('disabled', true); 
		$('#model-gr option:eq(0)').show().prop('selected', true);
		$('#model-gr option:eq(1)').show();
		$('#model-gr option:gt(1)').hide();
		$('#additional-info' ).html('');
		break;

	case ($('#model-type').val() == 2):
		$('#create-name').val('OnlyToDropMenu').prop('disabled', true); 
		$('#create-url').val('').prop('disabled', true); 
		$('#model-gr option:eq(0)').hide();
		$('#model-gr option:eq(1)').hide();
		$('#model-gr option:gt(1)').show().prop('selected', true);
		$( '#additional-info' ).html('The line is thicker to facilitate dragging. On the frontend it is normal.');break;
	default:
		  $('#create-url').prop('disabled', true);
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
