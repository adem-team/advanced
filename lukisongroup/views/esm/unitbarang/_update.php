<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\Unitbarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unitbarang-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
		]);
	?>
    <?= $form->field($model, 'NM_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SIZE')->textInput() ?>

    <?= $form->field($model, 'WEIGHT')->textInput() ?>

    <?= $form->field($model, 'COLOR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'UPDATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>
	
    <?= $form->field($model, 'UPDATED_AT')->hiddenInput(['value'=>date('Y-m-d H:i:s')])->label(false) ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '<i class="fa fa-pencil"></i>&nbsp;&nbsp;Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
