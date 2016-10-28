<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Issuemd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issuemd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID_DETAIL')->textInput() ?>

    <?= $form->field($model, 'KD_CUSTOMER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_CUSTOMER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_USER')->textInput() ?>

    <?= $form->field($model, 'NM_USER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISI_MESSAGES')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TGL')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'CREATE_BY')->textInput() ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput() ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
