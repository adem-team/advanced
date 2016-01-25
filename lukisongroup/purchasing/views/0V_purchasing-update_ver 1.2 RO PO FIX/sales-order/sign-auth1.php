<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use lukisongroup\hrd\models\employe;

	/*
	 * PERMISSION CREATE RO | AUTH1
	 * Jabatan CHCEKED CC =[M,SM,AVP,SM,VP,SVP,EVP,SEVP]
	 * Permission Modul [SIGN1=1]
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	*/
	$profile=Yii::$app->getUserOpt->Profile_user();
	/* GF_ID>=4 Group Function[Director|GM|M|S] */ 
	$userData = ArrayHelper::map(employe::find()->where('(GF_ID<=4) and (STATUS<>3 or EMP_STS=3)' )->all(),'EMP_ID','EMP_NM');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'auth1Mdl-ro',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/sales-order/sign-auth1-save'],
		]);
	?>	
		<?= $form->field($auth1Mdl, 'empID')->widget(Select2::classname(), [
			'data' => $userData,
			'options' => ['placeholder' => 'CC User To Checked RO ...'],
			'pluginOptions' => [
				'allowClear' => true
				 ],
		])->label('Employe Cc:');?>
		<?php echo  $form->field($auth1Mdl, 'empNm')->hiddenInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?php echo  $form->field($auth1Mdl, 'kdro')->hiddenInput(['value' => $roHeader->KD_RO,'maxlength' => true, 'readonly' => true])->label(false); ?>
		<?php echo  $form->field($auth1Mdl, 'status')->hiddenInput(['value'=>'101'])->label(false); ?>
		<?php echo  $form->field($auth1Mdl, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





