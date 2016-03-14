<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$profile=Yii::$app->getUserOpt->Profile_user();

//echo $poHeader->KD_RO;
//echo $roEmpe->EMP_ID;
//echo $profile->emp->EMP_NM;
	// $arrayStt= [
		  // ['status' => 0, 'DESCRIP' => 'PENDING'],
		  // ['status' => 1, 'DESCRIP' => 'SIGN'],
	// ];
	// $valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth3Mdl_term',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/master/term-customers/sign-auth3-save'],
		]);
	?>

		<?php echo  $form->field($auth3Mdl, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth3Mdl, 'id')->hiddenInput(['value' => $model->ID_TERM,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($auth3Mdl, 'status')->hiddenInput(['value'=>102])->label(false); ?>
		<?php echo  $form->field($auth3Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
