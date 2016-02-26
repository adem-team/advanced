<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Personallog_usbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personallog-usb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'TerminalID') ?>

    <?= $form->field($model, 'FingerPrintID') ?>

    <?= $form->field($model, 'FunctionKey') ?>

    <?= $form->field($model, 'DateTime') ?>

    <?= $form->field($model, 'FlagAbsence') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
