<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$profile=Yii::$app->getUserOpt->Profile_user();

//echo $poHeader->KD_RO;
//echo $roEmpe->EMP_ID;
//echo $profile->emp->EMP_NM;
	$arrayStt= [
		  ['status' => 0, 'DESCRIP' => 'PENDING'],		  
		  ['status' => 1, 'DESCRIP' => 'SIGN'],
	];	
	$valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth2Mdl_po',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/sign-auth2-save'],
		]);
	?>	
	
		<?php echo  $form->field($auth2Mdl, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'kdpo')->hiddenInput(['value' => $poHeader->KD_PO,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'status')->hiddenInput(['value'=>102])->label(false); ?>
		<?php echo  $form->field($auth2Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





