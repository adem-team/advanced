<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\RegulasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'RGTR_TITEL') ?>

    <?= $form->field($model, 'TGL') ?>

    <?= $form->field($model, 'RGTR_ISI') ?>

    <?= $form->field($model, 'RGTR_DCRPT') ?>

    <?php // echo $form->field($model, 'SET_ACTIVE') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'DEP_ID') ?>

    <?php // echo $form->field($model, 'DEP_SUB_ID') ?>

    <?php // echo $form->field($model, 'GF_ID') ?>

    <?php // echo $form->field($model, 'SEQ_ID') ?>

    <?php // echo $form->field($model, 'JOBGRADE_ID') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_TIME') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
