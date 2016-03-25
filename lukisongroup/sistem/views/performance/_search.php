<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\AbsensiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absensi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idno') ?>

    <?= $form->field($model, 'TerminalID') ?>

    <?= $form->field($model, 'UserID') ?>

    <?= $form->field($model, 'FunctionKey') ?>

    <?= $form->field($model, 'Edited') ?>

    <?php // echo $form->field($model, 'UserName') ?>

    <?php // echo $form->field($model, 'FlagAbsence') ?>

    <?php // echo $form->field($model, 'DateTime') ?>

    <?php // echo $form->field($model, 'tgl') ?>

    <?php // echo $form->field($model, 'waktu') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
