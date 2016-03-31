<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\password\PasswordInput;

$profile=Yii::$app->getUserOpt->Profile_user();
//echo  $profile->emp->EMP_ID;
// $this->registerCss('.kv-meter{
// 	margin-bottom:100px;
//
// }')
?>
	<?php
		$form = ActiveForm::begin([
				'type'=>ActiveForm::TYPE_VERTICAL,
				'id'=>'password-utama-login',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sistem/user-profile/password-utama-save'],
				// 'device'=>''
		]);
	?>
	<?php echo $form->field($validationFormLogin, 'oldpassword')->widget(PasswordInput::classname(),['options' => []
    ]) ?>
	<?php echo $form->field($validationFormLogin, 'password')->widget(PasswordInput::classname()) ?>
	<?php echo  $form->field($validationFormLogin, 'repassword')->widget(PasswordInput::classname()) ?>
		<?php //echo  $form->field($model, 'EMP_NM')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name'); ?>
		  <!-- $form->field($validationFormLogin, 'oldpassword')->textInput(['type'=>'password','maxlength' => true])->label('Old Password'); ?> -->
		<!-- echo  $form->field($validationFormLogin, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?> -->
		 <!-- echo  $form->field($validationFormLogin, 'repassword')->textInput(['type'=>'password','maxlength' => true])->label('Re-Password'); ?> -->
		<div style="text-align: right;">
			<?php echo Html::submitButton('Saved',['class' => 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>
