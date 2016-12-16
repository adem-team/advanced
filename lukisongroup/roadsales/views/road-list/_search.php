<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-road-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CASE_NAME') ?>

    <?= $form->field($model, 'CASE_DSCRIP') ?>

    <?= $form->field($model, 'STATUS') ?>

    <?= $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
