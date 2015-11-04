<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\RequestorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requestorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_RO') ?>

    <?= $form->field($model, 'NOTE') ?>

    <?= $form->field($model, 'ID_USER') ?>

    <?= $form->field($model, 'KD_CORP') ?>

    <?php // echo $form->field($model, 'KD_CAB') ?>

    <?php // echo $form->field($model, 'KD_DEP') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_ALL') ?>

    <?php // echo $form->field($model, 'DATA_ALL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
