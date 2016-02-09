<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\TermbudgetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termbudget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'INVES_TYPE') ?>

    <?= $form->field($model, 'BUDGET_SOURCE') ?>

    <?= $form->field($model, 'BUDGET_VALUE') ?>

    <?php // echo $form->field($model, 'PERIODE_START') ?>

    <?php // echo $form->field($model, 'PERIODE_END') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATE_BY') ?>

    <?php // echo $form->field($model, 'CREATE_AT') ?>

    <?php // echo $form->field($model, 'UPDATE_BY') ?>

    <?php // echo $form->field($model, 'UPDATE_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
