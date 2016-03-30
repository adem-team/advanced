<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\TipeStockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipe-stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TYPE_PARENT') ?>

    <?= $form->field($model, 'TYPE_KAT') ?>

    <?= $form->field($model, 'TYPE_ID') ?>

    <?= $form->field($model, 'TYPE_NAME') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
