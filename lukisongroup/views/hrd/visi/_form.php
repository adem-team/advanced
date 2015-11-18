<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Visi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'VISIMISI_TITEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'VISIMISI_ISI')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'VISIMISI_DCRPT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'VISIMISI_IMG')->textInput(['maxlength' => true]) ?>

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
