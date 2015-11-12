<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\KategoriSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kategori-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_KATEGORI') ?>

    <?= $form->field($model, 'NM_KATEGORI') ?>

    <?= $form->field($model, 'NOTE') ?>

    <?php //= $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_AT') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
