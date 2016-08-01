<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL_START')->textInput() ?>

    <?= $form->field($model, 'SCL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GEO_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAYER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DAY_ID')->textInput() ?>

    <?= $form->field($model, 'DAY_VALUE')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
