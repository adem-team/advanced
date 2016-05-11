<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\front\models\Procurement_item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SORT_PATENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRC_BRG_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRC_BRG_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRC_BRG_SPEK')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PRC_BRG_DCRP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'GROUP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL_START')->textInput() ?>

    <?= $form->field($model, 'TGL_END')->textInput() ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_TIME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
