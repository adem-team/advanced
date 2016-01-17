<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\KategoricusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kategoricus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CUST_KTG') ?>

    <?= $form->field($model, 'CUST_KTG_PARENT') ?>

    <?= $form->field($model, 'CUST_KTG_NM') ?>

    <?= $form->field($model, 'CREATED_BY') ?>

    <?= $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
