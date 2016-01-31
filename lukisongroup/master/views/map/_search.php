<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\MapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'LAT') ?>

    <?= $form->field($model, 'LAG') ?>

    <?= $form->field($model, 'RADIUS') ?>

    <?= $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'CUST_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
