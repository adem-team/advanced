<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallExpired */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customercall-expired-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_PRIORITASED')->textInput() ?>

    <?= $form->field($model, 'ID_DETAIL')->textInput() ?>

    <?= $form->field($model, 'CUST_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BRG_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USER_ID')->textInput() ?>

    <?= $form->field($model, 'TGL_KJG')->textInput() ?>

    <?= $form->field($model, 'QTY')->textInput() ?>

    <?= $form->field($model, 'DATE_EXPIRED')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <?= $form->field($model, 'CREATE_BY')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
