<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\password\PasswordInput;



?>
	<?php
		$form = ActiveForm::begin([
				'type'=>ActiveForm::TYPE_VERTICAL,
				'id'=>'password-utama-login',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/crmsistem/crm-user-profile/password-utama-save'],
				// 'device'=>''
		]);
	?>
	<?php echo $form->field($validationFormLogin, 'oldpassword')->widget(PasswordInput::classname(),['options' => []]) ?>
	<?php echo $form->field($validationFormLogin, 'password')->widget(PasswordInput::classname()) ?>
	<?php echo  $form->field($validationFormLogin, 'repassword')->widget(PasswordInput::classname()) ?>
		<div style="text-align: right;">
			<?php echo Html::submitButton('Saved',['class' => 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>
