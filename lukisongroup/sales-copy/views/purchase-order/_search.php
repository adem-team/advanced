<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\PurchaseorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_PO') ?>

    <?= $form->field($model, 'KD_SUPPLIER') ?>

    <?= $form->field($model, 'CREATE_BY') ?>

    <?= $form->field($model, 'CREATE_AT') ?>

    <?php // echo $form->field($model, 'APPROVE_BY') ?>

    <?php // echo $form->field($model, 'APPROVE_AT') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
