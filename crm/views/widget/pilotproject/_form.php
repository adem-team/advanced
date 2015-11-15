<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilotproject-form">

    <?php $form = ActiveForm::begin(); //ID=Auto incremen?>
	
    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'PILOT_ID')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'PILOT_NM')->textInput() ?>
	
    <?= $form->field($model, 'DSCRP')->textInput() ?>
	
    <?= $form->field($model, 'PLAN_DATE1')->textInput() ?>

    <?= $form->field($model, 'PLAN_DATE2')->textInput() ?>

    <?= $form->field($model, 'ACTUAL_DATE1')->textInput() ?>

    <?= $form->field($model, 'ACTUAL_DATE2')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
