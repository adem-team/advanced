<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$profile=Yii::$app->getUserOpt->Profile_user();

	// $arrayStt= [
		  // ['status' => 0, 'DESCRIP' => 'PENDING'],
		  // ['status' => 1, 'DESCRIP' => 'SIGN'],
	// ];
	// $valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'validationUrl'=>Url::toRoute('/purchasing/salesman-order/valid-sign2'),
		]);
	?>

		<?php echo  $form->field($model, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($model, 'kdso')->hiddenInput(['value' => $modelHeader->KD_SO,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($model, 'status')->hiddenInput(['value'=>101])->label(false); ?>
		<?php echo  $form->field($model, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
