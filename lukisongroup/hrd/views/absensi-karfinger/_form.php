<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Kar_finger */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kar-finger-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TerminalID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KAR_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FingerPrintID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FingerTmpl')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'UPDT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
