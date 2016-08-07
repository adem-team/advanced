<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftGeoSubSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-geo-sub-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'GEO_SUB') ?>

    <?= $form->field($model, 'GEO_ID') ?>

    <?= $form->field($model, 'GEO_DCRIP') ?>

    <?= $form->field($model, 'CUST_MAX_NORMAL') ?>

    <?php // echo $form->field($model, 'CUST_MAX_LAYER') ?>

    <?php // echo $form->field($model, 'START_LAT') ?>

    <?php // echo $form->field($model, 'START_LONG') ?>

    <?php // echo $form->field($model, 'CITY_ID') ?>

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
