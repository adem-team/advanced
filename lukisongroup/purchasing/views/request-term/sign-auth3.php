<?php
/* extensions */
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

// componen
$profile=Yii::$app->getUserOpt->Profile_user();

/* array for dropdown list using proses signature choice */
	$arrayStt= [
		  ['status' => 102, 'DESCRIP' => 'APPROVED'],
      ['status' => 4, 'DESCRIP' => 'REJECT'],
	];
	$valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');

?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth3Mdl_rt',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/request-term/sign-auth3-save'],
		]);
	?>

		<?php echo  $form->field($auth3Mdl, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth3Mdl, 'kdrib')->hiddenInput(['value' => $rtHeader->KD_RIB,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo $form->field($auth3Mdl, 'status')->widget(Select2::classname(), [
		    			  'data' => $valStt,
		    				'language' => 'en',
		    				'options' => ['placeholder' => 'Select...'],
		    				'pluginOptions' => [
		        					'allowClear' => true
		    					],
							]) ?>

		<?php echo  $form->field($auth3Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>

		<div style="text-align: right;">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
