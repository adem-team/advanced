<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\JobgradeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobgrade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'JOBGRADE_ID') ?>

    <?= $form->field($model, 'JOBGRADE_NM') ?>

    <?= $form->field($model, 'SORT') ?>

    <?= $form->field($model, 'JOBGRADE_STS') ?>

    <?php // echo $form->field($model, 'JOBGRADE_DCRP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
