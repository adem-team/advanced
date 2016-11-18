<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\salesmanorder\SoStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="so-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KD_SO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_USER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STT_PROCESS')->textInput() ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
