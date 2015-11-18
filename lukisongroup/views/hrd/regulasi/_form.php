<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Regulasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput() ?>

    <?= $form->field($model, 'RGTR_TITEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'RGTR_ISI')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'RGTR_DCRPT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SET_ACTIVE')->textInput() ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DEP_SUB_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GF_ID')->textInput() ?>

    <?= $form->field($model, 'SEQ_ID')->textInput() ?>

    <?= $form->field($model, 'JOBGRADE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_TIME')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
