<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\\Kar_fingerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kar-finger-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NO_URUT') ?>

    <?= $form->field($model, 'TerminalID') ?>

    <?= $form->field($model, 'KAR_ID') ?>

    <?= $form->field($model, 'FingerPrintID') ?>

    <?= $form->field($model, 'FingerTmpl') ?>

    <?php // echo $form->field($model, 'UPDT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
