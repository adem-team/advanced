<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\SopSalesHeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sop-sales-header-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'STT_DEFAULT') ?>

    <?= $form->field($model, 'SOP_TYPE') ?>

    <?= $form->field($model, 'KATEGORI') ?>

    <?php // echo $form->field($model, 'BOBOT_PERCENT') ?>

    <?php // echo $form->field($model, 'TARGET_MONTH') ?>

    <?php // echo $form->field($model, 'TARGET_DAY') ?>

    <?php // echo $form->field($model, 'TTL_DAYS') ?>

    <?php // echo $form->field($model, 'TARGET_UNIT') ?>

    <?php // echo $form->field($model, 'CREATE_BY') ?>

    <?php // echo $form->field($model, 'CREATE_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
