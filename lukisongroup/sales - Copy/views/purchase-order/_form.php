<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KD_PO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SUPPLIER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'APPROVE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'APPROVE_AT')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
