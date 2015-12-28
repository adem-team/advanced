<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$profile=Yii::$app->getUserOpt->Profile_user();

//echo $roHeader->KD_RO;
//echo $roEmpe->EMP_ID;
//echo $profile->emp->EMP_NM;
	$arrayStt= [
		  ['status' => 0, 'DESCRIP' => 'PROCESS'],
		  ['status' => 1, 'DESCRIP' => 'PENDING'],
		  ['status' => 101, 'DESCRIP' => 'APPROVED'],
		  ['status' => 4, 'DESCRIP' => 'REJECT'],
	];
	$valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'saFormlogin',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/request-order/approved-authorize-save'],
		]);
	?>	
	
		<?php echo  $form->field($saFormlogin, 'empNm')->hiddenInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($saFormlogin, 'kdro')->hiddenInput(['value' => $roHeader->KD_RO,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($saFormlogin, 'status')->dropDownList($valStt); ?>
		<?php echo  $form->field($saFormlogin, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





