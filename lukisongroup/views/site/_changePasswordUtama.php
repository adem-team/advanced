<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\password\PasswordInput;
use yii\bootstrap\Modal;

$profile=Yii::$app->getUserOpt->Profile_user();

    Modal::begin([
        'id' => 'ubah-password-modal',
        'header' => '<img src="http://lukisongroup.com/login_icon1.png" style="width:70px; height:50px"/>',
		'size' => Modal::SIZE_SMALL,
        'options' => ['class'=>'slide'],
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1);'
		], 
		/* 'options'=>[
			'style'=> 'display:bloack;padding-right:270px;'
		] */
	
    ]);
		$form = ActiveForm::begin([
				'type'=>ActiveForm::TYPE_VERTICAL,
				'id'=>'password-utama-login',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sistem/user-profile/password-utama-save'],
				// 'device'=>''
		]);
		echo $form->field($validationFormLogin, 'oldpassword')->widget(PasswordInput::classname(),['options' => []]);
		echo $form->field($validationFormLogin, 'password')->widget(PasswordInput::classname());
	    echo  $form->field($validationFormLogin, 'repassword')->widget(PasswordInput::classname());
		?>
		<div style="text-align: right;">
			<?php echo Html::submitButton('Saved',['class' => 'btn btn-primary']); ?>
		</div>
		<?php $form =ActiveForm::end();
	Modal::end();
   
?>	
