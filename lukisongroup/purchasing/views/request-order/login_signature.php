<?php
use yii\helpers\Html;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
//use yii\bootstrap\Modal;


//echo $roHeader->KD_RO;
//echo $employe->EMP_ID;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'signature-login',
				'enableClientValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/request-order/simpanfirst'],
		]);
	?>	
		<?php echo  $form->field($employe, 'EMP_NM')->textInput(['value' => $employe->EMP_NM .' '. $employe->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name'); ?>
		<?php echo  $form->field($employe, 'SIGPASSWORD')->textInput(['type'=>'password','value' => $employe->SIGPASSWORD,'maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('login',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





