<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$profile=Yii::$app->getUserOpt->Profile_user();

?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'login-form-alias',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/master/customers/login-cek'],
		]);
	?>

		<?php echo  $form->field($ValidationLoginPrice, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($ValidationLoginPrice, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
