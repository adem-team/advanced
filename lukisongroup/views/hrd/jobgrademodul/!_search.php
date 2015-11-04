<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\JobgrademodulSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobgrademodul-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'GF_ID') ?>

    <?= $form->field($model, 'SEQ_ID') ?>

    <?= $form->field($model, 'JOBGRADE_ID') ?>

    <?= $form->field($model, 'JOBGRADE_NM') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <?php // echo $form->field($model, 'JOBGRADE_STS') ?>

    <?php // echo $form->field($model, 'JOBGRADE_DCRP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
