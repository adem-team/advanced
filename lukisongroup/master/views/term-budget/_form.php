<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termbudget */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termbudget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INVES_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BUDGET_SOURCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BUDGET_VALUE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERIODE_START')->textInput() ?>

    <?= $form->field($model, 'PERIODE_END')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
