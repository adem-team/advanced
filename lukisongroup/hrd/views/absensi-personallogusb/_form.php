<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Personallog_usb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personallog-usb-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TerminalID')->textInput() ?>

    <?= $form->field($model, 'FingerPrintID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FunctionKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DateTime')->textInput() ?>

    <?= $form->field($model, 'FlagAbsence')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
