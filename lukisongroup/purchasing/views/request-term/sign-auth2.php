<?php

/*extensions */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


/* componen user */
$profile=Yii::$app->getUserOpt->Profile_user();

?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth2Mdl_rt',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/request-term/sign-auth2-save'],
		]);
	?>

		<?php echo  $form->field($auth2Mdl, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'kdrib')->hiddenInput(['value' => $rtHeader->KD_RIB,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'status')->hiddenInput(['value'=>101])->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
