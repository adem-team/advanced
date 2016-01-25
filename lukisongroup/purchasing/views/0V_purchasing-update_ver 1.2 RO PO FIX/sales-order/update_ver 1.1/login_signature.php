<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$profile=Yii::$app->getUserOpt->Profile_user();

//echo $roHeader->KD_RO;
//echo $roEmpe->EMP_ID;
//echo $profile->emp->EMP_NM;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'login-signature',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/request-order/approved-authorize-save'],
		]);
	?>	
		<?php echo  $form->field($loginSig, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name'); ?>
		<?php echo  $form->field($loginSig, 'kd_ro')->textInput(['value' => $roHeader->KD_RO,'maxlength' => true, 'readonly' => true]); ?>
		<?php echo  $form->field($loginSig, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





