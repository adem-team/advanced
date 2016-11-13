<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$profile=Yii::$app->getUserOpt->Profile_user();



?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth2Mdl_po',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/widget/notulen/sign-auth2-save'],
		]);
	?>

		<?php echo  $form->field($auth2Mdl, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'NotuID')->hiddenInput(['value' => $acara->NOTULEN_ID,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
