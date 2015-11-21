<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


?>
<div class="col-md-4 col-md-offset-4" style="margin-top: 10px">
    <div class="login-panel panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=Icon::show('user',['class'=>'fa-2x'],Icon::FA); ?> LukisonGroup User</h3>
		</div>
        <div class="panel-body">
			
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
					<?= $form->field($model, 'username') ?>
					<?= $form->field($model, 'password')->passwordInput() ?>
					<?= $form->field($model, 'rememberMe')->checkbox() ?>
					<div class="form-group">
						<?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-success btn-block',	 'name' => 'login-button']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			
		</div>
	</div>
</div>
	
