<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\PilotprojectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilotproject-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'DISC') ?>

    <?= $form->field($model, 'PLAN_DATE1') ?>

    <?= $form->field($model, 'PLAN_DATE2') ?>

    <?php // echo $form->field($model, 'PLAN_TIME1') ?>

    <?php // echo $form->field($model, 'PLAN_TIME2') ?>

    <?php // echo $form->field($model, 'ACTUAL_DATE1') ?>

    <?php // echo $form->field($model, 'ACTUAL_DATE2') ?>

    <?php // echo $form->field($model, 'ACTUAL_TIME1') ?>

    <?php // echo $form->field($model, 'ACTUAL_TIME2') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'DEP_ID') ?>

    <?php // echo $form->field($model, 'USER_CREATED') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
