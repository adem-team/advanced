<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\UnitbarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unitbarang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_UNIT') ?>

    <?= $form->field($model, 'NM_UNIT') ?>

    <?= $form->field($model, 'QTY') ?>

    <?= $form->field($model, 'SIZE') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'NOTE') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
