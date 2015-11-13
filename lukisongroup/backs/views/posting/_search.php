<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\backs\models\PostingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'JUDUL') ?>

    <?= $form->field($model, 'RESUME_EN') ?>

    <?= $form->field($model, 'RESUME_ID') ?>

    <?php // echo $form->field($model, 'IMG') ?>

    <?php // echo $form->field($model, 'CREATEBY') ?>

    <?php // echo $form->field($model, 'UPDATEBY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
