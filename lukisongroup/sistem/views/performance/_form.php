<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TerminalID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UserID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FunctionKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Edited')->textInput() ?>

    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FlagAbsence')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DateTime')->textInput() ?>

    <?= $form->field($model, 'tgl')->textInput() ?>

    <?= $form->field($model, 'waktu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
